<?php

use Illuminate\Support\Facades\DB;

    function formato_fecha_idioma($campo_fecha) {
        $formato = "";
        if(trim(session("idioma_codigo")) == "es") {
            $formato = " to_char(".$campo_fecha.", 'DD/MM/YYYY') ";
        }

        if(trim(session("idioma_codigo")) == "en") {
            $formato = " to_char(".$campo_fecha.", 'YYYY-MM-DD') ";
        }
        
        return $formato;
    }

    function formato_fecha_idioma_customer($campo_fecha, $idioma_codigo) {
        $formato = "";
        if(trim($idioma_codigo) == "es") {
            $formato = " to_char(".$campo_fecha.", 'DD/MM/YYYY') ";
        }

        if(trim($idioma_codigo) == "en") {
            $formato = " to_char(".$campo_fecha.", 'YYYY-MM-DD') "; 
        }
        
        return $formato;
    }

    function fecha_actual_idioma() {
        $formato = "";
        if(trim(session("idioma_codigo")) == "es") {
            $formato = date("d/m/Y");
        }

        if(trim(session("idioma_codigo")) == "en") {
            $formato = date("Y-m-d");
        }

        return $formato;
    }

    
    function mostrar_jerarquia($select, $where) {
        $sql = " SELECT (".$select.") AS select  FROM (SELECT /*d.descripcion AS division, */
        CASE WHEN di.di_descripcion IS NULL THEN
        (SELECT di_descripcion FROM iglesias.division_idiomas WHERE iddivision=d.iddivision AND idioma_id=".session("idioma_id_defecto").")
        ELSE di.di_descripcion END AS division, 
        p.pais_descripcion AS pais, u.descripcion AS union,
        mi.descripcion AS mision, dm.descripcion AS distritomisionero, i.descripcion AS iglesia,
        d.iddivision, p.pais_id, u.idunion, mi.idmision, dm.iddistritomisionero, i.idiglesia
        FROM  iglesias.division AS d  
        LEFT JOIN iglesias.division_idiomas AS di on(di.iddivision=d.iddivision AND di.idioma_id=".session("idioma_id").")
        INNER JOIN iglesias.paises AS p ON(d.iddivision=p.iddivision)
        INNER JOIN iglesias.union_paises AS up ON(up.pais_id=p.pais_id)
        INNER JOIN iglesias.union AS u ON(up.idunion=u.idunion)
        INNER JOIN iglesias.mision AS mi ON(u.idunion=mi.idunion)
        INNER JOIN iglesias.distritomisionero AS dm ON(mi.idmision=dm.idmision)
        INNER JOIN iglesias.iglesia AS i ON(dm.iddistritomisionero=i.iddistritomisionero)
        WHERE ".$where." ) AS s";
       
        $result = DB::select($sql);

        if(isset($result[0]->select)) {
            return $result[0]->select;
        }

        return "";
        
    }

    function mayusculas($cadena) {
        return strtr(strtoupper($cadena), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
    }


?>