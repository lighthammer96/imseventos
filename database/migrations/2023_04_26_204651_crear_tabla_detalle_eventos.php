<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CrearTablaDetalleEventos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE TABLE eventos.detalle_eventos(
                evento_id int,
                participante_id int,
                CONSTRAINT pk_detalle_eventos PRIMARY KEY(evento_id, participante_id),
                CONSTRAINT fk_eventos_detalle_eventos FOREIGN KEY(evento_id) REFERENCES eventos.eventos(evento_id),
                CONSTRAINT fk_participantes_detalle_eventos FOREIGN KEY(participante_id) REFERENCES eventos.participantes(participante_id)
            )
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP TABLE IF EXISTS eventos.detalle_eventos;");
    }
}
