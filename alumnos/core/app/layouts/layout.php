<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>IEM | Estudiantes </title>
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
        <link rel="icon" type="image/x-icon" href="../assets/images/aguila_dorada.ico" />    
 
 
 
 
 <!-- Nucleo Icons -->
<link href="../plugins/dist/css/nucleo-icons.css" rel="stylesheet" />
<link href="../plugins/dist/css/nucleo-svg.css" rel="stylesheet" />

  <!-- Font Awesome Icons -->
<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

<!-- Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

<!-- CSS Files -->

<link id="pagestyle" href="../plugins/dist/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />




  
  <!-- <link href="../assets/css/act2023_css.css" rel="stylesheet"> -->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <script src="../plugins/jquery/jquery-2.1.4.min.js"></script>
  <script src="../plugins/morris/raphael-min.js"></script>
  <script src="../plugins/morris/morris.js"></script>
  <script src="../plugins/morris/alertas.js"></script>
  <link rel="stylesheet" href="../plugins/morris/morris.css">
  <link rel="stylesheet" href="../plugins/morris/example.css">
  <script src="../plugins/jspdf/jspdf.min.js"></script>
  <script src="../plugins/jspdf/jspdf.plugin.autotable.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href='../plugins/fullcalendar/fullcalendar.min.css' rel='stylesheet' />
  <link href='../plugins/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
  <script src='../plugins/fullcalendar/moment.min.js'></script>
  <script src='../plugins/fullcalendar/fullcalendar.min.js'></script>
  <script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>



<style>



  .toggle-password-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
  }
</style>


</head>

<body class="<?php if (isset($_SESSION["alumn_id"])) : ?>  skin-blue sidebar-mini <?php else : ?>login-page<?php endif; ?>">
  <div class="wrapper">
    <!-- Main Header -->
    <?php if (isset($_SESSION["alumn_id"])) : ?>
      <header class="main-header">
        <!-- Logo -->
        <a href="https://aula.iemueem.edu.mx/Servicios/iem/alumnos/index.php?view=home" class="logo">
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

              <!-- Notificaciones -->
              <li class="nav-item dropdown">
                <a href="#" id='icono' name=viewport content="width=device-width, initial-scale=1" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="fa fa-bell" style="font-size:18px;"></span></a>
                <ul class="dropdown-menu" id="notificaciones"></ul>
              </li>
              <!-- Fin Notificaciones -->

              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                

                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    
                <img src="../assets/images/undraw_profile.svg" class="img-circle" alt="User Image" width="20px" />
                    
                  <!-- The user image in the navbar-->
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span style="font-family: Arial, sans-serif; font-size: 10px;">
                  <?php if (isset($_SESSION["alumn_id"])) {
                    echo PersonData::getById($_SESSION["alumn_id"])->name;
                  }
                  ?>
                 <?php if (isset($_SESSION["alumn_id"])) {
                    echo PersonData::getById($_SESSION["alumn_id"])->lastname;
                  }
                  ?>
                  <span class="caret"></span>
                </span>

                  
                  

                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-body">
                    <div class="col-xs-6 text-center">
                      <a href="index.php?view=edituser&id=<?php if (isset($_SESSION["alumn_id"])) {
                                                            echo PersonData::getById($_SESSION["alumn_id"])->id;
                                                          } ?>">
                        <div><i class="fa fa-briefcase"></i></div>Perfil
                      </a>
                    </div>
                    <div class="col-xs-6 text-center">
                      <a href="index.php?view=password&id=<?php if (isset($_SESSION["alumn_id"])) {
                                                            echo PersonData::getById($_SESSION["alumn_id"])->id;
                                                          } ?>">
                        <div><i class="fa fa-lock"></i></div>Contraseña
                      </a>
                    </div>
                  </li>

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


          <!-- Aqui Termina Para Icono de Usuario -->

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">Administración</li>
            <?php if (isset($_SESSION["alumn_id"])) :
            ?>


              <li><a href="./index.php?view=home"><i class='fa fa-dashboard'></i> <span>Inicio</span></a></li>

                <!-- Menu Notificaciones -->
              <li class="header">Avisos</li>
              <li><a href="./?view=notificaciones&code=<?php if (isset($_SESSION["alumn_id"])) {
                                                          echo PersonData::getById($_SESSION["alumn_id"])->code;
                                                        } ?>"><i class='fa fa-bell'></i> <span>Notificaciones</span></a></li>
                                                        
              <li class="header">Mi Expediente</li>

              <li><a href="index.php?view=edituser&id=<?php if (isset($_SESSION["alumn_id"])) {
                                                        echo PersonData::getById($_SESSION["alumn_id"])->id;
                                                      } ?>"><i class='fa fa-cog'></i> <span>Ver Perfil</span></a></li>

              
              <!------fin menu notificaciones-->
              <!-- Menu de pago  -->
              <!-- Menu Pagos -->
              <li class="header">Estado de Cuenta</li>
              <li><a href="./?view=pagos&code=<?php if (isset($_SESSION["alumn_id"])) {
                                                echo PersonData::getById($_SESSION["alumn_id"])->code;
                                              } ?>"><i class='fa fa-credit-card'></i> <span>Pagos</span></a></li>
              <!-- Recibos  -->
              <li><a href="./?view=recibos&code=<?php if (isset($_SESSION["alumn_id"])) {
                                                  echo PersonData::getById($_SESSION["alumn_id"])->code;
                                                } ?>"><i class="fa fa-file"></i> <span>Comprobantes de Pago</span></a></li>
                                                
                <li class="header">Ayuda IEM</li>
                <li><a href="mailto:soporte@ueem.mx"><i class='fa fa-question'></i> <span>Atención y Soporte Técnico</span></a></li>
                
            <?php endif; ?>
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
    <?php endif; ?>

    <!-- Content Wrapper. Contains page content -->
    <?php if (isset($_SESSION["alumn_id"])) : ?>
      <div class="content-wrapper">
        <div class="content">
          <?php View::load("index"); ?>
        </div>
      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 4.0
        </div>
        <strong>Copyright &copy;  <?php echo date('Y') ?> | Control Estudiantil | Powered by <a href="http://iemueem.edu.mx/" target="_blank">Instituto Ejecutivo Mexicano</a><br></strong>

      </footer>
    <?php else : ?>
      <div class="login-box">
        <div class="login-logo">
          <a href="https://aula.iemueem.edu.mx/Servicios/iem/" target="_self">
            <img src="../assets/images/logo_IEM.png" width="40%" height="auto">
        </a>
          <h4><strong>Bienvenido al Portal Estudiantil</strong></h4>
        </div><!-- /.login-logo -->

        <div class="header" style="border-top-left-radius: 39px;
    border-top-right-radius: 39px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
    background: none repeat scroll 0 0 #243a8e;
    box-shadow: inset 0px -3px 0px rgb(0 0 0 / 20%);
    padding: 14px 10px;
    text-align: center;
    font-size: 26px;
    font-weight: 300;
    color: #fff;">Iniciar sesión</div>


        <div class="login-box-body">
          <center></center>
          <form action="./?action=processlogin" method="post" id="formulario1">
            <div class="form-group has-feedback">
              <input type="tel" name="username" required class="form-control" placeholder="Usuario" />
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>

        <!-- Agreado para mostrar la contraseña, errores por parte de usuarios Nota de Ale-->
            <div class="form-group has-feedback">
              <input type="password" name="password" id="password-input" required class="form-control" placeholder="Password" />
              <i class="fa fa-eye-slash toggle-password-icon" onclick="togglePasswordVisibility()"></i>
              
            </div>
            
            <script>
              function togglePasswordVisibility() {
                const passwordInput = document.getElementById('password-input');
                const toggleIcon = document.querySelector('.toggle-password-icon');
                if (passwordInput.type === 'password') {
                  passwordInput.type = 'text';
                  toggleIcon.classList.remove('fa-eye-slash');
                  toggleIcon.classList.add('fa-eye');
                } else {
                  passwordInput.type = 'password';
                  toggleIcon.classList.remove('fa-eye');
                  toggleIcon.classList.add('fa-eye-slash');
                }
              }
            </script>


            
            <div class="row">
              <div class="col-xs-12">
                <button onclick="proceso(event)" type="submit" class="btn btn-primary btn-block btn-flat">Acceder</button> <!-- alerta del sistema  -->
                <!-- <a href="../"  class="btn btn-default btn-block btn-flat"><i class="fa fa-arrow-left"></i> Ir al Inicio</a>-->
                <a href="javascript:history.back()" class="btn btn-default btn-block btn-flat"><i class="fa fa-arrow-left"></i> Regresar</a>
              </div><!-- /.col -->
            </div>
          </form>
        </div><!-- /.login-box-body -->
      </div><!-- /.login-box -->
    <?php endif; ?>


  </div><!-- ./wrapper -->
<center>©  <?php echo date('Y') ?> System V4.0 - Instituto Ejecutivo Mexicano <br> Powered - <small>by CodigoVAP</small></center>
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

  <script>
    $(document).ready(function() {

      function load_unseen_notification(view = '') {
        $.ajax({
          url: "core/app/ajax/ajax_notificaciones_alumno.php",
          method: "POST",
          data: {
            view: view
          },
          dataType: "json",
          success: function(data) {
            $('#notificaciones').html(data.notification);
            if (data.unseen_notification > 0) {
              $('.count').html(data.unseen_notification);
            }
          }
        });
      }

      load_unseen_notification();

      $(document).on('click', '#icono', function() {
        $('.count').html('');
        load_unseen_notification('yes');
      });

      // setInterval(function() {
      //   load_unseen_notification();;
      // }, 5000);

    });
  </script>

</body>

</html>