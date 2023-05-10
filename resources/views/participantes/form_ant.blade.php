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
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-12" style="text-align: center;">
                            <label for="" class="control-label" id="" >Evento: <span id="evento-texto"></span></label>
                        </div>
                    </div>
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#datos-generales" data-toggle="tab">Datos Generales</a></li>
                            <li><a href="#vuelos" data-toggle="tab">Vuelos</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="datos-generales">

                                <div class="row">
                                    <input type="hidden" name="participante_id" class="input-sm entrada">
                                    <input type="hidden" name="evento_id" class="input-sm entrada">
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
                                    <div class="col-md-4">
                                        <label class="control-label">Tipo Documento</label>

                                        <select name="idtipodoc" id="idtipodoc" class="selectizejs entrada"></select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">Nro Documento</label>

                                        <input type="text" class="form-control input-sm entrada" name="participante_nrodoc"  placeholder=""/>

                                    </div>
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

                                        <input type="text" class="form-control input-sm entrada" name="participante_edad"  placeholder=""/>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-3">
                                        <label class="control-label">Celular</label>

                                        <input type="text" class="form-control input-sm entrada" name="participante_celular"  placeholder=""/>

                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">Celular Emergencia</label>

                                        <input type="text" class="form-control input-sm entrada" name="participante_celular_emergencia"  placeholder=""/>

                                    </div>
                                    <div class="col-md-5">
                                        <label class="control-label">Correo</label>

                                        <input type="text" class="form-control input-sm entrada" name="participante_correo"  placeholder=""/>

                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label">Iglesia</label>

                                        <input type="text" class="form-control input-sm entrada" name="participante_iglesia"  placeholder=""/>

                                    </div>

                                    <div class="col-md-6">
                                        <label class="control-label">Apoderado</label>

                                        <input type="text" class="form-control input-sm entrada" name="participante_apoderado"  placeholder=""/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="control-label">Pais</label>

                                        <select name="idpais" id="idpais" class="selectizejs entrada"></select>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="control-label">Ciudad Procedencia</label>

                                        <input type="text" class="form-control input-sm entrada" name="participante_ciudad_procedencia"  placeholder=""/>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">{{ traducir('traductor.estado')}}</label>
                                        <select name="estado" id="estado" class="form-control input-sm entrada" default-value="A">
                                            <option value="A">ACTIVO</option>
                                            <option value="I">INACTIVO</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="row" style="margin-top: 15px;">
                                    <div class="col-md-2" >
                                        <label class="control-label"style="padding: 0;">Delegado: </label>
                                    </div>
                                    <div class="col-md-3" >
                                        <input type="radio" name="participante_delegado" value="S" class="minimal entrada" >&nbsp;SI&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="participante_delegado" value="N" class="minimal entrada" >&nbsp;NO
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane" id="vuelos">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label">Aerolinea</label>

                                        <input type="text" class="form-control input-sm entrada" name="participante_aerolinea"  placeholder=""/>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Número de Vuelo</label>

                                        <input type="text" class="form-control input-sm entrada" name="participante_nrovuelo"  placeholder=""/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="control-label">Fecha de Llegada</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control input-sm entrada" name="participante_fecha_llegada" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask placeholder="" />
                                            <div class="input-group-addon"  id="calendar-participante_fecha_llegada" style="cursor: pointer;">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">Hora de Llegada</label>


                                        <div class="input-group">
                                            <input type="text" class="form-control input-sm entrada limpiar" name="participante_hora_llegada" />
                                            <div class="input-group-addon" style="cursor: pointer;">
                                                <i class="fa fa-clock-o" id="time-participante_hora_llegada"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">Fecha de Retorno</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control input-sm entrada" name="participante_fecha_retorno" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask placeholder="" />
                                            <div class="input-group-addon"  id="calendar-participante_fecha_retorno" style="cursor: pointer;">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">Hora de Retorno</label>


                                        <div class="input-group">
                                            <input type="text" class="form-control input-sm entrada limpiar" name="participante_hora_retorno" />
                                            <div class="input-group-addon" style="cursor: pointer;">
                                                <i class="fa fa-clock-o" id="time-participante_hora_retorno"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 15px;">
                                    <div class="col-md-12">
                                        <div class="col-md-8">
                                            <label class="control-label">Destino final de llegada para recepción en aeropuerto</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control input-sm entrada" name="participante_destino_llegada"  placeholder=""/>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="row qr" style="display: none; margin-top: 20px;">
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

                    <div class="pull-right">
                        <button type="button" class="btn btn-default btn-sm" id="cancelar-participante"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/cancelar.png') }}" ><br>[Esc] [{{ traducir('traductor.cancelar') }}]</button>
                        <button type="button" id="guardar-participante" class="btn btn-default btn-sm"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/salvar.png') }}" ><br>[F9] [{{ traducir('traductor.guardar') }}]</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
