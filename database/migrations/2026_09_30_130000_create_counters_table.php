<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Crea la tabla `counters` para correlativos atómicos anuales
 * (ej: pre_order.correlativo reinicia por año).
 *
 * El patrón de uso es:
 *   DB::statement(
 *       "INSERT INTO counters (name, year, value, created_at, updated_at)
 *        VALUES (?, ?, 1, NOW(), NOW())
 *        ON DUPLICATE KEY UPDATE value = value + 1",
 *       [$name, $year]
 *   );
 *
 * IRREVERSIBLE: el método down() lanza excepción para impedir
 * cualquier drop accidental que pudiera afectar datos.
 */
class CreateCountersTable extends Migration
{
    public function up()
    {
        Schema::create('counters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 40);
            $table->unsignedSmallInteger('year');
            $table->unsignedBigInteger('value')->default(0);
            $table->timestamps();

            $table->unique(['name', 'year']);
        });
    }

    public function down()
    {
        throw new \RuntimeException(
            'Migración IRREVERSIBLE para preservar datos: ' .
            'si necesitas rollback de counters hazlo manualmente tras backup.'
        );
    }
}
