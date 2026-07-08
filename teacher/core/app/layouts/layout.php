<!DOCTYPE html>

<html>

<head>

  <meta charset="UTF-8">

  <title>IEM | Teacher Dashboard</title>

  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

  <!-- Bootstrap 3.3.4 -->

  <link href="../plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

  <!-- Font Awesome Icons -->

  <link href="../plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

  <!-- Theme style -->

  <link href="../plugins/dist/css/AdminLTE_IEM_24.min.css" rel="stylesheet" type="text/css" />

  <link href="../plugins/dist/css/skins/skin-blue-IEM.min.css" rel="stylesheet" type="text/css" />

  <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">

 <!-- Favicon-->

        <link rel="icon" type="image/x-icon" href="assets/images/aguila_dorada.ico" />  

  

  

  <!-- Nucleo Icons -->

<link href="../plugins/dist/css/nucleo-icons.css" rel="stylesheet" />

<link href="../plugins/dist/css/nucleo-svg.css" rel="stylesheet" />



  <!-- Font Awesome Icons -->

<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>



<!-- Material Icons -->

<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">



<!-- CSS Files -->



<link id="pagestyle" href="../plugins/dist/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />





  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

  <!--[if lt IE 9]>

        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>

        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->

  <script src="../plugins/jquery/jquery-2.1.4.min.js"></script>

  <script src="../plugins/morris/raphael-min.js"></script>

  <script src="../plugins/morris/morris.js"></script>

  <link rel="stylesheet" href="../plugins/morris/morris.css">

  <link rel="stylesheet" href="../plugins/morris/example.css">

  <script src="../plugins/jspdf/jspdf.min.js"></script>

  <script src="../plugins/jspdf/jspdf.plugin.autotable.js"></script>



  <link href='../plugins/fullcalendar/fullcalendar.min.css' rel='stylesheet' />

  <link href='../plugins/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />

  <script src='../plugins/fullcalendar/moment.min.js'></script>

  <script src='../plugins/fullcalendar/fullcalendar.min.js'></script>

  <!--SweetAlert2-->

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>



</head>



<body class="<?php if (isset($_SESSION["teacher_id"])) : ?>  skin-blue sidebar-mini <?php else : ?>login-page<?php endif; ?>">

  <div class="wrapper">

    <!-- Main Header -->

    <?php if (isset($_SESSION["teacher_id"])) : ?>

      <header class="main-header">

        <!-- Logo -->

        <a href="./index.php?view=home" class="logo">

          <!-- mini logo for sidebar mini 50x50 pixels -->

          <span class="logo-mini"><b>IEM</b></span>

          <!-- logo for regular state and mobile devices -->

          <span><img src="../assets/images/logo_blanco_acostado.png" width="100px" height="auto"></span>

        </a>





        <!-- Header Navbar -->

        <nav class="navbar navbar-static-top" role="navigation">

          <!-- Sidebar toggle button-->

          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">

            <span class="sr-only">Toggle navigation</span>

          </a>





          <!-- Navbar Right Menu -->

          <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">



              <!-- User Account Menu -->

              <li class="dropdown user user-menu">



                <!-- Menu Toggle Button -->

                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                <img src="../assets/images/undraw_profile.svg" class="img-circle" alt="User Image" width="20px" />

                  <!-- The user image in the navbar-->

                  <!-- hidden-xs hides the username on small devices so only the image appears. -->

                  <span class="">

                    <?php if (isset($_SESSION["teacher_id"])) {

                      echo PersonData::getById($_SESSION["teacher_id"])->name;

                    } ?>

                    <?php if (isset($_SESSION["teacher_id"])) {

                      echo PersonData::getById($_SESSION["teacher_id"])->lastname;

                    } ?>

                    <span class="caret"></span>

                  </span>

                </a>

                <ul class="dropdown-menu">

                  <!-- The user image in the menu -->



                  <!-- Menu Footer-->

                  <li class="user-body">

                    <div class="col-xs-6 text-center">



                      <a href="index.php?view=miexpediente&id=<?php if (isset($_SESSION["teacher_id"])) {

                                                                echo PersonData::getById($_SESSION["teacher_id"])->id;

                                                              } ?>">

                        <div><i class="fa fa-briefcase"></i></div>Mi Expediente

                      </a>

                    </div>



                    <!--					<div class="col-xs-6 text-center">

                      <a href="index.php?view=edituser&id=<?php if (isset($_SESSION["alumn_id"])) {

                                                            echo PersonData::getById($_SESSION["alumn_id"])->id;

                                                          } ?>">

                       <div><i class="fa fa-lock"></i></div>Contraseña</a>

                     </div>-->







                    <!-- Menu Footer-->

                  <li class="user-footer" style="padding: 10px;

    					border-bottom-left-radius: 5px;

   						border-bottom-right-radius: 5px;

    					-webkit-border-bottom-left-radius: 5px;

    					-webkit-border-bottom-right-radius: 5px;

    					-moz-border-bottom-left-radius: 5px;

    					-moz-border-bottom-right-radius: 5px;

    					background-color: #F0B518;

    					color: #fff;">

                    <div class="text-center">

                      <a href="./?action=processlogout">

                        <div><i class="fa fa-power-off"></i></div>

                        <a href="./?action=processlogout">Cerrar Sesión</a>

                      </a>

                    </div>

                  </li>

                </ul>

              </li>

              <!-- Control Sidebar Toggle Button -->

            </ul>

          </div>

        </nav>

      </header>





      <!-- Left side column. contains the logo and sidebar -->

      <aside class="main-sidebar">



        <!-- sidebar: style can be found in sidebar.less -->

        <section class="sidebar">



          <!-- Para Icono de Usuario 

          <div class="user-panel">

            <div class="pull-left image">

              <img src="../assets/images/user.png" class="img-circle" alt="User Image" />

            </div>

            <div class="pull-left info">

              <p><?php if (isset($_SESSION["teacher_id"])) {

                    echo PersonData::getById($_SESSION["teacher_id"])->name;

                  } ?><br>

                <?php if (isset($_SESSION["teacher_id"])) {

                  echo PersonData::getById($_SESSION["teacher_id"])->lastname;

                } ?></p>



              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>

            </div>

          </div>-->

          <!-- Aqui Termina Para Icono de Usuario -->





          <!-- Sidebar Menu -->

          <ul class="sidebar-menu">

            <li class="header">Administración</li>

            <?php if (isset($_SESSION["teacher_id"])) :

            ?>





                <li><a href="./index.php?view=home"><i class='fa fa-dashboard'></i> <span>Inicio</span></a></li>

                <li><a href="./?view=myasignations&opt=all"><i class='fa fa-retweet'></i> <span>Grupos Asignados</span></a></li>

                <li><a href="index.php?view=miexpediente&id=<?php if (isset($_SESSION["teacher_id"])) {

                                                      echo PersonData::getById($_SESSION["teacher_id"])->id;

                                                    } ?>"><i class='fa fa-archive'></i> <span>Mi Expediente</span></a></li>

                <li><a href="index.php?view=misconstancias&id=<?php if (isset($_SESSION["teacher_id"])) {

                                                      echo PersonData::getById($_SESSION["teacher_id"])->id;

                                                    } ?>"><i class='fa fa-trophy'></i> <span>Mis Constancias</span></a></li>

                <li class="header">Ayuda IEM</li>

                <li><a href="mailto:soporte@ueem.mx"><i class='fa fa-question'></i> <span>Atención y Soporte Técnico</span></a></li>

                

      



              <!--

            <li class="treeview">

              <a href="#"><i class='fa fa-cog'></i> <span>Administracion</span> <i class="fa fa-angle-left pull-right"></i></a>

              <ul class="treeview-menu">

                <li><a href="./?view=users">Usuarios</a></li>

                <li><a href="./?view=settings">Configuracion</a></li>

              </ul>

            </li>

            -->

            <?php endif; ?>



          </ul><!-- /.sidebar-menu -->

        </section>

        <!-- /.sidebar -->

      </aside>

    <?php endif; ?>



    <!-- Content Wrapper. Contains page content -->

    <?php if (isset($_SESSION["teacher_id"])) : ?>

      <div class="content-wrapper">

        <div class="content">

          <?php View::load("index"); ?>

        </div>

      </div><!-- /.content-wrapper -->



      <footer class="main-footer">

        <div class="pull-right hidden-xs">

          <b>Version</b> 4.0

        </div>

        <strong>Copyright &copy; <?php echo date("Y"); ?> | Control Docente | Powered by <a href="http://iemueem.edu.mx/" target="_blank">Instituto Ejecutivo Mexicano</a><br></strong>



      </footer>

    <?php else : ?>





      <div class="login-box">

        <div class="login-logo">

          <a href="https://aula.iemueem.edu.mx/Servicios/iem/" target="_self">

            <img src="../assets/images/logo_IEM.png" width="40%" height="auto">

        </a>

          <h4>Bienvenido al Portal Docente</h4>



        </div><!-- /.login-logo -->

        

    <div class="header" style="border-top-left-radius: 39px;

    border-top-right-radius: 39px;

    border-bottom-right-radius: 0;

    border-bottom-left-radius: 0;

    background: none repeat scroll 0 0 #d2a02a;

    box-shadow: inset 0px -3px 0px rgb(0 0 0 / 20%);

    padding: 14px 10px;

    text-align: center;

    font-size: 26px;

    font-weight: 300;

    color: #fff;">Iniciar sesión</div>

    

    

        <div class="login-box-body">

          <center></center>

          <form action="./?action=processlogin" method="post">

            <div class="form-group has-feedback">

              <input type="text" name="username" required class="form-control" placeholder="Usuario" />

              <span class="glyphicon glyphicon-user form-control-feedback"></span>

            </div>

            <div class="form-group has-feedback">

              <input type="password" name="password" required class="form-control" placeholder="Password" />

              <span class="glyphicon glyphicon-lock form-control-feedback"></span>

            </div>

            <div class="row">



              <div class="col-xs-12">

                <button type="submit" class="btn btn-primary btn-block btn-flat">Acceder</button>

                <a href="javascript:history.back()" class="btn btn-default btn-block btn-flat"><i class="fa fa-arrow-left"></i> Regresar</a>



              </div><!-- /.col -->

            </div>

          </form>

        </div><!-- /.login-box-body -->

      </div><!-- /.login-box -->

    <?php endif; ?>





  </div><!-- ./wrapper -->

<center>© <?php echo date("Y"); ?> System V4.0 - Instituto Ejecutivo Mexicano <br> Powered - <small>by CodigoVAP</small></center>

  <!-- REQUIRED JS SCRIPTS -->



  <!-- jQuery 2.1.4 -->

  <!-- Bootstrap 3.3.2 JS -->

  <script src="../plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

  <!-- AdminLTE App -->

  <script src="../plugins/dist/js/app.min.js" type="text/javascript"></script>



  <script src="../plugins/datatables/jquery.dataTables.min.js"></script>

  <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>

  <script type="text/javascript">

    $(document).ready(function() {

      $(".datatable").DataTable({

        "language": {

          "sProcessing": "Procesando...",

          "sLengthMenu": "Mostrar _MENU_ registros",

          "sZeroRecords": "No se encontraron resultados",

          "sEmptyTable": "Ningún dato disponible en esta tabla",

          "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",

          "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",

          "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",

          "sInfoPostFix": "",

          "sSearch": "Buscar:",

          "sUrl": "",

          "sInfoThousands": ",",

          "sLoadingRecords": "Cargando...",

          "oPaginate": {

            "sFirst": "Primero",

            "sLast": "Último",

            "sNext": "Siguiente",

            "sPrevious": "Anterior"

          },

          "oAria": {

            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",

            "sSortDescending": ": Activar para ordenar la columna de manera descendente"

          }

        }

      });

    });

  </script>

  <!-- Optionally, you can add Slimscroll and FastClick plugins.

          Both of these plugins are recommended to enhance the

          user experience. Slimscroll is required when using the

          fixed layout. -->

</body>



</html>