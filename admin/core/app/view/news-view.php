<div class="row">
	<div class="col-md-12">

      <div class="row">
       
        <div class="col-md-12">
    <h1>Avisos</h1>
<br>

    <?php
    $teams = PostData::getAllByQ("where kind_pub=1");
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
        <!-- - - - - - - - - - - - - - - - - - - -->
      </div>


	</div>
</div>
</div>
</div>
</div>