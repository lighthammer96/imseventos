<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\AsistenciasModel;
use App\Models\PrincipalModel;
use PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class AsistenciasController extends Controller
{
    //

    private $base_model;
    private $asistencias_model;
    private $principal_model;

    public function __construct() {
        parent:: __construct();

        $this->principal_model = new PrincipalModel();
        $this->base_model = new BaseModel();
        $this->asistencias_model = new AsistenciasModel();

    }

    public function index() {
        $view = "asistencias.index";
        $data["title"] = "Control de Asistencia";
        $data["subtitle"] = "";
        $data["tabla"] = $this->asistencias_model->tabla()->HTML();

        $botones = array();
        $botones[0] = '<button disabled="disabled" tecla_rapida="F1" style="margin-right: 5px;" class="btn btn-default btn-sm" id="nueva-asistencia"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/agregar-archivo.png').'"><br>Nuevo [F1]</button>';
        // $botones[1] = '<button disabled="disabled" tecla_rapida="F2" style="margin-right: 5px;" class="btn btn-default btn-sm" id="modificar-asistencia"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/editar-documento.png').'"><br>Modificar [F2]</button>';
        $botones[1] = '<button disabled="disabled" tecla_rapida="F7" style="margin-right: 5px;" class="btn btn-default btn-sm" id="eliminar-asistencia"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/delete.png').'"><br>Eliminar [F7]</button>';
        $data["botones"] = $botones;

        $data["scripts"] = $this->cargar_js(["asistencias.js"]);
        return parent::init($view, $data);



    }

    public function buscar_datos() {
        $json_data = $this->asistencias_model->tabla()->obtenerDatos();
        echo json_encode($json_data);
    }



    public function guardar_asistencias(Request $request) {

        $result = $this->asistencias_model->guardar_asistencias($request);
        echo json_encode($result);
    }

    public function guardar_permisos(Request $request) {
        try {
            $data = $request->all();
            $permisos = $this->asistencias_model->obtener_permisos($data);

            if(count($permisos) > 0) {

                if($data["tipo"] == "S" && $permisos[0]->tipo == "S") {
                    throw new Exception("El ultimo registro es una Salida");
                }

                if($data["tipo"] == "E" && $permisos[0]->tipo == "E") {
                    throw new Exception("El ultimo registro es una Entrada");
                }
            } else {
                if($data["tipo"] == "E" ) {
                    throw new Exception("Debe registrar primero una Salida");
                }
            }

            $result = $this->base_model->insertar($this->preparar_datos("eventos.permisos", $data));

            $result["permisos"] = $this->asistencias_model->obtener_permisos($data);
            DB::commit();

            echo json_encode($result);

        } catch (Exception $e) {
            DB::rollBack();
            $response["status"] = "ei";
            $response["msg"] = $e->getMessage();

            echo json_encode($response);
        }
    }


    public function eliminar_asistencias(Request $request) {

        try {

            $datos = $request->all();
            $datos["asistencia_id"] = $datos["id"];
            $datos["estado"] = "I";

            $result = $this->base_model->modificar($this->preparar_datos("eventos.asistencias", $datos));
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(array("status" => "ee", "msg" => $e->getMessage()));
        }
    }

}
