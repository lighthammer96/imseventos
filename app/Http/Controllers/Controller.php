<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    private $base_model;
    private $css;
    private $js;

    public function __construct() {
        $this->base_model = new BaseModel();
        date_default_timezone_set("America/Lima");

    }

    public function getDate() {
        return date("Y-m-d");
    }

    public function init($view, $datos = array()) {
        // echo traducir("traductor.valor"); exit;
        // App::setLocale("es");
        // echo traducir("traductor.buscar");
        // App::setLocale("en");
        // echo traducir("traductor.buscar"); exit;
        // echo Lang::has('traductor.buscar'); exit;
        // ;
        // var_dump(session('usuario_id')); exit;
        if (session('usuario_id')) {

            $datos["modulos"]   = $this->base_model->getPermisos(true);

            return view($view, $datos);
        } else {
            // echo "ola";
            return redirect('/');
        }
    }


    public function cargar_css($css_array) {
        for ($i = 0; $i < count($css_array); $i++) {
            // $this->css[] = '<link href="' . URL::asset('app/css/' . $css_array[$i]) . '" rel="stylesheet" />';
            $this->css[] = URL::asset('app/css/' . $css_array[$i]);
        }
        return $this->css;
    }

    public function cargar_js($js_array) {
        for ($i = 0; $i < count($js_array); $i++) {
            //$this->js[] = '<script src="' . URL::asset('app/js/' . $js_array[$i]) . '"></script>';
            $this->js[] =  URL::asset('app/js/' . $js_array[$i]);
        }
        return $this->js;
    }

    public function listar_campos($tabla) {

        $campos = array();
        $primary_key = array();
        $foreign_key = array();
        $tabla = explode(".", $tabla);

        $schema = $tabla[0];
        $table = $tabla[1];

        // $sql = "SELECT * FROM INFORMATION_SCHEMA.constraint_column_usage WHERE table_schema='eventos' AND table_name='participantes'";
        // echo $sql;
        // $r = DB::select($sql);
        // print_r($r);
        // $sql = "SELECT * FROM INFORMATION_SCHEMA.key_column_usage WHERE table_schema='eventos' AND table_name='participantes'";
        // echo $sql;
        // $r = DB::select($sql);
        // print_r($r);
        // $sql = "SELECT * FROM INFORMATION_SCHEMA.referential_constraints WHERE constraint_schema='eventos'";
        // echo $sql;
        // $r = DB::select($sql);
        // print_r($r);
        // $sql = "SELECT * FROM INFORMATION_SCHEMA.columns WHERE table_schema='eventos' AND table_name='participantes'";
        // echo $sql;
        // $r = DB::select($sql);
        // print_r($r);
        // exit;
        $sql = "SELECT cols.column_name, cols.data_type, CASE WHEN EXISTS(SELECT * FROM INFORMATION_SCHEMA.key_column_usage k WHERE k.table_schema = cols.table_schema AND k.table_name = cols.table_name AND k.column_name = cols.column_name AND k.position_in_unique_constraint IS NULL)
        THEN 1 ELSE 0 END as is_primary_key,
        CASE WHEN EXISTS(SELECT * FROM INFORMATION_SCHEMA.key_column_usage k WHERE k.table_schema = cols.table_schema AND k.table_name = cols.table_name AND k.column_name = cols.column_name) AND
        EXISTS(SELECT * FROM INFORMATION_SCHEMA.referential_constraints f INNER JOIN INFORMATION_SCHEMA.key_column_usage k ON k.constraint_name = f.constraint_name WHERE k.column_name = cols.column_name)
        THEN 1 ELSE 0 END as is_foreign_key
        FROM information_schema.columns cols
        WHERE cols.table_schema='{$schema}' AND cols.table_name= '{$table}'";
        echo $sql;
        $result = DB::select($sql);
        print_r($result);
        exit;
        foreach ($result as $key => $value) {
            array_push($campos, $value->column_name);
            if($value->is_primary_key == 1) {

                array_push($primary_key, $value->column_name);
            }

            if($value->is_foreign_key == 1) {

                array_push($foreign_key, $value->column_name);
            }

        }

        $data = array();
        $data["campos"] = $campos;
        $data["primary_key"] = $primary_key;
        $data["foreign_key"] = $foreign_key;

        return $data;
    }

    public function toUpper($fields, $excluidos = array()) {
        foreach ($fields as $key => $value) {

            if (!in_array($key, $excluidos)) {
                if (gettype($value) == 'string') {
                    $fields[$key] = strtr(strtoupper($value), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
                }
            }
        }
        return $fields;
    }


    /**
    * [preparar_datos description]
    * @param  [type]  $table [la tabla donde se va insertar]
    * @param  [type]  $data  [los request de datos]
    * @param  [type]  $tipoTabla  [N -> si un tabla normal, D -> si un detalle]
    * @return [type]         [array de campo de la respectivaa tabla con su valor del request]
    */
    public function preparar_datos($table, $data, $tipoTabla = 'N') {
        // print_r($data); exit;
        $parametros = array();

        // $tabla  = $this->sinSchema($table);
        //$fields = $this->db->list_fields($tabla);
        $fields = $this->listar_campos($table);
        // print_r($fields); exit;
        $datos = array();

        //ordenamos los campos de acuerdo a la tabla que corresponde
        for ($i = 0; $i < count($fields["campos"]); $i++) {
            if (isset($data[$fields["campos"][$i]])) {
                $datos[$fields["campos"][$i]] = $data[$fields["campos"][$i]];
            }
        }



        // echo $table."\n";
        // echo gettype(array_values($datos)[1])."\n";
        //PONEMOS EN EL PRIMER ELEMENTO A LA CLAVE SE REPITE EN RESTO DE REGISTRO EN EL CASO DE SER UN DETALLE
        // print_r($datos); exit;
         // cuando es detalle
        if ($tipoTabla == "D") {
            $cantElementos = 0;

            foreach ($datos as $key => $value) {
                if(gettype($value) == "array") {
                    $cantElementos = count($value);
                    break;
                }
            }
            foreach ($datos as $key => $value) {

                if(gettype($value) != "array") {

                    for ($i = 0; $i < $cantElementos; $i++) {
                        $parametros["datos"][$i][$key] = $value;
                    }
                } else {
                    for ($i = 0; $i < $cantElementos; $i++) {

                        // para que inserte solo los campos que tiene dicha tabla
                        if (in_array($key, $fields["campos"])) {
                            // echo $primer_key." ".$key."\n";
                            if(isset($value[$i]) && $value[$i] != "" && $value[$i] != "null") {
                                //@$parametros["datos"][$i][$key] = NULL;
                                @$parametros["datos"][$i][$key] = $value[$i];
                            } else {
                                @$parametros["datos"][$i][$key] = NULL;
                            }

                        }



                    }
                }
            }
        }

        // cuando es tabla normal y no es detalle
        if ($tipoTabla == "N") {

            foreach ($datos as $key => $value) {
                if (in_array($key, $fields["campos"])) {
                    // var_dump(!empty($value));
                    if($value === 0) {
                        $value = "0";
                    }
                    if ($value != "" && $value != "null") {

                        $parametros["datos"][0][$key] = $value;
                        // $parametros["datos"][0][$key] = NULL;
                    //
                    } elseif (!in_array($key, $fields["primary_key"])) {
                        $parametros["datos"][0][$key] = NULL; // esto es para cuando modificas un campos que cuando lo registraste tenia informacion y ahora que lo modificas quieres que este vacio
                    }
                }

            }

        }

        //  $parametros["data"][0] = (object) $parametros["data"][0];
        $parametros["tabla"] = $table;

        return $parametros;
    }

    public function sinSchema($table) {
        $schema = explode(".", $table);
        // print_r($schema);
        if (count($schema) > 1) {
            $tabla = $schema[1];
        } else {
            $tabla = $table;
        }
        return $tabla;
    }

    /**
     * [exploderequest lo utilice para el extends de modulos padres]
     * @param  [type] $fields [description]
     * @return [type]         [description]
     */
    public function explode_request($fields) {
        $array = array();
        $cont  = 0;
        foreach ($fields as $key => $value) {
            $arr = explode("|", $key);
            if (count($arr) > 1) {
                $cont++;
                $array[$arr[0]] = $value;
            }
        }

        if ($cont > 0) {
            return $array;
        } else {
            return $fields;
        }

    }

    /**
     * [uploadfiles description]
     * @param  [array] $config [configuracion como la ruta, tamaño del file, etc]
     * @param  [string] $file   [nombre del file]
     * @return [string]         [status de la subida]
     */
    public function SubirArchivo($archivo, $ruta, $newname = "") {
        ini_set('memory_limit', '2024M');
        ini_set('upload_max_filesize', '2024M');
        $dir_subida = $ruta;

        if ($newname != "") {
            $exts = explode(".", $archivo['name']);

            if (count($exts) > 0) {
                $ext = $exts[count($exts) - 1];
            } else {
                $ext = "jpg";
            }

            $filename = $newname . "." . $ext;
        } else {
            $filename = $archivo['name'];
        }

        $fichero_subido = $dir_subida . basename($filename);
        //SI NO EXISTE LA CARPETA LO CREAMOS CON TODOS LOS PERMISOS
        if (!file_exists($ruta)) {
            mkdir($ruta, 0777, true);
        }

        $response = array();
        if (move_uploaded_file($archivo['tmp_name'], $fichero_subido)) {
            chmod($fichero_subido, 0777);
            $response["response"]   = "OK";
            $response["NombreFile"] = $filename;

        } else {
            $response["response"]   = "ERROR";
            $response["NombreFile"] = $filename;

        }
        return $response;
    }

    public function FormatoFecha($fecha, $formato) {
        // echo $fecha."\n";
        if ($fecha != null) {
            if ($formato == "user") {
                $date = explode("-", $fecha);
                if (count($date) == 3) {
                    return $date[2] . "/" . $date[1] . "/" . $date[0];
                }
            }

            if ($formato == "server") {
                $date = explode("/", $fecha);
                if (count($date) == 3) {
                    return $date[2] . "-" . $date[1] . "-" . $date[0];
                }
            }
        }

        return $fecha;
    }


    public function obtener_nivel_organizativo($jerarquia) {
        $sql = "";
        if(isset($jerarquia["iddivision"]) && $jerarquia["iddivision"] != '' && $jerarquia["iddivision"] != '0') {
            $sql = "SELECT CASE WHEN di.di_descripcion IS NULL THEN
            (SELECT di_descripcion FROM iglesias.division_idiomas WHERE iddivision=d.iddivision AND idioma_id=".session("idioma_id_defecto").")
            ELSE di.di_descripcion END AS descripcion FROM iglesias.division AS d
            LEFT JOIN iglesias.division_idiomas AS di on(di.iddivision=d.iddivision AND di.idioma_id=".session("idioma_id").")
            WHERE d.iddivision={$jerarquia["iddivision"]}";
        }

        if(isset($jerarquia["pais_id"]) && $jerarquia["pais_id"] != '' && $jerarquia["pais_id"] != '0') {
            $sql = "SELECT paise_descripcion AS descripcion FROM iglesias.paises WHERE pais_id={$jerarquia["pais_id"]}";
        }

        if(isset($jerarquia["idunion"]) && $jerarquia["idunion"] != '' && $jerarquia["idunion"] != '0') {
            $sql = "SELECT descripcion FROM iglesias.union WHERE idunion={$jerarquia["idunion"]}";
        }

        if(isset($jerarquia["idmision"]) && $jerarquia["idmision"] != '' && $jerarquia["idmision"] != '0') {
            $sql = "SELECT descripcion FROM iglesias.mision WHERE idmision={$jerarquia["idmision"]}";
        }

        if(isset($jerarquia["iddistritomisionero"]) && $jerarquia["iddistritomisionero"] != '' && $jerarquia["iddistritomisionero"] != '0') {
            $sql = "SELECT descripcion FROM iglesias.distritomisionero WHERE iddistritomisionero={$jerarquia["iddistritomisionero"]}";
        }

        if(isset($jerarquia["idiglesia"]) && $jerarquia["idiglesia"] != '' && $jerarquia["idiglesia"] != '0') {
            $sql = "SELECT descripcion FROM iglesias.iglesia WHERE idiglesia={$jerarquia["idiglesia"]}";
        }

            // die($sql);
        $nivel = "";
        if($sql != "") {
            $nivel = DB::select($sql);
            $nivel = $nivel[0]->descripcion;
        }

        return $nivel;
    }

    public function FileProceso($File, $TotalElementos, $ElementosProcesados = 0, $PorcentajeProgreso = 0, $TiempoTranscurrido = "0 segundos") {

        $texto = "";

        $texto = $TotalElementos . "|" . $ElementosProcesados . "|" . $PorcentajeProgreso . "|" . $TiempoTranscurrido;
        // file_put_contents("./procesos/" . $File, $texto);
        file_put_contents(base_path("public/procesos/") . $File, $texto);

    }



    public function procesar_resultados($request) {
        $votacion = array();
        $sql = "SELECT * FROM asambleas.votaciones AS vs
        WHERE vs.estado='A' AND vs.propuesta_id = {$request->input("propuesta_id")} AND vs.tabla='{$request->input("tabla")}'";

        $votacion = DB::select($sql);
        // var_dump(count($votacion));  exit;
        if(count($votacion) <= 0)  {
            $votacion[0] = (object) array("votacion_id" => 0);
            return $votacion;
        }
        // DB::table("asambleas.resultados")->where("votacion_id", $votacion[0]->votacion_id)->delete();

        $sql_results = "SELECT * FROM asambleas.resultados WHERE votacion_id = {$votacion[0]->votacion_id}";
        $results = DB::select($sql_results);
        if(count($results) > 0) {
            // $sql_resolucion = "SELECT * FROM asambleas.resoluciones WHERE resultado_id={$results[0]->resultado_id}";
            // $resolucion = DB::select($sql_resolucion);

            // if(count($resolucion) > 0) {
            //     return $votacion;
            // }

            if(!empty($results[0]->resolucion_id)) {
                // echo "ola";
                return $votacion;
            }

        }

        if($votacion[0]->fv_id == 1 || $votacion[0]->fv_id == 2) {
            //
            $result = array();
            $sql_forma = "SELECT * FROM asambleas.formas_votacion WHERE fv_id={$votacion[0]->fv_id}";
            $forma = DB::select($sql_forma);
            $criterios = explode(",", $forma[0]->fv_descripcion);

            for ($i=0; $i < count($criterios); $i++) {
                $sql = "SELECT CASE
                WHEN v.voto_item = 0 THEN '".$criterios[0]."'
                WHEN v.voto_item = 1 THEN '".$criterios[1]."'
                WHEN v.voto_item = 2 THEN '".$criterios[2]."'
                END AS resultado_descripcion,
                COUNT(v.voto_item) AS resultado_votos,
                vs.votacion_id,  COUNT(v.voto_item) AS resultado_total
                FROM asambleas.propuestas_temas AS pt
                LEFT JOIN asambleas.votaciones AS vs ON(vs.propuesta_id=pt.pt_id AND vs.tabla='asambleas.propuestas_temas')
                LEFT JOIN asambleas.votos AS v ON(vs.votacion_id=v.votacion_id AND pt.pt_id=v.propuesta_id AND v.tabla='asambleas.propuestas_temas' )
                WHERE vs.votacion_id={$votacion[0]->votacion_id} AND v.voto_item={$i}
                GROUP BY v.voto_item, vs.votacion_id";
                // die($sql);
                $res = DB::select($sql);

                if(count($res) > 0) {
                    $arr = $res[0];
                } else {
                    $arr = array();
                    $arr["resultado_descripcion"] = $criterios[$i];
                    $arr["resultado_votos"] = 0;
                    $arr["resultado_total"] = 0;
                    $arr["votacion_id"] = $votacion[0]->votacion_id;
                }

                array_push($result, (object)$arr);
            }

        }

        if($votacion[0]->fv_id == 3) {

            $sql = "SELECT (m.apellidos || ', ' || m.nombres) AS resultado_descripcion, COUNT(v.idmiembro_votado) AS resultado_votos, SUM(CASE WHEN v.voto_item = -1 OR v.voto_item IS NULL THEN 0 ELSE 1 END) AS abstenciones, vs.votacion_id, COUNT(v.idmiembro_votado) AS resultado_total
            FROM asambleas.propuestas_elecciones AS pe
            LEFT JOIN asambleas.votaciones AS vs ON(vs.propuesta_id=pe.pe_id AND vs.tabla='asambleas.propuestas_elecciones')
            LEFT JOIN asambleas.votos AS v ON(vs.votacion_id=v.votacion_id AND pe.pe_id=v.propuesta_id AND v.tabla='asambleas.propuestas_elecciones' )
            LEFT JOIN iglesias.miembro AS m ON(m.idmiembro=v.idmiembro_votado)
            WHERE vs.votacion_id={$votacion[0]->votacion_id}
            GROUP BY m.apellidos, m.nombres, vs.votacion_id";
            // die($sql);
            $result = DB::select($sql);
        }

        if($votacion[0]->fv_id == 4) {

            $sql = "SELECT v.voto_numero AS resultado_descripcion, COUNT(v.voto_numero) AS resultado_votos, SUM(CASE WHEN v.voto_item = -1 OR v.voto_item IS NULL THEN 0 ELSE 1 END) AS abstenciones, vs.votacion_id, COUNT(v.voto_numero) AS resultado_total
            FROM asambleas.propuestas_elecciones AS pe
            LEFT JOIN asambleas.votaciones AS vs ON(vs.propuesta_id=pe.pe_id AND vs.tabla='asambleas.propuestas_elecciones')
            LEFT JOIN asambleas.votos AS v ON(vs.votacion_id=v.votacion_id AND pe.pe_id=v.propuesta_id AND v.tabla='asambleas.propuestas_elecciones' )
            LEFT JOIN iglesias.miembro AS m ON(m.idmiembro=v.idmiembro_votado)
            WHERE vs.votacion_id={$votacion[0]->votacion_id}
            GROUP BY v.voto_numero, vs.votacion_id";
            // die($sql);
            $result = DB::select($sql);
        }

        if($votacion[0]->fv_id == 6 || $votacion[0]->fv_id == 8) {
            //

            $sql = "
            (SELECT 'Abstenciones' AS resultado_descripcion, 0 AS resultado_votos, SUM(CASE WHEN v.voto_item = -1 OR v.voto_item IS NULL THEN 0 ELSE 1 END) AS abstenciones, vs.votacion_id, 0 AS resultado_total, 0 AS idmiembro
            FROM asambleas.votos AS v
            INNER JOIN asambleas.votaciones AS vs ON(vs.votacion_id=v.votacion_id AND vs.propuesta_id=v.propuesta_id AND v.tabla='asambleas.propuestas_elecciones')
            WHERE vs.votacion_id={$votacion[0]->votacion_id}
            GROUP BY vs.votacion_id)
            UNION ALL
            (SELECT dp.dp_descripcion AS resultado_descripcion, COUNT(v.dp_id) AS resultado_votos, SUM(CASE WHEN v.voto_item = -1 OR v.voto_item IS NULL THEN 0 ELSE 1 END) AS abstenciones, vs.votacion_id, COUNT(v.dp_id) AS resultado_total, dp.idmiembro
            FROM asambleas.detalle_propuestas AS dp
            LEFT JOIN asambleas.propuestas_elecciones AS pe ON(pe.pe_id=dp.pe_id )
            LEFT JOIN asambleas.votaciones AS vs ON(vs.propuesta_id=pe.pe_id AND vs.tabla='asambleas.propuestas_elecciones')
            LEFT JOIN asambleas.votos AS v ON(vs.votacion_id=v.votacion_id AND vs.propuesta_id=v.propuesta_id AND v.dp_id=dp.dp_id AND v.tabla='asambleas.propuestas_elecciones' )
            WHERE vs.votacion_id={$votacion[0]->votacion_id}
            GROUP BY dp.dp_id, dp.dp_descripcion, vs.votacion_id, dp.idmiembro
            ORDER BY dp.dp_id)";
            // die($sql);
            $result = DB::select($sql);
        }


        if($votacion[0]->fv_id == 7 ) {

            $sql = "SELECT v.voto_miembro AS resultado_descripcion, COUNT(v.voto_miembro) AS resultado_votos, SUM(CASE WHEN v.voto_item = -1 OR v.voto_item IS NULL THEN 0 ELSE 1 END) AS abstenciones, vs.votacion_id, COUNT(v.voto_miembro) AS resultado_total
            FROM asambleas.propuestas_elecciones AS pe
            LEFT JOIN asambleas.votaciones AS vs ON(vs.propuesta_id=pe.pe_id AND vs.tabla='asambleas.propuestas_elecciones')
            LEFT JOIN asambleas.votos AS v ON(vs.votacion_id=v.votacion_id AND pe.pe_id=v.propuesta_id AND v.tabla='asambleas.propuestas_elecciones' )
            LEFT JOIN iglesias.miembro AS m ON(m.idmiembro=v.idmiembro_votado)
            WHERE vs.votacion_id={$votacion[0]->votacion_id}
            GROUP BY v.voto_miembro, vs.votacion_id";
            // die($sql);
            $result = DB::select($sql);
        }


        // print_r($result); exit;
        $abstenciones = 0;
        if(count($results) > 0) {
            //MODIFICAMOS
            foreach ($result as $key => $value) {

                $abstenciones += (isset($value->abstenciones)) ? $value->abstenciones : 0;

                if(isset($value->resultado_descripcion) && $value->resultado_descripcion == "Abstenciones") {

                    continue; // esto es para el caso de formas de votacione de:
                        // 6 => Elegir de Lista de Propuesta, Abstención
                        // 8 => Elegir de Lista de Propuesta(multiple), Abstención
                }

                DB::update(
                    'UPDATE asambleas.resultados set resultado_votos = '.$value->resultado_votos.', resultado_total = resultado_votos + resultado_mano_alzada  where resultado_descripcion = ? AND votacion_id = ?',
                    [$value->resultado_descripcion, $votacion[0]->votacion_id]
                );
            }

            DB::update(
                'UPDATE asambleas.resultados set resultado_votos = '.$abstenciones.', resultado_total = resultado_votos + resultado_mano_alzada  where resultado_descripcion = ? AND votacion_id = ?',
                [traducir("asambleas.abstencion"), $votacion[0]->votacion_id]
            );


        } else {
            //INSERTAMOS
            // print_r($sql); exit;
            foreach ($result as $key => $value) {
                $abstenciones += (isset($value->abstenciones)) ? $value->abstenciones : 0;

                if(isset($value->resultado_descripcion) && $value->resultado_descripcion == "Abstenciones") {

                    continue; // esto es para el caso de formas de votacione de:
                        // 6 => Elegir de Lista de Propuesta, Abstención
                        // 8 => Elegir de Lista de Propuesta(multiple), Abstención
                }
                $this->base_model->insertar($this->preparar_datos("asambleas.resultados", (array)$value));


            }

            if(isset($result[0]->abstenciones)) {
                $data = array();
                $data["resultado_descripcion"] = traducir("asambleas.abstencion");
                $data["votacion_id"] = $result[0]->votacion_id;
                $data["resultado_votos"] = $abstenciones;
                $data["resultado_total"] = $abstenciones;
                $this->base_model->insertar($this->preparar_datos("asambleas.resultados", $data));
            }

        }

        return $votacion;
    }
}
