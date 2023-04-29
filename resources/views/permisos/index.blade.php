@extends('layouts.layout')
{{-- @extends('layouts.header') --}}
{{-- @extends('layouts.menu') --}}
{{-- @extends('layouts.aside') --}}
{{-- @extends('layouts.footer') --}}


@section('content')

<form id="formulario-permisos" class="form-horizontal">
    <div class="row">

        <div class="col-md-4 col-md-offset-3" style="margin-top: 12px;">
            <select name="perfil_id" id="perfil_id" class="selectizejs entrada">
            </select>
            <!-- <div class="input-group m-bot15">
                <select placeholder="Seleccione Perfil..." name="perfil_id" id="perfil_id" class="selectizejs entrada">

                </select>
                <span class="input-group-btn">
                    <button style="margin-top: -5px;" type="button" id="nuevo-perfil" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button>

                </span>
            </div> -->

        </div>

        <div class="col-md-2" style="">
            <button type="button" class="btn btn-default btn-sm" id="guardar-permisos"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/salvar.png') }}" ><br>{{ traducir('traductor.guardar')}}</button>
        </div>

     <!--    <label class="control-label">Modulo Padre</label>

        <div class="input-group m-bot15 col-md-12 sin-padding">
            <select name="modulo_padre" id="modulo_padre" class="form-control chosen-select input-sm entrada"></select>

            <span class="input-group-btn">
                <button type="button" id="nuevoModuloPadre" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button>

            </span>

        </div> -->

    </div>
    <div class="row" style="margin-top: 15px;">
        <?php
            $i = 1;

            echo '<div class="col-md-3">';
            foreach ($modulos_all as $modulo) {
                if(count($modulo->hijos) > 0) {
                    echo '<h3 style="cursor:pointer" class="padre todo">'.$modulo->modulo_nombre.'</h3>';
                    foreach ($modulo->hijos as $hijo) {



                        echo '  <label class="checkboxes">';
                        echo '  <input class="minimal" type="checkbox" name="modulo_id[]" value="'.$hijo->modulo_id.'">';
                        echo    '&nbsp;&nbsp;'.$hijo->modulo_nombre;
                        echo '  </label><br>';



                    }
                    echo '</div>';
                    if($i%4 == 0) {
                        echo '<div style="clear:both;"></div>';
                    }
                    echo '<div class="col-md-3">';
                    $i++;
                }
            }
        ?>



    </div>
</form>


@include('perfiles.form')




@endsection



