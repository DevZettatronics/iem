<!-- Modal -->
<div class="modal fade" id="modal_nuevoRol" tabindex="-1" role="dialog" aria-labelledby="modal_nuevoRol">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Rol</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <h5> * Por favor, ingresa el nombre del nuevo rol.</h5>
              <h5> * Al crearlo, se asignará automáticamente un ID y se activarán todos los permisos por defecto.</h5>
                    <div class="row">
                        <div class="input-group input-daterange">
                            <div class="input-group-addon" for="start_date">Nuevo Nombre: </div>
                            <input type="text" name="nameRol" id="nameRol" class="form-control" >
                        </div>
                    </div>
                    <h5 id="errorMessage" class="text-danger text-center"></h5>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-img" id="insertar_rol">
                    Generar Reporte
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->