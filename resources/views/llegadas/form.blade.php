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



<div id="modal-toma-llegada" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none" data-backdrop="static">
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

<div id="modal-llegadas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <form id="formulario-llegadas" class="form-horizontal" role="form">

                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="evento_id" class="input-sm entrada">

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
                    <button type="button" class="btn btn-default btn-sm" id="cancelar-llegada"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/cancelar.png') }}" ><br>[Esc] [Cancelar]</button>
                    <button type="button" id="guardar-llegada" class="btn btn-default btn-sm"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/salvar.png') }}" ><br>[F9] [Guardar]</button>
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
                            <video style="width: 100%; height: 200px;" id="preview"></video>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="control-label">Seleccione Cámara</label>
                            <select name="camara" id="camara" class="form-control entrada">

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


<div id="modal-registro" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formulario-registro" class="form-horizontal" role="form">

                <div class="modal-body" style="">
                    <div class="row" style="margin-bottom: 5px; text-align: center;">
                        <div class="col-md-12">
                            <span class="">Participante recepcionado</span><br>
                            <label class="control-label"><span id="participante"></span></label>
                            <span class="" id="delegado"></span>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 5px; text-align: center;">
                        <div class="col-md-12">
                            <span class="">Vuelo: <span id="aerolinea"></span>, <span id="vuelo"></span>, <span id="fecha-llegada"></span>, desde <span id="destino-llegada"></span></span>

                        </div>

                    </div>
                    <div class="row" style="margin-bottom: 5px; text-align: center;">
                        <div class="col-md-12">
                            <span class="">Celular: <span id="celular"></span></span>

                        </div>

                    </div>



                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-2 col-md-offset-5">
                            <center><button type="button" id="volver-registro" class="btn btn-default btn-sm">Volver</button></center>
                        </div>

                    </div>




                </div>

            </form>

        </div>
    </div>
</div>


<div id="modal-registrado" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formulario-registrado" class="form-horizontal" role="form">

                <div class="modal-body" style="">
                    <div class="row" style="margin-bottom: 5px; text-align: center;">
                        <div class="col-md-12">
                            <span class="">El Participante <label class="control-label"><span id="participante_r"></span></label><span class="" id="delegado_r"></span></span><br>


                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 10px; text-align: center;">
                        <div class="col-md-12">
                            <span class="">Con celular: <span id="celular_r"></span>, ya fue recepcionado por: <br><span id="usuario"></span>, <span id="fecha-hora"></span></span>

                        </div>

                    </div>
                    <div class="row" style="margin-bottom: 5px; text-align: center;">
                        <div class="col-md-12">
                            <span class="">Vuelo: <span id="aerolinea_r"></span>, <span id="vuelo_r"></span>, <span id="fecha-llegada_r"></span>, desde <span id="destino-llegada_r"></span></span>

                        </div>

                    </div>



                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-2 col-md-offset-5">
                            <center><button type="button" id="volver-registrado" class="btn btn-default btn-sm">Volver</button></center>
                        </div>

                    </div>




                </div>

            </form>

        </div>
    </div>
</div>
