<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tabla;
use Illuminate\Support\Facades\DB;

class ProgramasModel extends Model
{
    use HasFactory;



    public function __construct() {
        parent::__construct();

    }

    public function tabla() {
        $tabla = new Tabla();
        $tabla->asignarID("tabla-programas");
        $tabla->agregarColumna("p.programa_id", "programa_id", "Id");
        $tabla->agregarColumna("p.programa_descripcion", "programa_descripcion", "Descripción");
        $tabla->agregarColumna("e.evento_descripcion", "evento", "Evento");
        $tabla->agregarColumna("tp.tp_descripcion", "tipo", "Tipo");
        $tabla->agregarColumna("to_char(p.programa_fecha, 'DD/MM/YYYY')", "programa_fecha", "Fecha");
        $tabla->agregarColumna("p.estado", "estado", "Estado");

        $tabla->setSelect("p.programa_id, p.programa_descripcion, e.evento_descripcion AS evento, tp.tp_descripcion AS tipo, to_char(p.programa_fecha, 'DD/MM/YYYY') AS programa_fecha, CASE WHEN p.estado='A' THEN 'ACTIVO' ELSE 'INACTIVO' END AS estado, p.estado AS state");
        $tabla->setFrom("eventos.programas AS p
        \nINNER JOIN eventos.eventos AS e ON(p.evento_id=e.evento_id)
        \nINNER JOIN eventos.tipos_programa AS tp ON(p.tp_id=tp.tp_id)");




        return $tabla;
    }




}