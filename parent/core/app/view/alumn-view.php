<?php
$inscription = InscriptionData::getActive($_GET["alumn_id"]);
$alumn = $inscription->getAlumn();

?>
<div class="row">
	<div class="col-md-12">
	<?php if($inscription==null):?>
	<?php else:?>
		<h1>Asignaturas</h1>
<br><br>
		<?php

		$teams = AsignationData::getAllbyTeamId($inscription->team_id);
		if(count($teams)>0){
			// si hay usuarios
			?>
      <div class="box box-primary">
			<table class="table table-bordered table-hover">
			<thead>
      <th>Grupo</th>
			<th>Asignatura</th>
      <th>Profesor</th>
      <th>Horario</th>
			<th></th>
			</thead>
			<?php
			foreach($teams as $team){
        $asig = $team->getAsignature();
        $teacher = $team->getTeacher();
				$t = $team->getTeam();
        ?>
				<tr>
        <td style="width:30px;">
<?php echo $t->grade." - ".$t->letter;?>

        </td>
				<td><?php echo $asig->name; ?></td>				
        <td><?php echo $teacher->name." ".$teacher->lastname; ?></td>
        <td style="padding:0;">
<?php
$schedule = ScheduleData::getAllByAsignationId($team->id);
?>
<?php if(count($schedule)>0):?>
<table class="table table-bordered">
<thead>
  <th>Salon</th>
  <th>Dia</th>
  <th>Inicio</th>
  <th>Fin</th>
</thead>
  <?php foreach($schedule as $s):?>
  <tr>
  <td><?php echo $s->getRoom()->name;?></td>
  <td><?php
switch ($s->d) {
  case 'mo': echo "Lunes"; break;
  case 'tu': echo "Martes"; break;
  case 'we': echo "Miercoles"; break;
  case 'th': echo "Jueves"; break;
  case 'fr': echo "Viernes"; break;
  case 'sa': echo "Sabado"; break;
  case 'su': echo "Domingo"; break;
  
  default:
    # code...
    break;
}
  ?></td>
  <td><?php echo $s->time_start;?></td>
  <td><?php echo $s->time_end;?></td>
  </tr>
  <?php endforeach;?>
</table>
  <?php endif;?>
        </td>   
				<td style="width:330px;">
      <a href="./?view=califications&id=<?php echo $team->id;?>&alumn_id=<?php echo $alumn->id; ?>" class="btn btn-default btn-xs"><i class="fa fa-th-list"></i> Calificaciones</a>    

            <a href="./?view=teams&opt=assistancereport&id=<?php echo $team->id;?>&alumn_id=<?php echo $alumn->id; ?>" class="btn btn-default btn-xs"><i class="fa fa-th-list"></i> Reporte de Asistencia</a>
                        <a href="./?view=teams&opt=behaviorreport&id=<?php echo $team->id;?>&alumn_id=<?php echo $alumn->id; ?>" class="btn btn-default btn-xs"><i class="fa fa-th-list"></i> Reporte de Conducta</a>
              
        </td>
				</tr>
				<?php
			}
			echo "</table></div>";
		}else{
			echo "<p class='alert alert-danger'>No hay Asignaturas</p>";
		}
		?>
	<?php endif; ?>
	</div>


        <!--- - - - - - - - - - - - - - - - - - -->
        <div class="col-md-12">
    <h1>Avisos</h1>
<br>

    <?php
    $teams = PostData::getAllByQ("where kind_pub=1 and (kind=1 or kind=3)");
    if(count($teams)>0){
      // si hay usuarios
      ?>
      <div class="box box-primary">
      <div class="box-body">
      <table class="table table-bordered datatable table-hover">
      <thead>
      <th>Avisos</th>
      </thead>
      <?php
      foreach($teams as $team){
        ?>
        <tr>
        <td><h4><?php echo $team->title; ?></h4>
        <p><?php echo $team->content; ?></p>
        </td>  
        </tr>
        <?php
      }
      echo "</table></div></div>";
    }else{
      echo "<p class='alert alert-danger'>No hay Avisos</p>";
    }
    ?>
    </table>
    </div>
        <!-- - - - - - - - - - - - - - - - - - - -->

</div>
