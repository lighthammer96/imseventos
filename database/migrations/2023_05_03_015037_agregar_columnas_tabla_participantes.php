<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AgregarColumnasTablaParticipantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            ALTER TABLE eventos.participantes ADD participante_edad int NULL;
            ALTER TABLE eventos.participantes ADD participante_delegado char(1) NULL;
            COMMENT ON COLUMN eventos.participantes.participante_delegado IS 'S -> Si
            N -> No';
            ALTER TABLE eventos.participantes ADD participante_aerolinea varchar(50) NULL;
            ALTER TABLE eventos.participantes ADD participante_nrovuelo varchar(50) NULL;
            ALTER TABLE eventos.participantes ADD participante_fecha_llegada date NULL;
            ALTER TABLE eventos.participantes ADD participante_hora_llegada time NULL;
            ALTER TABLE eventos.participantes ADD participante_fecha_retorno date NULL;
            ALTER TABLE eventos.participantes ADD participante_hora_retorno time NULL;
            ALTER TABLE eventos.participantes ADD participante_destino_llegada varchar(50) NULL;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
            ALTER TABLE eventos.participantes DROP COLUMN IF EXISTS participante_edad;
            ALTER TABLE eventos.participantes DROP COLUMN IF EXISTS participante_delegado;
            ALTER TABLE eventos.participantes DROP COLUMN IF EXISTS participante_aerolinea;
            ALTER TABLE eventos.participantes DROP COLUMN IF EXISTS participante_nrovuelo;
            ALTER TABLE eventos.participantes DROP COLUMN IF EXISTS participante_fecha_llegada;
            ALTER TABLE eventos.participantes DROP COLUMN IF EXISTS participante_hora_llegada;
            ALTER TABLE eventos.participantes DROP COLUMN IF EXISTS participante_fecha_retorno;
            ALTER TABLE eventos.participantes DROP COLUMN IF EXISTS participante_hora_retorno;
            ALTER TABLE eventos.participantes DROP COLUMN IF EXISTS participante_destino_llegada;
        ");
    }
}
