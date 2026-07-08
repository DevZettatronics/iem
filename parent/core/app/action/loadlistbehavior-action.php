		<?php
		$range = 0;
		if($_GET["start_at"]<=$_GET["finish_at"]){
			$range= ((strtotime($_GET["finish_at"])-strtotime($_GET["start_at"]))+(24*60*60)) /(24*60*60);
			if($range>31){
				echo "<p class='alert alert-danger'>El Rango Maximo es 31 Dias.</p>";
				exit(0);
			}
		}else{
			echo "<p class='alert alert-danger'>Rango Invalido</p>";
			exit(0);
		}
//		$alumns = AlumnTeamData::getAllByTeamId($_GET["team_id"]);
$alumns = InscriptionData::getAllByTP($_GET["team_id"],$_GET["period_id"]);

		if(count($alumns)>0){
			// si hay usuarios
			?>

			<div class="box box-primary">
<div class="table-responsive">
<table class="table table-bordered table-hover">
			<thead>
			<th>Nombre</th>
			<?php for($i=0;$i<$range;$i++):?>
			<th>
			<?php echo date("d-M",strtotime($_GET["start_at"])+($i*(24*60*60)));?>
			</th>
		<?php endfor;?>
			</thead>
			<?php
			foreach($alumns as $al){
				if($al->alumn_id==$_GET['alumn_id']){
				$alumn = $al->getAlumn();
				$values = array(""=>"Sin seleccion","1"=>"Asistencia","2"=>"Falta","3"=>"Retardo","4"=>"Justificacion");
				?>
				<tr>
				<td style="width:250px;"><?php echo $alumn->name." ".$alumn->lastname; ?></td>
			<?php for($i=0;$i<$range;$i++):
					$date_at= date("Y-m-d",strtotime($_GET["start_at"])+($i*(24*60*60)));
					$asist = BehaviorData::getByATD($alumn->id,$_GET["team_id"],$date_at);
						?>


				<td >
				<?php
					if($asist!=null){
						if($asist->kind_id==1){ echo "Normal"; }
						else if($asist->kind_id==2){ echo "Buena"; }
						else if($asist->kind_id==3){ echo "Excelente"; }
						else if($asist->kind_id==4){ echo "Mala"; }
						else if($asist->kind_id==4){ echo "Muy Mala"; }
						
					}	
				?>

				</td>
			<?php endfor; ?>
				</tr>
				<?php
			}
			}
echo "</table></div>";


		}else{
			echo "<p class='alert alert-danger'>No hay Grupos</p>";
		}


		?>

			</div>


			
