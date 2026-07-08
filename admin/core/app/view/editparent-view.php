<?php 
$alumn = PersonData::getById($_GET["id"]);
if($alumn->kind!=2){ Core::redir("./");}
?>
<div class="row">
	<div class="col-md-12">
	<h1>Editar Padre</h1>
	<br>
		<form class="form-horizontal" method="post" id="addcategory" action="index.php?action=parents&opt=upd" role="form">
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
      <input type="text" name="address"  class="form-control" value="<?php echo $alumn->address; ?>" id="name" placeholder="Domicilio">
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Email*</label>
    <div class="col-md-6">
      <input type="text" name="email"  class="form-control" value="<?php echo $alumn->email; ?>" id="name" placeholder="Email">
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Telefono*</label>
    <div class="col-md-6">
      <input type="text" name="phone" value="<?php echo $alumn->phone; ?>"  class="form-control" id="name" placeholder="Telefono">
    </div>
  </div>

    <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Password*</label>
    <div class="col-md-6">
      <input type="text" name="password"  class="form-control" id="name" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
    <input type="hidden" name="alumn_id" value="<?php echo $_GET["id"];?>">
      <button type="submit" class="btn btn-success">Actualizar Padre</button>
    </div>
  </div>
</form>
	</div>
</div>