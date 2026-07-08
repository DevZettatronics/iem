<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<div class="row">
	<div class="col-md-12">
<div class="btn-group pull-right">
	<a href="./?view=grades&opt=new" class="btn btn-default"><i class='fa fa-th-list'></i> Nuevo Grado</a>
</div>
		<h1>Grados</h1>
<br>
		<?php

		$teams = GradeData::getAll();
		if(count($teams)>0){
			// si hay usuarios
			?>
			<table class="table table-bordered table-hover">
			<thead>
			<th>Nombre</th>
			<th></th>
			</thead>
			<?php
			foreach($teams as $team){
				?>
				<tr>
				<td><?php echo $team->name; ?></td>				
				<td style="width:130px;"><a href="index.php?view=grades&opt=edit&id=<?php echo $team->id;?>" class="btn btn-warning btn-xs">Editar</a> <a href="index.php?action=grades&opt=del&id=<?php echo $team->id;?>" class="btn btn-danger btn-xs">Eliminar</a></td>
				</tr>
				<?php
			}
			echo "</table>";
		}else{
			echo "<p class='alert alert-danger'>No hay Grados</p>";
		}
		?>
	</div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
	<div class="row">
	<div class="col-md-12">
	<h1>Nueva Grado</h1>
	<br>
		<form class="form-horizontal" method="post" id="addcategory" action="./?action=grades&opt=add" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="name" required class="form-control" id="name" placeholder="Nombre">
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-primary">Agregar Grado</button>
    </div>
  </div>
</form>
	</div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):
$a = GradeData::getById($_GET["id"]);
?>
	<div class="row">
	<div class="col-md-12">
	<h1>Editar Grado</h1>
	<br>
		<form class="form-horizontal" method="post" id="addcategory" action="./?action=grades&opt=update" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="name" value="<?php echo $a->name; ?>" required class="form-control" id="name" placeholder="Nombre">
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
    <input type="hidden" name="id" value="<?php echo $a->id;?>">
      <button type="submit" class="btn btn-success">Actualizar Grado</button>
    </div>
  </div>
</form>
	</div>
</div>
<?php endif; ?>