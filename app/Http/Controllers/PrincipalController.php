<?php

namespace App\Http\Controllers;

use App\Models\PrincipalModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrincipalController extends Controller
{
    //

    private $principal_model;

    public function __construct() {
        parent::__construct();
        $this->principal_model = new PrincipalModel();
    }

    public function index() {
        $view = "principal.index";
        $datos = array();
        $datos["subtitle"] = "Sistema de información";
        $datos["title"] = "Bienvenido";

        $datos["scripts"] = $this->cargar_js(["principal.js"]);

        return parent::init($view, $datos);
        // return view($view, $datos);
    }

    public function obtener_departamentos(Request $request) {
        $result = $this->principal_model->obtener_departamentos($request);
        echo json_encode($result);
    }


    public function obtener_provincias(Request $request) {
        $result = $this->principal_model->obtener_provincias($request);
        echo json_encode($result);
    }

    public function obtener_distritos(Request $request) {
        $result = $this->principal_model->obtener_distritos($request);
        echo json_encode($result);
	}

    public function obtener_divisiones() {
        $sql = "SELECT iddivision as id, descripcion FROM iglesias.division";
        $result = DB::select($sql);
        echo json_encode($result);
    }

    public function obtener_tipos_documento() {
        $result = $this->principal_model->obtener_tipos_documento();
        echo json_encode($result);
    }

    public function obtener_tipos_acceso() {
        $result = $this->principal_model->obtener_tipos_acceso();
        echo json_encode($result);
    }

    public function obtener_categorias_iglesia() {
        $result = $this->principal_model->obtener_categorias_iglesia();
        echo json_encode($result);
    }

    public function obtener_tipos_construccion() {
        $sql = "SELECT idtipoconstruccion as id, descripcion FROM public.tipoconstruccion
        ORDER BY idtipoconstruccion ASC";
        $result = DB::select($sql);
        echo json_encode($result);
    }

    public function obtener_tipos_documentacion() {
        $sql = "SELECT idtipodocumentacion as id, descripcion FROM public.tipodocumentacion
        ORDER BY idtipodocumentacion ASC";
        $result = DB::select($sql);
        echo json_encode($result);
    }

    public function obtener_tipos_inmueble() {
        $sql = "SELECT idtipoinmueble as id, descripcion FROM public.tipoinmueble
        ORDER BY idtipoinmueble ASC";
        $result = DB::select($sql);
        echo json_encode($result);
    }

    public function obtener_condicion_inmueble() {
        $sql = "SELECT idcondicioninmueble as id, descripcion FROM public.condicioninmueble
        ORDER BY idcondicioninmueble ASC";
        $result = DB::select($sql);
        echo json_encode($result);
    }

    public function cambiar_idioma(Request $request) {

        session(['idioma_codigo' => $request->input("idioma_codigo")]);
        session(['idioma_id' => $request->input("idioma_id")]);

        // print_r(session("idioma_defecto")); exit;
        $response = array();
        $response["response"] = "ok";

        echo json_encode($response);
    }


    public function obtener_motivos_baja() {
        $result = $this->principal_model->obtener_motivos_baja();
        echo json_encode($result);
    }

    public function obtener_condicion_eclesiastica() {
        $result = $this->principal_model->obtener_condicion_eclesiastica();
        echo json_encode($result);
    }

    public function obtener_condicion_eclesiastica_all() {
        $result = $this->principal_model->obtener_condicion_eclesiastica_all();
        echo json_encode($result);
    }


    public function obtener_religiones() {
        $result = $this->principal_model->obtener_religiones();
        echo json_encode($result);
    }

    // public function obtener_tipos_cargo() {
    //     $sql = "SELECT idtipocargo as id, descripcion FROM public.tipocargo
    //     ORDER BY idtipocargo ASC";
    //     $result = DB::select($sql);
    //     echo json_encode($result);
    // }

    // public function obtener_cargos(Request $request) {
    //     $sql = "";
	// 	if(isset($_REQUEST["idtipocargo"]) && !empty($_REQUEST["idtipocargo"])) {
    //         $sql = "SELECT idcargo as id, descripcion FROM public.cargo
    //         WHERE idtipocargo=".$request->input("idtipocargo")."
    //         ORDER BY idcargo ASC";
	// 	} else {
	// 		$sql = "SELECT idcargo as id, descripcion FROM public.cargo
    //         ORDER BY idcargo ASC";
	// 	}


    //     $result = DB::select($sql);
    //     echo json_encode($result);
    // }

    public function obtener_instituciones() {

        $sql = "SELECT idinstitucion as id, descripcion FROM iglesias.institucion
        ORDER BY descripcion ASC";
        $result = DB::select($sql);
        echo json_encode($result);
    }

    public function obtener_parentesco() {
        $result = $this->principal_model->obtener_parentesco();
        echo json_encode($result);
    }

    public function obtener_paises() {
        $result = $this->principal_model->obtener_paises();
        echo json_encode($result);
    }


    public function consultar_modulo(Request $request) {
        $sql = "SELECT * FROM seguridad.modulos AS m
        INNER JOIN seguridad.modulos_idiomas AS mi ON(m.modulo_id=mi.modulo_id)
        WHERE mi.idioma_id=".session("idioma_id")." AND mi.mi_descripcion ILIKE '%".$request->input("buscador")."%'";
    // die($sql);
        $result = DB::select($sql);
        echo json_encode($result);
    }


    public function EliminarProceso() {
    	unlink(base_path("public/procesos/proceso_".$_REQUEST["proceso_id"].".txt"));
    	echo "OK";
    }

    public function obtener_tipos_programa() {
        $result = $this->principal_model->obtener_tipos_programa();
        echo json_encode($result);
    }




}
