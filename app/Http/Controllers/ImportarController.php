<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\BaseModel;


class ImportarController extends Controller
{
    //
  
    
    public function __construct() {
        parent:: __construct();
        $this->base_model = new BaseModel();
    }

    public function importar() {
        ini_set('max_execution_time', 600);
        // $r = $this->SubirArchivo($_FILES["excel"], "./assets/excels/", "");
        $campos =  array();
        $celdas =  array();

        $inputFileType = 'Xlsx';
        $inputFileName = base_path("public/excel/Division Politica Venezuela - Adicional.xlsx");
        

        $reader = IOFactory::createReader($inputFileType);
        $reader->setLoadSheetsOnly("Hoja1");
        $spreadsheet = $reader->load($inputFileName);

        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        // echo "<pre>";
        // print_r($sheetData);
        // exit;
        // foreach ($sheetData as $key => $value) {
        //     if(!empty($value) && !empty($key)) {

        //         $campos[$key] = $value;
        //         $celdas[$value] = $key;
        //     }
        // }

        $count = count($sheetData);
        
        $division1 = array();
        $division2 = array();
        $division3 = array();
        $id1 = "";
        $id2 = "";
        $id3 = "";
        for ($i=2; $i <= $count ; $i++) { 
           // echo $sheetData[$i]["A"]. " ".$sheetData[$i]["B"]."<br>";
            $sql_d = "SELECT * FROM public.departamento WHERE descripcion='{$sheetData[$i]["A"]}' AND pais_id=6";
            $rd = DB::select($sql_d);
            if(count($rd) <= 0) {
                if(!in_array($sheetData[$i]["A"] , $division1)) {
                    array_push($division1, $sheetData[$i]["A"]);
    
                    $data_division1 = array(
                        "descripcion" => $sheetData[$i]["A"],
                        "pais_id" => 6
                    );
    
    
                    DB::table('public.departamento')->insert($data_division1);
                    $id1 = DB::getPdo()->lastInsertId();
                    echo "DIVISION 1: ".$sheetData[$i]["A"]. " INSERTADO ...<br>";
                }
            } else {
                $id1 = $rd[0]->iddepartamento;
                echo "DIVISION 1: ".$sheetData[$i]["A"]. " YA EXISTE ...<br>";
            }
            
            $sql_p = "SELECT * FROM public.provincia WHERE descripcion='{$sheetData[$i]["B"]}' AND iddepartamento={$id1}";
            $rp = DB::select($sql_p);
            if(count($rp) <= 0) {
                if(!in_array($sheetData[$i]["B"] , $division2)) {
                    array_push($division2, $sheetData[$i]["B"]);
    
    
                    $data_division2 = array(
                        "descripcion" => $sheetData[$i]["B"],
                        "iddepartamento" => $id1
                    );
    
    
                    DB::table('public.provincia')->insert($data_division2);
                    $id2 = DB::getPdo()->lastInsertId();
                    echo "DIVISION 2: ".$sheetData[$i]["B"]. " INSERTADO ...<br>";
                }
            } else {
                $id2 = $rp[0]->idprovincia;
                echo "DIVISION 2: ".$sheetData[$i]["A"]. " YA EXISTE ...<br>";
            }

            
            $sql_dd = "SELECT * FROM public.distrito WHERE descripcion='{$sheetData[$i]["C"]}' and idprovincia={$id2}";
            $rdd = DB::select($sql_dd);

            if(count($rdd) <= 0) {
                if(!in_array($sheetData[$i]["C"] , $division3)) {
                    array_push($division3, $sheetData[$i]["C"]);
    
    
                    $data_division3 = array(
                        "descripcion" => $sheetData[$i]["C"],
                        "idprovincia" => $id2
                    );
    
    
                    DB::table('public.distrito')->insert($data_division3);
                    $id3 = DB::getPdo()->lastInsertId();
                    echo "DIVISION 3: ".$sheetData[$i]["C"]. " INSERTADO ...<br>";
                }
            } else{ 
                echo "DIVISION 3: ".$sheetData[$i]["C"]. " YA EXISTE ...<br>";
            }

            
        }


        // print_r($division1);
        // print_r($division2); exit;
    }


    public function importar_() {
        ini_set('max_execution_time', 600);
        // $r = $this->SubirArchivo($_FILES["excel"], "./assets/excels/", "");
        $campos =  array();
        $celdas =  array();

        $inputFileType = 'Xlsx';
        $inputFileName = base_path("public/excel/Formato_Jerarquia_2.xlsx");
        

        $reader = IOFactory::createReader($inputFileType);
        $reader->setLoadSheetsOnly("Hoja1");
        $spreadsheet = $reader->load($inputFileName);

        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        // echo "<pre>";
        // print_r($sheetData);
        // exit;
        // foreach ($sheetData as $key => $value) {
        //     if(!empty($value) && !empty($key)) {

        //         $campos[$key] = $value;
        //         $celdas[$value] = $key;
        //     }
        // }

        $count = count($sheetData);
        
        $union = array();
        $asociacion = array();
        $distrito = array();
        // $distrito = array();

        $union_id = "";
        $asociacion_id = "";
        $distrito_id = "";
        for ($i=2; $i <= $count ; $i++) { 
           // echo $sheetData[$i]["A"]. " ".$sheetData[$i]["B"]."<br>";

            if(!in_array($sheetData[$i]["C"] , $union)) {
                array_push($union, $sheetData[$i]["C"]);

                $data_union = array(
                    "descripcion" => trim($sheetData[$i]["C"]),
                
                );


                DB::table('iglesias.union')->insert($data_union);
                $union_id = DB::getPdo()->lastInsertId();


                $data_union = array(
                    "idunion" => $union_id,
                    "pais_id" => trim($sheetData[$i]["B"])
                );


                DB::table('iglesias.union_paises')->insert($data_union);
               // $union_id = DB::getPdo()->lastInsertId();



                echo "UNION: ".$sheetData[$i]["C"]. " INSERTADO ...<br>";
            }

            if(!in_array($sheetData[$i]["D"] , $asociacion)) {
                array_push($asociacion, $sheetData[$i]["D"]);


                $data_asociacion = array(
                    "descripcion" => $sheetData[$i]["D"],
                    "idunion" => $union_id,
                );


                DB::table('iglesias.mision')->insert($data_asociacion);
                $asociacion_id = DB::getPdo()->lastInsertId();

                echo "ASOCIACION: ".$sheetData[$i]["D"]. " INSERTADO ...<br>";
            }


            if(!in_array($sheetData[$i]["E"] , $distrito)) {
                array_push($distrito, $sheetData[$i]["E"]);


                $data_distrito = array(
                    "descripcion" => $sheetData[$i]["E"],
                    "idmision" => $asociacion_id,
                );


                DB::table('iglesias.distritomisionero')->insert($data_distrito);
                $distrito_id = DB::getPdo()->lastInsertId();

                echo "DISTRITO MISIONERO: ".$sheetData[$i]["E"]. " INSERTADO ...<br>";
            }

             $sql_division = "SELECT * FROM public.departamento AS d
            INNER JOIN public.provincia AS p ON (d.iddepartamento=p.iddepartamento)
            /*INNER JOIN public.distrito AS dd ON (dd.idprovincia=p.idprovincia)*/
            WHERE upper(p.descripcion)='".trim(strtr(strtoupper($sheetData[$i]["J"]), "ãàèìòùáéíóúçñäëïöü", "ÃÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"))."'";
            $division = DB::select($sql_division);
            $data_iglesia =  array(
                "descripcion" => trim($sheetData[$i]["F"]),
                "direccion" => trim($sheetData[$i]["G"]),
                "iddivision" => trim($sheetData[$i]["A"]),
                "pais_id" => trim($sheetData[$i]["B"]),
                "idunion" => trim($union_id),
                "idmision" => trim($asociacion_id),
                "iddistritomisionero" => trim($distrito_id),
                "iddepartamento" => (isset($division[0]->iddepartamento)) ? $division[0]->iddepartamento : 0,
                "idprovincia" => (isset($division[0]->idprovincia)) ? $division[0]->idprovincia : 0,
                "iddistrito" => (isset($division[0]->iddistrito)) ? $division[0]->iddistrito : 0,
                "idcategoriaiglesia" => trim($sheetData[$i]["H"])
            );

            DB::table('iglesias.iglesia')->insert($data_iglesia);

            echo "IGLESIA: ".$sheetData[$i]["F"]. " INSERTADO ...<br>";
        }


        // print_r($division1);
        // print_r($division2); exit;
    }

    public function datos() {
        $view = "importar.index";
        $data["title"] = traducir("traductor.titulo_importar_datos");
        $data["subtitle"] = "";
        // $data["tabla"] = $this->cargos_model->tabla()->HTML();

      
        $data["scripts"] = $this->cargar_js(["importar.js"]);
        return parent::init($view, $data);
    }

    public function guardar_importar(Request $request) {
        // print_r($_FILES);
        // print_r($_REQUEST);
        ini_set('max_execution_time', 600);
        // $r = $this->SubirArchivo($_FILES["excel"], "./assets/excels/", "");
        $Procesos    = array();
        $FechaActual = date("Y-m-d H:i:s");
        $result =  array();
        try {
            $nombre_archivo = $request->input("dato")."_".date("dmY")."_".date("His");
            $response = $this->SubirArchivo($_FILES["excel"], base_path("public/excel/"), $nombre_archivo);
            if ($response["response"] == "ERROR") {
                throw new Exception(traducir("traductor.error_archivo"));
            }  

            $inputFileType = 'Xlsx';
            $inputFileName = base_path("public/excel/". $response["NombreFile"]);
            
    
            $reader = IOFactory::createReader($inputFileType);
            $reader->setLoadSheetsOnly($request->input("dato"));
            $spreadsheet = $reader->load($inputFileName);
    
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $elementos = count($sheetData);

            $Procesos["proceso_fecha_comienzo"]              = $FechaActual;
            $Procesos["proceso_fecha_actualizacion"]         = $FechaActual;
            $Procesos["proceso_total_elementos_procesar"]    = $elementos - 1;
            $Procesos["proceso_numero_elementos_procesados"] = "0";
    
            $Proceso                         = $this->base_model->insertar($this->preparar_datos("public.procesos", $Procesos));
            $result["proceso_id"]      = $Proceso["id"];
            $result["total_elementos"] = $elementos - 1;
            $result["NombreFile"] = $response["NombreFile"];
      
            if (!file_exists(base_path("public/procesos/"))) {
                mkdir(base_path("public/procesos/"), 0777);
            }


            $this->FileProceso("proceso_" . $Proceso["id"] . ".txt", ($elementos - 1), 0, 0, "0 segundos");
            echo json_encode($result);

        } catch (Exception $e) {
            DB::rollBack();
            $response["status"] = "ei"; 
            $response["msg"] = $e->getMessage(); 
            echo json_encode($response);
        }
    }
    

    public function importar_datos(Request $request) {
        ini_set('max_execution_time', 600);
        // $r = $this->SubirArchivo($_FILES["excel"], "./assets/excels/", "");
        $campos =  array();
        $celdas =  array();
        $result =  array();
        try {

    
            $inputFileType = 'Xlsx';
            $inputFileName = base_path("public/excel/". $request["NombreFile"]);
            
    
            $reader = IOFactory::createReader($inputFileType);
            $reader->setLoadSheetsOnly($request->input("dato"));
            $spreadsheet = $reader->load($inputFileName);
    
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            // echo "<pre>";
            // print_r($sheetData);

           
            foreach ($sheetData[1] as $key => $value) {
                if(!empty($value) && !empty($key)) {
    
                    $campos[$key] = $value;
                    $celdas[$value] = $key;
                }
            }

            // print_r($campos);
            // print_r($celdas);
            // exit;

            $data = array();
            for ($i=2; $i <= count($sheetData) ; $i++) {
                $data =  array();
                foreach ($sheetData[$i] as $k => $v) {
                    if(isset($campos[$k]) && isset($sheetData[$i][$celdas[$campos[$k]]]) ) {
    
                        $data[$campos[$k]] = strtr(trim($sheetData[$i][$celdas[$campos[$k]]]),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
                    }
                }

                if($request->input("dato") == "asociados") {
                    $idiglesia = (isset($sheetData[$i][$celdas["idiglesia"]])) ? $sheetData[$i][$celdas["idiglesia"]] : 0;
                    $jerarquia = DB::select("SELECT * FROM iglesias.vista_jerarquia WHERE idiglesia={$idiglesia}");
    

                    $idtipodoc = (isset($sheetData[$i][$celdas["idtipodoc"]])) ? $sheetData[$i][$celdas["idtipodoc"]] : 0;
                    $nrodoc = (isset($sheetData[$i][$celdas["nrodoc"]])) ? $sheetData[$i][$celdas["nrodoc"]] : 0;
                    $pais_id = (isset($jerarquia[0]->pais_id)) ? $jerarquia[0]->pais_id : 0;


                    $asociado = DB::select("SELECT * FROM iglesias.miembro WHERE idtipodoc={$idtipodoc} AND nrodoc='{$nrodoc}' AND pais_id={$pais_id}");
                    
                    if(count($asociado) > 0) {
                        continue; // asociado ya existe
                    }

                    $data["fecharegistro"] = date("Y-m-d H:i:s");
                  
                    // $iddistritodomicilio = (isset($sheetData[$i][$celdas["iddistritodomicilio"]])) ? $sheetData[$i][$celdas["iddistritodomicilio"]] : 0;



                   
                    // $division_politica = DB::select("SELECT * FROM public.vista_division_politica WHERE iddistrito={$iddistritodomicilio}");
                    
                    $data["iddivision"] = (isset($jerarquia[0]->iddivision)) ? $jerarquia[0]->iddivision : 0;
                    $data["pais_id"] = (isset($jerarquia[0]->pais_id)) ? $jerarquia[0]->pais_id : 0;
                    $data["pais_id_domicilio"] = (isset($jerarquia[0]->pais_id)) ? $jerarquia[0]->pais_id : 0;
                    $data["idunion"] = (isset($jerarquia[0]->idunion)) ? $jerarquia[0]->idunion : 0;
                    $data["idmision"] = (isset($jerarquia[0]->idmision)) ? $jerarquia[0]->idmision : 0;
                    $data["iddistritomisionero"] = (isset($jerarquia[0]->iddistritomisionero)) ? $jerarquia[0]->iddistritomisionero : 0;
                    // $data["iddepartamentodomicilio"] = (isset($division_politica[0]->iddepartamento)) ? $division_politica[0]->iddepartamento : 0;
                    // $data["idprovinciadomicilio"] = (isset($division_politica[0]->idprovincia)) ? $division_politica[0]->idprovincia : 0;
                    // $data["iddistritodomicilio"] = (isset($division_politica[0]->iddistrito)) ? $division_politica[0]->iddistrito : 0;


                    $encargado_bautizo = DB::select("SELECT idmiembro AS id FROM iglesias.miembro WHERE idtipodoc={$sheetData[$i][$celdas["idtipodoc_encargado_bautizo"]]} AND nrodoc='{$sheetData[$i][$celdas["nrodoc_encargado_bautizo"]]}'");
                    $data["tabla_encargado_bautizo"] = "iglesias.miembro";

                    if(count($encargado_bautizo) <= 0) {
                        $encargado_bautizo = DB::select("SELECT idotrospastores AS id FROM iglesias.otrospastores WHERE idtipodoc={$sheetData[$i][$celdas["idtipodoc_encargado_bautizo"]]} AND nrodoc='{$sheetData[$i][$celdas["nrodoc_encargado_bautizo"]]}'");
                        $data["tabla_encargado_bautizo"] = "iglesias.otrospastores";
                    }
                    
                    $data["encargado_bautizo"] = $encargado_bautizo[0]->id;

                    $result = $this->base_model->insertar($this->preparar_datos("iglesias.miembro", $data));
                }
                // print_r($data);
                if($request->input("dato") == "iglesias") {

                    $iddistritomisionero = (isset($sheetData[$i][$celdas["iddistritomisionero"]])) ? $sheetData[$i][$celdas["iddistritomisionero"]] : 0;
                    // $iddistrito = (isset($sheetData[$i][$celdas["iddistrito"]])) ? $sheetData[$i][$celdas["iddistrito"]] : 0;


                    $jerarquia = DB::select("SELECT * FROM iglesias.vista_jerarquia WHERE iddistritomisionero={$iddistritomisionero}");
    
                    // $division_politica = DB::select("SELECT * FROM public.vista_division_politica WHERE iddistrito={$iddistrito}");
                    
                    $data["iddivision"] = (isset($jerarquia[0]->iddivision)) ? $jerarquia[0]->iddivision : 0;
                    $data["pais_id"] = (isset($jerarquia[0]->pais_id)) ? $jerarquia[0]->pais_id : 0;
                    $data["idunion"] = (isset($jerarquia[0]->idunion)) ? $jerarquia[0]->idunion : 0;
                    $data["idmision"] = (isset($jerarquia[0]->idmision)) ? $jerarquia[0]->idmision : 0;
                    $data["iddistritomisionero"] = (isset($jerarquia[0]->iddistritomisionero)) ? $jerarquia[0]->iddistritomisionero : 0;
                    // $data["iddepartamento"] = (isset($division_politica[0]->iddepartamento)) ? $division_politica[0]->iddepartamento : 0;
                    // $data["idprovincia"] = (isset($division_politica[0]->idprovincia)) ? $division_politica[0]->idprovincia : 0;
                    // $data["iddistrito"] = (isset($division_politica[0]->iddistrito)) ? $division_politica[0]->iddistrito : 0;
                   
                    $result = $this->base_model->insertar($this->preparar_datos("iglesias.iglesia", $data));
                }


                if($request->input("dato") == "cargos") {
                    $idtipodoc = (isset($sheetData[$i][$celdas["idtipodoc"]])) ? $sheetData[$i][$celdas["idtipodoc"]] : 0;
                    $nrodoc = (isset($sheetData[$i][$celdas["nrodoc"]])) ? $sheetData[$i][$celdas["nrodoc"]] : 0;
                    $pais_id = (isset($sheetData[$i][$celdas["pais_id"]])) ? $sheetData[$i][$celdas["pais_id"]] : 0;
                    $idjerarquia = (isset($sheetData[$i][$celdas["idjerarquia"]])) ? $sheetData[$i][$celdas["idjerarquia"]] : 0;

                    $tabla = "";
                    $asociado = DB::select("SELECT * FROM iglesias.miembro WHERE idtipodoc={$idtipodoc} AND nrodoc='{$nrodoc}' AND pais_id={$pais_id}");
                    
                    if(count($asociado) <= 0) {
                        continue; // asociado no existe
                    }
                    switch ($idjerarquia) {
                        case '1':
                            $tabla = "iglesias.division";
                            break;
                        case '2':
                            $tabla = "iglesias.paises";
                            break;
                        case '3':
                            $tabla = "iglesias.union";
                            break;
                        case '4':
                            $tabla = "iglesias.mision";
                            break; 
                        case '5':
                            $tabla = "iglesias.distritomisionero";
                            break;      
                        case '6':
                            $tabla = "iglesias.iglesia";
                            break;                 
                    }

                    $data["idmiembro"] = $asociado[0]->idmiembro;
                    $data["tabla"] = $tabla;
                    $result = $this->base_model->insertar($this->preparar_datos("iglesias.cargo_miembro", $data));
                }

                if($request->input("dato") == "capacitaciones") {
                    $idtipodoc = (isset($sheetData[$i][$celdas["idtipodoc"]])) ? $sheetData[$i][$celdas["idtipodoc"]] : 0;
                    $nrodoc = (isset($sheetData[$i][$celdas["nrodoc"]])) ? $sheetData[$i][$celdas["nrodoc"]] : 0;
                    $pais_id = (isset($sheetData[$i][$celdas["pais_id"]])) ? $sheetData[$i][$celdas["pais_id"]] : 0;
                    

                    $asociado = DB::select("SELECT * FROM iglesias.miembro WHERE idtipodoc={$idtipodoc} AND nrodoc='{$nrodoc}' AND pais_id={$pais_id}");
                    
                    if(count($asociado) <= 0) {
                        continue; // asociado no existe
                    }

                    $data["idmiembro"] = $asociado[0]->idmiembro;
                  
                    $result = $this->base_model->insertar($this->preparar_datos("iglesias.cargo_miembro", $data));
                }


                if($request->input("dato") == "familiares") {
                    $idtipodoc = (isset($sheetData[$i][$celdas["idtipodoc_asociado"]])) ? $sheetData[$i][$celdas["idtipodoc_asociado"]] : 0;
                    $nrodoc = (isset($sheetData[$i][$celdas["nrodoc_asociado"]])) ? $sheetData[$i][$celdas["nrodoc_asociado"]] : 0;
                    $pais_id = (isset($sheetData[$i][$celdas["pais_id"]])) ? $sheetData[$i][$celdas["pais_id"]] : 0;
                    

                    $asociado = DB::select("SELECT * FROM iglesias.miembro WHERE idtipodoc={$idtipodoc} AND nrodoc='{$nrodoc}' AND pais_id={$pais_id}");
                    
                    if(count($asociado) <= 0) {
                        continue; // asociado no existe
                    }

                    $data["idmiembro"] = $asociado[0]->idmiembro;
                  
                    $result = $this->base_model->insertar($this->preparar_datos("iglesias.parentesco_miembro", $data));
                }

                if($request->input("dato") == "estudios") {
                    $idtipodoc = (isset($sheetData[$i][$celdas["idtipodoc"]])) ? $sheetData[$i][$celdas["idtipodoc"]] : 0;
                    $nrodoc = (isset($sheetData[$i][$celdas["nrodoc"]])) ? $sheetData[$i][$celdas["nrodoc"]] : 0;
                    $pais_id = (isset($sheetData[$i][$celdas["pais_id"]])) ? $sheetData[$i][$celdas["pais_id"]] : 0;
                    

                    $asociado = DB::select("SELECT * FROM iglesias.miembro WHERE idtipodoc={$idtipodoc} AND nrodoc='{$nrodoc}' AND pais_id={$pais_id}");
                    
                    if(count($asociado) <= 0) {
                        continue; // asociado no existe
                    }

                    $data["idmiembro"] = $asociado[0]->idmiembro;
                  
                    $result = $this->base_model->insertar($this->preparar_datos("iglesias.educacion_miembro", $data));
                }


                if($request->input("dato") == "experiencia_laboral") {
                    $idtipodoc = (isset($sheetData[$i][$celdas["idtipodoc"]])) ? $sheetData[$i][$celdas["idtipodoc"]] : 0;
                    $nrodoc = (isset($sheetData[$i][$celdas["nrodoc"]])) ? $sheetData[$i][$celdas["nrodoc"]] : 0;
                    $pais_id = (isset($sheetData[$i][$celdas["pais_id"]])) ? $sheetData[$i][$celdas["pais_id"]] : 0;
                    

                    $asociado = DB::select("SELECT * FROM iglesias.miembro WHERE idtipodoc={$idtipodoc} AND nrodoc='{$nrodoc}' AND pais_id={$pais_id}");
                    
                    if(count($asociado) <= 0) {
                        continue; // asociado no existe
                    }

                    $data["idmiembro"] = $asociado[0]->idmiembro;
                  
                    $result = $this->base_model->insertar($this->preparar_datos("iglesias.laboral_miembro", $data));
                }

                DB::update('UPDATE public.procesos SET proceso_numero_elementos_procesados = proceso_numero_elementos_procesados + 1 WHERE proceso_id = ' . $_REQUEST["proceso_id"]);
        

                $row_process = DB::select('SELECT * FROM public.procesos WHERE proceso_id =' . $_REQUEST["proceso_id"]);

                $percentage = round(((int) $row_process[0]->proceso_numero_elementos_procesados * 100) / (int) $row_process[0]->proceso_total_elementos_procesar, 2);

                $date_add = new \DateTime($row_process[0]->proceso_fecha_comienzo);
                $date_upd = new \DateTime($row_process[0]->proceso_fecha_actualizacion);
                $diff     = $date_add->diff($date_upd);

                $execute_time = '';

                if ($diff->days > 0) {
                    $execute_time .= $diff->days . ' dias';
                }
                if ($diff->h > 0) {
                    $execute_time .= ' ' . $diff->h . ' horas';
                }
                if ($diff->i > 0) {
                    $execute_time .= ' ' . $diff->i . ' minutos';
                }

                if ($diff->s > 1) {
                    $execute_time .= ' ' . $diff->s . ' segundos';
                } else {
                    $execute_time .= ' 1 segundo';
                }

    
                DB::update("UPDATE public.procesos SET proceso_porcentaje_actual_progreso = " . $percentage . ", proceso_tiempo_transcurrido = '" . (string) $execute_time . "', proceso_fecha_actualizacion='" . date("Y-m-d H:i:s") . "' WHERE proceso_id = " . $_REQUEST["proceso_id"]);

                $Response = DB::select('SELECT * FROM public.procesos WHERE proceso_id =' . $_REQUEST["proceso_id"]);
                $this->FileProceso("proceso_" . $_REQUEST["proceso_id"] . ".txt", $_REQUEST["total_elementos"], $Response[0]->proceso_numero_elementos_procesados, $percentage, $execute_time);
               
                // print_r($sheetData[$i][$celdas["idiglesia"]]."<br>");
                // $this->db->insert($_REQUEST["tabla"], $data);
               
            }

          
        
            echo json_encode($result);
        } catch (Exception $e) {
            DB::rollBack();
            $response["status"] = "ei"; 
            $response["msg"] = $e->getMessage(); 
            echo json_encode($response);
        }
    }

    public function procesos(Request $request) {
        echo file_get_contents(base_path("public/procesos/proceso_".$request["proceso_id"].".txt"));
    }
}
