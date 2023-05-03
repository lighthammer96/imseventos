<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CrearTablaTiposPrograma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE TABLE eventos.tipos_programa(
                tp_id serial,
                tp_descripcion varchar(50),
                estado char(1) DEFAULT 'A',
                CONSTRAINT pk_tipos_programa PRIMARY KEY(tp_id)
            );
            INSERT INTO eventos.tipos_programa (tp_descripcion,estado) VALUES
            ('ALIMENTOS','A'),
            ('COLISEO','A');
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP TABLE IF EXISTS eventos.tipos_programa;");
    }
}
