<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalisisLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analisis_logs', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Referencia al análisis afectado (nullable para no romper si se elimina)
            $table->unsignedBigInteger('analisis_id')->nullable();

            // Quién realizó la acción
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_name', 100)->nullable(); // Snapshot del nombre en el momento

            // Tipo de evento: created | updated | deleted
            $table->string('event', 20);

            // Solo en 'updated': columnas que cambiaron (antes y después)
            // Se guarda como JSON para ser flexible sin columnas extra
            $table->text('old_values')->nullable(); // JSON con valores anteriores
            $table->text('new_values')->nullable(); // JSON con valores nuevos

            // Contexto adicional para auditoría
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();

            $table->timestamp('created_at')->useCurrent();

            // Índices para búsquedas frecuentes
            $table->index('analisis_id');
            $table->index('user_id');
            $table->index('event');
            $table->index('created_at');

            // FK opcional: no usamos constrained() para no bloquear
            // el log si el análisis o usuario es eliminado físicamente
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analisis_logs');
    }
}