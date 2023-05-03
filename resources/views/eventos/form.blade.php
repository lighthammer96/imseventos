<div id="modal-eventos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <form id="formulario-eventos" class="form-horizontal" role="form">

                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="evento_id" class="input-sm entrada">
                        <div class="col-md-12">
                            <label class="control-label">Descripción</label>
                            <input type="text" class="form-control input-sm entrada" name="evento_descripcion" />
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <label class="control-label">Fecha Inicio</label>
                            <div class="input-group">
                                <input type="text" class="form-control input-sm entrada" name="evento_fecha_inicio" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask placeholder="" />
                                <div class="input-group-addon"  id="calendar-evento_fecha_inicio" style="cursor: pointer;">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <label class="control-label">Fecha Fin</label>
                            <div class="input-group">
                                <input type="text" class="form-control input-sm entrada" name="evento_fecha_fin" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask placeholder="" />
                                <div class="input-group-addon"  id="calendar-evento_fecha_fin" style="cursor: pointer;">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="" class="control-label">Detalle</label>
                            <textarea class="form-control input-sm entrada" name="evento_detalle" rows="2"></textarea>
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
                    <button type="button" class="btn btn-default btn-sm" id="cancelar-evento"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/cancelar.png') }}" ><br>[Esc] [Cancelar]</button>
                    <button type="button" id="guardar-evento" class="btn btn-default btn-sm"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/salvar.png') }}" ><br>[F9] [Guardar]</button>
                </div>
            </form>

        </div>
    </div>
</div>
