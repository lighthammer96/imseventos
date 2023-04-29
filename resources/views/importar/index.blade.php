@extends('layouts.layout')
{{-- @extends('layouts.header') --}}
{{-- @extends('layouts.menu') --}}
{{-- @extends('layouts.aside') --}}
{{-- @extends('layouts.footer') --}}


@section('content')
<form id="formulario-importar" class="form-horizontal" role="form">
   <div class="row">

        <div class="col-md-2 col-md-offset-2">
            <label for="" class="control-label">{{ traducir("traductor.dato") }}</label>
            <select name="dato" id="dato" class="form-control">
                <option value="iglesias">{{ traducir("traductor.iglesias") }}</option>
                <option value="asociados">{{ traducir("traductor.asociados") }}</option>
                <option value="cargos">{{ traducir("traductor.cargos") }}</option>
                <option value="capacitaciones">{{ traducir("traductor.capacitaciones") }}</option>
                <option value="familiares">{{ traducir("traductor.familiares") }}</option>
                <option value="estudios">{{ traducir("traductor.estudios") }}</option>
                <option value="experiencia_laboral">{{ traducir("traductor.experiencia_laboral") }}</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="" class="control-label">{{ traducir("traductor.excel") }}</label>
            <input type="file" name="excel" id="excel" class="form-control">
        </div>
        <div class="col-md-3" style="margin-top: 2px;">
            <button type="button" class="btn btn-default"><a id="formato" style="color: #444 !important;" href="{{ URL::asset('formatos_carga/iglesias.xlsx') }}"><img style="width: 25px; height: 25px;" src="{{ URL::asset('images/iconos/archivo.png') }}" ><br>{{ traducir("traductor.descargar_formato") }}</a></button>
        </div>

   </div>

   <div class="row" style="margin-top: 20px;">
       <div class="col-md-2 col-md-offset-5">
           <button type="button" class="btn btn-default" id="importar"><img style="width: 25px; height: 25px;" src="{{ URL::asset('images/iconos/update.png') }}" ><br>{{ traducir("traductor.importar") }}</button>
       </div>
   </div>

</form>
@endsection

