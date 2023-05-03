

<div id="modal-programas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <form id="formulario-programas" class="form-horizontal" role="form">

                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="programa_id" class="input-sm entrada">

                        <div class="col-md-12">
                            <label class="control-label">Evento</label>

                            <select name="evento_id" id="evento_id" class="selectizejs entrada"></select>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Descripción</label>
                            <input type="text" class="form-control input-sm entrada" name="programa_descripcion" />
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <label class="control-label">Tipo</label>

                            <select name="tp_id" id="tp_id" class="entrada form-control input-sm"></select>
                        </div>


                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <label class="control-label">Fecha</label>
                            <div class="input-group">
                                <input type="text" class="form-control input-sm entrada" name="programa_fecha" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask placeholder="" />
                                <div class="input-group-addon"  id="calendar-programa_fecha" style="cursor: pointer;">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Estado</label>
                            <select name="estado" id="estado" class="form-control input-sm entrada" default-value="A">
                                <option value="A">ACTIVO</option>
                                <option value="I">INACTIVO</option>
                            </select>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" id="cancelar-programa"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/cancelar.png') }}" ><br>[Esc] [Cancelar]</button>
                    <button type="button" id="guardar-programa" class="btn btn-default btn-sm"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/salvar.png') }}" ><br>[F9] [Guardar]</button>
                </div>
            </form>

        </div>
    </div>
</div>
