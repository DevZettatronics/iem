<!-- Modal -->
<div class="modal fade" id="modal_nuevoCargo" tabindex="-1" role="dialog" aria-labelledby="modal_nuevoCargo">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Recargo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h5 id="errorMessage" class="text-danger text-center"></h5>
                <form id="FormRecargoAdd">
                    <div class="row">
                        <div class="input-group input-daterange">
                            <!-- <div class="input-group-addon" for="start_date">Nuevo Nombre: </div> -->
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" >
                        </div>
                        <div class="input-group input-daterange">
                            <!-- <div class="input-group-addon" for="start_date">Nuevo Nombre: </div> -->
                            <label for="descripcion">Decripción</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" >
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col">
                                <label for="fecha_inicio" >Fecha Inicio</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
                            </div>
                            <div class="col">
                                <label for="fecha_fin" >Fecha Fin</label>
                                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
                            </div>
                        </div>
                    </div>
                
            </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-img" id="cancelarRecargoAdd">
                                Cancelar
                        </button>    
                        <button type="submit" class="btn btn-success btn-img" id="insertar_recargo">
                            Generar Recargo
                        </button>

                    </div>
                </form>    
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<style>
    #cancelarRecargoAdd {
        margin-top: 10px; /* ajusta el valor hasta que queden alineados */
    }
</style>