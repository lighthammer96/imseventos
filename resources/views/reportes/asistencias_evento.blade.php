@extends('layouts.layout')



@section('content')

<form id="formulario-asistencias_evento" class="form-horizontal" role="form">
    <div class="row">

            <div class="col-md-6 col-md-offset-3">
                <input type="hidden" name="evento_descripcion" class="input-sm entrada">
                <div class="row">
                    <div class="col-md-8 col-md-offset-1">
                        <label class="control-label">Evento:</label>

                        <select  class="entrada selectizejs" name="evento_id" id="evento_id">

                        </select>
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

