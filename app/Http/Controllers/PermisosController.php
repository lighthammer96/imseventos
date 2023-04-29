<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermisosController extends Controller
{

    private $base_model;

    public function __construct() {
        parent:: __construct();
        $this->base_model = new BaseModel();

    }

    public function index() {
        $view = "permisos.index";
        $data["title"] = "Administración de Permisos";

        $data["modulos_all"] = $this->base_model->getPermisos();
        // echo "<pre>";
        // print_r($data["modulos"] ); exit;
        $data["scripts"] = $this->cargar_js([ "permisos.js"]);
        return parent::init($view, $data);
    }


    public function guardar_permisos(Request $request) {

        // echo "<pre>";
        // print_r($this->prepararDatos("permisos", $_POST, "D")); exit;
        // $this->db->where("perfil_id",$request->input("perfil_id"));
        // $this->db->delete("permisos");
        DB::table("seguridad.permisos")->where("perfil_id", $request->input("perfil_id"))->delete();

        for ($i = 0; $i < count($request["modulo_id"]) ; $i++) {
            // if(isset($_REQUEST["accion_id_".$_REQUEST["modulo_id"][$i]])) {
            //     for ($j = 0; $j < count($_REQUEST["accion_id_".$_REQUEST["modulo_id"][$i]]); $j++) {
            //         $this->db->insert("seguridad.permisos", array(
            //             "perfil_id" => $_REQUEST["perfil_id"],
            //             "modulo_id" => $_REQUEST["modulo_id"][$i],
            //             "accion_id" => $_REQUEST["accion_id_".$_REQUEST["modulo_id"][$i]][$j]
            //         ));
            //     }
            // } else {
                // $this->db->insert("permisos", array(
                //     "perfil_id" => $request["perfil_id"],
                //     "modulo_id" => $request["modulo_id"][$i],

                // ));

                DB::table("seguridad.permisos")->insert(array(
                    "perfil_id" => $request["perfil_id"],
                    "modulo_id" => $request["modulo_id"][$i],

                ));
            // }

        }

        // $this->base_model->insertar($this->prepararDatos("permisos", $_POST, "D"), "D");
        $Response = array(
            "status" => "i",

            "msg" => traducir("traductor.guardo"),
            "type" => "success"
        );


       echo json_encode($Response);
    }

    public function get(Request $request) {

        $permisos = DB::table("seguridad.permisos")->where("perfil_id", $request->input("perfil_id"))->get();
        echo json_encode($permisos);
    }

    public function getPermisos() {
         $modulos = $this->base_model->getPermisos(true);
         echo json_encode($modulos);
    }

}
