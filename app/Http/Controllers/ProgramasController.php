<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\EventosModel;
use App\Models\ProgramasModel;
use App\Models\PrincipalModel;
use PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class ProgramasController extends Controller
{
    //

    private $base_model;
    private $programas_model;
    private $principal_model;
    private $eventos_model;

    public function __construct() {
        parent:: __construct();

        $this->principal_model = new PrincipalModel();
        $this->base_model = new BaseModel();
        $this->programas_model = new ProgramasModel();
        $this->eventos_model = new EventosModel();

    }

    public function index() {
        $view = "programas.index";
        $data["title"] = "Administración de Programas";
        $data["subtitle"] = "";
        $data["tabla"] = $this->programas_model->tabla()->HTML();

        $botones = array();
        $botones[0] = '<button disabled="disabled" tecla_rapida="F1" style="margin-right: 5px;" class="btn btn-default btn-sm" id="nuevo-programa"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/agregar-archivo.png').'"><br>Nuevo [F1]</button>';
        $botones[1] = '<button disabled="disabled" tecla_rapida="F2" style="margin-right: 5px;" class="btn btn-default btn-sm" id="modificar-programa"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/editar-documento.png').'"><br>Modificar [F2]</button>';
        $botones[2] = '<button disabled="disabled" tecla_rapida="F7" style="margin-right: 5px;" class="btn btn-default btn-sm" id="eliminar-programa"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/delete.png').'"><br>Eliminar [F7]</button>';
        $data["botones"] = $botones;

        $data["scripts"] = $this->cargar_js(["programas.js"]);
        return parent::init($view, $data);



    }

    public function buscar_datos() {
        $json_data = $this->programas_model->tabla()->obtenerDatos();
        echo json_encode($json_data);
    }



    public function guardar_programas(Request $request) {
        try {
            DB::beginTransaction();
            $_POST = $this->toUpper($_POST, []);
            $_POST["programa_fecha"] = (isset($_REQUEST["programa_fecha"])) ? $this->FormatoFecha($_REQUEST["programa_fecha"], "server") : "";


            if ($request->input("programa_id") == '') {
                $result = $this->base_model->insertar($this->preparar_datos("eventos.programas", $_POST));

            }else{
                $result = $this->base_model->modificar($this->preparar_datos("eventos.programas", $_POST));
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

    public function eliminar_programas() {


        try {
            // $sql_asociados = "SELECT * FROM eventos.miembro WHERE programa_id=".$_REQUEST["id"];
            // $asociados = DB::select($sql_asociados);

            // if(count($asociados) > 0) {
            //     throw new Exception(traducir("traductor.eliminar_iglesia_asociado"));
            // }

            $result = $this->base_model->eliminar(["eventos.programas","programa_id"]);
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(array("status" => "ee", "msg" => $e->getMessage()));
        }
    }


    public function get_programas(Request $request) {

        $sql = "SELECT * FROM eventos.programas AS e

        WHERE e.programa_id=".$request->input("id");
        $one = DB::select($sql);



        echo json_encode($one);
    }

    public function obtener_programas_segun_tipo(Request $request) {
        $data = $request->all();
        $result["evento"] = $this->eventos_model->obtener_evento($data["evento_id"]);
        $result["coliseo"] = $this->programas_model->obtener_programas_segun_coliseo($data);
        $result["alimentos"] = $this->programas_model->obtener_programas_segun_alimentos($data);

        echo json_encode($result);
    }

    public function select_init() {
        $data = array();
        $data["evento_id"] = $this->eventos_model->obtener_eventos();
        $data["tp_id"] = $this->principal_model->obtener_tipos_programa();
        echo json_encode($data);
    }

    public function obtener_programas(Request $request) {
        $data = $request->all();

        $result = $this->programas_model->obtener_programas($data["evento_id"], $data["tp_id"]);
        echo json_encode($result);

    }


}
