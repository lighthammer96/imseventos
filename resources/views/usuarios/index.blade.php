@extends('layouts.layout')
{{-- @extends('layouts.header') --}}
{{-- @extends('layouts.menu') --}}
{{-- @extends('layouts.aside') --}}
{{-- @extends('layouts.footer') --}}



@section('content')

<div class="modal fade" id="modal-usuarios" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <h4 class="modal-title"><span class="typeoperacion"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> -->
            <form id="formulario-usuarios" class="form-horizontal">
                <input type="hidden" id="_token" class="entrada" name="_token" value="{{ csrf_token() }}">
                <div class="modal-body">
                    <div class="row">


                        <input type="hidden" name="usuario_id" class="input-sm entrada">

                        <div class="col-md-12">
                            <label class="control-label">Nombres</label>
                            <input type="text" autofocus="autofocus" class="form-control input-sm entrada" name="usuario_nombres" />

                        </div>

                        <div class="col-md-6">
                            <label class="control-label">{{ traducir('traductor.usuario')}}</label>
                            <input type="text" class="form-control input-sm entrada" name="usuario_user" />
                            <!-- <div class="msg"></div> -->

                        </div>
                        <div class="col-md-6">
                            <label class="control-label">{{ traducir('traductor.clave')}}</label>
                            <input type="password" class="form-control input-sm entrada" name="pass1" />

                        </div>
                        <!-- <div class="col-md-6">
                            <label class="control-label">Confimar Clave</label>
                            <input type="password" class="form-control input-sm entrada" name="pass2" />

                        </div> -->
                        <div class="col-md-6">
                            <label class="control-label">{{ traducir('traductor.perfil')}}</label>
                            <select name="perfil_id" id="perfil_id" class="selectizejs entrada">

                            </select>

                        </div>


                        <!-- <div class="col-md-6">
                            <label class="control-label">Referencia</label>
                            <textarea name="usuario_referencia" id="usuario_referencia" class="form-control input-sm entrada"></textarea>

                        </div> -->
                        <div class="col-md-6">
                            <label class="control-label">{{ traducir('traductor.estado')}}</label>
                            <select name="estado" id="estado" class="form-control input-sm entrada" default-value="A">
                                <option value="A">ACTIVO</option>
                                <option value="I">INACTIVO</option>
                            </select>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" id="cancelar-usuario"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/cancelar.png') }}" ><br>[Esc] [{{ traducir('traductor.cancelar')}}]</button>
                    <button type="button" id="guardar-usuario" class="btn btn-default btn-sm"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/salvar.png') }}" ><br>[F9] [{{ traducir('traductor.guardar')}}]</button>
                </div>
            </form>
        </div>
    </div>
</div>





@endsection
