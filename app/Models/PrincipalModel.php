<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tabla;
use Illuminate\Support\Facades\DB;


class PrincipalModel extends Model
{
    use HasFactory;



    public function __construct() {
        parent::__construct();
    }

    public function obtener_categorias_iglesia() {
        $sql = "SELECT idcategoriaiglesia as id, descripcion /*, CASE WHEN idcategoriaiglesia=1 THEN 'S' ELSE 'N' END AS defecto*/ FROM iglesias.categoriaiglesia
        ORDER BY idcategoriaiglesia ASC";
        $result = DB::select($sql);
        return $result;
    }

    public function obtener_departamentos($request) {
        $sql = "";
        if(isset($_REQUEST["pais_id"]) && !empty($_REQUEST["pais_id"])) {
            $sql = "SELECT iddepartamento as id, descripcion
            FROM public.departamento
            WHERE pais_id=".$request->input("pais_id").
            " ORDER BY descripcion ASC";
        } else {
            $sql = "SELECT iddepartamento as id, descripcion FROM public.departamento
            WHERE pais_id = ".session("pais_id").
            " ORDER BY descripcion ASC";
        }
        $result = DB::select($sql);
        return $result;
        // echo json_encode($result);
    }

    public function obtener_provincias($request) {
        $sql = "";
        $result = array();
		if(isset($_REQUEST["iddepartamento"]) && !empty($_REQUEST["iddepartamento"])) {

			$sql = "SELECT idprovincia as id,  descripcion FROM public.provincia WHERE iddepartamento=".$request->input("iddepartamento").
            " ORDER BY descripcion ASC";
		} else {
			//$sql = "SELECT idprovincia as id, descripcion FROM public.provincia";
		}

        if($sql != "") {
            $result = DB::select($sql);
        }
        return $result;
    }

    public function obtener_distritos($request) {
        $sql = "";
        $result = array();
		if(isset($_REQUEST["idprovincia"]) && !empty($_REQUEST["idprovincia"])) {
            $sql = "SELECT iddistrito as id, descripcion FROM public.distrito WHERE idprovincia=".$request->input("idprovincia").
            " ORDER BY descripcion ASC";
			//$result = DB::select($sql);
		} else {

            // $sql = "SELECT iddistrito as id, descripcion FROM public.distrito";
            // $result = DB::select($sql);

		}
        if($sql != "") {
            $result = DB::select($sql);
        }
        return $result;
    }

    public function obtener_tipos_documento() {

        $sql = "SELECT idtipodoc as id, descripcion FROM public.tipodoc ORDER BY descripcion ASC";
        $result = DB::select($sql);
        return $result;
    }

    public function obtener_motivos_baja() {
        $sql = "SELECT idmotivobaja as id, descripcion FROM iglesias.motivobaja
        ORDER BY descripcion ASC";
        $result = DB::select($sql);
        return $result;
    }

    public function obtener_condicion_eclesiastica() {
        $sql = "SELECT idcondicioneclesiastica as id, descripcion FROM iglesias.condicioneclesiastica
        ORDER BY descripcion ASC";
        $result = DB::select($sql);
        return $result;
    }

    public function obtener_religiones() {
        $sql = "SELECT idreligion as id, descripcion FROM iglesias.religion
        ORDER BY descripcion ASC";
        $result = DB::select($sql);
        return $result;
    }

    public function obtener_parentesco() {
        $sql = "SELECT idparentesco as id, descripcion FROM public.parentesco
        WHERE estado='1'
        ORDER BY descripcion ASC";
        $result = DB::select($sql);
        return $result;
    }

    public function obtener_condicion_eclesiastica_all() {
        $array = array("id" => "-1", "descripcion" => "Todos");
        $array = (object) $array;
        $sql = "SELECT idcondicioneclesiastica as id, descripcion FROM iglesias.condicioneclesiastica
        ORDER BY descripcion ASC";
        $result = DB::select($sql);

        array_push($result, $array);
        return $result;
    }

    public function obtener_tipos_acceso() {
        $sql = "SELECT idtipoacceso as id, descripcion FROM seguridad.tipoacceso
        ORDER BY idtipoacceso DESC";
        $result = DB::select($sql);
        return $result;
    }

    public function obtener_paises() {
        $sql = "SELECT idpais AS id, descripcion FROM public.pais
        ORDER BY descripcion ASC";
        $result = DB::select($sql);
        return $result;
    }

    public function obtener_tipos_programa() {
        $sql = "SELECT tp_id AS id, tp_descripcion AS descripcion FROM eventos.tipos_programa WHERE estado='A'";
        $result = DB::select($sql);
        return $result;
    }

}
