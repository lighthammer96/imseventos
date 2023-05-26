<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CrearTablaAsistenciasTransporte extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "CREATE TABLE eventos.asistencias_transporte(
                at_id serial,
                evento_id int,
                participante_id int,
                usuario_registro varchar(50),
                fecha_registro timestamp without time ZONE,
                estado char(1) NULL DEFAULT 'A',
                CONSTRAINT pk_asistencias_transporte PRIMARY KEY(at_id),
                CONSTRAINT fk_eventos_asistencias_transporte FOREIGN KEY(evento_id) REFERENCES eventos.eventos(evento_id),
                CONSTRAINT fk_participantes_asistencias_transporte FOREIGN KEY(participante_id) REFERENCES eventos.participantes(participante_id)
            );"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP TABLE IF EXISTS eventos.asistencias_transporte;");
    }
}
