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



<div id="modal-participantes" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formulario-participantes" class="form-horizontal" role="form">

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Seleccione Eventos:</label>
                            <select class="selectizejs entrada" multiple="multiple" name="evento_id[]" id="evento_id"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="control-label">Pais</label>

                            <select name="idpais" id="idpais" class="selectizejs entrada"></select>
                        </div>
                        <div class="col-md-5">
                            <label class="control-label">Tipo Documento</label>

                            <select name="idtipodoc" id="idtipodoc" class="selectizejs entrada"></select>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Nro Documento</label>

                            <input type="text" class="form-control input-sm entrada" name="participante_nrodoc"  placeholder=""/>

                        </div>

                    </div>

                    <div class="row">
                        <input type="hidden" name="participante_id" class="input-sm entrada">
                        <input type="hidden" name="registro_id_ultimo" class="input-sm entrada">
                        <input type="hidden" name="operacion" default-value="NUEVO" class="input-sm entrada">
                        <div class="col-md-6">
                            <label class="control-label">Nombres</label>

                            <input autofocus="autofocus" type="text" class="form-control input-sm entrada" name="participante_nombres"  placeholder=""/>

                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Apellidos</label>

                            <input type="text" class="form-control input-sm entrada" name="participante_apellidos"  placeholder=""/>

                        </div>


                    </div>



                    <div class="row">

                        <div class="col-md-3">
                            <label class="control-label">Celular</label>

                            <input type="text" class="form-control input-sm entrada" name="registro_celular"  placeholder=""/>

                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Celular Emergencia</label>

                            <input type="text" class="form-control input-sm entrada" name="registro_celular_emergencia"  placeholder=""/>

                        </div>
                        <div class="col-md-5">
                            <label class="control-label">Correo</label>

                            <input type="text" class="form-control input-sm entrada" name="registro_correo"  placeholder=""/>

                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Iglesia</label>

                            <input type="text" class="form-control input-sm entrada" name="registro_iglesia"  placeholder=""/>

                        </div>

                        <div class="col-md-6">
                            <label class="control-label">Apoderado</label>

                            <input type="text" class="form-control input-sm entrada" name="registro_apoderado"  placeholder=""/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3" style="">
                            <label class="control-label">Fecha Nacimiento</label>
                            <div class="input-group">
                                <input type="text" class="form-control input-sm entrada" name="participante_fecha_nacimiento" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask placeholder="" />
                                <div class="input-group-addon"  id="calendar-participante_fecha_nacimiento" style="cursor: pointer;">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">

                            <label class="control-label">Edad</label>

                            <input type="text" class="form-control input-sm entrada" name="registro_edad"  placeholder=""/>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Ciudad Procedencia</label>

                            <input type="text" class="form-control input-sm entrada" name="registro_ciudad_procedencia"  placeholder=""/>
                        </div>
                        <div class="col-md-3" >
                            <label class="control-label"style="margin-bottom: 5px;">Delegado: </label><br>
                            <input type="radio" name="registro_delegado" value="S" class="minimal entrada" >&nbsp;SI&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="registro_delegado" value="N" class="minimal entrada" >&nbsp;NO
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Aerolinea</label>

                            <input type="text" class="form-control input-sm entrada" name="registro_aerolinea"  placeholder=""/>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Número de Vuelo</label>

                            <input type="text" class="form-control input-sm entrada" name="registro_nrovuelo"  placeholder=""/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Fecha de Llegada</label>

                            <div class="input-group">
                                <input type="text" class="form-control input-sm entrada" name="registro_fecha_llegada" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask placeholder="" />
                                <div class="input-group-addon"  id="calendar-registro_fecha_llegada" style="cursor: pointer;">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Hora de Llegada</label>


                            <div class="input-group">
                                <input type="text" class="form-control input-sm entrada limpiar" name="registro_hora_llegada" />
                                <div class="input-group-addon" style="cursor: pointer;">
                                    <i class="fa fa-clock-o" id="time-registro_hora_llegada"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Fecha de Retorno</label>

                            <div class="input-group">
                                <input type="text" class="form-control input-sm entrada" name="registro_fecha_retorno" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask placeholder="" />
                                <div class="input-group-addon"  id="calendar-registro_fecha_retorno" style="cursor: pointer;">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Hora de Retorno</label>


                            <div class="input-group">
                                <input type="text" class="form-control input-sm entrada limpiar" name="registro_hora_retorno" />
                                <div class="input-group-addon" style="cursor: pointer;">
                                    <i class="fa fa-clock-o" id="time-registro_hora_retorno"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" >

                        <div class="col-md-7" style="padding-right: 0; margin-top: 27px;">
                            <label class="control-label">Destino final de llegada para recepción en aeropuerto</label>
                        </div>
                        <div class="col-md-3" style="margin-top: 27px;">
                            <input type="text" class="form-control input-sm entrada" name="registro_destino_llegada"  placeholder=""/>
                        </div>
                        <div class="col-md-2"  style="padding-left: 0;">
                            <label class="control-label">{{ traducir('traductor.estado')}}</label>
                            <select name="estado" id="estado" class="form-control input-sm entrada" default-value="A">
                                <option value="A">ACTIVO</option>
                                <option value="I">INACTIVO</option>
                            </select>
                        </div>



                    </div>






                </div>
                <div class="modal-footer">

                    <div class="pull-right">
                        <button type="button" class="btn btn-default btn-sm" id="cancelar-participante"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/cancelar.png') }}" ><br>[Esc] [{{ traducir('traductor.cancelar') }}]</button>
                        <button type="button" id="guardar-participante" class="btn btn-default btn-sm"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/salvar.png') }}" ><br>[F9] [{{ traducir('traductor.guardar') }}]</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


<div id="modal-eventos-participante" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="" class="control-label">Eventos Asignados al Participante: <span id="participante"></span></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered display compact" id="detalle-eventos">
                            <thead>
                                <tr>
                                    <th style="width: 100px;">Evento</th>
                                    <th style="width: 50px;">Fecha Inicio</th>
                                    <th style="width: 50px;">Fecha Fin</th>


                                    <th style="width: 10px;"><center>Ver</center></th>
                                </tr>

                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" id="cancelar-eventos-participante"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/cancelar.png') }}" ><br>[Esc] [Cerrar]</button>


            </div>



        </div>
    </div>
</div>

<div id="modal-ver-evento" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="" class="control-label">Evento: <span id="evento"></span></label>
                    </div>
                </div>
                <div class="row qr" style="margin-top: 20px;">
                    <div class="col-md-4 col-md-offset-2" style="">
                        {{-- <label class="control-label" style="text-align: center;">QR</label> --}}
                        <img title="Código QR" style="cursor: pointer;height: 165px !important;" src="{{ URL::asset('images/camara.png') }}" class="thumb-lg img-thumbnail usuario_foto" alt="profile-image" id="cargar_qr">
                    </div>
                    <div class="col-md-4" style="">
                        <center>

                            <div style="margin-top: 20px;">
                                <a id="descargar_pdf" class="btn btn-default"><img style="width: 30px; height: 30px;" src="{{ URL::asset('images/iconos/pdf.png') }}" > &nbsp;&nbsp;&nbsp; Descargar PDF</a>
                            </div>

                            <div style="margin-top: 20px;">
                                <button type="button" id="enviar_qr" class="btn btn-default"><img style="width: 30px; height: 30px;" src="{{ URL::asset('images/iconos/importante.png') }}" > &nbsp;&nbsp;&nbsp; Enviar QR</button>
                            </div>
                        </center>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" id="cancelar-ver-evento"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/cancelar.png') }}" ><br>[Esc] [Cerrar]</button>


            </div>



        </div>
    </div>
</div>
