<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):



?>
<html lang="es">
<div class="row">

	<div class="col-md-12">

		<h1>Grupos Asignados</h1>
<a href="./?view=home" class="btn btn-dark" style="color: #62AED2;"><i class="fa fa-arrow-left"></i> Regresar</a>
    
    <br>

		

		<?php



		$teams = AsignationData::getActiveByTeacherId($_SESSION["teacher_id"]);



		if(count($teams)>0){

			// si hay usuarios

			?>

      <div class="box box-primary">

			<table class="table table-bordered table-hover">

			<thead>

    			<th style="text-align: center;">Materias Asignadas</th>



<!--                <th>Profesor</th> -->

<!--      			<th>Horario</th>-->

				<th style="text-align: center;">Cierre de Grupo</th>

			</thead>

			<?php

			foreach($teams as $team){

        $asig = $team->getAsignature();

        $teacher = $team->getTeacher();

				$t = $team->getTeam();

        ?>

				<tr>

                	<td style="width:100px;font-size: 10px;text-align: center;">

                	    <strong>Grupo:</strong> <?php echo $t->grade." - ".$t->letter;?>
                	    <br><br>

                	    <strong style="color: #A8A8A8;">Asignatura:</strong> <strong style="color: #106187;"><?php echo $asig->name; ?></strong>
                	    
                	    <h5>No de Estudiantes: 

						<?php echo count(InscriptionData::getAllByTP($t->id,$team->period_id));?></h5><br>

                        <a href="./?view=teamalumns&id=<?php echo $team->id;?>&tid=<?php echo $team->team_id;?>&pid=<?php echo $team->period_id;?>" class="btn bg-gradient-secondary btn-tooltip"><i class="fa fa-th-list"></i> Ver Estudiantes</a>

        			</td>   

			

<!--        <td><?php echo $teacher->name." ".$teacher->lastname; ?></td> -->

        			<!--<td style="padding:0;">

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

        </td>   -->

					

		<td style="width:200px;text-align: center;">

      		<!--<a href="./?view=teamalumns&id=<?php echo $team->id;?>&tid=<?php echo $team->team_id;?>&pid=<?php echo $team->period_id;?>" class="btn bg-gradient-secondary btn-tooltip"><i class="fa fa-th-list"></i> Ver Estudiantes</a> <br><br>

      		<a href="./?view=teamcalifications&id=<?php echo $team->id;?>&tid=<?php echo $team->team_id;?>&pid=<?php echo $team->period_id;?>" class="btn btn-default btn-xs"><i class="fa fa-th-list"></i> Calificaciones</a>    

            <a href="./?view=blocks&opt=all&id=<?php echo $team->id;?>" class="btn btn-default btn-xs"><i class="fa fa-th-large"></i> Bloques</a>  -->  

            <!-- <a href="./?action=asignations&opt=finish&id=<?php echo $team->id;?>" class="btn bg-gradient-success btn-tooltip"><i class="fa fa-check"></i> Enviar Calificaciones</a>     -->

			<a href="#" onclick="confirmAction('<?php echo $team->id;?>')" class="btn bg-gradient-success btn-tooltip"><i class="fa fa-check"></i> Enviar Calificaciones</a>



        </td>

				</tr>

				<?php

			}

			echo "</table></div>";

		}else{

			echo "<p class='alert alert-danger'>No hay Asignaturas</p>";

		}

		?>

	</div>

</div>

<?php endif; ?>

<!-- <script>
function confirmAction(teamId) {
    if (confirm("¿Estás seguro de que quieres realizar esta acción?")) {
        window.location.href = `./?action=asignations&opt=finish&id=${teamId}`;
    } else {
        // No hagas nada o puedes agregar un mensaje de cancelación si lo deseas
    }
}
</script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmAction(teamId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `./?action=asignations&opt=finish&id=${teamId}`;
        }
    });
}
</script>