<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;

class ParticipantesEventoExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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
                $event->getSheet()->getDelegate()->getStyle('A1:L'.$count)->applyFromArray(
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
        ];
    }
    public function collection()
    {


        $participantes = DB::table("eventos.participantes AS p")
            ->select('p.participante_nombres', 'p.participante_apellidos', 'td.descripcion AS tipo_documento', 'p.participante_nrodoc', 'pp.descripcion AS pais', 'r.registro_celular', 'r.registro_celular_emergencia', 'r.registro_correo', 'r.registro_apoderado', 'r.registro_iglesia', 'r.registro_edad', DB::raw("CASE WHEN r.registro_delegado='S' THEN 'SI' ELSE 'NO' END AS registro_delegado"))
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

            ->where('de.evento_id', '=', $_REQUEST["evento_id"])
            ->where('p.estado', '=', 'A');


        //echo $vuelos->toSql(); exit;
        $participantes =  $participantes->get();


        if (count($participantes) <= 0) {
            echo '<script>alert("No hay Datos!"); window.close();</script>';
            exit;
        }

        return $participantes;
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
