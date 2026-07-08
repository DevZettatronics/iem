<?php
$asignation = AsignationData::getById($_GET["asignation_id"]);
$alumn = PersonData::getById($_GET["alumn_id"]);
?>
<div class="row">
	<div class="col-md-12">
		<h1>Asignar calificaciones</h1>
    <h4>Alumno: <?php echo $alumn->name." - ".$alumn->lastname;?></h4>
    <h4>Grupo: <?php echo $asignation->getTeam()->grade." - ".$asignation->getTeam()->letter;?></h4>

    <a href="./?view=teamalumns&id=<?php echo $asignation->id;?>" class="btn btn-default">Regresar</a>



<br><br>
		<?php

		$teams = BlockData::getAllbyAsignationId($asignation->id);
		if(count($teams)>0){
			// si hay usuarios
			?>
			<div class="box box-primary">
      <form method="post" action="./?action=save">
      <input type="hidden" name="alumn_id" value="<?php echo $alumn->id; ?>">
      <input type="hidden" name="asignation_id" value="<?php echo $asignation->id; ?>">
			<table class="table table-bordered table-hover">
			<thead>
      <th></th>
			<th>Nombre</th>
      <th>Calificacion</th>
			<th></th>
			</thead>
			<?php
			foreach($teams as $team){
          $exist = CalificationData::getExist($alumn->id,$team->id);
				?>
				<tr>
        <td style="width:30px;">

        </td>
				<td><?php echo $team->name; ?></td>
        <td><input type="text" class="form-control" name="val-<?php echo $team->id; ?>" value="<?php if($exist!=null){ echo $exist->val;}?>" placeholder="Calificacion"></td>

				<td style="width:130px;">

</td>
				</tr>
				<?php
			}
			echo "</table><input type='submit' value='Guardar' class='btn btn-primary'></form><br></div>";
		}else{
			echo "<p class='alert alert-danger'>No hay Bloques</p>";
		}
		?>
	</div>
</div>
