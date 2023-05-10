<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CrearTablaRegistros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE TABLE eventos.registros(
                registro_id serial,
                participante_id int,
                registro_ciudad_procedencia varchar(50) NULL,
                registro_celular varchar(20) NULL,
                registro_celular_emergencia varchar(20) NULL,
                registro_correo varchar(100) NULL,
                registro_apoderado varchar(200) NULL,
                registro_iglesia varchar(100) NULL,
                registro_edad int NULL,
                registro_delegado char(1) NULL,
                registro_aerolinea varchar(50) NULL,
                registro_nrovuelo varchar(50) NULL,
                registro_fecha_llegada date NULL,
                registro_hora_llegada time NULL,
                registro_fecha_retorno date NULL,
                registro_hora_retorno time NULL,
                registro_destino_llegada varchar(50) NULL,
                CONSTRAINT pk_registros PRIMARY KEY(registro_id),
                CONSTRAINT fk_participantes_registros FOREIGN KEY(participante_id) REFERENCES eventos.participantes(participante_id)
            );
            COMMENT ON COLUMN eventos.registros.registro_delegado IS 'S -> Si
                    N -> No';

        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP TABLE IF EXISTS eventos.registros;");
    }
}
