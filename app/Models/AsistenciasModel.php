<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tabla;
use Exception;
use Illuminate\Support\Facades\DB;

class AsistenciasModel extends Model
{
    use HasFactory;



    public function __construct() {
        parent::__construct();

    }


    public function tabla() {
        $tabla = new Tabla();
        $tabla->asignarID("tabla-asistencias");
        $tabla->agregarColumna("a.asistencia_id", "asistencia_id", "Id");
        $tabla->agregarColumna("ev.evento_descripcion", "evento", "Evento");
        $tabla->agregarColumna("p.programa_descripcion", "programa", "Programa");
        $tabla->agregarColumna("(pr.participante_nombres ||' '|| pr.participante_apellidos)", "participante", "Participante");

        $tabla->agregarColumna("to_char(a.fecha_registro, 'DD/MM/YYYY HH24:MI:SS')", "fecha_registro", "Fecha y Hora");

        $tabla->agregarColumna("e.estado", "estado", "Estado");

        $tabla->setSelect("a.asistencia_id, ev.evento_descripcion AS evento, p.programa_descripcion AS programa, (pr.participante_nombres ||' '|| pr.participante_apellidos) AS participante, to_char(a.fecha_registro, 'DD/MM/YYYY HH24:MI:SS') AS fecha_registro, CASE WHEN a.estado='A' THEN 'ACTIVO' ELSE 'INACTIVO' END AS estado, a.estado AS state");
        $tabla->setFrom("eventos.asistencias AS a
        \nINNER JOIN eventos.eventos AS ev ON(a.evento_id=ev.evento_id)
        \nINNER JOIN eventos.programas AS p ON(a.programa_id=p.programa_id)
        \nINNER JOIN eventos.participantes AS pr ON(a.participante_id=pr.participante_id)");




        return $tabla;
    }

    public function validar_codigo_qr_segun_evento($data) {
        $sql = "SELECT * FROM eventos.participantes AS p
        INNER JOIN eventos.detalle_eventos AS de ON(p.participante_id=de.participante_id)
        INNER JOIN eventos.eventos AS e ON(e.evento_id=de.evento_id)
        INNER JOIN eventos.programas AS pr ON(pr.evento_id=e.evento_id)
        INNER JOIN eventos.registros AS r ON(p.participante_id=r.participante_id)
        WHERE de.evento_id={$data["evento_id"]} AND de.de_codigoqr='{$data["codigo_qr"]}' AND pr.programa_id={$data["programa_id"]}";
        // echo $sql;
        $result = DB::select($sql);
        return $result;
    }

    public function validar_asistencia($data) {
        $sql = "SELECT * FROM eventos.participantes AS p
        INNER JOIN eventos.detalle_eventos AS de ON(p.participante_id=de.participante_id)
        INNER JOIN eventos.eventos AS e ON(e.evento_id=de.evento_id)
        INNER JOIN eventos.programas AS pr ON(pr.evento_id=e.evento_id)
        INNER JOIN eventos.registros AS r ON(p.participante_id=r.participante_id)
        INNER JOIN eventos.asistencias AS a ON(a.participante_id=p.participante_id AND a.evento_id=e.evento_id AND a.programa_id=pr.programa_id)

        WHERE a.evento_id={$data["evento_id"]} AND a.programa_id={$data["programa_id"]} AND a.participante_id='{$data["participante_id"]}' ";
        // echo $sql;
        $result = DB::select($sql);
        return $result;
    }

    public function obtener_permisos($data) {
        $sql = "SELECT CASE WHEN tipo='S' THEN 'Salida' ELSE 'Entrada' END AS tipo_permiso, to_char(fecha_registro, 'DD/MM/YYYY HH24:MI:SS') AS fecha_registro, tipo FROM eventos.permisos WHERE evento_id={$data["evento_id"]} AND programa_id={$data["programa_id"]} AND participante_id={$data["participante_id"]} AND estado='A'
        ORDER BY permiso_id DESC";
        $result = DB::select($sql);
        return $result;
    }

    public function guardar_asistencias($request) {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $result = array();


            $participante = $this->asistencias_model->validar_codigo_qr_segun_evento($data);
            if(count($participante) <= 0) {
                throw new Exception("participante_no_registrado");
            }

            $data["participante_id"] = $participante[0]->participante_id;

            $asistencia = $this->asistencias_model->validar_asistencia($data);
            // print_r($asistencia); exit;

            if(count($asistencia) > 0) {
                throw new Exception("asistencia_registrada");
            }


            $result = $this->base_model->insertar($this->preparar_datos("eventos.asistencias", $data));

            $result["participante"] = $participante[0];
            $result["delegado"] = $participante[0]->registro_delegado;

            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            $response["status"] = "ei";
            $response["participante"] = (isset($participante[0])) ? $participante[0] : array();
            $response["code"] = "";
            $response["msg"] = $e->getMessage();
            $response["permisos"] = $this->asistencias_model->obtener_permisos($data);
            if($e->getMessage() == "asistencia_registrada") {
                $response["code"] = "asistencia_registrada";
                $response["msg"] = "La asistencia ya ha sido registrada";
            }

            if($e->getMessage() == "participante_no_registrado") {
                $response["code"] = "participante_no_registrado";
                $response["msg"] = "El participante no esta registrado en el Sistema";
            }

            return $response;
        }
    }

}
