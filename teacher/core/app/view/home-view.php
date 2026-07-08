<?php

$teams = AsignationData::getActiveByTeacherId($_SESSION["teacher_id"]);

$nalumns = 0;

foreach ($teams as $tx) {

  $alumns = InscriptionData::getAllByTP($tx->team_id, $tx->period_id);

  $nalumns += count($alumns);

}



?>



<html lang="es">

<section class="content-header">

  <h1><img src="../storage/posts/visherbot1.png"  width="52px"> Te saludo <?php if (isset($_SESSION["teacher_id"])) {

                    echo PersonData::getById($_SESSION["teacher_id"])->name;

                  } ?>

  



               !<br>

               <small><strong>Bienvenido(a) al Sistema de Carga de Calificaciones </strong></small>

               <small><strong></strong>Version 4.0</small></h1>



</section>









<section class="content">

  <div class="row">

    <div class="col-md-12">



      <div class="row">

<!-- Diseño anterior

        <div class="col-lg-3 col-xs-6">

   

          <div class="small-box bg-yellow">

            <div class="inner">

              <h3><?php echo $nalumns; ?></h3>

              <p>Estudiantes</p>

            </div>

            <div class="icon">

              <i class="fa fa-users"></i>

            </div>

          </div>

        </div>-->

        

        

        <div class="col-xl-3 col-sm-6 mb-xl-5 mb-4">

        <div class="card">

            <div class="card-header p-3 pt-2">

                <div class="icon icon-3xl icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">

                    <i class="material-icons opacity-10">people</i>

                </div>

                <div class="text-end pt-1">

                    <p class="text-5xl mb-0 text-capitalize">Estudiantes</p>

                    <img src="../storage/posts/estudiantes.png" width="64px" style="opacity: 0.3;position: absolute;top: 45px;left: 50%;">

                    <h4 class="mb-0"><?php echo $nalumns; ?></h4>

                </div>

            </div>

            <hr class="dark horizontal my-0">

            <div class="card-footer p-3">

                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"> </span>Muestra el número de estudiantes asignados durante el ciclo escolar activo.</p>

            </div>

        </div>

        </div>





        <div class="col-xl-3 col-sm-6 mb-xl-5 mb-4">

        <div class="card">

            <div class="card-header p-3 pt-2">

                <div class="icon icon-3xl icon-shape bg-gradient-blue shadow-dark text-center border-radius-xl mt-n4 position-absolute">

                    <i class="material-icons opacity-10">people</i>

                </div>

                <div class="text-end pt-1">

                    <p class="text-5xl mb-0 text-capitalize">Asignaciones</p>

                    <img src="../storage/posts/biblioteca.png" width="64px" style="opacity: 0.3;position: absolute;top: 45px;left: 50%;">

                    <h4 class="mb-0"><?php echo count($teams); ?></h4>

                </div>

            </div>

            <hr class="dark horizontal my-0">

            <div class="card-footer p-3">

                <a href="./?view=myasignations&opt=all" class="small-box-footer">Ir <i class="fa fa-arrow-circle-right"></i></a>

                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"> </span>Muestra el número de asignaturas a impartir durante el ciclo escolar.</p>

            </div>

        </div>

        </div>

        

        

        <div class="col-xl-3 col-sm-6 mb-xl-5 mb-4">

        <div class="card">

            <div class="card-header p-3 pt-2">

               

                <div class="icon icon-3xl icon-shape shadow-dark text-center border-radius-xl mt-n4 position-absolute" style="background-color: #d2a12a;">

                    <i class="material-icons opacity-10">inventory_2</i>

                    

                </div>

                <div class="text-end pt-1">

                    <p class="text-5xl mb-0 text-capitalize">Mi Expediente</p>

                    <img src="../storage/posts/aguila_dorada.png" width="94px" style="opacity: 0.3;position: absolute;top: 45px;left: 50%;">

                    <h4 class="mb-0" style="color: #FFFFFF;">.</h4>

                </div>

            </div>

            <hr class="dark horizontal my-0">

            <div class="card-footer p-3">

                <a href="index.php?view=miexpediente&id=<?php if (isset($_SESSION["teacher_id"])) {

                                                      echo PersonData::getById($_SESSION["teacher_id"])->id;

                                                    } ?>" class="small-box-footer">Ir <i class="fa fa-arrow-circle-right"></i></a>

                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"> </span>En este espacio deberá cargar su documentación en PDF.</p>

            </div>

        </div>

        </div>





        <div class="col-xl-3 col-sm-6 mb-xl-5 mb-4">

        <div class="card">

            <div class="card-header p-3 pt-2">

                <div class="icon icon-3xl icon-shape shadow-dark text-center border-radius-xl mt-n4 position-absolute" style="background-color: #d81b60;">

                    <i class="material-icons opacity-10">verified</i>

                

                </div>

                <div class="text-end pt-1">

                    <p class="text-5xl mb-0 text-capitalize">Mis Constancias IEM</p>

                    <img src="../storage/posts/certificado_docente.png" width="64px" style="opacity: 0.3;position: absolute;top: 45px;left: 50%;">

                    <h4 class="mb-0" style="color: #FFFFFF;">.</h4>

                </div>

            </div>

            <hr class="dark horizontal my-0">

            <div class="card-footer p-3">

                <a href="index.php?view=misconstancias&id=<?php if (isset($_SESSION["teacher_id"])) {

                                                      echo PersonData::getById($_SESSION["teacher_id"])->id;

                                                    } ?>" class="small-box-footer">Ir <i class="fa fa-arrow-circle-right"></i></a>

                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"> </span>Descargar tus constancias.</p>

            </div>

        </div>

        </div>

        



        <div class="col-xl-3 col-sm-6 mb-xl-5 mb-4">

        <div class="card">

            <div class="card-header p-3 pt-2">

                <div class="icon icon-3xl icon-shape bg-gradient-success shadow-dark text-center border-radius-xl mt-n4 position-absolute">

                    <i class="material-icons opacity-10">cast_for_education</i>

                </div>

                <div class="text-end pt-1">

                    <p class="text-5xl mb-0 text-capitalize">Mis Cursos</p>

                    <img src="../storage/posts/salon-de-clases.png" width="64px" style="opacity: 0.3;position: absolute;top: 45px;left: 50%;">

                    <h4 class="mb-0" style="color: #FFFFFF;">.</h4>

                </div>

            </div>

            <hr class="dark horizontal my-0">

            <div class="card-footer p-3">

                <a href="index.php?view=courses" class="small-box-footer">Ir <i class="fa fa-arrow-circle-right"></i></a>

                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"> </span>En este espacio podrás inscribirte a los cursos IEM.</p>

            </div>

        </div>

        </div>

        

        

        <!-- ./col -->

        <!-- ./col -->

        <!--- - - - - - - - - - - - - - - - - - -->



      </div>



      <?php

      $teams = PostData::getAllByQ("where kind_pub=1 and (kind=1 or kind=2)");

      if (count($teams) > 0) {

        // si hay usuarios

      ?>

        <div class="box box-primary">

          <div class="box-body">

            <table class="table table-bordered datatable table-hover">

              <thead>

                <th width="100px"></th>

                <th>Avisos</th>

                <th></th>

              </thead>

              <?php

              foreach ($teams as $team) {

              ?>

                <tr>



                  <td>



                    <img src="../storage/posts/<?php echo $team->image; ?>" class="img-responsive">



                  </td>



                  <td>

                    <h4><?php echo $team->title; ?></h4>

                    <p><?php echo $team->content; ?></p>

                  </td>









                  <td><a href="../storage/pdf/<?php echo $team->pdf; ?>" class="btn btn-primary btn-xs" target="_blank">Ir al documento</a>





                  </td>





                </tr>

              <?php

              }

              ?>

            </table>

          </div>

        </div>

      <?php

      } else {

        echo "<p class='alert alert-danger'>No hay Avisos</p>";

      }

      ?>

      <!-- - - - - - - - - - - - - - - - - - - -->









    </div>

  </div>







</section>