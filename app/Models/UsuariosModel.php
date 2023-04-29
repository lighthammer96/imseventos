<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuariosModel extends Model
{
    use HasFactory;

    public function __construct() {
        parent::__construct();

    }

    public function tabla() {
        $tabla = new Tabla();
        $tabla->asignarID("tabla-usuarios");
        $tabla->agregarColumna("u.usuario_id", "usuario_id", "Id");
        //$tabla->agregarColumna("u.usuario_nombres", "usuario_nombres", "Nombres");
        // $tabla->agregarColumna("m.nombres", "responsable", traducir('traductor.responsable'));
        $tabla->agregarColumna("u.usuario_user", "usuario_user", traducir('traductor.usuario'));
       // $tabla->agregarColumna("u.usuario_referencia", "usuario_referencia", "Referencia");
        $tabla->agregarColumna("p.perfil_descripcion", "perfil_descripcion", traducir("traductor.perfil"));
        // $tabla->agregarColumna("ta.descripcion", "tipoacceso", traducir('traductor.tipo_acceso'));
        $tabla->agregarColumna("u.estado", "estado", traducir('traductor.estado'));
        $tabla->setSelect("u.usuario_id, u.usuario_user,
        p.perfil_descripcion, CASE WHEN u.estado = 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END AS estado, u.estado AS state");
        $tabla->setFrom("seguridad.usuarios as u
        \nINNER JOIN seguridad.perfiles AS p ON(p.perfil_id=u.perfil_id)");
        //$tabla->setWhere("u.estado='A'");
        // $tabla->setupdate("updateusuario");
        // $tabla->setdelete("eliminarusuario");

        $array_where = array();
        $where = "";
        // var_dump(session("array_tipos_acceso")); exit;
        if(session("array_tipos_acceso") != NULL && count(session("array_tipos_acceso")) > 0) {
            foreach (session("array_tipos_acceso") as $value) {
                foreach ($value as $k => $v) {
                    array_push($array_where, " m.".$k." = ".$v);
                }
            }
            $where = implode(' AND ', $array_where);
        }



        $tabla->setWhere($where);


        return $tabla;
    }
}
