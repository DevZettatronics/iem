<?php
$user = UserData::getById($_GET["id"]);
$con = Database::getCon();
?>
 <h3><img src="../storage/posts/clave.png"  width="52px"> Cambio de Contraseña</h3>
 <a href="./?view=home" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a> 
<br>
<!-- action="index.php?action=alumns&opt=upd" -->
<section class="content">
  <div class="row">
    <form class="form-horizontal" method="post" id="new_register" action="" role="form" autocomplete="off">

      <div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#acceso" data-toggle="tab" aria-expanded="false">Datos del Estudiante</a></li>
          </ul>

          <div class="tab-content">

            <div class="tab-pane active" id="acceso">

              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Usuario:</label>
                <div class="col-md-2">
                  <input type="text" name="code" value="<?php echo $user->username; ?>" class="form-control" id="code" placeholder="Nombre de usuario" readonly onmousedown="return false;">
                </div>

                <label for="inputEmail1" class="col-lg-2 control-label">Nombre del Colaborador:</label>
                <div class="col-md-2">
                  <input type="text" name="name" value="<?php echo $user->name; ?> <?php echo $user->lastname; ?>" class="form-control" id="name" placeholder="Nombre" disabled="disabled">
                </div>

          
              </div>

              <div class="form-group">
               

                <label for="inputEmail1" class="col-lg-2 control-label">Estatus en Sistema: </label>
                <div class="col-md-2">
                  <input type="radio" name="is_active" disabled="disabled" <?php if ($user->is_active) {
                                                                              echo "checked";
                                                                            } ?>> Activo
                </div>
                </div>
                
                <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Contrase&ntilde;a Nueva:</label>
                <div class="col-md-2">
                  <input type="password" name="password" class="form-control" id="inputEmail1" placeholder="Contrase&ntilde;a">
                  <p class="help-block">La contrase&ntilde;a sólo se modificará si escribes en casilla, en caso contrario no habrá modificación.</p>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>



      <div class="form-group">
        <div class="col-lg-5"></div>
        <div class="col-lg-2">
          <button type="submit" class="btn bg-navy">Actualizar Contraseña</button>
        </div>
        <div class="col-lg-5"></div>
    </form>
  </div>
</section>

<div class="modal" tabindex="-1" role="dialog" id="modalMensaje">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Mensaje Del Sistema</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="mensaje"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<script>
 



  $("#new_register").submit(function(event) {

    var parametros = $(this).serialize();
    var formData = new FormData(document.getElementById("new_register"));
    $.ajax({
      type: "POST",
      url: "core/app/action/pass-action.php",
      dataType: "html",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function(objeto) {
        $("#modalMensaje").modal('show');
        $("#mensaje").html('Enviando Datos......');
      },
      success: function(datos) {
        $("#modalMensaje").modal('show');
        $("#mensaje").html(datos);
      }
    });
    event.preventDefault();
  });
</script>