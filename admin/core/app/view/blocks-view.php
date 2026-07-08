<?php
if (isset($_GET["opt"]) && $_GET["opt"] == "all") :
  $asignation = AsignationData::getById($_GET["id"]);
  $period = PeriodData::getById($asignation->period_id);
  $team = TeamData::getById($asignation->team_id);
  $blocks = BlockData::getAllByAsignationId($asignation->id);
?>
  <div class="row">
    <div class="col-md-12">
      <h1>Bloques [<?php echo $asignation->getAsignature()->name; ?>] [<?php echo $team->grade . " - " . $team->letter; ?>] [<?php echo $period->name; ?>]</h1>



      <!-- Button trigger modal -->
      <a href="./?view=teamasignatures&opt=all&id=<?php echo $asignation->team_id; ?>&period_id=<?php echo $asignation->period_id; ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar </a>



      <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
        <i class='fa fa-plus'></i> Bloque
      </button>


      <!-- Modal -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel"> <i class='fa fa-plus'></i> Agregar Bloque</h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="post" id="addcategory" action="index.php?action=blocks&opt=add" role="form">

                <div class="form-group">
                  <label for="inputEmail1" class="col-md-3 control-label">Nombre del Bloque</label>
                  <div class="col-md-12"><br>
                    <input type="text" name="name" class="form-control" placeholder="Nombre" required>
                  </div>
                </div>


                <div class="form-group">
                  <label for="inputEmail1" class="col-md-2 control-label">Sub Bloque</label>
                  <button type="button" id="add_field" class="btn bg-primary"><i class="fa fa-plus"></i></button>
                  <div id="listas" class="col-md-8">
                    <input type="text" name="nameBlockChildren[]" class="form-control" placeholder="Nombre Del Sub Bloque" required><br>
                  </div>
                </div>

                <input type="hidden" name="asignation_id" value="<?php echo $asignation->id; ?>">

                <div class="form-group">
                  <div class="col-lg-10">
                    <button type="submit" class="btn btn-primary"> <i class='fa fa-plus'></i> Agregar Bloque</button>
                  </div>
                </div>
              </form>

            </div>

          </div>
        </div>
      </div>

      <!-- Modal -->
      <!--       <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel"> <i class='fa fa-plus'></i> Agregar Sub Bloque</h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="post" id="addcategory" action="index.php?action=blocks&opt=addsub" role="form">
                <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Bloque*</label>
                  <div class="col-md-12">
                    <select name="block_id" class="form-control" required>
                      <option value="">-- SELECCIONE --</option>
                      <?php foreach ($blocks as $b) :
                        if ($b->block_id == null) :
                      ?>
                          <option value="<?php echo $b->id; ?>"> <?php echo $b->name; ?></option>
                      <?php endif;
                      endforeach; ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
                  <div class="col-md-12">
                    <input type="text" name="name" class="form-control" placeholder="Nombre">
                  </div>
                </div>

                <input type="hidden" name="asignation_id" value="<?php echo $asignation->id; ?>">

                <div class="form-group">
                  <div class="col-lg-10">
                    <button type="submit" class="btn btn-primary"> <i class='fa fa-plus'></i> Agregar Sub Bloque</button>
                  </div>
                </div>
              </form>

            </div>

          </div>
        </div>
      </div> -->


      <br><br>
      <?php

      if (count($blocks) > 0) {
        // si hay usuarios
      ?>
        <div class="box box-primary">
          <table class="table table-bordered table-hover">
            <thead>
              <th></th>
              <th>Nombre</th>
              <th>Padre</th>
              <th></th>
            </thead>
            <?php
            foreach ($blocks as $team) {
            ?>
              <tr>
                <td style="width:30px;">

                  <!-- Button trigger modal -->
                </td>
                <td><?php echo $team->name; ?></td>
                <td><?php
                    if ($team->block_id != null) {
                      $bp  = BlockData::getById($team->block_id);
                      echo $bp->name;
                    }
                    ?></td>

                <td style="width:130px;">


                  <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#addschedule<?php echo $team->id; ?>">
                    <i class='fa fa-pencil'></i>
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="addschedule<?php echo $team->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="myModalLabel"> <i class='fa fa-plus'></i> Actualizar Bloque</h4>
                        </div>
                        <div class="modal-body">
                          <form class="form-horizontal" method="post" id="addcategory" action="index.php?action=blocks&opt=upd" role="form">
                            <div class="form-group">
                              <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
                              <div class="col-md-12">
                                <input type="text" name="name" class="form-control" value="<?php echo $team->name; ?>" placeholder="Nombre">
                              </div>
                            </div>

                            <input type="hidden" name="asignation_id" value="<?php echo $asignation->id; ?>">
                            <input type="hidden" name="block_id" value="<?php echo $team->id; ?>">

                            <div class="form-group">
                              <div class="col-lg-10 col-md-offset-2">
                                <button type="submit" class="btn btn-primary"> <i class='fa fa-plus'></i> Actualizar Bloque</button>
                              </div>
                            </div>
                          </form>

                        </div>

                      </div>
                    </div>
                  </div>


                  <a href="index.php?action=blocks&opt=del&id=<?php echo $team->id; ?>&asignation_id=<?php echo $asignation->id; ?>" class="btn btn-danger btn-xs">Eliminar</a>
                </td>
              </tr>
          <?php
            }
            echo "</table></div>";
          } else {
            echo "<p class='alert alert-danger'>No hay Bloques</p>";
          }
          ?>
        </div>
    </div>
  <?php endif; ?>

  <script>
    var campos_max = 10; //max de 10 campos

    var x = 0;
    $('#add_field').click(function(e) {
      e.preventDefault(); //prevenir novos clicks
      if (x < campos_max) {
        $('#listas').append(
          '<div>\ <input type="text" name="nameBlockChildren[]" class="form-control" placeholder="Nombre Del Sub Bloque" required>\ <a href="#" class="remover_campo">Remover</a>\</div>'
        );
        x++;
      }
    });
    // Remover o div anterior
    $('#listas').on("click", ".remover_campo", function(e) {
      e.preventDefault();
      $(this).parent('div').remove();
      x--;
    });
  </script>