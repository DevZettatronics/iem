<!-- Modal -->
<div class="modal fade" id="modal_vinculacionEdit" tabindex="-1" role="dialog" aria-labelledby="modal_vinculacionEdit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ACTUALIZAR CONCEPTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <!-- <h5>Acompleta el siguiente registro</h4> -->
                    <div class="row">
                        <form class="form-horizontal" method="post" id="addcategoryEdit" role="form">
                            <input type="hidden" id="edit_id" name="edit_id">

                            <div class="form-group">
                                <label for="name" class="col-lg-2 control-label">Nombre*</label>
                                <div class="col-md-12">
                                    <input type="text" name="edit_name" required class="form-control" id="edit_name" placeholder="Nombre">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="monto" class="col-lg-2 control-label">Monto*</label>
                                <div class="col-md-12">
                                    <input type="text" name="edit_monto" required class="form-control" id="edit_monto" placeholder="Monto">
                                </div>
                            </div>
                        </form>
                    </div>
                    <h5 id="errorMessageedit" class="text-danger text-center"></h5>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="Actualizar">Actualizar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->