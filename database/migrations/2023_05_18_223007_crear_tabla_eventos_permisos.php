<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CrearTablaEventosPermisos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "CREATE TABLE eventos.permisos(
                permiso_id serial,
                evento_id int,
                programa_id int,
                participante_id int,
                tipo char(1),
                usuario_registro varchar(50),
                fecha_registro timestamp without time ZONE,
                estado char(1) NULL DEFAULT 'A',
                CONSTRAINT pk_permisos PRIMARY KEY(permiso_id),
                CONSTRAINT fk_eventos_permisos FOREIGN KEY(evento_id) REFERENCES eventos.eventos(evento_id),
                CONSTRAINT fk_programas_permisos FOREIGN key(programa_id) REFERENCES eventos.programas(programa_id),
                CONSTRAINT fk_participantes_permisos FOREIGN KEY(participante_id) REFERENCES eventos.participantes(participante_id)
            );
            COMMENT ON COLUMN eventos.permisos.tipo IS 'S -> SALIDA
                                E -> ENTRADA';"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP TABLE IF EXISTS eventos.permisos;");
    }
}
