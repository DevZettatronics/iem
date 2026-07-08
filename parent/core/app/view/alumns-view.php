<?php
$alumns = AlumnData::getAllByParentId($_SESSION["parent_id"]);
?>
<div class="row">
  <div class="col-md-12">
    <h1>Alumnos</h1>
  <?php if(count($alumns)>0):?>
<?php endif; ?>
<!--  <a href="index.php?view=list&team_id=<?php echo $_GET["id"]; ?>" class="btn btn-default"><i class='fa fa-area-chart'></i> Estadisticas</a> -->


<br><br>
    <?php

    if(count($alumns)>0){
      // si hay usuarios
      ?>
<div class="box box-primary">
<div class="box-body">
      <table class="table table-bordered datatable table-hover">
      <thead>
      <th>Codigo</th>
      <th>Nombre</th>
      <th></th>
      </thead>
      <?php
      foreach($alumns as $alumn){
        ?>
        <tr>
        <td><?php echo $alumn->code; ?></td>
        <td><?php echo $alumn->name." ".$alumn->lastname; ?></td>
        <td style="width:160px;">
        <a href="index.php?view=alumn&id=<?php echo $alumn->id;?>" class="btn btn-default btn-xs">Horarios</a>    </td>
        </tr>
        <?php

      }

echo "</table></div></di>";

    }else{
      echo "<p class='alert alert-danger'>No hay Alumnos</p>";
    }


    ?>


  </div>
</div>
</div>