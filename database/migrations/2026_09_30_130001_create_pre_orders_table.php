<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Crea la tabla `pre_orders` que recibe las solicitudes previas
 * vía POST /pre-orders.
 *
 * Snapshot denormalizado: NO FK a persons, NO FK a_tests, branch_id
 * VARCHAR libre. La transición nuevo → creado (que llenará analisis_id)
 * se hará en una iteración posterior.
 *
 * IRREVERSIBLE: down() lanza excepción.
 */
class CreatePreOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('pre_orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('order_number', 20)->unique();

            $table->string('branch_id', 80);
            $table->boolean('is_stat')->default(false);

            $table->string('patient_full_name', 255);
            $table->string('patient_age', 50)->nullable();
            $table->string('patient_gender', 2);
            $table->string('patient_ci', 30);
            $table->date('patient_birth_date')->nullable();
            $table->text('patient_diagnosis')->nullable();
            $table->string('patient_physician', 200)->nullable();

            $table->json('tests_snapshot');

            $table->string('state', 20)->default('nuevo');
            $table->unsignedBigInteger('analisis_id')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('state');
            $table->index('branch_id');
            $table->index('patient_ci');
            $table->index('created_by');

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('analisis_id')->references('id')->on('analisis')->onDelete('set null');
        });
    }

    public function down()
    {
        throw new \RuntimeException(
            'Migración IRREVERSIBLE para preservar datos: ' .
            'si necesitas rollback de pre_orders hazlo manualmente tras backup.'
        );
    }
}
