<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tabla;
use Illuminate\Support\Facades\DB;

class EventosModel extends Model
{
    use HasFactory;



    public function __construct() {
        parent::__construct();

    }


    public function tabla() {
        $tabla = new Tabla();
        $tabla->asignarID("tabla-eventos");
        $tabla->agregarColumna("e.evento_id", "evento_id", "Id");
        $tabla->agregarColumna("e.evento_descripcion", "evento_descripcion", "Descripción");
        $tabla->agregarColumna("to_char(e.evento_fecha_inicio, 'DD/MM/YYYY')", "evento_fecha_inicio", "Fecha Inicio");
        $tabla->agregarColumna("to_char(e.evento_fecha_fin, 'DD/MM/YYYY')", "evento_fecha_fin", "Fecha Fin");
        $tabla->agregarColumna("e.evento_detalle", "evento_detalle", "Detalle");

        $tabla->agregarColumna("e.estado", "estado", "Estado");

        $tabla->setSelect("e.evento_id, e.evento_descripcion, to_char(e.evento_fecha_inicio, 'DD/MM/YYYY') AS evento_fecha_inicio, to_char(e.evento_fecha_fin, 'DD/MM/YYYY') AS evento_fecha_fin, e.evento_detalle, CASE WHEN e.estado='A' THEN 'ACTIVO' ELSE 'INACTIVO' END AS estado, e.estado AS state");
        $tabla->setFrom("eventos.eventos AS e");




        return $tabla;
    }

    public function obtener_eventos() {
        $sql = "SELECT evento_id AS id, evento_descripcion AS descripcion FROM eventos.eventos WHERE estado='A'";
        $result = DB::select($sql);
        return $result;
    }


}
