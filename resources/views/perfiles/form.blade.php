<div id="modal-perfiles" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="typeoperacion"></span></h4>
            </div> -->
            <form id="formulario-perfiles" class="form-horizontal" role="form">

                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="perfil_id" class="input-sm entrada">
                        <div class="col-md-6">
                            <label class="control-label">Descripción</label>
                            <input type="text" class="form-control input-sm entrada limpiar" name="perfil_descripcion" />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Estado</label>
                            <select name="estado" id="estado" class="form-control input-sm entrada" default-value="A">
                                <option value="A">ACTIVO</option>
                                <option value="I">INACTIVO</option>
                            </select>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" id="cancelar-perfil"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/cancelar.png') }}" ><br>[Esc] [Cancelar]</button>
                    <button type="button" id="guardar-perfil" class="btn btn-default btn-sm"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/salvar.png') }}" ><br>[F9] [Guardar]</button>
                </div>
            </form>

        </div>
    </div>
</div>
