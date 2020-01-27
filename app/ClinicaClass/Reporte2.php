<?php
namespace App\ClinicaClass;

class Reporte2
{
    private $fecha;
    private $citologia_total;
    private $biopsia_total;
    private $inmuno_total;

    private $ingreso;
    private $acuenta;
    private $pago_efectuado;

    /**
     * Reporte2 constructor.
     * @param $citologia_total
     * @param $biopsia_total
     * @param $inmuno_total
     * @param $ingreso
     * @param $acuenta
     * @param $pago_efectuado
     */
    public function __construct()
    {
        $this->citologia_total = 0;
        $this->biopsia_total = 0;
        $this->inmuno_total = 0;
        $this->ingreso = 0;
        $this->acuenta = 0;
        $this->pago_efectuado = 0;
    }

    /**
     * @return mixed
     */
    public function getCitologiaTotal()
    {
        return $this->citologia_total;
    }

    /**
     * @param mixed $citologia_total
     */
    public function setCitologiaTotal($citologia_total): void
    {
        $this->citologia_total = $citologia_total;
    }

    /**
     * @return mixed
     */
    public function getBiopsiaTotal()
    {
        return $this->biopsia_total;
    }

    /**
     * @param mixed $biopsia_total
     */
    public function setBiopsiaTotal($biopsia_total): void
    {
        $this->biopsia_total = $biopsia_total;
    }

    /**
     * @return mixed
     */
    public function getInmunoTotal()
    {
        return $this->inmuno_total;
    }

    /**
     * @param mixed $inmuno_total
     */
    public function setInmunoTotal($inmuno_total): void
    {
        $this->inmuno_total = $inmuno_total;
    }

    /**
     * @return mixed
     */
    public function getIngreso()
    {
        return $this->ingreso;
    }

    /**
     * @param mixed $ingreso
     */
    public function setIngreso($ingreso): void
    {
        $this->ingreso = $ingreso;
    }

    /**
     * @return mixed
     */
    public function getAcuenta()
    {
        return $this->acuenta;
    }

    /**
     * @param mixed $acuenta
     */
    public function setAcuenta($acuenta): void
    {
        $this->acuenta = $acuenta;
    }

    /**
     * @return mixed
     */
    public function getPagoEfectuado()
    {
        return $this->pago_efectuado;
    }

    /**
     * @param mixed $pago_efectuado
     */
    public function setPagoEfectuado($pago_efectuado): void
    {
        $this->pago_efectuado = $pago_efectuado;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

}