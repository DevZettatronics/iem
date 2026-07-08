<?php
// echo $_SESSION["alumn_id"];
$inscription = InscriptionData::getActive($_SESSION["alumn_id"]);
$alumn = PersonData::getById($inscription->alumn_id);
$asignations = AsignationData::getAllByTP($inscription->team_id,$inscription->period_id);

?>


<div class="row">
	<div class="col-md-12">
		
		    <div class="small-box bg-maroon" style="    background: linear-gradient(
60deg
, #d81b60, #8e0638);
    box-shadow: 0 12px 20px -10px rgb(0 188 212 / 28%), 0 4px 20px 0px rgb(0 0 0 / 12%), 0 7px 8px -5px rgb(0 188 212 / 20%);"
				 
				 >
            <div class="inner">
				<h4 align="left"><i class='fa fa-tasks'></i> <strong>Datos del Estudiante</strong></h4>
				<h5 align="left">Matrícula: <strong><?php echo $alumn->code; ?></strong></h5>
				<h5 align="left">Nombre(s): <strong><?php echo $alumn->name; ?></strong></h5>
				<h5 align="left">Apellidos: <strong><?php echo $alumn->lastname; ?></strong></h5>		
							
            </div>
            <div class="icon">
              <i class="fa fa-list"></i>
            </div>
          </div>
		
		

	
		<h4><img src="../storage/posts/biblioteca.png"  width="52px"> <strong>Historial de Asignaturas Cursadas</strong></h4>
		<h5>La información mostrada en este espacio corresponde a las asignaturas cursadas durante la vida activa del estudiante.</h5>
<a href="./?view=home" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a> 
<a href="./index.php?view=alumnhistory&id=<?php if(isset($_SESSION["alumn_id"]) ){ echo PersonData::getById($_SESSION["alumn_id"])->id; }?>" class="btn btn-info"><i class="fa fa-check-square"></i> Ver Calificaciones por Periodo</a> 
		
<br><br>		  

<div class="row">
	<div class="col-md-12">
	<?php if($inscription==null):?>
	<?php else:?>

		<?php
		// echo $inscription->team_id;
		$teams = AsignationData::getAllbyTeamId($inscription->team_id);
		if(count($teams)>0){
			// si hay usuarios
			?>
      <div class="box box-primary">
			<table class="table table-bordered table-hover">
			<thead>
      		<th>Grupo</th>
			<th>Asignatura</th>
      		<th>Catedrático</th>
			<!--<th></th> Columna Boton Desglose de Calificaciones-->
			</thead>
			<?php
			foreach($teams as $team){
        		$asig = $team->getAsignature();
        		$teacher = $team->getTeacher();
				$t = $team->getTeam();
        	?>
				
				
			<tr>
        	<td style="width:10px;">
			<?php /*?><?php echo $t->grade." - ".$t->letter;?><?php */?>
			<?php echo $t ? $t->letter : '-'; ?>
        	</td>
				
			<td><?php echo $asig ? $asig->name : 'Sin materia'; ?></td>				
        	<td><?php echo $teacher ? $teacher->name." ".$teacher->lastname : 'Sin docente'; ?></td>
        	

			<!--	Boton cancelado desglose 
			<td style="width:130px;">
      		<a href="./?view=califications&id=<?php echo $team->id;?>" class="btn btn-default btn-xs"><i class="fa fa-th-list"></i> Calificaciones</a>    
            </td>
			-->
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



		 		  
		  
		  
		  
		  
		  


</div>
