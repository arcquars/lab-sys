<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\Classes\FacturaSiatModel;
use App\Helpers\SiatHelper;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;

class SiatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invoicing(Request $request, $analysisId)
    {
        $analisis = Analisis::find($analysisId);
        return view('siat.invoicing', compact('analisis'));
    }

    public function ajaxSendInvoide(Request $request){
        // Implementar objeto para mandar a siat
        $siatHelper = new SiatHelper();
        /** @var FacturaSiatModel $factura */
//        $factura = $siatHelper->sendSiatFactura($request);
        dd($siatHelper->getSiatCuis());
        return response()->json(['success' => '1']);
    }
}
