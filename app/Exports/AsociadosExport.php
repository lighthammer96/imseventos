<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AsociadosExport implements FromCollection, WithHeadings
{
   

    // referencia: https://www.nigmacode.com/laravel/exportar-excel-en-laravel/
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        $headers = array();
        for ($i=0; $i < count($_REQUEST["campos"]) ; $i++) { 
            $alias = explode("AS", $_REQUEST["campos"][$i]);
            if(isset($alias[1])) {
                array_push($headers, traducir("traductor.".trim($alias[1])));
                
            } else {
               
                $alias_2 = explode(".", $alias[0]);
                if(isset($alias_2[1])) {
                    array_push($headers, traducir("traductor.".trim($alias_2[1])));
                } else{
                    array_push($headers, traducir("traductor.".$_REQUEST["campos"][$i]));
                }
                
            }
            
        }
        return $headers;
    }
    public function collection()
    {
      
        //  echo "<pre>";
        // print_r($_REQUEST); exit;
        $miembros = DB::table("iglesias.miembro AS m")
        ->leftJoin('public.gradoinstruccion AS gi', 'gi.idgradoinstruccion', '=', 'm.idgradoinstruccion')
        ->leftJoin('public.ocupacion AS o', 'o.idocupacion', '=', 'm.idocupacion')
        ->leftJoin('iglesias.religion AS r', 'r.idreligion', '=', 'm.idreligion')
        ->leftJoin('iglesias.vista_responsables AS vr', 'vr.id', '=', 'm.encargado_bautizo', 'vr.tabla', '=', 'm.tabla_encargado_bautizo')
        ->leftJoin('public.estadocivil AS ec', 'ec.idestadocivil', '=', 'm.idestadocivil')
        ->leftJoin('iglesias.division AS d', 'd.iddivision', '=', 'm.iddivision')
        ->leftJoin('iglesias.paises AS p', 'p.pais_id', '=', 'm.pais_id')
        ->leftJoin('iglesias.union AS u', 'u.idunion', '=', 'm.idunion')
        ->leftJoin('iglesias.mision AS mm', 'mm.idmision', '=', 'm.idmision')
        ->leftJoin('iglesias.distritomisionero AS dm', 'dm.iddistritomisionero', '=', 'm.iddistritomisionero')
        ->leftJoin('iglesias.iglesia AS i', 'i.idiglesia', '=', 'm.idiglesia')
        ->leftJoin('iglesias.condicioneclesiastica AS ce', 'ce.idcondicioneclesiastica', '=', 'm.idcondicioneclesiastica');

        for ($i=0; $i < count($_REQUEST["campos"]); $i++) { 
           
            $miembros = $miembros->addSelect(DB::raw($_REQUEST["campos"][$i]));
        }
       

        if($_REQUEST["idcondicioneclesiastica"] != '') {
            $miembros = $miembros->where('m.idcondicioneclesiastica', '=', $_REQUEST["idcondicioneclesiastica"]);
            //array_push($array_where, 'm.idcondicioneclesiastica='.$_REQUEST["idcondicioneclesiastica"]);
        }
        if($_REQUEST["idestadocivil"] != '') {
            // array_push($array_where, 'm.idestadocivil='.$_REQUEST["idestadocivil"]);
            $miembros = $miembros->where('m.idestadocivil', '=', $_REQUEST["idestadocivil"]);
        }
        
        if($_REQUEST["idocupacion"] != '') {
            // array_push($array_where, 'm.idocupacion='.$_REQUEST["idocupacion"]);
            $miembros = $miembros->where('m.idocupacion', '=', $_REQUEST["idocupacion"]);
        }
       
        
        
  

        if($_REQUEST["estado"] != '') {
            // array_push($array_where, 'm.estado='.$_REQUEST["estado"]);
            $miembros = $miembros->where('m.estado', '=', $_REQUEST["estado"]);
        }

        if($_REQUEST["iddivision"] != '') {
            // array_push($array_where, 'm.iddivision='.$_REQUEST["iddivision"]);
            $miembros = $miembros->where('m.iddivision', '=', $_REQUEST["iddivision"]);
        }
        

        if($_REQUEST["pais_id"] != '') {
            // $array_pais = explode("|", $_REQUEST["pais_id"]);
            // array_push($array_where, 'm.pais_id='.$array_pais[0]);
            $miembros = $miembros->where('m.pais_id', '=', $_REQUEST["pais_id"]);

            // $_REQUEST["pais_id"] = $array_pais[0];
            // if(isset($array_pais[1]) && $array_pais[1] == "N" && empty($_REQUEST["idunion"])) {
            //     $sql = "SELECT * FROM iglesias.union AS u 
            //     INNER JOIN iglesias.union_paises AS up ON(u.idunion=up.idunion)
            //     WHERE up.pais_id={$_REQUEST["pais_id"]}";
            //     $res = DB::select($sql);
            //     $_REQUEST["idunion"] = $res[0]->idunion;
            // }
        }
        if($_REQUEST["idunion"] != '') {
            // array_push($array_where, 'm.idunion='.$_REQUEST["idunion"]);
            $miembros = $miembros->where('m.idunion', '=', $_REQUEST["idunion"]);
        }
       

        if($_REQUEST["idmision"] != '') {
            // array_push($array_where, 'm.idmision='.$_REQUEST["idmision"]);
            $miembros = $miembros->where('m.idmision', '=', $_REQUEST["idmision"]);
        }

        if($_REQUEST["iddistritomisionero"] != '') {
            // array_push($array_where, 'm.iddistritomisionero='.$_REQUEST["iddistritomisionero"]);
            $miembros = $miembros->where('m.iddistritomisionero', '=', $_REQUEST["iddistritomisionero"]);
        }
        
       
        if($_REQUEST["fechaini"] != '' && $_REQUEST["fechafin"] !=  '') {
            // $where .= " AND m.fechabautizo BETWEEN '".$this->FormatoFecha($_REQUEST["fechaini"], "server")."' AND '".$this->FormatoFecha($_REQUEST["fechafin"], "server")."'";

            $miembros = $miembros->whereBetween('m.fechabautizo', [$this->FormatoFecha($_REQUEST["fechaini"], "server"), $this->FormatoFecha($_REQUEST["fechafin"], "server")]);
        }

        if($_REQUEST["fechaini"] != '' && $_REQUEST["fechafin"] ==  '') {
           // $where .= " AND m.fechabautizo = '".$this->FormatoFecha($_REQUEST["fechaini"], "server")."'"; 
            $miembros = $miembros->where('m.fechabautizo', '=', $this->FormatoFecha($_REQUEST["fechaini"], "server"));
        }

        if($_REQUEST["fechaini"] == '' && $_REQUEST["fechafin"] !=  '') {
            //$where .= " AND m.fechabautizo = '".$this->FormatoFecha($_REQUEST["fechafin"], "server")."'";
            $miembros = $miembros->where('m.fechabautizo', '=', $this->FormatoFecha($_REQUEST["fechafin"], "server")); 
        }
        
        if(isset($_REQUEST["iglesias"]) && count($_REQUEST["iglesias"]) > 0) {
            // $iglesias = implode(", ", $_REQUEST["iglesias"]);
            // die($iglesias);
            // $where .= ' AND m.idiglesia IN('.$iglesias.')';
            $miembros = $miembros->whereIn('m.idiglesia', $_REQUEST["iglesias"]);
        }
       
        $miembros = $miembros->get();
        // die($miembros);
        // echo count($miembros); exit;    
        if(count($miembros) <= 0) {
            echo '<script>alert("No hay Datos!"]; window.close();</script>';
            exit;
        }

        return $miembros;
    }

    public function FormatoFecha($fecha, $formato) {
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
}