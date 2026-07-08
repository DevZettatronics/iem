<?php
if (isset($_GET["opt"]) && $_GET["opt"] == "all") {
  $theteam = TeamData::getById($_GET["id"]);
  $period = PeriodData::getById($_GET["period_id"]);
?>


  <div class="row">
    <div class="col-md-12">
      <h3>Asignaturas <?php echo $theteam->grade . " - Grupo: " . $theteam->letter; ?> Ciclo: <?php echo $period->name; ?></h3>


      <a href="./?view=teams&opt=byperiod&id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>


      <?php
      if (Permisos::puede(Core::$user->kind, 'ciclos_escolares', 'crear')): ?>
        <!-- limite por usuarios o grupo de usuarios -->
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
          <i class='fa fa-plus'></i> Agregar Asignatura al Grupo y Asignar Docente
        </button>

      <?php endif; ?>

      <!--<a href="./?view=teams&opt=general1&id=<?php echo $theteam->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-default"><i class="fa fa-arrow-up"></i> Ir a Alumnos</a>-->

      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel"> <i class='fa fa-plus'></i> Agregar Asignatura</h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="post" id="addcategory" action="index.php?action=addasignation" role="form">
                <input type="hidden" name="period_id" value="<?php echo $period->id; ?>">

                <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Docente*</label>
                  <div class="col-md-12">
                    <select name="teacher_id" data-live-search="true" class="form-control select" required>
                      <option value="">-- SELECCIONE --</option>
                      <?php foreach (PersonData::getTeachers() as $al) : ?>
                        <option value="<?php echo $al->id; ?>"><?php echo $al->name . " " . $al->lastname . " - " . $al->code; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Asignatura*</label>
                  <div class="col-md-12">
                    <select name="asignature_id" data-live-search="true" class="form-control select" required>
                      <option value="">-- SELECCIONE --</option>
                      <?php foreach (AsignatureData::getAll() as $al) : ?>
                        <option value="<?php echo $al->id; ?>"><?php echo $al->program . " " . $al->name; ?></option>
                      <?php endforeach; ?>
                    </select>

                  </div>
                </div>

                <div class="form-group">
                  <label for="asignature_type" class="col-lg-2 control-label">Tipo de Materia*</label>
                  <div class="col-md-12">
                    <select name="asignature_type" class="form-control" required>
                      <option value="">-- SELECCIONE --</option>
                      <option value="APR">De Aprobacion</option>
                      <option value="NUM">Numerica</option>
                    </select>
                  </div>
                </div>


                <input type="hidden" name="team_id" value="<?php echo $theteam->id; ?>">

                <div class="form-group">
                  <div class="col-lg-10">
                    <button type="submit" class="btn btn-primary"> <i class='fa fa-plus'></i> Agregar Asignatura</button>
                  </div>
                </div>
              </form>

            </div>

          </div>
        </div>
      </div>



      <br><br>
      <?php

      $teams = AsignationData::getAllByTP($theteam->id, $period->id);
      if (count($teams) > 0) {
        // si hay usuarios
      ?>
        <div class="box box-primary">
          <div class="box-body">

            <table class="table datatable table-bordered table-hover">
              <thead>
                <th></th>
                <th>Asignatura</th>
                <th>Profesor</th>
                <th>Tipo de Materia</th>
                <th>Horario</th>
                <th></th>
              </thead>
              <?php
              foreach ($teams as $team) {
                // echo '<pre>';
                // print_r($team);
                $asig = $team->getAsignature();
                $asignature_type = $team->asignature_type == 'NUM' ? "Numerica" : 'De Aprobacion';
                $teacher = $team->getTeacher();
              ?>
                <tr>
                  <td style="width:30px;">

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-xs btn-default" data-toggle="modal" data-target="#addschedule<?php echo $team->id; ?>">
                      <i class='fa fa-plus'></i><i class='fa fa-clock-o'></i>
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="addschedule<?php echo $team->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"> <i class='fa fa-plus'></i> Agregar Horario</h4>
                          </div>
                          <div class="modal-body">
                            <form class="form-horizontal" method="post" id="addcategory" action="index.php?action=addschedule" role="form">
                              <input type="hidden" name="period_id" value="<?php echo $period->id; ?>">
                              <?php
                              $days = array(
                                array("id" => "mo", "name" => "Lunes"),
                                array("id" => "tu", "name" => "Martes"),
                                array("id" => "we", "name" => "Miercoles"),
                                array("id" => "th", "name" => "Jueves"),
                                array("id" => "fr", "name" => "Viernes"),
                                array("id" => "sa", "name" => "Sabado"),
                                array("id" => "su", "name" => "Domingo")
                              );
                              ?>
                              <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 control-label">Dia*</label>
                                <div class="col-md-4">
                                  <select name="d" class="form-control" required>
                                    <option value="">-- SELECCIONE --</option>
                                    <?php foreach ($days as $al) : ?>
                                      <option value="<?php echo $al["id"]; ?>"><?php echo $al["name"]; ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                                <label for="inputEmail1" class="col-lg-2 control-label">Salon*</label>
                                <div class="col-md-4">
                                  <select name="room_id" class="form-control" required>
                                    <option value="">-- SELECCIONE --</option>
                                    <?php foreach (RoomData::getAll() as $al) : ?>
                                      <option value="<?php echo $al->id; ?>"><?php echo $al->name; ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                              </div>


                              <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 control-label">Inicio*</label>
                                <div class="col-md-4">
                                  <input type="time" class="form-control" name="time_start" required>
                                </div>
                                <label for="inputEmail1" class="col-lg-2 control-label">Fin*</label>
                                <div class="col-md-4">
                                  <input type="time" class="form-control" name="time_end" required>
                                </div>
                              </div>


                              <input type="hidden" name="team_id" value="<?php echo $theteam->id; ?>">
                              <input type="hidden" name="asignation_id" value="<?php echo $team->id; ?>">

                              <div class="form-group">
                                <div class="col-lg-10 col-md-offset-2">
                                  <button type="submit" class="btn btn-primary"> <i class='fa fa-plus'></i> Agregar Horario</button>
                                </div>
                              </div>
                            </form>

                          </div>

                        </div>
                      </div>
                    </div>

                  </td>
                  <td><?php echo $asig->name; ?></td>
                  <td><?php echo $teacher->name . " " . $teacher->lastname; ?></td>
                  <td><?php echo $asignature_type; ?></td>
                  <td style="padding:0;">
                    <?php
                    $schedule = ScheduleData::getAllByAsignationId($team->id);
                    ?>
                    <?php if (count($schedule) > 0) : ?>
                      <table class="table table-bordered">
                        <thead>
                          <th>Salon</th>
                          <th>Dia</th>
                          <th>Inicio</th>
                          <th>Fin</th>
                          <th></th>
                        </thead>
                        <?php foreach ($schedule as $s) : ?>
                          <tr>
                            <td><?php echo $s->getRoom()->name; ?></td>
                            <td><?php
                                switch ($s->d) {
                                  case 'mo':
                                    echo "Lunes";
                                    break;
                                  case 'tu':
                                    echo "Martes";
                                    break;
                                  case 'we':
                                    echo "Miercoles";
                                    break;
                                  case 'th':
                                    echo "Jueves";
                                    break;
                                  case 'fr':
                                    echo "Viernes";
                                    break;
                                  case 'sa':
                                    echo "Sabado";
                                    break;
                                  case 'su':
                                    echo "Domingo";
                                    break;

                                  default:
                                    # code...
                                    break;
                                }
                                ?></td>
                            <td><?php echo $s->time_start; ?></td>
                            <td><?php echo $s->time_end; ?></td>
                            <td style="width:30px;"><a href="index.php?action=asignatures&opt=delschedule&id=<?php echo $s->id; ?>&team_id=<?php echo $theteam->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a></td>

                          </tr>
                        <?php endforeach; ?>
                      </table>
                    <?php endif; ?>
                  </td>
                  <td style="width:300px;">
                    <!-- Button trigger modal -->
                    <!-------------------Editar asignaturas------------------------>
                    <?php
                    if (Core::$user->kind == 1 or Core::$user->kind == 13) : ?>
                      <!-- limite por usuarios o grupo de usuarios -->
                      <a type="button" class="btn  btn-primary" title="Modificar Asignatura" href="index.php?view=teamasignatures&opt=edit_asignature&id_asignature=<?php echo $team->id; ?>"><i class='fa fa-pencil'></i></a>
                    <?php endif; ?>
                    <!--------------------VER ASIGNATURAS----------------------->
                    <a href="index.php?view=califications&id=<?php echo $team->id; ?>" class="btn btn-warning " title="Ver Calificaciones"><i class="fa fa-eye" aria-hidden="true"></i></a>

                    <!---------------------EDITAR CALIFICACIONES---------------------->

                    <?php
                    if (Core::$user->kind == 1 or Core::$user->kind == 13) : ?>   <!-- limite por usuarios o grupo de usuarios -->
                      <?php if ($team->asignature_type == 'NUM') { ?>
                        <!--  -->
                        <a href="index.php?view=editcalifications&id=<?php echo $team->id; ?>" class="btn btn-success " title="Modificar Calificaciones"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                      <?php } else { ?>
                        <a href="index.php?view=editcalificationsL&id=<?php echo $team->id; ?>" class="btn btn-success " title="Modificar Calificaciones"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                      <?php } ?>

                      <!-------------------BLOQUE DE CALIFICACIONES------------------------>
                      <a href="index.php?view=blocks&opt=all&id=<?php echo $team->id; ?>" class="btn btn-info " title="Bloque de calificaciones"><i class="fa fa-cubes" aria-hidden="true"></i></a>
                      <!----------------ELIMINAR--------------------------->
                      <a href="index.php?action=asignatures&opt=deltas&id=<?php echo $team->id; ?>&team_id=<?php echo $theteam->id; ?>&period_id=<?php echo $period->id; ?>" class="btn btn-danger "><i class="fa fa-trash-o" aria-hidden="true" title="Eliminar"></i></a>
                    <?php endif; ?>
                  </td>
                </tr>
            <?php
              }
              echo "</table></div></div>";
            } else {
              echo "<p class='alert alert-danger'>No hay Asignaturas</p>";
            }
            ?>
          </div>
        </div>
      <?php } elseif (isset($_GET["opt"]) && $_GET["opt"] == "new") { ?>
        <div class="row">
          <div class="col-md-12">
            <h1>Nueva Asignatura</h1>
            <br>
            <form class="form-horizontal" method="post" id="addcategory" action="./?action=asignatures&opt=add" role="form">
              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
                <div class="col-md-6">
                  <input type="text" name="name" required class="form-control" id="name" placeholder="Nombre">
                </div>
              </div>

              <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                  <button type="submit" class="btn btn-primary">Agregar Asignatura</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      <?php } elseif (isset($_GET["opt"]) && $_GET["opt"] == "edit") {
      $a = AsignatureData::getById($_GET["id"]);
      ?>
        <div class="row">
          <div class="col-md-12">
            <h1>Editar Asignatura</h1>
            <br>
            <form class="form-horizontal" method="post" id="addcategory" action="./?action=asignatures&opt=update" role="form">
              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
                <div class="col-md-6">
                  <input type="text" name="name" value="<?php echo $a->name; ?>" required class="form-control" id="name" placeholder="Nombre">
                </div>
              </div>

              <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                  <input type="hidden" name="id" value="<?php echo $a->id; ?>">
                  <button type="submit" class="btn btn-success">Actualizar Asignatura</button>
                </div>
              </div>
            </form>
          </div>
        </div>

      <?php } elseif (isset($_GET["opt"]) && $_GET["opt"] == "edit_asignature") {
      $asignation = AsignationData::getById($_GET["id_asignature"]);
      $teacher = PersonData::getById($asignation->teacher_id);
      $asignature = AsignatureData::getById($asignation->asignature_id);
      $asignature_type = $asignation->asignature_type == 'NUM' ? 'Numerica' : 'De Aprobacion';
      ?>
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel"> <i class='fa fa-edit'></i> Editar Asignatura : <b><?php echo $asignature->name ?></b></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="post" id="addcategory" action="index.php?action=editasignation" role="form">
            <input type="hidden" name="asignation_id" value="<?php echo $_GET["id_asignature"]; ?>">
            <input type="hidden" name="team_id" value="<?php echo $asignation->team_id; ?>">
            <input type="hidden" name="period_id" value="<?php echo $asignation->period_id; ?>">

            <div class="form-group">
              <label for="inputEmail1" class="col-lg-2 control-label">Docente*</label>
              <div class="col-md-12">
                <select name="teacher_id" data-live-search="true" class="form-control select" required>
                  <option value="">-- SELECCIONE --</option>
                  <option value="<?php echo $teacher->id; ?>" selected><?php echo $teacher->name . " " . $teacher->lastname; ?></option>
                  <?php foreach (PersonData::getTeachers() as $al) { ?>
                    <option value="<?php echo $al->id; ?>"><?php echo $al->name . " " . $al->lastname . " - " . $al->code; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail1" class="col-lg-2 control-label">Asignatura*</label>
              <div class="col-md-12">
                <select name="asignature_id" data-live-search="true" class="form-control select" required>
                  <option value="">-- SELECCIONE --</option>
                  <option value="<?php echo $asignature->id; ?>" selected><?php echo $asignature->name; ?></option>
                  <?php foreach (AsignatureData::getAll() as $al) : ?>
                    <option value="<?php echo $al->id; ?>"><?php echo $al->program . " " . $al->name; ?></option>
                  <?php endforeach; ?>
                </select>

              </div>
            </div>

            <div class="form-group">
              <label for="asignature_type" class="col-lg-2 control-label">Tipo de Materia*</label>
              <div class="col-md-12">
                <select name="asignature_type" class="form-control" required>
                  <option value="">-- SELECCIONE --</option>
                  <option value="<?php echo $asignation->asignature_type ?>" selected><?php echo $asignature_type ?></option>
                  <option value="APR">De Aprobacion</option>
                  <option value="NUM">Numerica</option>
                </select>

              </div>
            </div>

            <div class="form-group">
              <div class="col-lg-10">
                <button type="submit" class="btn btn-primary"> <i class='fa fa-plus'></i> Agregar Asignatura</button>
              </div>
            </div>
          </form>

        </div>
      <?php }  ?>


      <script>
        $('.select').selectpicker();
      </script>