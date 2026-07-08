<?php
$alumn = PersonData::getById($_GET["id"]);
if($alumn->kind!=3){ Core::redir("./"); }
$alumns = InscriptionData::getAllByAlumnId($alumn->id);
?>
<div class="row">
	<div class="col-md-12">
		<h1><?php echo $alumn->name." ".$alumn->lastname; ?></h1>
		<h3>Historial Académico del Estudiante</h3>
<a href="./?view=alumns" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>

  
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
			<th>Estudiante</th>
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
				<td style="width:200px;">
				 <a href="index.php?view=viewinscription&id=<?php echo $alumnx->id;?>" class="btn btn-default btn-xs">Ver informacion</a>
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