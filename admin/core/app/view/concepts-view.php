<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<div class="row">
	<div class="col-md-12">
		<h1>Conceptos</h1>
	<a href="./?view=concepts&opt=new" class="btn btn-default"><i class='fa fa-th-list'></i> Nuevo Concepto</a>
<br>
<br>
		<?php

		$teams = ConceptData::getAll();
		if(count($teams)>0){
			// si hay usuarios
			?>
			<div class="box box-primary">
			<div class="box-body">
			<table class="table table-bordered datatable table-hover">
			<thead>
			<th>Nombre</th>
			<th>Precio</th>
			<th></th>
			</thead>
			<?php
			foreach($teams as $team){
				?>
				<tr>
				<td><?php echo $team->name; ?></td>				
				<td>$ <?php echo $team->price; ?></td>				

				<td style="width:130px;"><a href="index.php?view=concepts&opt=edit&id=<?php echo $team->id;?>" class="btn btn-warning btn-xs">Editar</a> <a href="index.php?action=concepts&opt=del&id=<?php echo $team->id;?>" class="btn btn-danger btn-xs">Eliminar</a></td>
				</tr>
				<?php
			}
			echo "</table></div></div>";
		}else{
			echo "<p class='alert alert-danger'>No hay Conceptos</p>";
		}
		?>
	</div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
	<div class="row">
	<div class="col-md-12">
	<h1>Nuevo Concepto</h1>
	<br>
		<form class="form-horizontal" method="post" id="addcategory" action="./?action=concepts&opt=add" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="name" required class="form-control" id="name" placeholder="Nombre">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Precio*</label>
    <div class="col-md-6">
      <input type="text" name="price" required class="form-control" id="name" placeholder="Precio">
    </div>
  </div>
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-primary">Agregar Concepto</button>
    </div>
  </div>
</form>
	</div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):
$a = ConceptData::getById($_GET["id"]);
?>
	<div class="row">
	<div class="col-md-12">
	<h1>Editar Concepto</h1>
	<br>
		<form class="form-horizontal" method="post" id="addcategory" action="./?action=concepts&opt=update" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="name" value="<?php echo $a->name; ?>" required class="form-control" id="name" placeholder="Nombre">
    </div>
  </div>
 <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Precio*</label>
    <div class="col-md-6">
      <input type="text" name="price" value="<?php echo $a->price; ?>" required class="form-control" id="name" placeholder="Precio">
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
    <input type="hidden" name="id" value="<?php echo $a->id;?>">
      <button type="submit" class="btn btn-success">Actualizar Concepto</button>
    </div>
  </div>
</form>
	</div>
</div>
<?php endif; ?>