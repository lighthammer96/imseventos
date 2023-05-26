<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CrearTablaAsistencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "CREATE TABLE eventos.asistencias(
                asistencia_id serial,
                evento_id int,
                programa_id int,
                participante_id int,
                usuario_registro varchar(50),
                fecha_registro timestamp without time ZONE,
                estado char(1) NULL DEFAULT 'A',
                CONSTRAINT pk_asistencias PRIMARY KEY(asistencia_id),
                CONSTRAINT fk_eventos_asistencias FOREIGN KEY(evento_id) REFERENCES eventos.eventos(evento_id),
                CONSTRAINT fk_programas_asistencias FOREIGN key(programa_id) REFERENCES eventos.programas(programa_id),
                CONSTRAINT fk_participantes_asistencias FOREIGN KEY(participante_id) REFERENCES eventos.participantes(participante_id)
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
        DB::statement("DROP TABLE IF EXISTS eventos.asistencias;");
    }
}
