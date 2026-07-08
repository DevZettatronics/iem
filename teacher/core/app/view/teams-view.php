


<?php if(isset($_GET["opt"]) && $_GET["opt"]=="assistance"):
?>
<?php
$asignation = AsignationData::getById($_GET["asignation_id"]);
$team = TeamData::getById($asignation->team_id);
$period = PeriodData::getById($asignation->period_id);

$alumns = InscriptionData::getAllByTP($asignation->team_id,$asignation->period_id);
?>

<div class="row">
	<div class="col-md-12">
		<h4>Lista de Asistencia <?php echo $team->grade." - Grupo: ".$team->letter;?> Ciclo Escolar: <?php echo $period->name;?></h4>
		<a href="./?view=teamalumns&id=<?php echo $asignation->id;?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>

		<a href="./?view=teams&opt=assistance&asignation_id=<?php echo $asignation->id; ?>" class="btn btn-default">Tomar Asistencia</a>
		<a href="./?view=teams&opt=assistancereport&asignation_id=<?php echo $asignation->id; ?>" class="btn btn-default">Reporte de Asistencia</a>


<!--		<a href="../report/alumns-word.php?id=<?php echo $team->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-download"></i> Descargar </a><br><br> -->
</div>
</div>
<br><div class="row">
	<div class="col-md-12">
<!--	<a href="index.php?view=list&team_id=<?php echo $_GET["team_id"]; ?>" class="btn btn-default"><i class='fa fa-check'></i> Asistencia</a> -->
<form class="form-horizontal" id="loadlist" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Seleccionar Fecha:</label>
    <div class="col-lg-7">
      <input type="date" name="date_at" value="<?php echo date("Y-m-d");?>" required class="form-control" >
    </div>
    <div class="col-lg-offset-3">
    <input type="hidden" name="team_id" value="<?php echo $team->id;?>">
    <input type="hidden" name="period_id" value="<?php echo $period->id;?>">
    <input type="hidden" name="asignation_id" value="<?php echo $asignation->id;?>">
      <button type="submit" class="btn btn-primary">Buscar</button>
    </div>

  </div>
</form>

<div id="data">
	<p class="alert alert-warning">No hay datos, por favor selecciona una fecha.</p>
</div>

	</div>
</div>

<script>
	$("#loadlist").submit(function(e){
		e.preventDefault();
		var d = $("#loadlist").serialize();
		$.get("./?action=loadassistance",d,function(data){
			console.log(data);
			$("#data").html(data);

		});
	});
</script>


<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="assistancereport"):
?>
<?php
$asignation = AsignationData::getById($_GET["asignation_id"]);
$team = TeamData::getById($asignation->team_id);
$period = PeriodData::getById($asignation->period_id);

$alumns = InscriptionData::getAllByTP($asignation->team_id,$asignation->period_id);
?>

<div class="row">
	<div class="col-md-12">
		<h4>Reporte de Asistencia <?php echo $team->grade." - Grupo: ".$team->letter;?> Ciclo Escolar: <?php echo $period->name;?></h4>
		<a href="./?view=teamalumns&id=<?php echo $asignation->id;?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>

		<a href="./?view=teams&opt=assistance&asignation_id=<?php echo $asignation->id; ?>" class="btn btn-default">Tomar Asistencia</a>
		<a href="./?view=teams&opt=assistancereport&asignation_id=<?php echo $asignation->id; ?>" class="btn btn-default">Reporte de Asistencia</a>


<!--		<a href="../report/alumns-word.php?id=<?php echo $team->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-download"></i> Descargar </a><br><br> -->
</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
<!--	<a href="index.php?view=list&team_id=<?php echo $_GET["team_id"]; ?>" class="btn btn-default"><i class='fa fa-check'></i> Asistencia</a> -->
<form class="form-horizontal" id="loadlist" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Inicio:</label>
    <div class="col-lg-3">
      <input type="date" name="start_at" value="<?php echo date("Y-m-d");?>" required class="form-control" >
    </div>
    <label for="inputEmail1" class="col-lg-2 control-label">Fin:</label>
    <div class="col-lg-3">
      <input type="date" name="finish_at" value="<?php echo date("Y-m-d");?>" required class="form-control" >
    </div>
    <div class="col-lg-offset-3">
    <input type="hidden" name="team_id" value="<?php echo $team->id;?>">
    <input type="hidden" name="period_id" value="<?php echo $period->id;?>">
    <input type="hidden" name="asignation_id" value="<?php echo $asignation->id;?>">
      <button type="submit" class="btn btn-primary">Buscar</button>
    </div>

  </div>
</form>

<div id="data">
	<p class="alert alert-warning">No hay datos, por favor selecciona una fecha.</p>
</div>

	</div>
</div>

<script>
	$("#loadlist").submit(function(e){
		e.preventDefault();
		var d = $("#loadlist").serialize();
		$.get("./?action=loadlist",d,function(data){
			console.log(data);
			$("#data").html(data);

		});
	});
</script>



<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="behavior"):
?>
<?php
$asignation = AsignationData::getById($_GET["asignation_id"]);
$team = TeamData::getById($asignation->team_id);
$period = PeriodData::getById($asignation->period_id);

$alumns = InscriptionData::getAllByTP($asignation->team_id,$asignation->period_id);
?>

<div class="row">
	<div class="col-md-12">
		<h1>Lista de Conducta [<?php echo $team->grade." - ".$team->letter;?>] [<?php echo $period->name;?>]</h1>
		<a href="./?view=teamalumns&id=<?php echo $asignation->id;?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>

		<a href="./?view=teams&opt=behavior&asignation_id=<?php echo $asignation->id; ?>" class="btn btn-default">Modificar Conducta</a>
		<a href="./?view=teams&opt=behaviorreport&asignation_id=<?php echo $asignation->id; ?>" class="btn btn-default">Reporte de Conducta</a>


<!--		<a href="../report/alumns-word.php?id=<?php echo $team->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-download"></i> Descargar </a><br><br> -->
</div>
</div>
<br><div class="row">
	<div class="col-md-12">
<!--	<a href="index.php?view=list&team_id=<?php echo $_GET["team_id"]; ?>" class="btn btn-default"><i class='fa fa-check'></i> Asistencia</a> -->
<form class="form-horizontal" id="loadlist" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Seleccionar Fecha:</label>
    <div class="col-lg-7">
      <input type="date" name="date_at" value="<?php echo date("Y-m-d");?>" required class="form-control" >
    </div>
    <div class="col-lg-offset-3">
    <input type="hidden" name="team_id" value="<?php echo $team->id;?>">
    <input type="hidden" name="period_id" value="<?php echo $period->id;?>">
    <input type="hidden" name="asignation_id" value="<?php echo $asignation->id;?>">
      <button type="submit" class="btn btn-primary">Buscar</button>
    </div>

  </div>
</form>

<div id="data">
	<p class="alert alert-warning">No hay datos, por favor selecciona una fecha.</p>
</div>

	</div>
</div>

<script>
	$("#loadlist").submit(function(e){
		e.preventDefault();
		var d = $("#loadlist").serialize();
		$.get("./?action=loadbehavior",d,function(data){
			console.log(data);
			$("#data").html(data);

		});
	});
</script>


<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="behaviorreport"):
?>
<?php
$asignation = AsignationData::getById($_GET["asignation_id"]);
$team = TeamData::getById($asignation->team_id);
$period = PeriodData::getById($asignation->period_id);

$alumns = InscriptionData::getAllByTP($asignation->team_id,$asignation->period_id);
?>

<div class="row">
	<div class="col-md-12">
		<h1>Reporte de Conducta [<?php echo $team->grade." - ".$team->letter;?>] [<?php echo $period->name;?>]</h1>
		<a href="./?view=teamalumns&id=<?php echo $asignation->id;?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>

		<a href="./?view=teams&opt=behavior&asignation_id=<?php echo $asignation->id; ?>" class="btn btn-default">Modificar Conducta</a>
		<a href="./?view=teams&opt=behaviorreport&asignation_id=<?php echo $asignation->id; ?>" class="btn btn-default">Reporte de Conducta</a>


<!--		<a href="../report/alumns-word.php?id=<?php echo $team->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-download"></i> Descargar </a><br><br> -->
</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
<!--	<a href="index.php?view=list&team_id=<?php echo $_GET["team_id"]; ?>" class="btn btn-default"><i class='fa fa-check'></i> Asistencia</a> -->
<form class="form-horizontal" id="loadlist" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Inicio:</label>
    <div class="col-lg-3">
      <input type="date" name="start_at" value="<?php echo date("Y-m-d");?>" required class="form-control" >
    </div>
    <label for="inputEmail1" class="col-lg-2 control-label">Fin:</label>
    <div class="col-lg-3">
      <input type="date" name="finish_at" value="<?php echo date("Y-m-d");?>" required class="form-control" >
    </div>
    <div class="col-lg-offset-3">
    <input type="hidden" name="team_id" value="<?php echo $team->id;?>">
    <input type="hidden" name="period_id" value="<?php echo $period->id;?>">
    <input type="hidden" name="asignation_id" value="<?php echo $asignation->id;?>">
      <button type="submit" class="btn btn-primary">Buscar</button>
    </div>

  </div>
</form>

<div id="data">
	<p class="alert alert-warning">No hay datos, por favor selecciona una fecha.</p>
</div>

	</div>
</div>

<script>
	$("#loadlist").submit(function(e){
		e.preventDefault();
		var d = $("#loadlist").serialize();
		$.get("./?action=loadlistbehavior",d,function(data){
			console.log(data);
			$("#data").html(data);

		});
	});
</script>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="all"):
?>

	<div class="row">
	<div class="col-md-12">
<div class="btn-group pull-right">
	<a href="index.php?view=newteam" class="btn btn-default"><i class='fa fa-th-list'></i> Nuevo Grupo</a>
</div>
		<h1>Grupos</h1>
<br>
		<?php
		$teams = TeamData::getAll();
		if(count($teams)>0){
			// si hay usuarios
			?>
			<div class="box box-primary">
			<div class="box-body">
			<table class="table table-bordered datatable table-hover">
			<thead>
			<th>Nombre</th>
			<th></th>
			<th></th>
			</thead>
			<?php
			foreach($teams as $team){
				?>
				<tr>
				<td><?php echo $team->grade; ?></td>				
				<td><?php echo $team->letter; ?></td>				
			<td style="width:130px;"><a href="index.php?view=editteam&id=<?php echo $team->id;?>" class="btn btn-warning btn-xs">Editar</a> <a href="index.php?action=delteam&id=<?php echo $team->id;?>" class="btn btn-danger btn-xs">Eliminar</a></td>
				</tr>
				<?php

			}
			echo "</table></div></div>";
		}else{
			echo "<p class='alert alert-danger'>No hay Grupos</p>";
		}


		?>


	</div>
</div>
<?php endif; ?>