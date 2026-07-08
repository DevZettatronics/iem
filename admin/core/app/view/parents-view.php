<?php
$alumns = PersonData::getParents();
?>
<div class="row">
	<div class="col-md-12">
		<h1>Padres</h1>
	<a href="index.php?view=newparent" class="btn btn-default"><i class='fa fa-asterisk'></i> Nuevo Padre</a>
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
			<th>Codigo</th>
			<th>Nombre</th>
			<th>Domicilio</th>
			<th>Telefono</th>
			<th>Email</th>
			<th></th>
			</thead>
			<?php
			foreach($alumns as $alumn){
				?>
				<tr>
				<td><?php echo $alumn->code; ?></td>
				<td><?php echo $alumn->name." ".$alumn->lastname; ?></td>
				<td><?php echo $alumn->address; ?></td>
				<td><?php echo $alumn->phone; ?></td>
				<td><?php echo $alumn->email; ?></td>
				<td style="width:160px;">
				<!--<a href="index.php?view=openalumn&id=<?php echo $alumn->id;?>&tid=<?php echo $team->id;?>" class="btn btn-default btn-xs">Ver</a> --><a href="index.php?view=editparent&id=<?php echo $alumn->id;?>" class="btn btn-warning btn-xs">Editar</a> <a href="index.php?action=parents&opt=del&id=<?php echo $alumn->id;?>" class="btn btn-danger btn-xs">Eliminar</a></td>
				</tr>
				<?php

			}

echo "</table></div></div>";

		}else{
			echo "<p class='alert alert-danger'>No hay Padres</p>";
		}


		?>


	</div>
</div>
