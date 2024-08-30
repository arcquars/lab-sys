<?php


namespace App\Helpers;


use App\Classes\CustomerSiatModel;
use App\Classes\EventoSiat;
use App\Classes\FacturaSiatModel;
use App\Classes\ItemFacturaModel;
use App\Exceptions\CustomException;
use App\Models\Client;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SiatHelper
{
    public $urlBase;
    public $urlApi;

    public $token;
    public $configModel;
    public $authorization;

    function __construct() {
        $strTemplate = env("SIAT.BASEURL"); // SIAT.APIREST.BASEURL
        $strTemplate = str_replace('{HOST}', env("SIAT.APIREST.HOST"), $strTemplate);
        $strTemplate = str_replace('{PORT}', env("SIAT.APIREST.PORT"), $strTemplate);
        $strTemplate = str_replace('{SUBDIR}', env("SIAT.APIREST.HOST.SUBDIR"), $strTemplate);

        $this->urlBase = $strTemplate;
        $this->urlApi = $strTemplate . DIRECTORY_SEPARATOR . env("SIAT.APIREST.BASEURL");
        $this->token = env('SIAT.APIREST.TOKEN');
        $this->authorization = "Authorization:Bearer ". $this->token;
    }

    public function urlLogin(){
        return $this->urlBase .
            DIRECTORY_SEPARATOR . 'admin' .
            DIRECTORY_SEPARATOR . 'login-i.php?username=' .
            env("SIAT.USERNAME") . '&pwd=' . env("SIAT.PASSWORD");
    }

    public function getToken(){
        $url = $this->urlApi.'/v1.0.0/users/get-token';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $username = env("SIAT.USERNAME");
        $password = env("SIAT.PASSWORD");
        $data = <<<DATA
        {
          "username": "$username",
          "password": "$password"
        }
DATA;
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $resp = curl_exec($curl);
        curl_close($curl);

        return $resp;
    }

    public function getSiatCuis(){
        $params = array('sucursal' => '0');
        $url = $this->urlApi.'/invoices/siat/v2/cuis?'.http_build_query($params); // SIAT.APIREST.ENDPOINTS.CUIS
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            $this->authorization));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $resp = json_decode(curl_exec($curl));
        curl_close($curl);

        return $resp;
    }

    public function crearSiatFactura($saleRequest){
        $factura = new FacturaSiatModel();
        /** Obtener cliente  */
        $customerId = $this->getSiatCrearCustomer($saleRequest['razon_social'], $saleRequest['nit'], '');
        $discount = (strcmp($saleRequest['discount'], "") != 0)? $saleRequest['discount']: 0;
        $extra = (strcmp($saleRequest['extra'], "") != 0)? $saleRequest['extra']: 0;

        $factura->codigo_sucursal = 0;
        $factura->meta = array();
        $factura->invoice_id = 0;
        $factura->dosage_id = 0;
        $factura->customer_id = $customerId;
        $factura->customer = $client->razon_social;
        $factura->user_id = Auth::id();
        $factura->store_id = 0;
        $factura->nit_ruc_nif = $client->nit;
        $factura->tax_id = 0;
        $factura->tax_rate = 0;

//        $factura->discount = $datos['descuento'];
        $factura->discount = $discount;
//        $factura->subtotal = $datos['total'];
        $factura->subtotal = $this->getSiatTotalItems($saleRequest['products']);

        if($saleRequest['metodo_pago'] == '27' || $saleRequest['metodo_pago'] == '35'){
            $factura->monto_giftcard = $extra;
            $factura->total_tax = ($factura->subtotal - ($discount + $extra))*0.13;
            $factura->total = $factura->subtotal - ($discount + $extra);
//            var_dump($factura->subtotal . '|' . $discount . '|' . $extra);
//            var_dump($factura->total);
//            die();
        } else {
//            var_dump($saleRequest['discount']);
//            die();
            $factura->monto_giftcard = 0;
            $factura->total_tax = ($factura->subtotal - $discount)*0.13;
            $factura->total = $factura->subtotal - $discount;
        }


        $factura->cash = 0;
        $factura->invoice_number = 0;
        $factura->control_code = '';
        $factura->authorization = '';
        $factura->invoice_date_time = '';
        $factura->invoice_limite_date = '';
        $factura->currency_code = '';
        $factura->status = '';
//        $factura->codigo_sucursal = 0;
        $factura->punto_venta = 0;
        $factura->codigo_documento_sector = 1;
        $factura->tipo_documento_identidad = $saleRequest['tipo_documento'];
        $factura->codigo_metodo_pago = $saleRequest['metodo_pago'];
        $factura->codigo_moneda = 1;
        $factura->cufd = '';
        $factura->cuf = '';
        $factura->cafc = '';

        if($saleRequest['com'] != ''){
            $factura->complemento = $saleRequest['com'];
        } else {
            $factura->complemento = null;
        }
        if($saleRequest['metodo_pago'] == '2'){
            $factura->numero_tarjeta = $saleRequest['extra'];
        } else {
            $factura->numero_tarjeta = null;
        }

        $factura->tipo_cambio = 1;

        $nroFactura = null;
//        $excepcion = $saleRequest['excepcionFactura'];
        $excepcion = $saleRequest['excepcion'];
        if($excepcion == 1){
            $factura->data['excepcion'] = $excepcion;
        }

        // IMPORTANTE verificar si existe evento activo
        $evento = $this->getSiatEventoActivo();
        if($evento == null){
            $factura->evento_id = null;
        } else {
            $factura->evento_id = $evento->siat_evento_id;
            if($evento->evento_id == 5 || $evento->evento_id == 6 || $evento->evento_id == 7){
                $factura->invoice_date_time = $saleRequest['fecha'].'T'.$saleRequest['hora'].':00.000Z';
                $nroFactura = $saleRequest['numeroFactura'];
                $excepcion = '0';
            }
        }

        $factura->siat_id = null;
        $factura->tipo_emision = 1;
        $factura->tipo_factura_documento = 1;
//        $factura->tipo_producto_id = 99100;
        $factura->items = $this->getSiatCrearItems($saleRequest['products']);
        $factura->dosage = '';


        if($nroFactura != null){
            $factura->data['nro_factura'] = $nroFactura;
        }

        Log::error("ssssss:::");
        Log::error(json_encode($factura));

        return $factura;
    }

    public function getSiatCrearCustomer($last_name, $nit, $email)
    {
        $customer = new CustomerSiatModel();
        $customer->customer_id = null;
        $customer->extern_id = null;
        $customer->user_id = null;
        $customer->code = '';
        $customer->group_id = -1;
        $customer->store_id = 0;
        $customer->first_name = '';
        $customer->last_name = $last_name;
        $customer->identity_document = $nit;
        $customer->company = '';
        $customer->date_of_birth = null;
        $customer->gender = '';
        $customer->phone = '';
        $customer->mobile = '';
        $customer->fax = '';
        $customer->email = $email;
//        $customer->email = 'arc.quars@hotmail.com';
        $customer->website = '';
        $customer->address_1 = '';
        $customer->address_2 = '';
        $customer->zip_code = '';
        $customer->city = '';
        $customer->country = 'Bolivia';
        $customer->country_code = 'BO';
        $customer->meta = array('_nit_ruc_nif' => $nit, '_billing_name' => '');

        $url = $this->urlApi.'/customers/saveupdate';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            $this->authorization));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($customer));
        $resp = json_decode(curl_exec($curl));
        curl_close($curl);

        $siatCustomerId = null;

        if($resp->response == 'ok' && $resp->code == '200'){
            $siatCustomerId = $resp->data->customer->customer_id;
        } else {
            Log::info("PDM:: " . $resp->error);
            throw new CustomException("SIAT: ".$resp->error, 101);
        }

        return $siatCustomerId;
    }

    public function getSiatEventoActivo(){
        $params = array('sucursal_id' => '0', 'puntoventa_id' => '0');
        $url = $this->urlApi.'/invoices/siat/v2/eventos/activo?'.http_build_query($params);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            $this->authorization));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $resp = json_decode(curl_exec($curl));
        curl_close($curl);

        Log::info("PDM:: " . __CLASS__ . " | " . __METHOD__ . " :: " . json_encode($resp));

        $evento = null;

        if($resp->data != null){
            $evento = new EventoSiat();
            $evento->setDataRest($resp->data);
        }


        return $evento;
    }

    public function getSiatCrearItems($items){
        $facItems = array();
        foreach ($items as $item){
            // $producto = Product::find($item['code']);
            $producto = Product::where('code', $item['code'])->firstOrFail();
            $facItem = new ItemFacturaModel();
            $facItem->item_id = 0;
            $facItem->invoice_id = 0;
            $facItem->product_id = 0;
            $facItem->data = '';
            $facItem->product_code = $item['code'];
            $facItem->product_name = $item["name"];
            $facItem->price = $item["price"];
            $facItem->quantity = $item["amount"];
//            $facItem->total = $item["valor"] * $item["cantidad"];
            $facItem->total = $item["price"] * $item["amount"];
            $facItem->total = round($facItem->total, 2);
            $facItem->unidad_medida = (isset($producto->measure))? $producto->measure : '57';
//            $facItem->unidad_medida = '22';
            $facItem->numero_serie = '';
            $facItem->numero_imei = '';
            $facItem->codigo_producto_sin = (isset($producto->producto_sin))? $producto->producto_sin : 99100;
            $facItem->codigo_actividad = (isset($producto->actividad_economica))? $producto->actividad_economica : '474110';
            $facItem->discount = 0;

            array_push($facItems, $facItem);
        }


        return $facItems;
    }

    public function getSiatTotalItems($items){
        $total = 0;
        foreach ($items as $item){
            $total += $item["price"] * $item["amount"];
        }
        $total = round($total, 2);

        return $total;
    }

    public function sendSiatFactura($saleRequest){
        $url = $this->urlApi.DIRECTORY_SEPARATOR.'invoices';

        $facturaModel = $this->crearSiatFactura($saleRequest);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            $this->authorization));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($facturaModel));
        $resp = json_decode(curl_exec($curl));
        curl_close($curl);

        $siatFactura = null;
        if($resp->response == 'ok' && $resp->code == '200') {
            $siatFactura = $resp->data;
        } else {
            $pos = strpos($resp->error, 'EL NUMERO DOCUMENTO DE TIPO NIT NO ES VALIDO: Nit enviado ' . $facturaModel->nit_ruc_nif . ' para codigo excepcion 0');
            $eMensaje = $resp->error;
            $eCodigo = 800;
            if($pos !== false){
                $eMensaje = $resp->error . '. Desea generar la factura de todas formas?';
                $eCodigo = 805;
            }
//            $log->info('eeeee1:: ');
//            $log->info($eMensaje);
//            $log->info($eCodigo);
            throw new CustomException($eMensaje, $eCodigo);
        }
        return $siatFactura;
    }

    public function getSiatInvoicePdf($invoiceId){
//        $params = array('tpl' => 'rollo');
//        $params = array('tpl' => 'carta');
        $params = array('tpl' => 'rollo');
        $url = $this->urlApi.'/invoices/'.$invoiceId.'/pdf?'.http_build_query($params); // SIAT.APIREST.ENDPOINTS.CUIS
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            $this->authorization));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $resp = json_decode(curl_exec($curl));
        curl_close($curl);

        if($resp->response == 'ok' && $resp->code == '200') {
            $siatFactura = $resp->data;
        } else {
            dd($resp->error);
            throw new CustomException($resp->error, 800);
        }
        return $siatFactura->buffer;
    }

    public function sendSiatJsonFactura($facturaJson){
        $url = $this->urlApi.DIRECTORY_SEPARATOR.'invoices';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            $this->authorization));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $facturaJson);
        $resp = json_decode(curl_exec($curl));
        curl_close($curl);

        $siatFactura = null;
        if($resp->response == 'ok' && $resp->code == '200') {
            $siatFactura = $resp->data;
        } else {
            $pos = strpos($resp->error, 'EL NUMERO DOCUMENTO DE TIPO NIT NO ES VALIDO: Nit enviado  para codigo excepcion 0');
            $eMensaje = $resp->error;
            $eCodigo = 800;
            if($pos !== false){
                $eMensaje = $resp->error . '. Desea generar la factura de todas formas?';
                $eCodigo = 805;
            }
//            $log->info('eeeee1:: ');
//            $log->info($eMensaje);
//            $log->info($eCodigo);
            throw new CustomException($eMensaje, $eCodigo);
        }
        return $siatFactura;
    }

    public function sendSiatGetEvent($sucursalId, $puntoVentaId){
        $parameters = array('sucursal_id' => $sucursalId, 'puntoventa_id' => $puntoVentaId);
        $url = $this->urlApi.DIRECTORY_SEPARATOR.'invoices/siat/v2/eventos/activo?'.http_build_query($parameters);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            $this->authorization));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($curl, CURLOPT_POST, true);
//        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($facturaModel));
        try {
            $resp = json_decode(curl_exec($curl));
            curl_close($curl);

            $evento = null;
            Log::info("PDM:: " . __CLASS__ . " | " . __METHOD__ . " :: " . json_encode($resp));
            if($resp->response == 'ok' && $resp->code == '200') {
                if($resp->data != null){
                    $evento = new EventoSiat();
                    $evento->setDataRest($resp->data);
                }
            } else {
                $eMensaje = $resp->error;
                $eCodigo = 800;
                throw new CustomException($eMensaje, $eCodigo);
            }
            return $evento;
        } catch (\Exception $e){
            return null;
        }

    }

    public function sendSiatGetListActividades(){
        $url = $this->urlApi.DIRECTORY_SEPARATOR.'invoices/siat/v2/actividades';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            $this->authorization));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $resp = json_decode(curl_exec($curl));
        curl_close($curl);

        $actividades = null;
        Log::info("PDM 458001:: " . __CLASS__ . " | " . __METHOD__ . " :: " );
        Log::info($resp);
        if($resp->response == 'ok' && $resp->code == '200') {
            if($resp->data != null){
                $actividades = $resp->data->RespuestaListaActividades->listaActividades;
            }
        } else {
            $eMensaje = $resp->error;
            $eCodigo = 800;
            throw new CustomException($eMensaje, $eCodigo);
        }
        return $actividades;
    }

    public function sendSiatGetListProductos(){
        $url = $this->urlApi.DIRECTORY_SEPARATOR.'invoices/siat/v2/lista-productos-servicios';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            $this->authorization));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $resp = json_decode(curl_exec($curl));
        curl_close($curl);

        $productos = null;
        Log::info("PDM:: " . __CLASS__ . " | " . __METHOD__ . " :: " . json_encode($resp));
        if($resp->response == 'ok' && $resp->code == '200') {
            if($resp->data != null){
                $productos = $resp->data->RespuestaListaProductos->listaCodigos;
            }
        } else {
            $eMensaje = $resp->error;
            $eCodigo = 800;
            throw new CustomException($eMensaje, $eCodigo);
        }
        return $productos;
    }

    public function sendSiatCreateEvent($sucursal, $puntoVenta, $eventoId){
        $evento = 0;
        $url = $this->urlApi.DIRECTORY_SEPARATOR.'invoices/siat/v2/eventos';
        $datos = array(
            'sucursal_id' => $sucursal,
            'puntoventa_id' => $puntoVenta,
            'evento_id' => $eventoId,
            'fecha_inicio' => Carbon::now()->format('Y-m-d H:i:s'),
            'fecha_fin' => null,
            'cafc' => null,
            'cufd_evento' => ""
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            $this->authorization));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($datos));
        $resp = json_decode(curl_exec($curl));
        curl_close($curl);

        Log::info("PDM:: " . __CLASS__ . " | " . __METHOD__ . " :: " . json_encode($resp));
        if($resp->response == 'ok' && $resp->code == '200') {
            $evento = $resp->data->id;
        } else {
            $eMensaje = $resp->error;
            $eCodigo = 800;
            throw new CustomException($eMensaje, $eCodigo);
        }
        return $evento;
    }

    public function sendSiatCloseEvent($eventId){
        $result = false;
        $url = $this->urlApi.DIRECTORY_SEPARATOR.'invoices/siat/v2/eventos/'.$eventId.'/cerrar';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            $this->authorization));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $resp = json_decode(curl_exec($curl));
        curl_close($curl);

        Log::info("PDM:: " . __CLASS__ . " | " . __METHOD__ . " :: " . json_encode($resp));
        if($resp->response == 'ok' && $resp->code == '200') {
            $result = true;
        } else {
            $eMensaje = $resp->error;
            $eCodigo = 800;
            throw new CustomException($eMensaje, $eCodigo);
        }
        return $result;
    }
}
