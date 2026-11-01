<?php

namespace Tests\Unit;

use App\Analisis;
use Tests\TestCase;

class AnalisisLabelEdadTest extends TestCase
{
    public function testEdadDePocosDiasEsNeonato()
    {
        $analisis = new Analisis(['edad' => 0.03]);
        $this->assertEquals('neonato', $analisis->label_edad);
    }

    public function testEdadJustoDebajoDelUmbralEsNeonato()
    {
        $analisis = new Analisis(['edad' => 0.07]);
        $this->assertEquals('neonato', $analisis->label_edad);
    }

    public function testEdadDeUnMesNoEsNeonato()
    {
        $analisis = new Analisis(['edad' => 0.08]);
        $this->assertEquals('1 mes', $analisis->label_edad);
    }

    public function testEdadVaciaSigueMostrandoCeroMeses()
    {
        $analisis = new Analisis(['edad' => null]);
        $this->assertEquals('0 meses', $analisis->label_edad);
    }

    public function testEdadCeroSigueMostrandoCeroMeses()
    {
        $analisis = new Analisis(['edad' => 0]);
        $this->assertEquals('0 meses', $analisis->label_edad);
    }

    public function testEdadConAniosYMesesSigueFuncionando()
    {
        $analisis = new Analisis(['edad' => 1.5]);
        $this->assertEquals('1 año y 6 meses', $analisis->label_edad);
    }
}
