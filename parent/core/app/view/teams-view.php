
<?php 
// print_r($_GET);
if(isset($_GET["opt"]) && $_GET["opt"]=="assistance"):
?>


<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="assistancereport"):
?>
<?php
$asignation = AsignationData::getById($_GET["id"]);
$team = TeamData::getById($asignation->team_id);
$period = PeriodData::getById($asignation->period_id);

$alumns = InscriptionData::getAllByTP($asignation->team_id,$asignation->period_id);
?>

<div class="row">
	<div class="col-md-12">
		<h1>Reporte de Asistencia [<?php echo $team->grade." - ".$team->letter;?>] [<?php echo $period->name;?>]</h1>
		<a href="./?view=alumn&alumn_id=<?php echo $_GET['alumn_id'];?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>



<!--		<a href="../report/alumns-word.php?id=<?php echo $team->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-download"></i> Descargar </a><br><br> -->
</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
<!--	<a href="index.php?view=list&team_id=<?php echo $_GET["team_id"]; ?>" class="btn btn-default"><i class='fa fa-check'></i> Asistencia</a> -->
<form class="form-horizontal" id="loadlist" role="form">
	<input type="hidden" name="alumn_id" value="<?php echo $_GET['alumn_id']; ?>">
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



<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="behaviorreport"):
?>
<?php
$asignation = AsignationData::getById($_GET["id"]);
$team = TeamData::getById($asignation->team_id);
$period = PeriodData::getById($asignation->period_id);

$alumns = InscriptionData::getAllByTP($asignation->team_id,$asignation->period_id);
?>

<div class="row">
	<div class="col-md-12">
		<h1>Reporte de Conducta [<?php echo $team->grade." - ".$team->letter;?>] [<?php echo $period->name;?>]</h1>
		<a href="./?view=alumn&alumn_id=<?php echo $_GET['alumn_id'];?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>



<!--		<a href="../report/alumns-word.php?id=<?php echo $team->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-download"></i> Descargar </a><br><br> -->
</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
<!--	<a href="index.php?view=list&team_id=<?php echo $_GET["team_id"]; ?>" class="btn btn-default"><i class='fa fa-check'></i> Asistencia</a> -->
<form class="form-horizontal" id="loadlist" role="form">
	<input type="hidden" name="alumn_id" value="<?php echo $_GET['alumn_id']; ?>">
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

<?php endif; ?>