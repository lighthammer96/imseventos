<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\EventosModel;
use App\Models\PrincipalModel;
use PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class EventosController extends Controller
{
    //

    private $base_model;
    private $eventos_model;
    private $principal_model;

    public function __construct() {
        parent:: __construct();

        $this->principal_model = new PrincipalModel();
        $this->base_model = new BaseModel();
        $this->eventos_model = new EventosModel();

    }

    public function index() {
        $view = "eventos.index";
        $data["title"] = "Administración de Eventos";
        $data["subtitle"] = "";
        $data["tabla"] = $this->eventos_model->tabla()->HTML();

        $botones = array();
        $botones[0] = '<button disabled="disabled" tecla_rapida="F1" style="margin-right: 5px;" class="btn btn-default btn-sm" id="nuevo-evento"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/agregar-archivo.png').'"><br>Nuevo [F1]</button>';
        $botones[1] = '<button disabled="disabled" tecla_rapida="F2" style="margin-right: 5px;" class="btn btn-default btn-sm" id="modificar-evento"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/editar-documento.png').'"><br>Modificar [F2]</button>';
        // $botones[2] = '<button disabled="disabled" tecla_rapida="F7" style="margin-right: 5px;" class="btn btn-default btn-sm" id="eliminar-evento"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/delete.png').'"><br>Eliminar [F7]</button>';
        $data["botones"] = $botones;

        $data["scripts"] = $this->cargar_js(["eventos.js"]);
        return parent::init($view, $data);



    }

    public function buscar_datos() {
        $json_data = $this->eventos_model->tabla()->obtenerDatos();
        echo json_encode($json_data);
    }



    public function guardar_eventos(Request $request) {
        try {
            DB::beginTransaction();

            $_POST = $this->toUpper($_POST, []);
            $_POST["evento_fecha_inicio"] = (isset($_REQUEST["evento_fecha_inicio"])) ? $this->FormatoFecha($_REQUEST["evento_fecha_inicio"], "server") : "";
            $_POST["evento_fecha_fin"] = (isset($_REQUEST["evento_fecha_fin"])) ? $this->FormatoFecha($_REQUEST["evento_fecha_fin"], "server") : "";


            if ($request->input("evento_id") == '') {
                $result = $this->base_model->insertar($this->preparar_datos("eventos.eventos", $_POST));

            }else{
                $result = $this->base_model->modificar($this->preparar_datos("eventos.eventos", $_POST));
            }




            DB::commit();
            echo json_encode($result);
        } catch (Exception $e) {
            DB::rollBack();
            $response["status"] = "ei";
            $response["msg"] = $e->getMessage();
            echo json_encode($response);
        }
    }

    public function eliminar_eventos() {


        try {
            // $sql_asociados = "SELECT * FROM eventos.miembro WHERE evento_id=".$_REQUEST["id"];
            // $asociados = DB::select($sql_asociados);

            // if(count($asociados) > 0) {
            //     throw new Exception(traducir("traductor.eliminar_iglesia_asociado"));
            // }

            $result = $this->base_model->eliminar(["eventos.eventos","evento_id"]);
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(array("status" => "ee", "msg" => $e->getMessage()));
        }
    }

    public function select_init(Request $request) {

        $data = array();

        $data["idtipodoc"] = $this->principal_model->obtener_tipos_documento();
        $data["idpais"] = $this->principal_model->obtener_paises();

        echo json_encode($data);
    }


    public function get_eventos(Request $request) {

        $sql = "SELECT * FROM eventos.eventos AS e

        WHERE e.evento_id=".$request->input("id");
        $one = DB::select($sql);



        echo json_encode($one);
    }

    public function obtener_eventos() {
        $result = $this->eventos_model->obtener_eventos();
        echo json_encode($result);
    }


}
