@extends('layouts.layout')
{{-- @extends('layouts.header') --}}
{{-- @extends('layouts.menu') --}}
{{-- @extends('layouts.aside') --}}
{{-- @extends('layouts.footer') --}}



@section('content')


<form id="formulario-usuarios" class="form-horizontal">

    <div class="row">
        <input type="hidden" name="usuario_id" id="usuario_id" value="{{ session('usuario_id') }}">
        <div class="col-md-4 col-md-offset-4">
            <center>
                <label class="control-label">{{ traducir("traductor.nueva_password") }}</label>
                <input type="password" class="form-control input-sm entrada" name="nueva_pass_1" id="nueva_pass_1" placeholder="" />
            </center>
        </div>
        <div class="col-md-4 col-md-offset-4">
            <center>
                <label class="control-label">{{ traducir("traductor.repita_nueva_password") }}</label>
                <input type="password" class="form-control input-sm entrada" name="nueva_pass_2" id="nueva_pass_2" placeholder="" />
            </center>
        </div>
    
        <div class="col-md-2 col-md-offset-5" style="margin-top: 20px;">
        
        <center>
                <button type="button" id="guardar-usuario" class="btn btn-default btn-sm"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/salvar.png') }}" ><br>[F9] [{{ traducir("traductor.guardar") }}]</button>
        </center>
        </div>

        
    </div>
</form>
@endsection
