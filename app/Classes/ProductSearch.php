<?php


namespace App\Classes;


class ProductSearch
{
    public $id;
    public $text;

    /**
     * ProductSearch constructor.
     * @param $id
     * @param $nombre
     */
    public function __construct($id, $nombre)
    {
        $this->id = $id;
        $this->text = $nombre;
    }
}