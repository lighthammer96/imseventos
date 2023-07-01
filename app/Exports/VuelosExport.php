<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;

class VuelosExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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
                $event->getSheet()->getDelegate()->getStyle('A1:Q'.$count)->applyFromArray(
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
            'Correo',
            'Apoderado',
            'Iglesia',
            'Delegado',
            'Aerolínea',
            'Número Vuelo',
            'Fecha Llegada',
            'Hora Llegada',
            'Fecha Retorno',
            'Hora Retorno',
            'Destino Llegada',
        ];
    }
    public function collection()
    {

        // $sql = "SELECT p.participante_nombres, p.participante_apellidos, td.descripcion AS tipo_documento,
        // p.participante_nrodoc, pp.descripcion AS pais, r.registro_celular, r.registro_correo, r.registro_apoderado,
        // r.registro_iglesia,
        // CASE WHEN r.registro_delegado='S' THEN 'SI' ELSE 'NO' END AS registro_delegado,
        // r.registro_aerolinea, r.registro_nrovuelo, to_char(r.registro_fecha_llegada, 'DD/MM/YYYY') AS registro_fecha_llegada,
        // r.registro_hora_llegada, to_char(r.registro_fecha_retorno, 'DD/MM/YYYY') AS registro_fecha_retorno, r.registro_hora_retorno,
        // r.registro_destino_llegada
        // FROM eventos.participantes AS p
        // LEFT JOIN public.pais AS pp ON(p.idpais=pp.idpais)
        // LEFT JOIN public.tipodoc AS td ON(td.idtipodoc=p.idtipodoc)
        // INNER JOIN eventos.registros AS r ON(p.participante_id=r.participante_id AND p.registro_id_ultimo=r.registro_id)
        // INNER JOIN eventos.detalle_eventos AS de ON(de.participante_id=r.participante_id AND de.registro_id=r.registro_id)
        // WHERE de.evento_id={$_REQUEST["evento_id"]}";



        // $vuelos = DB::select($sql);

        $vuelos = DB::table("eventos.participantes AS p")
            ->select('p.participante_nombres', 'p.participante_apellidos', 'td.descripcion AS tipo_documento', 'p.participante_nrodoc', 'pp.descripcion AS pais', 'r.registro_celular', 'r.registro_correo', 'r.registro_apoderado', 'r.registro_iglesia', DB::raw("CASE WHEN r.registro_delegado='S' THEN 'SI' ELSE 'NO' END AS registro_delegado"), 'r.registro_aerolinea', 'r.registro_nrovuelo', DB::raw("to_char(r.registro_fecha_llegada, 'DD/MM/YYYY') AS registro_fecha_llegada"), 'r.registro_hora_llegada', DB::raw("to_char(r.registro_fecha_retorno, 'DD/MM/YYYY') AS registro_fecha_retorno"), 'r.registro_hora_retorno', 'r.registro_destino_llegada')
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
            ->whereNotNull('r.registro_nrovuelo');
        $vuelos =  $vuelos->get();

        if (count($vuelos) <= 0) {
            echo '<script>alert("No hay Datos!"]; window.close();</script>';
            exit;
        }

        return $vuelos;
    }
}
