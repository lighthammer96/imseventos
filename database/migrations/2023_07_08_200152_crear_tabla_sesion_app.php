<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CrearTablaSesionApp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "CREATE TABLE eventos.sesion_app(
                sa_id serial,
                usuario_id int,
                sa_fecha date,
                sa_hora time,
                estado char(1) DEFAULT 'A',
                CONSTRAINT pk_sesion_app PRIMARY KEY(sa_id),
                CONSTRAINT fk_usuarios_sesion_app FOREIGN KEY(usuario_id) REFERENCES seguridad.usuarios(usuario_id)
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
        DB::statement("DROP TABLE IF EXISTS eventos.sesion_app;");
    }
}
