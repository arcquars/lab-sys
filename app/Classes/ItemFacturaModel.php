<?php


namespace App\Classes;


class ItemFacturaModel
{
    public $item_id;
    public $invoice_id;
    public $product_id;
    public $product_code;
    public $product_name;
    public $price;
    public $quantity;
    public $total;
    public $unidad_medida;
    public $numero_serie;
    public $numero_imei;
    public $codigo_producto_sin;
    public $codigo_actividad;
    public $discount;
    public $data;

    function __construct() {

    }
}