<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\UsuariosModel;

use App\Models\PerfilesModel;
use App\Models\PrincipalModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class UsuariosController extends Controller
{
    //
    private $usuarios_model;
    private $base_model;

    private $principal_model;
    private $perfiles_model;

    public function __construct() {
        parent::__construct();
        $this->usuarios_model = new UsuariosModel();

        $this->base_model = new BaseModel();
        $this->principal_model = new PrincipalModel();
        $this->perfiles_model = new PerfilesModel();
    }

    public function index() {
        $view             = "usuarios.index";
        $data["title"]    = "Administración de Usuarios";
        // $data["acciones"] = $this->getAcciones($modulo_id);
        $data["tabla"]    = $this->usuarios_model->tabla()->HTML();
        // $data["tabla_asociados"] = $this->asociados_model->tabla()->HTML();
        $botones = array();
        $botones[0] = '<button disabled="disabled" tecla_rapida="F1" style="margin-right: 5px;" class="btn btn-default btn-sm" id="nuevo-usuario"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/agregar-archivo.png').'"><br>'.traducir("traductor.nuevo").' [F1]</button>';
        $botones[1] = '<button disabled="disabled" tecla_rapida="F2" style="margin-right: 5px;" class="btn btn-default btn-sm" id="modificar-usuario"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/editar-documento.png').'"><br>'.traducir("traductor.modificar").' [F2]</button>';
        $botones[2] = '<button disabled="disabled" tecla_rapida="F4" style="margin-right: 5px;" class="btn btn-default btn-sm" id="ver-usuario"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/documento.png').'"><br>'.traducir("traductor.ver").' [F4]</button>';
        $botones[3] = '<button disabled="disabled" tecla_rapida="F7" style="margin-right: 5px;" class="btn btn-default btn-sm" id="eliminar-usuario"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/delete.png').'"><br>'.traducir("traductor.eliminar").' [F7]</button>';
        $data["botones"] = $botones;
        $data["scripts"]  = $this->cargar_js(["usuarios.js"]);
        return parent::init($view, $data);
    }

    public function buscar_datos() {
        $json_data = $this->usuarios_model->tabla()->obtenerDatos();
        echo json_encode($json_data);
    }

    public function guardar_usuarios(Request $request) {
        // ES PARA EL CASO DE CUANDO CREE SU CUENTA POR PRIMERA VEZ SERA LA DE ADMINISTRADOR perfil_id=1

        if (!isset($_POST["perfil_id"])) {
            $_POST["perfil_id"] = 1;
        }

        if (!empty($_POST["pass1"])) {
            //     unset($_POST["usuario_pass"]);
            // } else {
            $_POST["usuario_pass"] = Hash::make($request->input("pass1"));
        }

        if (!empty($_POST["nueva_pass_1"])) {

            $_POST["usuario_pass"] = Hash::make($request->input("nueva_pass_1"));
        }

        $_POST = $this->toUpper($_POST, ["usuario_user", "usuario_pass"]);

        if ($request->input("usuario_id") == '') {
            $_POST["usuario_user"] = strtolower($_POST["usuario_user"]);
            $result = $this->base_model->insertar($this->preparar_datos("seguridad.usuarios", $_POST));
        } else {

            $result = $this->base_model->modificar($this->preparar_datos("seguridad.usuarios", $_POST));
        }
        // $_POST["usuario_id"] = $result["id"];
        // if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == "0") {

        //     $response = $this->SubirArchivo($_FILES["foto"], "./assets/fotos_usuarios/", "usuario_" . $_POST["usuario_id"]);
        //     if ($response["response"] == "ERROR") {
        //         throw new Exception('Error al subir foto del Usuario!');
        //     }
        //     $_POST["usuario_foto"] = $response["NombreFile"];
        //     $this->session->set_userdata("foto", 'assets/fotos_usuarios/'.$_POST["usuario_foto"]);
        //     $result = $this->base_model->modificar($this->preparar_datos("usuarios", $_POST));
        // }
        echo json_encode($result);
    }

    public function eliminar_usuarios() {
        try {
            // $sql_asociados = "SELECT * FROM seguridad.usuarios AS u
            // INNER JOIN iglesias.miembro AS m ON(m.idmiembro=u.idmiembro)
            // WHERE u.usuario_id=".$_REQUEST["id"];
            // $asociados = DB::select($sql_asociados);

            // if(count($asociados) > 0) {
            //     throw new Exception(traducir("traductor.eliminar_usuario_asociado"));
            // }

            $result = $this->base_model->eliminar(["seguridad.usuarios", "usuario_id"]);
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(array("status" => "ee", "msg" => $e->getMessage()));
        }
    }

    public function get_usuarios(Request $request) {
        $sql = "SELECT * FROM seguridad.usuarios WHERE usuario_id=" . $request->input("id");
        $one = DB::select($sql);
        echo json_encode($one);
    }

    public function obtener_usuarios() {
        $sql = "SELECT usuario_id as id, usuario_user as descripcion FROM seguridad.usuarios WHERE estado='A'";
        $result = DB::select($sql);
        echo json_encode($result);
        //print_r($this->db->last_query());
    }

    public function perfil($modulo_id = "") {

        $view             = "usuarios/usuarios.perfil.php";
        $data["title"]    = "Configuración de Perfil de Usuario";
        //$data["acciones"] = $this->getAcciones($modulo_id);
         //echo $modulo_id; exit;
        //$data["tabla"] = $this->usuarios_model->tabla()->HTML();
        $data["scripts"] = $this->cargar_js(["usuario_perfil.js"]);
        parent::init($view, $data);
    }


    public function cambiar_password($modulo_id = "") {

        $view             = "usuarios.cambiar_password";
        $data["title"]    = "Reestablecer Contraseña";
        //$data["acciones"] = $this->getAcciones($modulo_id);
         //echo $modulo_id; exit;
        //$data["tabla"] = $this->usuarios_model->tabla()->HTML();
        $data["scripts"] = $this->cargar_js(["cambiar_password.js"]);
        return parent::init($view, $data);
    }

    public function select_init() {
        $data["perfil_id"] = $this->perfiles_model->obtener_perfiles();
        // $data["idtipoacceso"] = $this->principal_model->obtener_tipos_acceso();
        echo json_encode($data);
    }

}
