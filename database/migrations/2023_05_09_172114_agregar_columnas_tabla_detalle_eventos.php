<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AgregarColumnasTablaDetalleEventos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            ALTER TABLE eventos.detalle_eventos ADD de_codigoqr varchar(255) NULL;
            ALTER TABLE eventos.detalle_eventos ADD de_codigoqr_ruta varchar(255) NULL;
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
            ALTER TABLE eventos.detalle_eventos DROP COLUMN IF EXISTS de_codigoqr;
            ALTER TABLE eventos.detalle_eventos DROP COLUMN IF EXISTS de_codigoqr_ruta;
        ");
    }
}
