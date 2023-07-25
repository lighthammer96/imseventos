<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;

class AsistenciasProgramaExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    // referencia para dar estilos:https://laracasts.com/discuss/channels/laravel/formatting-exported-excel-file
    public function registerEvents(): array
    {
        global $count;
        $regs = $this->collection();
        $count = count($regs) + 1;
        // print_r($count); exit;
        return [
            AfterSheet::class => function(AfterSheet $event)
            {
                global $count;
                $event->getSheet()->getDelegate()->getStyle('A1:P'.$count)->applyFromArray(
                    array(
                        'borders' => array(
                            'allBorders' => array(
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => array('rgb' => '000000')
                            )
                        )
                    )
                );
            }
        ];
    }

    // referencia: https://www.nigmacode.com/laravel/exportar-excel-en-laravel/
    /**
     * @return \Illuminate\Support\Collection
     */

    public function headings(): array
    {
        return [
            'Nombres',
            'Apellidos',
            'Tipo Documento',
            'Número Documento',
            'Páis',
            'Celular',
            'Celular Emergencia',
            'Correo',
            'Apoderado',
            'Iglesia',
            'Edad',
            'Delegado',
            'Tipo de Programa',
            'Programa',
            'Fecha y Hora',
            'Usuario',

        ];
    }
    public function collection()
    {


        $asistencias = DB::table("eventos.participantes AS p")
            ->select('p.participante_nombres', 'p.participante_apellidos', 'td.descripcion AS tipo_documento', 'p.participante_nrodoc', 'pp.descripcion AS pais', 'r.registro_celular', 'r.registro_celular_emergencia', 'r.registro_correo', 'r.registro_apoderado', 'r.registro_iglesia', 'r.registro_edad', DB::raw("CASE WHEN r.registro_delegado='S' THEN 'SI' ELSE 'NO' END AS registro_delegado"), 'tp.tp_descripcion', "pr.programa_descripcion", DB::raw("to_char(a.fecha_registro, 'DD/MM/YYYY HH24:MI:SS') AS fecha_registro"), "a.usuario_registro")
            ->leftJoin('public.pais AS pp', 'p.idpais', '=', 'pp.idpais')
            ->leftJoin('public.tipodoc AS td', 'td.idtipodoc', '=', 'p.idtipodoc')
            ->join('eventos.registros AS r', function ($join) {
                $join->on('p.participante_id', '=', 'r.participante_id');
                $join->on('p.registro_id_ultimo', '=', 'r.registro_id');
            })
            ->join('eventos.detalle_eventos AS de', function ($join) {
                $join->on('de.participante_id', '=', 'r.participante_id');
                $join->on('de.registro_id', '=', 'r.registro_id');
            })
            ->join('eventos.asistencias AS a', function ($join) {
                $join->on('a.evento_id', '=', 'de.evento_id');
                $join->on('a.participante_id', '=', 'p.participante_id');
            })
            ->join('eventos.programas AS pr', function ($join) {
                $join->on('pr.programa_id', '=', 'a.programa_id');
            })
            ->join('eventos.tipos_programa AS tp', function ($join) {
                $join->on('pr.tp_id', '=', 'tp.tp_id');
            })

            ->where('de.evento_id', '=', $_REQUEST["evento_id"])
            //->where('p.estado', '=', 'A')
            ->where('a.estado', '=', 'A');

        if(isset($_REQUEST["tp_id"]) && !empty($_REQUEST["tp_id"]) && $_REQUEST["tp_id"] != "-1") {
            $asistencias =  $asistencias ->where('tp.tp_id', '=', $_REQUEST["tp_id"]);

        }

        if(isset($_REQUEST["programa_id"]) && !empty($_REQUEST["programa_id"]) && $_REQUEST["programa_id"] != "-1") {
            $asistencias =  $asistencias ->where('pr.programa_id', '=', $_REQUEST["programa_id"]);
        }
        //echo $vuelos->toSql(); exit;
        $asistencias =  $asistencias->get();


        if (count($asistencias) <= 0) {
            echo '<script>alert("No hay Datos!"); window.close();</script>';
            exit;
        }

        return $asistencias;
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
