<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tabla;
use Illuminate\Support\Facades\DB;

class ParticipantesModel extends Model
{
    use HasFactory;



    public function __construct() {
        parent::__construct();

    }

    public function tabla() {
        $tabla = new Tabla();
        $tabla->asignarID("tabla-participantes");
        $tabla->agregarColumna("p.participante_id", "participante_id", "Id");
        $tabla->agregarColumna("p.participante_nombres", "participante_nombres", "Nombres");
        $tabla->agregarColumna("p.participante_apellidos", "participante_apellidos", "Apellidos");
        $tabla->agregarColumna("td.descripcion", "tipodoc", "Tipo Documento");
        $tabla->agregarColumna("p.participante_nrodoc", "participante_nrodoc", "Nro Documento");
        $tabla->agregarColumna("to_char(p.participante_fecha_nacimiento, 'DD/MM/YYYY')", "participante_fecha_nacimiento", "Fecha Nacimiento");
        $tabla->agregarColumna("r.registro_celular", "registro_celular", "Celular");
        $tabla->agregarColumna("r.registro_correo", "registro_correo", "Correo");
        $tabla->agregarColumna("ps.descripcion", "pais", "País");
        $tabla->agregarColumna("r.registro_ciudad_procedencia", "registro_ciudad_procedencia", "Ciudad Procedencia");
        $tabla->agregarColumna("p.estado", "estado", "Estado");

        $tabla->setSelect("p.participante_id, p.participante_nombres, p.participante_apellidos, td.descripcion AS tipodoc, p.participante_nrodoc, to_char(p.participante_fecha_nacimiento, 'DD/MM/YYYY') AS participante_fecha_nacimiento, r.registro_celular, r.registro_correo, ps.descripcion AS pais, r.registro_ciudad_procedencia, CASE WHEN p.estado='A' THEN 'ACTIVO' ELSE 'INACTIVO' END AS estado, p.estado AS state, p.registro_id_ultimo");
        $tabla->setFrom("eventos.participantes AS p
        \nLEFT JOIN public.tipodoc AS td ON(td.idtipodoc=p.idtipodoc)
        \nLEFT JOIN public.pais AS ps ON(ps.idpais=p.idpais)
        \nLEFT JOIN eventos.registros AS r ON(r.participante_id=p.participante_id)");




        return $tabla;
    }

    public function obtener_participante_segun_evento($participante_id, $evento_id, $registro_id) {
        $sql_participante = "SELECT * FROM eventos.participantes AS p
        INNER JOIN eventos.detalle_eventos AS de ON(p.participante_id=de.participante_id)
        INNER JOIN eventos.eventos AS e ON(e.evento_id=de.evento_id)
        INNER JOIN eventos.registros AS r ON(p.participante_id=r.participante_id)
        WHERE p.participante_id={$participante_id} AND de.evento_id={$evento_id} AND r.registro_id={$registro_id}";
        $result = DB::select($sql_participante);
        return $result;
    }

    public function obtener_participante($participante_id) {

        $sql = "SELECT * FROM eventos.participantes WHERE participante_id={$participante_id}";
        $result = DB::select($sql);
        return $result;

    }


}
