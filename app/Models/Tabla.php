<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tabla extends Model
{
    use HasFactory; 


   
    private $columnas;
    // private $table;
    private $id;
    private $join;
    private $select;
    private $from;
    private $where;
    private $orderBy;
    private $dir;
    private $button;
    private $accion;
    private $modificar;
    private $eliminar;
    private $instancia;
    private $icons;
    private $omitidos;
    private $whereAnd;
    private $whereOr;
    private $groupBy;
    private $having;


    public function __construct() {
      
        $this->columnas = array();
        $this->accion = "";
        $this->classBotonModificar = "modificar";
        $this->classBotonEliminar = "eliminar";
        $this->instancia = "";
        $this->omitidos = 0;
        $this->whereAnd = "";
        $this->whereOr = "";
        $this->groupBy = "";
        $this->having = "";
        $this->withButtons = true;
        $this->operaciones = true;
        //$this->dir = "asc";
    }

    public function setOperaciones($bool) {
        $this->operaciones = $bool;
    }

    public function getOperaciones() {
        return $this->operaciones;
    }

    public function setWithButtons($withButtons) {
        $this->withButtons = $withButtons;
    }


    public function getWithButtons(){
        return $this->withButtons;
    }


    public function setGroupBy($groupBy) {
        $this->groupBy = $groupBy;
    }


    public function getGroupBy(){
        return $this->groupBy;
    }


    public function setHaving($having) {
        $this->having = $having;
    }


    public function getHaving(){
        return $this->having;
    }

    public function setWhereAnd($whereAnd) {
        $this->whereAnd = $whereAnd;
    }


    public function getWhereAnd(){
        return $this->whereAnd;
    }

    public function setWhereOr($whereOr){
        $this->whereOr = $whereOr;
    }


    public function getWhereOr() {
        return $this->whereOr;
    }

    public function setOmitidos($omitidos){
        $this->omitidos = $omitidos;
    }


    public function getOmitidos(){
        return $this->omitidos;
    }


    public function setAccion($accion) {
        $this->accion = $accion;
    }

    public function getAccion() {
        return $this->accion;
    }

    public function setinstancia($instancia) {
        $this->instancia = $instancia;
    }

    public function getinstancia() {
        return $this->instancia;
    }

    public function asignarClassBotonModificar($classBotonModificar) {
        $this->classBotonModificar = $classBotonModificar;
    }

    public function obtenerClassBotonModificar() {
        return $this->classBotonModificar;
    }

    public function asignarClassBotonEliminar($classBotonEliminar) {
        $this->classBotonEliminar = $classBotonEliminar;
    }

    public function obtenerClassBotonEliminar() {
        return $this->classBotonEliminar;
    }


    public function setButton($button) {
        $this->button[] = $button;
    }

    public function getButtons() {
        return $this->button;
    }


    public function asignarID($id) {
        $this->id = $id;
    }

    public function obtenerID() {
        return $this->id;
    }

    /**
     * @param  [type]
     * @param  [type]
     * @param  [type]
     * @param  string
     * @param  string
     * @param  search -> si es true indica que es apto para buscarque desde el buscador del datatable, si no no lo busca.
     * @return [type]
     */
    public function agregarColumna($campo, $alias, $titulo, $width="", $height="", $search=true) {
        //campo
        //titulo
        $array = array(
            "campo" => $campo,
            "alias" => $alias,
            "titulo" => $titulo,
            "width" => $width,
            "height" => $height,
            "search" => $search
        );

        $object = (object) $array;
        array_push($this->columnas, $object);
        //$this->columnas[] = $object;
    }

    public function obtenerColumnas() {
        return $this->columnas;
    }


    public function setSelect($select) {
        $this->select = $select;
    }

    public function getSelect() {
        return $this->select;
    }

    public function setFrom($from) {
        $this->from = $from;
    }

    public function getFrom() {
        return $this->from;
    }

    public function setWhere($where) {
        $this->where = $where;
    }

    public function getWhere() {
        return $this->where;
    }

    public function setOrderBy($orderBy) {
        $this->orderBy = $orderBy;
    }

    public function getOrderBy() {
        return $this->orderBy;
    }

    public function formatuserfecha($fecha) {


        //  PRIMERO VALIDAMOS  SI TIPO DATETIME O TIMESTAMP
        $datetime = explode(" ", $fecha);
        if(count($datetime) > 1) {
            $array = explode("-", $datetime[0]);
            if(count($array) == 3) {
                return $array[2]."/".$array[1]."/".$array[0]. " " .$datetime[1];
            } else {
                return $fecha;
            }
        } else {
            $array = explode("-", $fecha);
            if(count($array) == 3) {
                return $array[2]."/".$array[1]."/".$array[0];
            } else {
                return $fecha;
            }
        }


    }

    // public function obtenerDatos() {

    //     $campos = ""; $where = ""; $whereConcatenado = ""; $searchWhere = "";
    //     $columnas = $this->obtenerColumnas();
    //     $tabla = $this->obtenerTabla();
    //     $classBotonModificar = $this->obtenerClassBotonModificar();
    //     $classBotonEliminar = $this->obtenerClassBotonEliminar();
    //     //nt_r($columnas); exit;
    //     foreach ($columnas as $value) {
    //         $campos .= $value->campo . ", ";
    //     }

    //     // QUITAMOS LAS COMAS DE MAS DE ULTIMO DEL STRING DEL SELECT
    //     $campos = substr_replace($campos, '', -2, -1);

    //     $select = "SELECT ".$campos;
    //     $from = "FROM " . $tabla;
    //     if($this->getWhere() != "") {
    //         $where = " WHERE ".$this->db->getWhere();
    //     }


    //     //echo $where; exit;
    //     if ( !empty($_REQUEST['search']['value']) ) {

    //         foreach ($columnas as $value) {
    //             if(empty($where)) {
    //                 $where .= " WHERE ( CAST( COALESCE(" . $value->campo . ",null) as CHAR) LIKE '%" . $_REQUEST['search']['value'] . "%' ";
    //             } else {
    //                 $where .= " OR CAST( COALESCE(" . $value->campo . ",null) as CHAR) LIKE '%" . $_REQUEST['search']['value'] . "%' ";
    //             }

    //             $whereConcatenado .= " CAST( COALESCE(" . $value->campo . ",null) as CHAR) || ' ' || ";
    //         }

    //         $whereConcatenado = substr_replace($whereConcatenado, '', -11, -1);
    //         #print_r($searchWhereConcat); exit;
    //         $where .= "OR CONCAT(" . $whereConcatenado . ") LIKE '%" . $_REQUEST['search']['value'] . "%' )";

    //     }


    //     $orderBy = " ORDER BY " . $columnas[$_REQUEST['order'][0]['column']]->campo . " ".$_REQUEST['order'][0]['dir']." LIMIT " . $_REQUEST['length'] . "  OFFSET " . $_REQUEST['start'] . "  ";

    //     $consulta = $select . $from . $where. $orderBy;
    //    //echo $consulta; exit;
    //     $registros = $this->ci->db->query($consulta)->result();
    //     $totalRegistros = $this->ci->db->query($consulta)->num_rows();
    //     $totalFiltered = $totalRegistros;

    //     // $arrayFilas = array();

    //     // foreach ($registros as $key => $value) {

    //     //     $arrayValues = array();
    //     //     $arrayCampos = array();

    //     //     foreach ($value as $k => $val) {
    //     //         array_push($arrayCampos, $val);
    //     //         array_push($arrayValues, '"'.$k . '":"'.$val.'"');
    //     //     }
    //     //     array_push($arrayFilas, $arrayCampos);


    //     // }

    //   //print_r($arrayFilas); exit;

    //     // $j = 0;
    //     // if (count($registros) > 0) {

    //     //     foreach ($registros as $key => $value) {
    //     //         $i = 0; $attrs = " ";
    //     //         foreach ($columnas as $column) {
    //     //             if ($column->column == null) {
    //     //                 continue;
    //     //             }
    //     //             $column_name = (string) $column->column;
    //     //             if ($i > 0) {
    //     //                 //VALIDAMOS SI ES ESTADO
    //     //                 if($column_name == "estado") {
    //     //                     if($value->$column_name == "A") {
    //     //                          $data[$j][] = "ACTIVO";
    //     //                     } else {
    //     //                          $data[$j][] = "INACTIVO";
    //     //                     }
    //     //                 } else {

    //     //                     $data[$j][] =  $this->formatuserfecha($value->$column_name);
    //     //                 }
    //     //             } else {
    //     //                 $id = $value->$column_name;
    //     //             }
    //     //             $i++;
    //     //         }

    //     //         foreach ($value as $k => $val) {
    //     //             $attrs .= $k . '="'.$val.'" ';
    //     //         }
    //     //         if(count($this->getButtons())>0) {
    //     //             $buttons = '<center id=' . $id . ' >';
    //     //             for ($i=0; $i < count($this->getButtons()) ; $i++) {
    //     //                 $buttons .= $this->getButtons()[$i].'&nbsp;&nbsp;';
    //     //             }
    //     //             $data[$j][] = $buttons.'</center>';
    //     //         } else {
    //     //             $modificar = $this->getmodificar();
    //     //             $eliminar = $this->geteliminar();
    //     //             $instancia = $this->getinstancia();
    //     //             $data[$j][] = '<center id=' . $id . $attrs .' ><button title="Modificar" class="btn btn-primary btn-xs '.$modificar.$instancia.'" ><i class="md md-edit"></i></button>&nbsp;&nbsp;<button title="Eliminar" class="btn btn-danger '.$eliminar.$instancia.' btn-xs"><i class="md md-eliminar"></i></button></center>';
    //     //         }
    //     //         $j++;
    //     //     }
    //     // } else {
    //     //     $data = array();
    //     // }

    //     $json_data = array(
    //         "draw" => intval($_REQUEST['draw']),
    //         "recordsTotal" => intval($totalRegistros),
    //         "recordsFiltered" => intval($totalFiltered),
    //         "data" => $registros
    //     );

    //     //print_r($json_data); exit;

    //     return $json_data;
    // }

    public function funcionAgregacion($column_consult) {
        $funcionesAgregacion = ['MAX', 'MIN', 'COUNT', 'SUM', 'AVG'];
        for ($i=0; $i < count($funcionesAgregacion) ; $i++) {
            $array = explode($funcionesAgregacion[$i], $column_consult);
            if(count($array) > 1) {
                return true;
            }
        }
        return false;
    }

    public function obtenerDatos() {
        $whereConcatenado = "";

        //$columnas = $this->obtenerColumnas();
        $columnas = $this->columnas;
        //$select = "SELECT " . $this->getSelect();
        $select = "SELECT " . $this->select;
        //$from = "\nFROM " . $this->getFrom();
        $from = "\nFROM " . $this->from;
        if($this->getWhere() != "") {
           // $where = "\nWHERE " . $this->getWhere();
            $where = "\nWHERE " . $this->where;
        } else {
            $where = "\nWHERE 1=1";
        }
        if(!empty($this->getGroupBy())) {
            //$groupBy = "\nGROUP BY " . $this->getGroupBy();
            $groupBy = "\nGROUP BY " . $this->groupBy;

        } else {
            $groupBy = "";
        }
        if(!empty($this->getHaving())) {
            //$having = "\nHAVING " . $this->getHaving();
            $having = "\nHAVING " . $this->having;

        } else {
            $having = "";
        }

        if(!empty($this->getOrderBy())) {
            //$orderBy = "\nORDER BY " . $this->getOrderBy();
            $orderBy = "\nORDER BY " . $this->orderBy;

        } else {
            $orderBy = "";
        }


        if ( !empty($_REQUEST['search']['value']) ) {
            $where .= "\nAND (";
            foreach ($columnas as $value) {
                if(!$value->search) {
                    continue;
                }
                $where .= "\n CAST( COALESCE(" . $value->campo . ",null) as VARCHAR) ILIKE '%" . $_REQUEST['search']['value'] . "%' OR ";

                $whereConcatenado .= "\nCAST( COALESCE(" . $value->campo . ",null) as VARCHAR) || ' ' || ";
            }
            $where = substr_replace($where, '', -4, -1);
           // echo $where; exit;
            $whereConcatenado = substr_replace($whereConcatenado, '', -11, -1);
             #print_r($searchWhereConcat); exit;
            $where .= "\nOR CONCAT(" . $whereConcatenado . ") ILIKE '%" . $_REQUEST['search']['value'] . "%'";
            $where .= " ) ";



        }

       // ESTE BLOQUE DE 3 LINEAS DE CODIGO SE UTILIZA SIN EL LIMIT
        $consulta = $select . $from . $where. $groupBy . $having;
    //    echo $consulta; exit;
        // $totalFiltered = $this->ci->db->query($consulta)->num_rows();
        // $totalRegistros = $this->ci->db->query($consulta)->num_rows();
        // die($consulta);
        $result = DB::select($consulta);
        $totalFiltered = count($result);
        $totalRegistros = $totalFiltered;
        if(empty($orderBy)) {
            $orderBy = "\nORDER BY " . $columnas[$_REQUEST['order'][0]['column']]->campo . " ".$_REQUEST['order'][0]['dir'];
        }
        $limit = " LIMIT " . $_REQUEST['length'] . "  OFFSET " . $_REQUEST['start'] . "  ";
        $consulta = $select . $from . $where. $groupBy . $having. $orderBy. $limit;
        // echo $consulta; exit;
        $registros = DB::select($consulta);
       


        $json_data = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($totalRegistros),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $registros
        );

        return $json_data;
    }



    public function HTML() {
        $stringColumnas = "";
        $arrayAlias = array();
        $columnas = $this->obtenerColumnas();
        foreach ($columnas as $key => $value) {
            array_push($arrayAlias, $value->alias);
        }
        $stringColumnas = implode(",", $arrayAlias);
        //$html = '<div class="table-responsive" style="overflow: hidden;">';
        $html = '<table columnas="'.$stringColumnas.'" id="' . $this->obtenerID() . '" class="table table-striped table-bordered display compact" style="font-size: 12px;">';
        $html .= '<thead><tr>';

        foreach ($columnas as $columna) {
            
            $html .= '<th /*bgcolor="#666666" */ bgcolor="#4896c4" style="color: white;" width="'.$columna->width.'" height="'.$columna->height.'">' . $columna->titulo . '</th>';

        }

        // if($this->getWithButtons()) {
        //     if($this->getAccion() == "") {
        //          $html .= '<th><center>Acción</center></th>';
        //     } else {
        //          $html .= '<th><center>'.$this->getAccion().'</center></th>';
        //     }
        //  }

        $html .= '</tr></thead>';
        $html .= '</table>';
        //$html .= '</div>';
        return $html;
    }

}
