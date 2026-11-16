<?php

namespace Tests\Unit;

use App\Analisis;
use App\IndustrialExhibition;
use App\User;
use Tests\TestCase;

class IndustrialSampleModelTest extends TestCase
{
    public function testRelationsAndDatesUseTheIndustrialSchemaWithoutDatabaseAccess()
    {
        $analisis = new Analisis();
        $analisis->is_industrial = 1;
        $this->assertTrue($analisis->is_industrial);
        $relation = $analisis->industrialExhibition();
        $this->assertInstanceOf(IndustrialExhibition::class, $relation->getRelated());
        $this->assertEquals('industrial_exhibition.analisis_id', $relation->getQualifiedForeignKeyName());

        $detail = new IndustrialExhibition([
            'rehearsal_date' => '2026-11-10',
            'manufacture_date' => null,
            'expiration_date' => '2027-03-01',
            'user_id' => 999,
        ]);
        $this->assertEquals('industrial_exhibition', $detail->getTable());
        $this->assertEquals('2026-11-10', $detail->rehearsal_date->format('Y-m-d'));
        $this->assertNull($detail->manufacture_date);
        $this->assertEquals('2027-03-01', $detail->expiration_date->format('Y-m-d'));
        $this->assertNull($detail->user_id);
        $this->assertInstanceOf(Analisis::class, $detail->analisis()->getRelated());
        $this->assertEquals('analisis_id', $detail->analisis()->getForeignKeyName());
        $this->assertInstanceOf(User::class, $detail->user()->getRelated());
    }
}
