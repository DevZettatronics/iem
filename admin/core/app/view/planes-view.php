<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<div class="row">
	<div class="col-md-12">
<div class="btn-group pull-right">
	<a href="./?view=planes&opt=new" class="btn btn-default"><i class='fa fa-th-list'></i> Nuevo Plan de estudio</a>
</div>
		<h1>Planes de Estudio</h1>
<br>
		<?php

		$teams = PlanData::getAll();
		if(count($teams)>0){
			// si hay usuarios
			?>
			<div class="box box-primary">
			<div class="box-body">

			<table class="table table-bordered datatable table-hover">
			<thead>
			<th>Nombre</th>
			<th></th>
			</thead>
			<?php
			foreach($teams as $team){
				?>
				<tr>
				<td><?php echo $team->name; ?></td>		
				<td style="width:230px;">

				<a href="index.php?view=planes&opt=grades&id=<?php echo $team->id;?>" class="btn btn-default btn-xs">Grados</a>
				<a href="index.php?view=planes&opt=asignatures&id=<?php echo $team->id;?>" class="btn btn-default btn-xs">Asignaturas</a>

				<a href="index.php?view=planes&opt=edit&id=<?php echo $team->id;?>" class="btn btn-warning btn-xs">Editar</a> <a href="index.php?action=planes&opt=del&id=<?php echo $team->id;?>" class="btn btn-danger btn-xs">Eliminar</a></td>
				</tr>
				<?php
			}
			echo "</table></div></div>";
		}else{
			echo "<p class='alert alert-danger'>No hay Planes de Estudio</p>";
		}
		?>
	</div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
	<div class="row">
	<div class="col-md-12">
	<h1>Nuevo Plan de estudio</h1>
	<br>
		<form class="form-horizontal" method="post" id="addcategory" action="./?action=planes&opt=add" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="name" required class="form-control" id="name" placeholder="Nombre">
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-primary">Agregar Plan de estudio</button>
    </div>
  </div>
</form>
	</div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):
$a = PlanData::getById($_GET["id"]);
?>
	<div class="row">
	<div class="col-md-12">
	<h1>Editar Plan de estudio</h1>
	<br>
		<form class="form-horizontal" method="post" id="addcategory" action="./?action=planes&opt=update" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="name" value="<?php echo $a->name; ?>" required class="form-control" id="name" placeholder="Nombre">
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
    <input type="hidden" name="id" value="<?php echo $a->id;?>">
      <button type="submit" class="btn btn-success">Actualizar Plan de estudio</button>
    </div>
  </div>
</form>
	</div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="grades"):
$plan = PlanData::getById($_GET["id"]);
?>

<div class="row">
	<div class="col-md-12">






<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo grado</h4>
      </div>
      <div class="modal-body">

		<form class="form-horizontal" method="post" id="addcategory" action="index.php?action=planes&opt=addgrade" role="form">
<input type="hidden" name="plan_id" value="<?php echo $plan->id; ?>">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Grado*</label>
    <div class="col-md-6">
    <select name="grade_id" class="form-control" required>
    <option value="">-- SELECCIONE --</option>
      <?php foreach(GradeData::getAll() as $al):?>
    <option value="<?php echo $al->id;?>"><?php echo $al->name; ?></option>
      <?php endforeach;?>
    </select>

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
  </div>
</div>


		<h1><?php echo $plan->name; ?> <small>Grados</small></h1>
<!-- Button trigger modal -->
<a href="./?view=planes&opt=all" class="btn btn-default">Regresar</a>
<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
  Agregar Grado
</button>
<br><br>
		<?php

		$teams = PGData::getAllByPlanId($plan->id);
		if(count($teams)>0){
			// si hay usuarios
			?>
			<div class="box box-primary">
			<div class="box-body">

			<table class="table table-bordered datatable table-hover">
			<thead>
			<th>Nombre</th>
			<th></th>
			</thead>
			<?php
			foreach($teams as $team){
				?>
				<tr>
				<td><?php echo $team->getGrade()->name; ?></td>		
				<td style="width:230px;">
 <a href="index.php?action=planes&opt=delgrade&plan_id=<?php echo $plan->id; ?>&id=<?php echo $team->id;?>" class="btn btn-danger btn-xs">Eliminar</a></td>
				</tr>
				<?php
			}
			echo "</table></div></div>";
		}else{
			echo "<p class='alert alert-danger'>No hay Grados</p>";
		}
		?>
	</div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="asignatures"):
$plan = PlanData::getById($_GET["id"]);
?>

<div class="row">
	<div class="col-md-12">






<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nueva asignatura</h4>
      </div>
      <div class="modal-body">

		<form class="form-horizontal" method="post" id="addcategory" action="index.php?action=planes&opt=addasignature" role="form">
<input type="hidden" name="plan_id" value="<?php echo $plan->id; ?>">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Grado*</label>
    <div class="col-md-6">
    <select name="grade_id" class="form-control" required>
    <option value="">-- SELECCIONE --</option>
      <?php foreach(GradeData::getAll() as $al):?>
    <option value="<?php echo $al->id;?>"><?php echo $al->name; ?></option>
      <?php endforeach;?>
    </select>

        </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Asignatura*</label>
    <div class="col-md-6">
    <select name="asignature_id" class="form-control" required>
    <option value="">-- SELECCIONE --</option>
      <?php foreach(AsignatureData::getAll() as $al):?>
    <option value="<?php echo $al->id;?>"><?php echo $al->name; ?></option>
      <?php endforeach;?>
    </select>

        </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-primary">Agregar Asignatura</button>
    </div>
  </div>
</form>
      </div>

    </div>
  </div>
</div>


		<h1><?php echo $plan->name; ?> <small>Asignatura</small></h1>
<!-- Button trigger modal -->
<a href="./?view=planes&opt=all" class="btn btn-default">Regresar</a>
<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
  Agregar Asignatura
</button>
<br><br>
		<?php

		$teams = PGAData::getAllByPlanId($plan->id);
		if(count($teams)>0){
			// si hay usuarios
			?>
			<div class="box box-primary">
			<div class="box-body">

			<table class="table table-bordered datatable table-hover">
			<thead>
			<th>Grado</th>
			<th>Asignatura</th>
			<th></th>
			</thead>
			<?php
			foreach($teams as $team){
				?>
				<tr>
				<td><?php echo $team->getGrade()->name; ?></td>		
				<td><?php echo $team->getAsignature()->name; ?></td>		
				<td style="width:230px;">
 <a href="index.php?action=planes&opt=delasignature&plan_id=<?php echo $plan->id; ?>&id=<?php echo $team->id;?>" class="btn btn-danger btn-xs">Eliminar</a></td>
				</tr>
				<?php
			}
			echo "</table></div></div>";
		}else{
			echo "<p class='alert alert-danger'>No hay Asignaturas</p>";
		}
		?>
	</div>
</div>
<?php endif; ?>