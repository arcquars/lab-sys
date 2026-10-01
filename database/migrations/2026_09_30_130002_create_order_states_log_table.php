<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Crea la tabla `order_states_log` que registra las transiciones
 * de estado de cada pre_order.
 *
 * Estructura específica (no replicar analisis_logs con JSON):
 *   - previous_state: estado anterior (NULL en creación inicial)
 *   - new_state: estado nuevo
 *   - user_id: usuario que ejecutó la transición (nullable para honrrar ON DELETE SET NULL)
 *   - note: justificación opcional (rechazo, etc.)
 *
 * IRREVERSIBLE: down() lanza excepción.
 */
class CreateOrderStatesLogTable extends Migration
{
    public function up()
    {
        Schema::create('order_states_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pre_order_id');
            $table->string('previous_state', 20)->nullable();
            $table->string('new_state', 20);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('note')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('pre_order_id');
            $table->index('new_state');

            $table->foreign('pre_order_id')->references('id')->on('pre_orders')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        throw new \RuntimeException(
            'Migración IRREVERSIBLE para preservar datos: ' .
            'si necesitas rollback de order_states_log hazlo manualmente tras backup.'
        );
    }
}
