@extends('layouts.layout')



@section('content')

<form id="formulario-reporte_vuelos" class="form-horizontal" role="form">
    <div class="row">

            <div class="col-md-6 col-md-offset-3">
                <div class="row">
                    <div class="col-md-8 col-md-offset-1">
                        <label class="control-label">Evento:</label>

                        <select  class="entrada selectizejs" name="evento_id" id="evento_id">

                        </select>
                    </div>
                    <div class="col-md-8 col-md-offset-1">
                        <label class="control-label">Fecha de Llegada</label>

                        <div class="input-group">
                            <input type="text" class="form-control input-sm entrada" name="registro_fecha_llegada" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask placeholder="" />
                            <div class="input-group-addon"  id="calendar-registro_fecha_llegada" style="cursor: pointer;">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 col-md-offset-1" style="margin-top: 15px;">
                        <center>
                            <button type="button" id="exportar_excel" class="btn btn-default"><img style="width: 30px; height: 30px;" src="{{ URL::asset('images/iconos/excel.png') }}" ><br>&nbsp;&nbsp;&nbsp;{{ traducir("traductor.exportar_excel") }}</button>
                        </center>
                    </div>
                </div>

            </div>




    </div>


</form>


@endsection

