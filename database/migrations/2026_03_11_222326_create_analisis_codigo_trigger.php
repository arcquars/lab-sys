<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAnalisisCodigoTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(<<<SQL
            DROP TRIGGER IF EXISTS trg_generar_codigo_analisis;

            CREATE TRIGGER trg_generar_codigo_analisis
            BEFORE INSERT ON analisis
            FOR EACH ROW
            BEGIN
                DECLARE v_prefijo CHAR(1);
                DECLARE v_anio VARCHAR(2);
                DECLARE v_ultimo_correlativo INT;
                -- Aumentamos el tamaño a VARCHAR(10) por seguridad en caso de superar el 9999
                DECLARE v_nuevo_correlativo VARCHAR(10); 

                -- 1. Obtener la primera letra del tipo_analisis (en mayúscula)
                IF NEW.tipo_analisis IS NOT NULL AND NEW.tipo_analisis != '' THEN
                    SET v_prefijo = UPPER(SUBSTRING(NEW.tipo_analisis, 1, 1));
                ELSE
                    SET v_prefijo = 'X';
                END IF;

                -- 2. Obtener los últimos dos dígitos del año actual
                SET v_anio = DATE_FORMAT(CURRENT_DATE(), '%y');

                -- 3. Buscar el último código generado usando la intercalación correcta para evitar el error 1267
                SELECT IFNULL(MAX(CAST(SUBSTRING_INDEX(codigo, '-', -1) AS UNSIGNED)), 0)
                INTO v_ultimo_correlativo
                FROM analisis
                WHERE codigo LIKE CONCAT(v_prefijo, '-', v_anio, '-%') COLLATE utf8mb4_unicode_ci;

                -- 4. AQUÍ ESTÁ EL CAMBIO: LPAD con 4 posiciones.
                -- Incrementará así: 0008, 0009, 0010 ... 0099, 0100 ... 0999, 1000
                SET v_nuevo_correlativo = LPAD(v_ultimo_correlativo + 1, 4, '0');

                -- 5. Asignar el código final concatenado
                SET NEW.codigo = CONCAT(v_prefijo, '-', v_anio, '-', v_nuevo_correlativo);

            END;
        SQL);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_generar_codigo_analisis;');
    }
}
