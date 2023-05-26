<style>
    .evento{
        background-color: #dceff7;
        color: #444;
        border: 1px solid #367fa9;
        border-radius: 3px;
        padding: 5px;
        text-align: center;
        cursor: pointer;
    }
    .programa{
        background-color: #dceff7;
        color: #444;
        border: 1px solid #367fa9;
        border-radius: 3px;
        padding: 3px 5px;
        text-align: center;
        cursor: pointer;
        margin-bottom: 5px;
    }
</style>
<div id="modal-eventos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formulario-eventos" class="form-horizontal" role="form">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="" class="control-label">Seleccione Evento:</label>
                        </div>
                    </div>
                    <div class="row" id="eventos" style="margin-top: 10px;">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" id="cerrar-evento"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/cancelar.png') }}" ><br>[Esc] [Cerrar]</button>


                </div>

            </form>

        </div>
    </div>
</div>

<div id="modal-programas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formulario-programas" class="form-horizontal" role="form">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="" class="control-label">Seleccione Programa de: <span id="evento"></span></label>
                        </div>
                    </div>
                    <div class="row" id="programas" style="margin-top: 10px;">
                        <div class="col-md-6">
                            <fieldset>
                                <legend>Ingreso Colisesio</legend>
                                <div id="coliseo">

                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset>
                                <legend>Ingreso Alimentos</legend>
                                <div id="alimentos">

                                </div>
                            </fieldset>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" id="cerrar-programa"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/cancelar.png') }}" ><br>[Esc] [Cerrar]</button>


                </div>

            </form>

        </div>
    </div>
</div>

<div id="modal-toma-asistencia" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <form id="formulario-eventos" class="form-horizontal" role="form">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="" class="control-label">Seleccione Evento:</label>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" id="cerrar-evento"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/cancelar.png') }}" ><br>[Esc] [Cerrar]</button>


                </div>

            </form>

        </div>
    </div>
</div>

<div id="modal-asistencias" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <form id="formulario-asistencias" class="form-horizontal" role="form">

                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="evento_id" class="input-sm entrada">
                        <input type="hidden" name="programa_id" class="input-sm entrada">
                        <div class="col-md-8">
                            <label class="control-label">Ingrese Código</label>
                            <input type="text" class="form-control input-sm entrada" name="codigo_qr" />
                        </div>
                        <div class="col-md-4" style="margin-top: 27px;">
                            <a href="#" id="leer-qr" style="text-decoration: underline;">o leer QR</a>
                        </div>

                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" id="cancelar-asistencia"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/cancelar.png') }}" ><br>[Esc] [Cancelar]</button>
                    <button type="button" id="guardar-asistencia" class="btn btn-default btn-sm"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/salvar.png') }}" ><br>[F9] [Guardar]</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div id="modal-leer-qr" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <form id="formulario-leer-qr" class="form-horizontal" role="form">

                <div class="modal-body">
                    <div class="row">


                        <div class="col-md-12">
                            <video id="preview"></video>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="control-label">Seleccione Cámara</label>
                            <select name="camara" id="camara" class="form-comtrol entrada">
                                
                            </select>
                        </div>


                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" id="cancelar-leer-qr"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/cancelar.png') }}" ><br>[Esc] [Cancelar]</button>

                </div>
            </form>

        </div>
    </div>
</div>


<div id="modal-permisos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formulario-permisos" class="form-horizontal" role="form">
                <input type="hidden" name="evento_id" class="input-sm entrada">
                <input type="hidden" name="programa_id" class="input-sm entrada">
                <input type="hidden" name="participante_id" class="input-sm entrada">
                <div class="modal-body" style="height: 420px; overflow-y: scroll; overflow-x: hidden;">
                    <div class="row" style="margin-bottom: 5px;">
                        <div class="col-md-3">
                            <label class="control-label">Ya registró Ingreso:</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" readonly="readonly" class="form-control input-sm entrada" name="participante" />
                        </div>

                    </div>

                    <div class="row" style="margin-bottom: 5px;">
                        <div class="col-md-3">
                            <label class="control-label">Celular:</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" readonly="readonly" class="form-control input-sm entrada" name="celular" />
                        </div>

                        <div class="col-md-3">
                            <label class="control-label">Cel. Emergencia:</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" readonly="readonly" class="form-control input-sm entrada" name="celular_emergencia" />
                        </div>

                    </div>

                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-3">
                            <label class="control-label">Apoderado:</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" readonly="readonly" class="form-control input-sm entrada" name="apoderado" />
                        </div>

                    </div>

                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-4">
                            <center><button type="button" id="volver" class="btn btn-default btn-sm">Volver</button></center>
                        </div>
                        <div class="col-md-4">
                            <center><button type="button" id="permiso-salida" class="btn btn-default btn-sm">Permiso de Salida</button></center>
                        </div>
                        <div class="col-md-4">
                            <center><button type="button" id="permiso-entrada" class="btn btn-default btn-sm">Permiso de Entrada</button></center>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="" style="text-align: center;">Historial de Permisos</label>
                            <table class="table table-striped table-bordered display compact" id="detalle-permisos">
                                <thead>
                                    <tr>
                                        <th style="width: 100px;">Tipo</th>
                                        <th style="width: 100px;">Fecha y Hora</th>

                                    </tr>

                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>



                </div>

            </form>

        </div>
    </div>
</div>
