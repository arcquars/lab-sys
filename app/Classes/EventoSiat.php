<?php


namespace App\Classes;


class EventoSiat
{
    public $siat_evento_id;
    public $user_id;
    public $evento_id;
    public $sucursal_id;
    public $puntoventa_id;
    public $codigo_recepcion;
    public $descripcion;
    public $fecha_inicio;
    public $fecha_fin;
    public $cufd;
    public $cufd_evento;
    public $cafc;
    public $codigo_recepcion_paquete;
    public $stado_recepcion;
    public $status;
    public $data;

    public function setDataRest($data){
        $this->siat_evento_id = $data->id;
        $this->evento_id = $data->evento_id;
        $this->descripcion = $data->descripcion;
        $this->user_id = $data->user_id;
        $this->fecha_inicio = $data->fecha_inicio;
        $this->sucursal_id = $data->sucursal_id;
        $this->puntoventa_id = $data->puntoventa_id;
        $this->codigo_recepcion = $data->codigo_recepcion;
        $this->fecha_fin = $data->fecha_fin;
        $this->cufd = $data->cufd;
        $this->cufd_evento = $data->cufd_evento;
        $this->cafc = $data->cafc;
        $this->codigo_recepcion_paquete = $data->codigo_recepcion_paquete;
        $this->stado_recepcion = $data->stado_recepcion;
        $this->status = $data->status;
    }
}