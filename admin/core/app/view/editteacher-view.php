<?php
$alumn = PersonData::getById($_GET["id"]);
if ($alumn->kind != 1) {
  Core::redir("./");
}
?>
<div class="row">
  <div class="col-md-12">
    <h1>Editar Profesor</h1>
    <br>
    <a href="./?view=teachers" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a> 
    <form class="form-horizontal" method="post" id="addcategory" action="index.php?action=teachers&opt=upd" role="form">
      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Codigo*</label>
        <div class="col-md-6">
          <input type="text" name="code" value="<?php echo $alumn->code; ?>" required class="form-control" id="name" placeholder="Codigo">
        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
        <div class="col-md-6">
          <input type="text" name="name" value="<?php echo $alumn->name; ?>" required class="form-control" id="name" placeholder="Nombre">
        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Apellidos*</label>
        <div class="col-md-6">
          <input type="text" name="lastname" value="<?php echo $alumn->lastname; ?>" required class="form-control" id="name" placeholder="Apellidos">
        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Domicilio*</label>
        <div class="col-md-6">
          <input type="text" name="address" class="form-control" value="<?php echo $alumn->address; ?>" id="name" placeholder="Domicilio">
        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Email*</label>
        <div class="col-md-6">
          <input type="text" name="email" class="form-control" value="<?php echo $alumn->email; ?>" id="name" placeholder="Email">
        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Telefono*</label>
        <div class="col-md-6">
          <input type="text" name="phone" value="<?php echo $alumn->phone; ?>" class="form-control" id="name" placeholder="Telefono">
        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Año*</label>
        <div class="col-md-6">
          <input type="text" name="year" value="<?php echo $alumn->year; ?>" class="form-control" id="year" placeholder="Año">
        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Núm. Tarjeta*</label>
        <div class="col-md-6">
          <input type="text" name="tarjeta" value="<?php echo $alumn->tarjeta; ?>" class="form-control" id="tarjeta" placeholder="Núm. Tarjeta">
        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Fotografia</label>
        <div class="col-md-6">
          <input type="file" name="filename"  id="filename" class="form-control">
        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Password*</label>
        <div class="col-md-6">
          <input type="text" name="password" class="form-control" id="name" placeholder="Password">
        </div>
      </div>
      <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
          <input type="hidden" name="alumn_id" value="<?php echo $_GET["id"]; ?>">
          <button type="submit" class="btn btn-success">Actualizar Profesor</button>
        </div>
      </div>
    </form>
  </div>
</div>