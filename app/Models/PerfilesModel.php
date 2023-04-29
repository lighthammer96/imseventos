<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tabla;
use Illuminate\Support\Facades\DB;

class PerfilesModel extends Model
{
    use HasFactory;



    public function __construct() {
        parent::__construct();

        //$tabla = new Tabla();


    }

    public function tabla() {
        $tabla = new Tabla();
        $tabla->asignarID("tabla-perfiles");
        $tabla->agregarColumna("p.perfil_id", "perfil_id", "Id");
        $tabla->agregarColumna("pi.perfil_descripcion", "perfil_descripcion", "Descripción");
        $tabla->agregarColumna("p.estado", "estado", "Estado");
        $tabla->setSelect("p.perfil_id, p.perfil_descripcion , CASE WHEN p.estado='A' THEN 'ACTIVO' ELSE 'INACTIVO' END AS estado, p.estado AS state");
        $tabla->setFrom("seguridad.perfiles AS p");




        return $tabla;
    }

    public function obtener_perfiles() {
        $sql = "SELECT p.perfil_id AS id, p.perfil_descripcion AS descripcion
        FROM seguridad.perfiles AS p

        WHERE p.estado='A'";
        // die($sql);
        $result = DB::select($sql);
        return $result;
    }


}
