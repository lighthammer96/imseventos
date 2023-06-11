<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    //
    private $base_model;


    public function __construct() {
        parent:: __construct();

        $this->base_model = new BaseModel();
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

        if(!isset($result[0]->usuario_user) || !isset($result[0]->idmiembro) || !isset($result[0]->perfil_id)) {
            $data["response"] = "nouser";
        }

        if(count($result) > 0 && $result[0]->perfil_id != 1 && $result[0]->perfil_id != 2) {
            $data["response"] = "nouser";
        }

        // print_r($result); exit;
        if(count($result) > 0 && isset($result[0]->usuario_pass) && Hash::check($pass, $result[0]->usuario_pass)) {
            $data["response"] = "ok";
        }
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

    public function obtener_votacion_activa() {
        $result = array();
        // print($_REQUEST["idmiembro"]);
        // votacion_status, A votacion abierta, C votacion cerrada
        $sql_forma_votacion = "SELECT fv.*, v.propuesta_id, v.tabla, v.asamblea_id, v.votacion_id
        FROM asambleas.votaciones AS v
        INNER JOIN asambleas.formas_votacion AS fv ON(v.fv_id=fv.fv_id)
        WHERE v.estado='A' AND v.votacion_status='A' AND '".date("Y-m-d"). "' = to_char(v.votacion_fecha, 'YYYY-MM-DD') /*AND '".date("H:i")."' BETWEEN v.votacion_hora_apertura AND v.votacion_hora_cierre*/ AND  v.votacion_id={$_REQUEST["votacion_id"]}";
        // echo $sql_forma_votacion; exit;


        $result["formas_votacion"] = DB::select($sql_forma_votacion);


        //VALIDAMOS QUE EL ASOCIADO LOGUEADO EN LA APP NO HAYA TENIDO NINGUN VOTO
        $sql_validar_voto = "SELECT * FROM asambleas.votos WHERE votacion_id={$_REQUEST["votacion_id"]} AND idmiembro={$_REQUEST["idmiembro"]}";

        $validar_voto = DB::select($sql_validar_voto);


        if(count($result["formas_votacion"]) > 0 && count($validar_voto) <= 0) {

            $result["formas_votacion"][0]->items = array();

            // print_r($result); exit;
            if($result["formas_votacion"][0]->tabla == "asambleas.propuestas_temas") {

                $sql_propuestas = "SELECT CASE WHEN tpt.tpt_titulo IS NULL THEN '' ELSE tpt.tpt_titulo END AS propuesta, tpt.tpt_idioma AS idioma_codigo, tpt.tpt_propuesta AS detalle_propuesta FROM asambleas.propuestas_temas AS pt
                INNER JOIN asambleas.traduccion_propuestas_temas AS tpt ON(pt.pt_id=tpt.pt_id)
                WHERE pt.pt_id = {$result["formas_votacion"][0]->propuesta_id}";
                $propuestas = DB::select($sql_propuestas);

            } elseif($result["formas_votacion"][0]->tabla == "asambleas.propuestas_elecciones") {

                $sql_propuestas = "SELECT CASE WHEN tpe.tpe_descripcion IS NULL THEN '' ELSE tpe.tpe_descripcion END AS propuesta, tpe.tpe_idioma AS idioma_codigo, tpe.tpe_detalle_propuesta AS detalle_propuesta FROM asambleas.propuestas_elecciones AS pe
                INNER JOIN asambleas.traduccion_propuestas_elecciones AS tpe ON(pe.pe_id=tpe.pe_id)
                WHERE pe.pe_id = {$result["formas_votacion"][0]->propuesta_id}";

                $propuestas = DB::select($sql_propuestas);
            }

            if($result["formas_votacion"][0]->fv_id == 3) {
                $sql_asistencia = "SELECT m.idmiembro AS id, (m.apellidos || ', ' || m.nombres) AS descripcion FROM asambleas.asistencia AS a
                INNER JOIN asambleas.detalle_asistencia AS da ON(a.asistencia_id=da.asistencia_id)
                INNER JOIN iglesias.miembro AS m ON(m.idmiembro=da.idmiembro)
                WHERE a.estado='A' AND a.asamblea_id={$result["formas_votacion"][0]->asamblea_id}
                GROUP BY m.idmiembro, m.apellidos, m.nombres";
                $result["formas_votacion"][0]->items = DB::select($sql_asistencia);
            }

            if($result["formas_votacion"][0]->fv_id == 6 || $result["formas_votacion"][0]->fv_id == 8) {
                $sql_detalle_propuesta = "SELECT dp.dp_id AS id, dp.dp_descripcion AS descripcion FROM asambleas.propuestas_elecciones AS pe
                INNER JOIN asambleas.detalle_propuestas AS dp ON(dp.pe_id=pe.pe_id)
                WHERE pe.estado='A' AND pe.pe_id={$result["formas_votacion"][0]->propuesta_id}";
                // die($sql_detalle_propuesta);
                $result["formas_votacion"][0]->items = DB::select($sql_detalle_propuesta);
            }
            // print_r($propuestas); exit;
            $result["formas_votacion"][0]->propuestas = $propuestas;
            if($result["formas_votacion"][0]->fv_id == 5) {
                // $sql_detalle_propuesta = "SELECT dp.dp_id AS id, dp.dp_descripcion AS descripcion FROM asambleas.propuestas_elecciones AS pe
                // INNER JOIN asambleas.detalle_propuestas AS dp ON(dp.pe_id=pe.pe_id)
                // WHERE pe.estado='A' AND pe.pe_id={$result["formas_votacion"][0]->propuesta_id} AND dp.dp_idioma='".session("idioma_codigo")."'";
                // $result["formas_votacion"][0]->items = DB::select($sql_detalle_propuesta);
            }
        }

        echo json_encode($result);

    }





    public function guardar_distritos(Request $request) {

        $_POST = $this->toUpper($_POST);
        if ($request->input("iddistrito") == '') {
            $result = $this->base_model->insertar($this->preparar_datos("public.distrito", $_POST));
        }else{
            $result = $this->base_model->modificar($this->preparar_datos("public.distrito", $_POST));
        }



        echo json_encode($result);
    }

    public function eliminar_distritos() {


        try {
            $sql_miembros = "SELECT * FROM iglesias.miembro WHERE iddistritodomicilio=".$_REQUEST["id"];
            $miembros = DB::select($sql_miembros);

            if(count($miembros) > 0) {
                throw new Exception(traducir("traductor.eliminar_distrito_asociado"));
            }

            $sql_iglesias = "SELECT * FROM iglesias.iglesia WHERE iddistrito=".$_REQUEST["id"];
            $iglesias = DB::select($sql_iglesias);

            if(count($iglesias) > 0) {
                throw new Exception(traducir("traductor.eliminar_distrito_iglesia"));
            }



            $result = $this->base_model->eliminar(["public.distrito","iddistrito"]);
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(array("status" => "ee", "msg" => $e->getMessage()));
        }
    }


    public function get_distritos(Request $request) {

        $sql = "SELECT * FROM public.distrito WHERE iddistrito=".$request->input("id");
        $one = DB::select($sql);
        echo json_encode($one);
    }

    public function obtener_distritos(Request $request) {
        $sql = "";
		if(isset($_REQUEST["idprovincia"]) && !empty($_REQUEST["idprovincia"])) {
            $sql = "SELECT iddistrito as id, descripcion FROM public.distrito WHERE idprovincia=".$request->input("idprovincia");
			$result = DB::select($sql);
		} else {

            $sql = "SELECT iddistrito as id, descripcion FROM public.distrito";
            $result = DB::select($sql);
            // $result = array();
		}

        echo json_encode($result);
	}



    public function obtener_url() {
        //$data["url"] = "https://iglesia.solucionesahora.com/";
        // $data["url"] = "https://smisystem.org/imssystem/public/";
        $data["url"] = "https://smisystem.org/imseventos/public/";
        echo json_encode($data);
    }



}
