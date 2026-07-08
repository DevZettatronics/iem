<?php
$inscription = InscriptionData::getActive($_SESSION["alumn_id"]);
?>



	  

<html lang="es">
		  
        <!--- - - - - - - - - - - - - - - - - - -->
        <div class="col-md-12">
            
            <h4><img src="../storage/posts/campana-de-notificacion.png"  width="52px"> Avisos Institucionales y Normatividad IEM</h4>
 
			
			<a href="./?view=home" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a> 
		
<br><br>

    <?php
    $teams = PostData::getAllByQ("where kind_pub=1 and (kind=1 or kind=4)");
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
						<td>
				
				<img src="../storage/posts/<?php echo $team->image; ?>" class="img-responsive">
			
			</td>
        <td><h4><?php echo $team->title; ?></h4>
        <p><?php echo $team->content; ?></p>
        </td> 
			
			<td><a href="../storage/pdf/<?php echo $team->pdf; ?>" class="btn btn-primary btn-xs" target="_blank">Ir al documento</a> 	
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
