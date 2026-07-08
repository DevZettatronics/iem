<?php
$asignation = AsignationData::getById($_GET["id"]);
$team = TeamData::getById($asignation->team_id);
$alumns = InscriptionData::getAllByAlumnId($_GET["alumn_id"]);
$blocks = BlockData::getAllByAsignationId($_GET["id"]);
?>
<div class="row">
	<div class="col-md-12">
		<h1><?php echo $asignation->getAsignature()->name; ?> [<?php echo $team->grade." - ".$team->letter;?>] <small>Calificaciones</small></h1>
	<?php if(count($alumns)>0):?>
<?php endif; ?>
		<?php

		if(count($alumns)>0){
			// si hay usuarios
			?>
<div class="box box-primary">
			<table class="table table-bordered table-hover">
			<thead>
			<th>Codigo</th>
			<th>Nombre</th>
			<?php if(count($blocks)>0):?>
			<?php foreach($blocks as $b):?>
			<th><?php echo $b->name;?></th>
			<?php endforeach; ?>
			<th>Promedio</th>
		<?php endif;?>
			</thead>
			<?php
			foreach($alumns as $alumnx){
				$alumn = $alumnx->getAlumn();
				?>
				<tr>
				<td><?php echo $alumn->code; ?></td>
				<td><?php echo $alumn->name." ".$alumn->lastname; ?></td>
			<?php if(count($blocks)>0):?>
			<?php 
			$total=0;
			$promedio = 0;
			$c=0;
			foreach($blocks as $b):
			$exist = CalificationData::getExist($alumn->id,$b->id);
			?>
			<td>
				<?php if($exist!=null){ echo $exist->val; $total+=$exist->val; $c++; }?>
			</td>
			<?php endforeach; ?>
			<td><?php if($c>0){ echo $total/$c;}?></td>
		<?php endif;?>
				</tr>
				<?php

			}

echo "</table></div>";

		}else{
			echo "<p class='alert alert-danger'>No hay Alumnos</p>";
		}


		?>


	</div>
</div>