<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\EventosModel;
use App\Models\LlegadasModel;
use App\Models\ProgramasModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    //
    private $base_model;
    private $eventos_model;
    private $programas_model;
    private $llegadas_model;


    public function __construct() {
        parent:: __construct();

        $this->base_model = new BaseModel();
        $this->eventos_model = new EventosModel();
        $this->programas_model = new ProgramasModel();
        $this->llegadas_model = new LlegadasModel();
    }

    public function login(Request $request) {
        $user = strtolower($request->input('user'));
        $pass = $request->input('pass');
        $response = array();
        // $clave = Hash::make('1235');
        // echo $clave; exit;
        // echo Hash::check("1235", $clave);
        $sql_login = "SELECT u.*, p.* FROM seguridad.usuarios AS u
        INNER JOIN seguridad.perfiles AS p ON(u.perfil_id=p.perfil_id)


        WHERE lower(u.usuario_user)='{$user}'";
        // die($sql_login);
        $response["usuario"] = DB::select($sql_login);

        if(!isset($response["usuario"][0]->usuario_user)  || !isset($response["usuario"][0]->perfil_id)) {
            $response["response"] = "nouser";
        }

        if(count($response["usuario"]) > 0 && $response["usuario"][0]->perfil_id != 1 && $response["usuario"][0]->perfil_id != 3) {
            $response["response"] = "noperfil";
        }

        // print_r($response["usuario"]); exit;
        if(count($response["usuario"]) > 0 && isset($response["usuario"][0]->usuario_pass) && Hash::check($pass, $response["usuario"][0]->usuario_pass)) {
            $response["response"] = "ok";
             $sql_sesion = "SELECT * FROM eventos.sesion_app WHERE usuario_id={$response["usuario"][0]->usuario_id} AND estado='A'";
            $response["sesion"] = DB::select($sql_sesion);
            if(count($response["sesion"]) <= 0) {
                $data = array();
                $data["usuario_id"] = $response["usuario"][0]->usuario_id;
                $data["sa_fecha"] = date("Y-m-d");
                $data["sa_hora"] = date("H:i:s");
                $data["estado"] = 'A';
                $result = $this->base_model->insertar($this->preparar_datos("eventos.sesion_app", $data));
                $response["sesion_id"] = $result["id"];
            } else {
                $response["sesion_id"] = $response["sesion"][0]->sa_id;
            }
        } else {
            $response["response"] = "nopass";
        }


        echo json_encode($response);
        // print("hola");
    }

    public function marcar_asistencia(Request $request) {
        $_REQUEST["da_fecha"] = date("Y-m-d");
        $_REQUEST["da_hora"] = date("H:i:s");
        $result = $this->base_model->insertar($this->preparar_datos("asambleas.detalle_asistencia", $_REQUEST));
        // print_r($result);
        $result["datos"][0]["status"] = $result["status"];
        $result["datos"][0]["type"] = $result["type"];
        $result["datos"][0]["msg"] = $result["msg"];
        echo json_encode($result["datos"]);
    }

    public function guardar_votos(Request $request) {
        if($request->input("fv_id") == 8) {
            $miembros_multiple = explode("|", $_REQUEST["multiples_miembros"]);
            $data = $_REQUEST;
            $data["voto_fecha"] = date("Y-m-d");
            $data["voto_hora"] = date("H:i:s");
            for ($i=0; $i < count($miembros_multiple); $i++) {
                $data["dp_id"] = $miembros_multiple[$i];
                $result = $this->base_model->insertar($this->preparar_datos("asambleas.votos", $data));
            }


        } else {
            $miembro_votado = explode("|", $request->input("idmiembro_votado"));
            if($request->input("fv_id") == 6) {
                $_REQUEST["idmiembro_votado"] = "";
                $_REQUEST["dp_id"] = $miembro_votado[0];
            } else {
                $_REQUEST["idmiembro_votado"] = $miembro_votado[0];
                $_REQUEST["dp_id"] = "";
            }


            $_REQUEST["voto_fecha"] = date("Y-m-d");
            $_REQUEST["voto_hora"] = date("H:i:s");
            $result = $this->base_model->insertar($this->preparar_datos("asambleas.votos", $_REQUEST));
        }

        // print_r($result);
        $result["datos"][0]["status"] = $result["status"];
        $result["datos"][0]["type"] = $result["type"];
        $result["datos"][0]["msg"] = $result["msg"];
        echo json_encode($result["datos"]);
    }

    public function guardar_comentarios() {

        $result = $this->base_model->insertar($this->preparar_datos("asambleas.comentarios", $_REQUEST));
        $result["datos"][0]["status"] = $result["status"];
        $result["datos"][0]["type"] = $result["type"];
        $result["datos"][0]["msg"] = $result["msg"];
        echo json_encode($result["datos"]);

    }

    public function obtener_paises() {
        $sql = "SELECT * FROM iglesias.paises WHERE estado='A' ORDER BY pais_descripcion ASC";
        $result = DB::select($sql);
        echo json_encode($result);
    }

    public function obtener_tipos_documento() {
        $sql = "SELECT * FROM public.tipodoc ORDER BY descripcion ASC";
        $result = DB::select($sql);
        echo json_encode($result);
    }

    public function obtener_foros() {
        $sql = "SELECT * FROM asambleas.foros WHERE estado='A' ORDER BY foro_id DESC";
        $result = DB::select($sql);
        echo json_encode($result);
    }

    public function obtener_comentarios(Request $request) {
        $sql = "SELECT * FROM asambleas.comentarios AS c
        INNER JOIN iglesias.miembro AS m ON(c.idmiembro=m.idmiembro)
        WHERE c.foro_id={$request->input("foro_id")} AND c.estado='A'
        ORDER BY c.comentario_id DESC";
        $result = DB::select($sql);
        echo json_encode($result);
    }






    public function obtener_url() {
        //$data["url"] = "https://iglesia.solucionesahora.com/";
        // $data["url"] = "https://smisystem.org/imssystem/public/";
        $data["url"] = "https://smisystem.org/imseventos/public/";
        echo json_encode($data);
    }


    public function obtener_eventos() {
        $eventos = $this->eventos_model->obtener_eventos();
        echo json_encode($eventos);
    }

    public function obtener_tipos_programa() {
        $array = array();

        array_push($array, array("id" => 1, "descripcion" => "Alimentos"));
        array_push($array, array("id" => 2, "descripcion" => "Coliseo"));

        echo json_encode($array);

    }

    public function obtener_programas(Request $request) {
        $data = $request->all();

        $data["evento_id"] = (!empty($data["evento_id"])) ? $data["evento_id"] : '-1';
        $data["tp_id"] = (!empty($data["tp_id"])) ? $data["tp_id"] : '-1';

        $result = $this->programas_model->obtener_programas($data["evento_id"], $data["tp_id"]);
        echo json_encode($result);

    }

    public function obtener_asistencia_participante(Request $request) {
        $data = $request->all();
        $sql = "SELECT p.*, r.*,
        COALESCE(r.registro_aerolinea, '-.-') AS registro_aerolinea,
        COALESCE(r.registro_nrovuelo, '-.-') AS registro_nrovuelo,
        COALESCE(to_char(r.registro_fecha_llegada, 'DD/MM/YYYY'), '-.-') AS registro_fecha_llegada,
        COALESCE(r.registro_destino_llegada, '-.-') AS registro_destino_llegada
        FROM eventos.participantes AS p
        INNER JOIN eventos.registros AS r ON(p.participante_id=r.participante_id AND p.registro_id_ultimo=r.registro_id)
        WHERE p.participante_id={$data["participante_id"]}";
        $result = DB::select($sql);
        echo json_encode($result);
    }

    public function obtener_llegada_participante(Request $request) {
        $data = $request->all();
        $llegada = $this->llegadas_model->validar_asistencia($data);
        echo json_encode($llegada);
    }

    public function cerrar_sesion() {

        $sa_id = $_REQUEST["sesion_id"];

        $update = array();
        $update["sa_id"] = $sa_id;
        $update["estado"] = "I";
        $result = $this->base_model->modificar($this->preparar_datos("eventos.sesion_app", $update));


        echo json_encode($result);
    }
}
