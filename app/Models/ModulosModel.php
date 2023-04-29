<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModulosModel extends Model
{
    use HasFactory;

    public function __construct() {
        parent::__construct();

    }

    public function tabla() {
        $tabla = new Tabla();
        $tabla->asignarId("tabla-modulos");
        $tabla->agregarColumna("h.modulo_id", "modulo_id", "ID");
        $tabla->agregarColumna("h.modulo_nombre", "hijo", "Modulo");
        $tabla->agregarColumna("h.modulo_icono", "modulo_icono", traducir('traductor.icono'));
        $tabla->agregarColumna("h.modulo_controlador", "modulo_controlador", traducir('traductor.controlador'));
        $tabla->agregarColumna("p.modulo_nombre", "padre", traducir('traductor.modulo_padre'));
        $tabla->agregarColumna("h.estado", "estado", traducir('traductor.estado'));
        $tabla->setSelect("h.modulo_id as modulo_id, h.modulo_nombre AS hijo , p.modulo_id as idpadre,

        p.modulo_nombre AS padre,

        h.modulo_icono, h.modulo_controlador, CASE WHEN h.estado='A' THEN 'ACTIVO' ELSE 'INACTIVO' END AS estado, h.estado AS state");
        $tabla->setFrom("seguridad.modulos as p
        \nINNER JOIN seguridad.modulos as h on(p.modulo_id=h.modulo_padre)");
        // $tabla->setOrderBy("h.modulo_id DESC, p.modulo_id ASC");
        $tabla->setWhere("h.modulo_id > 0");




        return $tabla;
    }

    public function obtener_padres() {
        $sql = "SELECT m.modulo_id AS id, m.modulo_nombre AS descripcion
        FROM seguridad.modulos AS m

        WHERE m.modulo_padre=0 AND m.estado='A'";
        $result = DB::select($sql);
        return $result;
    }
}
