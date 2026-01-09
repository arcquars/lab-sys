<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_movements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('amount', 10, 2);
            $table->string('type'); // INGRESO, EGRESO
            $table->string('payment_method')->nullable(); // Efectivo, Tarjeta, etc.
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_id'); // Quien registra
            
            // Polimorfismo para relacionar con Reservas u otros modelos (ya lo usas en tu Helper)
            $table->nullableMorphs('source'); 
            $table->timestamps();
        });

         // Agregar la llave foránea de concepto a los movimientos
        Schema::table('cash_movements', function (Blueprint $table) {
            $table->unsignedBigInteger('concept_id')->nullable()->after('type');
            $table->foreign('concept_id')->references('id')->on('concepts');
            
            // Fecha del movimiento (puede ser diferente al created_at)
            if (!Schema::hasColumn('cash_movements', 'movement_date')) {
                $table->date('movement_date')->useCurrent()->after('amount');
            }
        });

        // Seed básico de conceptos
        DB::table('concepts')->insert([
            ['name' => 'Pago de Servicios (Luz/Agua)', 'type' => 'EGRESO', 'created_at' => now()],
            ['name' => 'Compra de Insumos', 'type' => 'EGRESO', 'created_at' => now()],
            ['name' => 'Cobro de Consulta', 'type' => 'INGRESO', 'created_at' => now()],
            ['name' => 'Otros Ingresos', 'type' => 'INGRESO', 'created_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_movements');
    }
}
