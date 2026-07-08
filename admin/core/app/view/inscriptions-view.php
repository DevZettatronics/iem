<?php
$alumns = InscriptionData::getAll();
?>
<div class="row">
	<div class="col-md-12">
		<h1>Inscripciones</h1>
	<a href="index.php?view=inscription" class="btn btn-default"><i class='fa fa-asterisk'></i> Nueva Inscripcion</a>
	<?php if(count($alumns)>0):?>
<?php endif; ?>
<!--	<a href="index.php?view=list&team_id=<?php echo $_GET["id"]; ?>" class="btn btn-default"><i class='fa fa-area-chart'></i> Estadisticas</a> -->


<br><br>
		<?php

		if(count($alumns)>0){
			// si hay usuarios
			?>
			<div class="box box-primary">
			<div class="box-body">
			<table class="table table-bordered datatable table-hover">
			<thead>
			<th></th>
			<th>Alumno</th>
			<th>Grupo</th>
			<th>Periodo</th>
			<th>Fecha</th>
			<th></th>
			</thead>
			<?php
			foreach($alumns as $alumnx){
				$alumn = $alumnx->getAlumn();
				$team = $alumnx->getTeam();
				?>
				<tr>
				<td style="width:30px;"></td>
				<td><?php echo $alumn->code." - ".$alumn->name." ".$alumn->lastname; ?></td>
				<td><?php echo $team->grade." ".$team->letter; ?></td>
				<td><?php echo $alumnx->getPeriod()->name; ?></td>
				<td><?php echo $alumnx->created_at; ?></td>
				<td style="width:40px;">
				 <a href="index.php?action=delinscription&id=<?php echo $alumnx->id;?>" class="btn btn-danger btn-xs">Eliminar</a></td>
				</tr>
				<?php
			}
echo "</table></div></div>";

		}else{
			echo "<p class='alert alert-danger'>No hay Inscripciones</p>";
		}
		?>


	</div>
</div>