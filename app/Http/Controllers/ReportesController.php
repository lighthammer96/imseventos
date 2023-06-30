<?php

namespace App\Http\Controllers;

use App\Exports\VuelosExport;
use App\Models\PrincipalModel;


// use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
class ReportesController extends Controller
{
    //
    // private $base_model;

    private $reportes_model;
    private $principal_model;


    public function __construct() {
        parent:: __construct();

        $this->principal_model = new PrincipalModel();

        // $this->base_model = new BaseModel();
    }

    public function index() {
        $view = "reportes.general_asociados";
        $data["title"] = traducir("traductor.titulo_general_asociados");
        $data["subtitle"] = "";
        // $data["tabla"] = $this->ReportesController_model->tabla()->HTML();

        // $botones = array();
        // $botones[0] = '<button disabled="disabled" tecla_rapida="F1" style="margin-right: 5px;" class="btn btn-primary btn-sm" id="nuevo-perfil">'.traducir("traductor.nuevo").' [F1]</button>';
        // $botones[1] = '<button disabled="disabled" tecla_rapida="F2" style="margin-right: 5px;" class="btn btn-success btn-sm" id="modificar-perfil">'.traducir("traductor.modificar").' [F2]</button>';
        // $botones[2] = '<button disabled="disabled" tecla_rapida="F7" style="margin-right: 5px;" class="btn btn-danger btn-sm" id="eliminar-perfil">'.traducir("traductor.eliminar").' [F7]</button>';
        // $data["botones"] = $botones;
        $data["scripts"] = $this->cargar_js(["idiomas.js", "ReportesController.js"]);
        return parent::init($view, $data);


    }

    public function vuelos() {
        $view = "reportes.vuelos";
        // echo traducir("traductor.titulo_general_asociados");
        // exit;
        $data["title"] = 'Reporte de Vuelos';
        $data["subtitle"] = "";

        $data["scripts"] = $this->cargar_js(["reporte_vuelos.js"]);
        return parent::init($view, $data);
    }

    public function imprimir_fichas_asociados(Request $request) {
        // echo "hola";
        // print_r($request->input("iddivision"));


        $miembros = $this->obtener_miembros($request, "fichas");

        if(count($miembros) <= 0) {
            echo '<script>alert("'.traducir("traductor.no_hay_datos").'"); window.close();</script>';
            exit;
        }
        $sql_estado_civil = "SELECT * FROM public.estadocivil";
        $estado_civil = DB::select($sql_estado_civil);
        // $sql_motivos_baja = "SELECT * FROM iglesias.motivobaja";
        // $motivos_baja = DB::select($sql_motivos_baja);

        foreach ($miembros as $km => $vm) {
            $sql_baja = "SELECT h.*, ".formato_fecha_idioma("h.fecha")." AS fecha, mb.descripcion AS motivo_baja
            FROM iglesias.historial_altasybajas AS h
            INNER JOIN iglesias.motivobaja AS mb ON(mb.idmotivobaja=h.idmotivobaja)
            WHERE h.idmiembro=".$vm->idmiembro."
            ORDER BY h.fecha DESC";
            $miembros[$km]->bajas = DB::select($sql_baja);



            $sql_cargos = "SELECT c.descripcion AS cargo, cm.periodoini, cm.periodofin, cm.lugar FROM iglesias.miembro AS m
            INNER JOIN iglesias.cargo_miembro AS cm ON(cm.idmiembro=m.idmiembro)
            INNER JOIN public.cargo AS c ON(c.idcargo=cm.idcargo)
            WHERE m.idmiembro=".$vm->idmiembro;

            $miembros[$km]->cargos = DB::select($sql_cargos);


            $sql_control = "SELECT ".formato_fecha_idioma("ct.fecha")." AS fecha_aceptacion, ".formato_fecha_idioma("ht.fecha")." AS fecha_aceptacion_local FROM iglesias.control_traslados AS ct
            INNER JOIN iglesias.historial_traslados AS ht ON(ct.idcontrol=ht.idcontrol)
            WHERE estado='0' AND ht.idmiembro=".$vm->idmiembro."
            ORDER BY ct.idcontrol DESC";
            $control = DB::select($sql_control);
            $miembros[$km]->fecha_aceptacion = (isset($control[0]->fecha_aceptacion)) ? $control[0]->fecha_aceptacion : "";
            $miembros[$km]->fecha_aceptacion_local = (isset($control[0]->fecha_aceptacion_local)) ? $control[0]->fecha_aceptacion_local : "";

        }




        $datos["estado_civil"] = $estado_civil;
        // $datos["baja"] = $baja;
        // $datos["motivos_baja"] = $motivos_baja;

        // $datos["cargos"] = $cargos;
        $datos["miembros"] = $miembros;
        // print_r($miembros[0]); exit;
        $datos["nivel_organizativo"] = $this->obtener_nivel_organizativo($_REQUEST);


        // referencia: https://styde.net/genera-pdfs-en-laravel-con-el-componente-dompdf/

        $pdf = PDF::loadView("reportes.fichas", $datos)->setPaper('A4', "portrait");

        // return $pdf->save("ficha_asociado.pdf"); // guardar
        // return $pdf->download("ficha_asociado.pdf"); // descargar
        return $pdf->stream("fichas_asociados.pdf"); // ver
    }

    public function exportar_excel_reporte_vuelos(Request $request) {
        // $miembros = $this->obtener_miembros($request, "");

        // if(count($miembros) <= 0) {
        //     echo '<script>alert("'.traducir("traductor.no_hay_datos").'"); window.close();</script>';
        //     exit;
        // }
        // echo '<script>window.close();</script>';
        return Excel::download(new VuelosExport, 'reporte_vuelos.xlsx');

    }









    public function select_init(Request $request) {

        $data["idcondicioneclesiastica"] = $this->principal_model->obtener_condicion_eclesiastica();
        $data["idcondicioneclesiastica_all"] = $this->principal_model->obtener_condicion_eclesiastica_all();

        echo json_encode($data);
    }
}
