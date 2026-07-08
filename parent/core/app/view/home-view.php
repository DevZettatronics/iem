
<div class="row">
  <div class="col-md-12">
    <h1>Mis Alumnos</h1>
<br>
    <?php

    $teams = PersonData::getAllByPersonId($_SESSION["parent_id"]);
    if(count($teams)>0){
      // si hay usuarios
      ?>
      <div class="box box-primary">
      <div class="box-body">
      <table class="table table-bordered datatable table-hover">
      <thead>
      <th>Nombre</th>
      <th>Domicilio</th>
      <th>Telefono</th>
      <th>Email</th>
      <th></th>
      </thead>
      <?php
      foreach($teams as $team){
        ?>
        <tr>
        <td><?php echo $team->name." ".$team->lastname; ?></td>       
       <td><?php echo $team->address; ?></td>       
       <td><?php echo $team->phone; ?></td>       
       <td><?php echo $team->email; ?></td>       
 
        <td style="width:130px;"><a href="index.php?view=alumn&alumn_id=<?php echo $team->id;?>" class="btn btn-default btn-xs">Ver</a>        </tr>
        <?php
      }
      echo "</table></div></div>";
    }else{
      echo "<p class='alert alert-danger'>No hay Asignaturas</p>";
    }
    ?>
  </div>
</div>
