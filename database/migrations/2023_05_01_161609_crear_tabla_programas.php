<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CrearTablaProgramas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE TABLE eventos.programas(
                programa_id serial,
                programa_descripcion varchar(100),
                programa_fecha date,
                tp_id int,
                evento_id int,
                estado char(1) DEFAULT 'A',
                CONSTRAINT pk_programas PRIMARY KEY(programa_id),
                CONSTRAINT fk_tipos_programa_programas FOREIGN KEY(tp_id) REFERENCES eventos.tipos_programa(tp_id),
                CONSTRAINT fk_eventos_programas FOREIGN KEY(evento_id) REFERENCES eventos.eventos(evento_id)

            );
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP TABLE IF EXISTS eventos.programas;");
    }
}
