<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;

use App\Models\ModulosModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class ModulosController extends Controller
{

    private $base_model;
    private $modulos_model;




    public function __construct() {
        parent::__construct();

        $this->modulos_model = new ModulosModel();
        $this->base_model = new BaseModel();


    }

    public function index() {
        $view            = "modulos.index";
        $data["title"]   = "Administración de Modulos";
        $data["tabla"]   = $this->modulos_model->tabla()->HTML();

        $botones = array();
        $botones[0] = '<button disabled="disabled" tecla_rapida="F1" style="margin-right: 5px;" class="btn btn-default btn-sm" id="nuevo-modulo"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/agregar-archivo.png').'"><br>'.traducir("traductor.nuevo").' [F1]</button>';
        $botones[1] = '<button disabled="disabled" tecla_rapida="F2" style="margin-right: 5px;" class="btn btn-default btn-sm" id="modificar-modulo"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/editar-documento.png').'"><br>'.traducir("traductor.modificar").' [F2]</button>';
        $botones[2] = '<button disabled="disabled" tecla_rapida="F4" style="margin-right: 5px;" class="btn btn-default btn-sm" id="ver-modulo"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/documento.png').'"><br>'.traducir("traductor.ver").' [F4]</button>';
        $botones[3] = '<button disabled="disabled" tecla_rapida="F7" style="margin-right: 5px;" class="btn btn-default btn-sm" id="eliminar-modulo"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/delete.png').'"><br>'.traducir("traductor.eliminar").' [F7]</button>';
        $data["botones"] = $botones;

        $data["scripts"] = $this->cargar_js(["idiomas.js","modulos.js"]);
        // $data["acciones"] = $this->getAcciones($modulo_id);
        return parent::init($view, $data);
    }



    public function buscar_datos() {
        $json_data = $this->modulos_model->tabla()->obtenerDatos();
        echo json_encode($json_data);
    }

    public function guardar_modulos(Request $request) {
       #print_r($_REQUEST); exit;
        $_POST = $this->toUpper($_POST, array("modulo_nombre", "modulo_controlador", "modulo_icono"));
        $_POST = $this->explode_request($_POST);
        $_POST["modulo_route"] = "C".date("YmdHis");
        #print_r($this->preparar_datos("seguridad.modulos", $_POST)); exit;
        if ($request->input("modulo_id") == '') {
            $result = $this->base_model->insertar($this->preparar_datos("seguridad.modulos", $_POST));
        } else {
            $result = $this->base_model->modificar($this->preparar_datos("seguridad.modulos", $_POST));
        }

      
        echo json_encode($result);


    }

    public function guardar_padres() {
        // print_r($_REQUEST); exit;
        $_POST = $this->toUpper($_POST, array("modulo_nombre", "modulo_controlador", "modulo_icono"));
        $_POST = $this->explode_request($_POST);
        $_POST["modulo_route"] = "C".date("YmdHis");
        $_POST["modulo_controlador"] = "#";
        $result = $this->base_model->insertar($this->preparar_datos("seguridad.modulos", $_POST));

         echo json_encode($result);
     }

    public function eliminar_modulos() {


        try {


            $sql_permisos = "SELECT * FROM seguridad.permisos WHERE modulo_id=".$_REQUEST["id"];
            $permisos = DB::select($sql_permisos);

            if(count($permisos) > 0) {
                throw new Exception(traducir("traductor.eliminar_modulo_permisos"));
            }

            $result = $this->base_model->eliminar(["seguridad.modulos", "modulo_id"]);
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(array("status" => "ee", "msg" => $e->getMessage()));
        }
    }

    public function get_modulos(Request $request) {
        $sql = "SELECT * FROM seguridad.modulos WHERE modulo_id=" . $request->input("id");
        $one = DB::select($sql);
        echo json_encode($one);
    }

    public function select() {
        $term = isset($_REQUEST["term"]) ? $_REQUEST["term"] : "" ;

        $sql = "SELECT modulo_id AS id, modulo_nombre AS text FROM seguridad.modulos
        WHERE estado='A' AND modulo_padre=1 AND modulo_nombre like '%".$term."%'";
        $result = DB::select($sql);
        echo json_encode($result);
    }

    public function obtener_padres() {
        $result = $this->modulos_model->obtener_padres();
        echo json_encode($result);
    }

    // public function obtenerAcciones() {
    //     $r = $this->db->query("SELECT accion_id AS id, accion_descripcion AS descripcion FROM acciones WHERE estado='A'")->result();
    //     echo json_encode($r);
    // }

    // public function obtenerAccionesModulo() {
    //     $r = $this->db->query("SELECT * FROM acciones_modulo AS am
    //         INNER JOIN acciones AS a ON(a.accion_id=am.accion_id)
    //         WHERE am.modulo_id=".$_REQUEST["modulo_id"]."
    //         ORDER BY am.am_id ASC")->result();
    //     echo json_encode($r);
    //     //print_r($_REQUEST);
    // }

    public function obtener_traducciones(Request $request) {
         $sql = "SELECT mi.idioma_id, mi.mi_descripcion AS descripcion, i.idioma_descripcion FROM seguridad.modulos_idiomas AS mi
         INNER JOIN public.idiomas AS i ON(i.idioma_id=mi.idioma_id)
         WHERE mi.modulo_id=".$request->input("modulo_id")."
         ORDER BY mi.idioma_id ASC";
        $result = DB::select($sql);
        echo json_encode($result);
        //print_r($_REQUEST);
    }

    public function obtener_modulos() {
        $r = $this->db->query("SELECT modulo_id AS id, modulo_nombre AS descripcion FROM seguridad.modulos WHERE estado='A' AND modulo_padre<>1")->result();
        echo json_encode($r);
    }

    public function select_init() {
        $data["modulo_padre"] = $this->modulos_model->obtener_padres();

        echo json_encode($data);
    }
}
