
<div class="row">
	<div class="col-md-12">
		<h1>Seleccionar un Periodo</h1>
<br>
		<?php

		$teams = PeriodData::getAll();
		if(count($teams)>0){
			// si hay usuarios
			?>
			<div class="box box-primary">
			<div class="box-body">
						<table class="table table-bordered datatable table-hover">
			<thead>
			<th></th>
			<th>Nombre del Semestre</th>
			<th>Terminado</th>
			</thead>
			<?php
			foreach($teams as $team){
				?>
				<tr>
				<td style="width:130px;"><a href="index.php?view=teams&opt=byperiod&id=<?php echo $team->id;?>" class="btn btn-default btn-small">Seleccionar <i class="fa fa-arrow-right"></i></a> </td>				<td><?php echo $team->name; ?></td>					
				<td>
					<?php if($team->is_finished):?>
					<i class="fa fa-check"></i>
					<?php endif;?>
				</td>

				</tr>
				<?php
			}
echo "</table></div></div>";
					}else{
			echo "<p class='alert alert-danger'>No hay Periodos</p>";
		}
		?>
	</div>
</div>