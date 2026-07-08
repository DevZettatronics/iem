<!-- Modal -->
<div class="modal fade" id="modal_editRecargo" tabindex="-1" role="dialog" aria-labelledby="modal_editRecargo">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Recargo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h5 id="errorMessageedit" class="text-danger text-center"></h5>
                <form id="FormRecargoEdit">
                    <div class="row">
                        <input type="hidden" id="idEdit" name="idEdit">
                        <div class="input-group input-daterange">
                            <!-- <div class="input-group-addon" for="start_date">Nuevo Nombre: </div> -->
                            <label for="nombreEdit">Nombre</label>
                            <input type="text" name="nombreEdit" id="nombreEdit" class="form-control" >
                        </div>
                        <div class="input-group input-daterange">
                            <!-- <div class="input-group-addon" for="start_date">Nuevo Nombre: </div> -->
                            <label for="descripcionEdit">Decripción</label>
                            <input type="text" name="descripcionEdit" id="descripcionEdit" class="form-control" >
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col">
                                <label for="fecha_inicioEdit" >Fecha Inicio</label>
                                <input type="date" name="fecha_inicioEdit" id="fecha_inicioEdit" class="form-control">
                            </div>
                            <div class="col">
                                <label for="fecha_finEdit" >Fecha Fin</label>
                                <input type="date" name="fecha_finEdit" id="fecha_finEdit" class="form-control">
                            </div>
                        </div>
                    </div>
                
            </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-img" id="Edit_recargoCancelar">
                            Cancelar
                        </button>
                         <button type="submit" class="btn btn-success btn-img" id="Actualizar">
                            Editar Recargo
                        </button>
                    </div>
                </form>    
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<style>
    #Edit_recargoCancelar {
        margin-top: 10px; /* ajusta el valor hasta que queden alineados */
    }
</style>