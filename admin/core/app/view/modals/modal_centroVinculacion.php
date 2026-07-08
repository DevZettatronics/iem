<!-- Modal -->
<div class="modal fade" id="modal_vinculacionADD" tabindex="-1" role="dialog" aria-labelledby="modal_vinculacionADD">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">NUEVO REGISTRO</h5>
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
                                <label for="lastname" class="col-lg-2 control-label">Apellidos*</label>
                                <div class="col-md-12">
                                    <input type="text" name="lastname" required class="form-control" id="lastname" placeholder="Apellidos">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-lg-2 control-label">Email*</label>
                                <div class="col-md-12">
                                    <input type="email" name="email" required class="form-control" id="email" placeholder="Correo Electronico">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="descripcion" class="col-lg-2 control-label">Descripcion*</label>
                                <div class="col-md-12">
                                    <input type="text" name="descripcion" required class="form-control" id="descripcion" placeholder="Descripcion">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="responsable" class="col-lg-2 control-label">Responsable*</label>
                                <div class="col-md-12">
                                    <input type="text" name="responsable" required class="form-control" id="responsable" placeholder="Responsable">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="direccion" class="col-lg-2 control-label">Direccion*</label>
                                <div class="col-md-12">
                                    <input type="text" name="direccion" required class="form-control" id="direccion" placeholder="Direccion">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="telefono" class="col-lg-2 control-label">Telefono*</label>
                                <div class="col-md-12">
                                    <input type="text" name="telefono" required class="form-control" id="telefono" placeholder="Telefono">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="parcialidades " class="col-lg-2 control-label">Parcialidades*</label>
                                <div class="col-md-12">
                                    <select name="parcialidades" id="parcialidades" class="form-control">
                                       <option value="">Seleciona parcialidades </option>
                                       <option value="1">SI</option>
                                       <option value="2">NO</option>
                                    </select>
                                    <!-- <input type="text" name="edit_telefono" required class="form-control" id="edit_telefono" placeholder="Telefono"> -->
                                </div>
                            </div>
                        </form>
                    </div>
                    <h5 id="errorMessage" class="text-danger text-center"></h5>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="generar_registro">Agregar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->