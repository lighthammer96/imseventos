<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CambiarKeysTablaDetalleEventos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            ALTER TABLE eventos.detalle_eventos DROP CONSTRAINT pk_detalle_eventos;
            ALTER TABLE eventos.detalle_eventos DROP CONSTRAINT fk_eventos_detalle_eventos;
            ALTER TABLE eventos.detalle_eventos DROP CONSTRAINT fk_participantes_detalle_eventos;
            ALTER TABLE eventos.detalle_eventos ADD CONSTRAINT pk_detalle_eventos PRIMARY KEY (evento_id,participante_id,registro_id);
            ALTER TABLE eventos.detalle_eventos ADD CONSTRAINT fk_eventos_detalle_eventos FOREIGN KEY (evento_id) REFERENCES eventos.eventos(evento_id);
            ALTER TABLE eventos.detalle_eventos ADD CONSTRAINT fk_participantes_detalle_eventos FOREIGN KEY (participante_id) REFERENCES eventos.participantes(participante_id);
            ALTER TABLE eventos.detalle_eventos ADD CONSTRAINT fk_registros_detalle_eventos FOREIGN KEY (registro_id) REFERENCES eventos.registros(registro_id);
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
            ALTER TABLE eventos.detalle_eventos DROP CONSTRAINT IF EXISTS pk_detalle_eventos;
            ALTER TABLE eventos.detalle_eventos DROP CONSTRAINT IF EXISTS fk_eventos_detalle_eventos;
            ALTER TABLE eventos.detalle_eventos DROP CONSTRAINT IF EXISTS fk_participantes_detalle_eventos;
            ALTER TABLE eventos.detalle_eventos DROP CONSTRAINT IF EXISTS fk_registros_detalle_eventos;

            ALTER TABLE eventos.detalle_eventos ADD CONSTRAINT pk_detalle_eventos PRIMARY KEY (evento_id,participante_id);
            ALTER TABLE eventos.detalle_eventos ADD CONSTRAINT fk_eventos_detalle_eventos FOREIGN KEY (evento_id) REFERENCES eventos.eventos(evento_id);
            ALTER TABLE eventos.detalle_eventos ADD CONSTRAINT fk_participantes_detalle_eventos FOREIGN KEY (participante_id) REFERENCES eventos.participantes(participante_id);
        ");
    }
}
