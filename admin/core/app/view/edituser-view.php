<?php $user = UserData::getById($_GET["id"]); ?>
<div class="row">
  <div class="col-md-12">
    <h1>Editar Usuario</h1>
    <br>
    <form class="form-horizontal" method="post" id="addproduct" action="index.php?view=updateuser" autocomplete="off" role="form">
       <?php if (Core::$user->kind == 1) : ?>
      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Tipo de usuario*</label>
        <div class="col-md-6">
          <select name="kind" class="form-control" required>
            <option value="">-- SELECCIONE --</option>
            <option value="1" <?php if ($user->kind == 1) {
                                echo "selected";
                              } ?>>Administrador</option>
            <option value="2" <?php if ($user->kind == 2) {
                                echo "selected";
                              } ?>>Capturista</option>
            <option value="9" <?php if ($user->kind == 9) {
                                echo "selected";
                              } ?>>Relaciones Publicas</option>
            <option value="10" <?php if ($user->kind == 10) {
                                  echo "selected";
                                } ?>>Servicios</option>
            <option value="11" <?php if ($user->kind == 11) {
                                  echo "selected";
                                } ?>>Departamento Contable</option>
            <option value="12" <?php if ($user->kind == 12) {
                                  echo "selected";
                                } ?>>Ventas</option>
          </select>
        </div>
      </div>

    <?php endif; ?>

      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
        <div class="col-md-6">
          <input type="text" name="name" value="<?php echo $user->name; ?>" class="form-control" id="name" placeholder="Nombre">
        </div>
      </div>
      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Apellido*</label>
        <div class="col-md-6">
          <input type="text" name="lastname" value="<?php echo $user->lastname; ?>" required class="form-control" id="lastname" placeholder="Apellido">
        </div>
      </div>
      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Nombre de usuario*</label>
        <div class="col-md-6">
          <input type="text" name="username" value="<?php echo $user->username; ?>" class="form-control" required id="username" placeholder="Nombre de usuario">
        </div>
      </div>
      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Email*</label>
        <div class="col-md-6">
          <input type="text" name="email" value="<?php echo $user->email; ?>" class="form-control" id="email" placeholder="Email">
        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Contrase&ntilde;a</label>
        <div class="col-md-6">
          <input type="password" autocomplete="off" name="password" class="form-control" id="inputEmail1" placeholder="Contrase&ntilde;a">
          <p class="help-block">La contrase&ntilde;a solo se modificara si escribes algo, en caso contrario no se modifica.</p>
        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Esta activo</label>
        <div class="col-md-6">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="is_active" <?php if ($user->is_active) {
                                                        echo "checked";
                                                      } ?>>
            </label>
          </div>
        </div>
      </div>



      <p class="alert alert-info">* Campos obligatorios</p>

      <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
          <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
          <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- Codigo no reconocido // Ale
<div class="col-md-4">
  <section class="panel">
    <div class="panel-body">
      <div class="thumb-info mb-md">
        <img src="<?php //echo $this->crud_model->get_image_url('admin', $row['admin_id']); ?>" class="rounded img-responsive">
        <div class="thumb-info-title">
          <span class="thumb-info-inner">
            <?php //echo $row['name']; ?>
          </span>
          <span class="thumb-info-type">
            <?php //echo $this->session->userdata('login_type'); ?>
          </span>
        </div>
      </div>
    </div>
	</section>
</div>
-->