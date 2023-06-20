<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\EventosModel;
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


    public function __construct() {
        parent:: __construct();

        $this->base_model = new BaseModel();
        $this->eventos_model = new EventosModel();
        $this->programas_model = new ProgramasModel();
    }

    public function login(Request $request) {
        $user = strtolower($request->input('user'));
        $pass = $request->input('pass');
        // $clave = Hash::make('1235');
        // echo $clave; exit;
        // echo Hash::check("1235", $clave);
        $sql_login = "SELECT u.*, p.* FROM seguridad.usuarios AS u
        INNER JOIN seguridad.perfiles AS p ON(u.perfil_id=p.perfil_id)


        WHERE lower(u.usuario_user)='{$user}'";
        // die($sql_login);
        $result = DB::select($sql_login);

        if(!isset($result[0]->usuario_user)  || !isset($result[0]->perfil_id)) {
            $data["response"] = "nouser";
        }

        if(count($result) > 0 && $result[0]->perfil_id != 1 && $result[0]->perfil_id != 3) {
            $data["response"] = "noperfil";
        }

        // print_r($result); exit;
        if(count($result) > 0 && isset($result[0]->usuario_pass) && Hash::check($pass, $result[0]->usuario_pass)) {
            $data["response"] = "ok";
        }

        $data["datos"] = $result;
        echo json_encode($data);
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

        $result = $this->programas_model->obtener_programas($data["evento_id"], $data["tp_id"]);
        echo json_encode($result);

    }

    public function obtener_asistencia_participante(Request $request) {
        $data = $request->all();
        $sql = "SELECT * FROM eventos.participantes WHERE participante_id={$data["participante_id"]}";
        $result = DB::select($sql);
        echo json_encode($result);
    }
}
