<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CambiarTipoDatoColumnaFechaRegistroTablaParticipantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            ALTER TABLE eventos.participantes DROP COLUMN fecha_registro;
            ALTER TABLE eventos.participantes ADD fecha_registro timestamp without time zone NULL;
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
            ALTER TABLE eventos.participantes DROP COLUMN fecha_registro;
            ALTER TABLE eventos.participantes ADD fecha_registro time without time zone NULL;
        ");

        

    }
}
