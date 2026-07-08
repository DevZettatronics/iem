<!-- Modal -->
<div class="modal fade" id="modal_ConceptosADD" tabindex="-1" role="dialog" aria-labelledby="modal_vinculacionADD">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">NUEVO CONCEPTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <!-- <h5>Acompleta el siguiente registro</h4> -->
                    <div class="row">
                        <form class="form-horizontal" method="post" id="addcategory" role="form">
                            <div class="form-group">
                                <label for="name" class="col-lg-2 control-label">Nombre*</label>
                                <div class="col-md-12">
                                    <input type="text" name="name" required class="form-control" id="name" placeholder="Nombre">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="monto" class="col-lg-2 control-label">Monto*</label>
                                <div class="col-md-12">
                                    <input type="number" name="monto" required class="form-control" id="monto" placeholder="Monto" step="0.01" min="0">
                                </div>
                            </div>
                            <input type="hidden" id="centro_id" name ="centro_id" value= <?php echo intval($_GET['id']); ?> readonly>
                        </form>
                    </div>
                    <h5 id="errorMessage" class="text-danger text-center"></h5>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="generar_registroConcepto">Agregar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->