<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tabla;
use Illuminate\Support\Facades\DB;

class LlegadasModel extends Model
{
    use HasFactory;



    public function __construct() {
        parent::__construct();

    }


    public function tabla() {
        $tabla = new Tabla();
        $tabla->asignarID("tabla-llegadas");
        $tabla->agregarColumna("a.at_id", "at_id", "Id");
        $tabla->agregarColumna("ev.evento_descripcion", "evento", "Evento");

        $tabla->agregarColumna("(pr.participante_nombres ||' '|| pr.participante_apellidos)", "participante", "Participante");

        $tabla->agregarColumna("to_char(a.fecha_registro, 'DD/MM/YYYY HH24:MI:SS')", "fecha_registro", "Fecha y Hora");

        $tabla->agregarColumna("e.estado", "estado", "Estado");

        $tabla->setSelect("a.at_id, ev.evento_descripcion AS evento, (pr.participante_nombres ||' '|| pr.participante_apellidos) AS participante, to_char(a.fecha_registro, 'DD/MM/YYYY HH24:MI:SS') AS fecha_registro, CASE WHEN a.estado='A' THEN 'ACTIVO' ELSE 'INACTIVO' END AS estado, a.estado AS state");
        $tabla->setFrom("eventos.asistencias_transporte AS a
        \nINNER JOIN eventos.eventos AS ev ON(a.evento_id=ev.evento_id)

        \nINNER JOIN eventos.participantes AS pr ON(a.participante_id=pr.participante_id)");




        return $tabla;
    }

    public function validar_codigo_qr_segun_evento($data) {
        $sql = "SELECT p.*, r.*, e.*, de.*,
        COALESCE(r.registro_aerolinea, '-.-') AS registro_aerolinea,
        COALESCE(r.registro_nrovuelo, '-.-') AS registro_nrovuelo,
        COALESCE(to_char(r.registro_fecha_llegada, 'DD/MM/YYYY'), '-.-') AS registro_fecha_llegada,
        COALESCE(r.registro_destino_llegada, '-.-') AS registro_destino_llegada

        FROM eventos.participantes AS p
        INNER JOIN eventos.detalle_eventos AS de ON(p.participante_id=de.participante_id)
        INNER JOIN eventos.eventos AS e ON(e.evento_id=de.evento_id)
        INNER JOIN eventos.registros AS r ON(p.participante_id=r.participante_id)
        WHERE de.evento_id={$data["evento_id"]} AND de.de_codigoqr='{$data["codigo_qr"]}'";
        // echo $sql;
        $result = DB::select($sql);
        return $result;
    }

    public function validar_asistencia($data) {
        $sql = "SELECT p.*, de.*, e.*, r.*, a.*,
        COALESCE(to_char(a.fecha_registro, 'DD/MM/YYYY HH24:MI:SS'), '-.-') AS fecha_registro
        FROM eventos.participantes AS p
        INNER JOIN eventos.detalle_eventos AS de ON(p.participante_id=de.participante_id)
        INNER JOIN eventos.eventos AS e ON(e.evento_id=de.evento_id)
        INNER JOIN eventos.registros AS r ON(p.participante_id=r.participante_id)
        INNER JOIN eventos.asistencias_transporte AS a ON(a.participante_id=p.participante_id AND a.evento_id=e.evento_id)

        WHERE a.evento_id={$data["evento_id"]} AND a.participante_id='{$data["participante_id"]}' ";
        // echo $sql;
        $result = DB::select($sql);
        return $result;
    }


}
