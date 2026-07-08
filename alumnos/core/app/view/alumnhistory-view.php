<?php
$alumn = PersonData::getById($_GET["id"]);
if($alumn->kind!=3){ Core::redir("./"); }
$alumns = InscriptionData::getAllByAlumnId($alumn->id);
?>

<div class="row">
	<div class="col-md-12">	
	
		<div class="small-box bg-maroon" style="background: linear-gradient(60deg, #d81b60, #8e0638);
    box-shadow: 0 12px 20px -10px rgb(0 188 212 / 28%), 0 4px 20px 0px rgb(0 0 0 / 12%), 0 7px 8px -5px rgb(0 188 212 / 20%);">
			
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
		

		
		  <h4><img src="../storage/posts/examen.png"  width="52px"> <strong>Historial Académico del Estudiante</strong></h4>
		  
		<h5>La información mostrada en este espacio es de carácter informativo, si se requiere una versión impresa y legalizada por la Universidad IEM, deberá solicitarse en el área de Servicios Escolares.</h5>

<a href="./?view=home" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a> 
		
<br><br>
		<?php

		if(count($alumns)>0){
			// si hay usuarios
			?>
			<div class="box box-primary">
			<div class="box-body">
			<table class="table table-bordered datatable table-hover">
			<thead>
			<!--<th></th>-->
			<!--<th>Esstudiante</th>-->
			<th>Carrera</th>
			<th>Periodo</th>
			<!--<th>Fecha</th>-->
			<th></th>
			</thead>
			<?php
			foreach($alumns as $alumnx){
				$alumn = $alumnx->getAlumn();
				$team = $alumnx->getTeam();
				?>
			
				<tr>
				
				<?php /*?><td><?php echo $alumn->code." - ".$alumn->name." ".$alumn->lastname; ?></td><?php */?>
				<?php /*?><td><?php echo $team->grade." ".$team->letter; ?></td><?php */?>
				<td align="left"style="font-size: 10px;"><?php echo $team->grade; ?></td>	
				<td><?php echo $alumnx->getPeriod()->name; ?></td>
				<?php /*?><td><?php echo $alumnx->created_at; ?></td><?php */?>
				<td style="width:200px;">
				 <a href="index.php?view=viewinscription&id=<?php echo $alumnx->id;?>" class="btn btn-info btn-sm">Ver Calificciones</a>
				 <!--<a href="index.php?action=delinscription&id=<?php echo $alumnx->id;?>" class="btn btn-danger btn-xs">Eliminar</a>--></td>
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