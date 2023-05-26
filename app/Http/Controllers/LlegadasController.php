<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\LlegadasModel;
use App\Models\PrincipalModel;
use PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class LlegadasController extends Controller
{
    //

    private $base_model;
    private $llegadas_model;
    private $principal_model;

    public function __construct() {
        parent:: __construct();

        $this->principal_model = new PrincipalModel();
        $this->base_model = new BaseModel();
        $this->llegadas_model = new LlegadasModel();

    }

    public function index() {
        $view = "llegadas.index";
        $data["title"] = "Control de Llegadas de Visitantes";
        $data["subtitle"] = "";
        $data["tabla"] = $this->llegadas_model->tabla()->HTML();

        $botones = array();
        $botones[0] = '<button disabled="disabled" tecla_rapida="F1" style="margin-right: 5px;" class="btn btn-default btn-sm" id="nueva-llegada"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/agregar-archivo.png').'"><br>Nuevo [F1]</button>';
        // $botones[1] = '<button disabled="disabled" tecla_rapida="F2" style="margin-right: 5px;" class="btn btn-default btn-sm" id="modificar-asistencia"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/editar-documento.png').'"><br>Modificar [F2]</button>';
        $botones[1] = '<button disabled="disabled" tecla_rapida="F7" style="margin-right: 5px;" class="btn btn-default btn-sm" id="eliminar-llegada"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/delete.png').'"><br>Eliminar [F7]</button>';
        $data["botones"] = $botones;

        $data["scripts"] = $this->cargar_js(["llegadas.js"]);
        return parent::init($view, $data);



    }

    public function buscar_datos() {
        $json_data = $this->llegadas_model->tabla()->obtenerDatos();
        echo json_encode($json_data);
    }



    public function guardar_llegadas(Request $request) {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $result = array();
            $asistencia[0] = array();
            $participante[0] = array();


            $participante = $this->llegadas_model->validar_codigo_qr_segun_evento($data);
            if(count($participante) <= 0) {
                throw new Exception("participante_no_registrado");
            }

            $data["participante_id"] = $participante[0]->participante_id;

            $asistencia = $this->llegadas_model->validar_asistencia($data);
            // print_r($asistencia); exit;

            if(count($asistencia) > 0) {
                throw new Exception("asistencia_registrada");
            }


            $result = $this->base_model->insertar($this->preparar_datos("eventos.asistencias_transporte", $data));

            $result["participante"] = $participante[0];
            $result["delegado"] = $participante[0]->registro_delegado;

            DB::commit();
            echo json_encode($result);
        } catch (Exception $e) {
            DB::rollBack();
            $response["status"] = "ei";
            var_dump($participante);
            $response["participante"] = $participante[0];
            $response["asistencia"] = $asistencia[0];
            $response["code"] = "";
            $response["msg"] = $e->getMessage();

            if($e->getMessage() == "asistencia_registrada") {
                $response["code"] = "asistencia_registrada";
                $response["msg"] = "La asistencia ya ha sido registrada";
            }

            if($e->getMessage() == "participante_no_registrado") {
                $response["code"] = "participante_no_registrado";
                $response["msg"] = "El participante no esta registrado en el Sistema";
            }

            echo json_encode($response);
        }
    }



    public function eliminar_llegadas(Request $request) {

        try {

            $datos = $request->all();
            $datos["asistencia_id"] = $datos["id"];
            $datos["estado"] = "I";

            $result = $this->base_model->modificar($this->preparar_datos("eventos.asistencias_transporte", $datos));
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(array("status" => "ee", "msg" => $e->getMessage()));
        }
    }

}
