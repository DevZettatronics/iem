<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <!-- Bootstrap 4 actualizado 2020-->
  <link href="../plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

  <!-- Font Awesome Icons -->
  <link href="../plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

  <!-- Theme style -->

  <link href="../plugins/dist/css/AdminLTE_IEM_24.min.css" rel="stylesheet" type="text/css" />
  <link href="../plugins/dist/css/skins/skin-blue-IEM.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="../plugins/morris/morris.css">
  <link rel="stylesheet" href="../plugins/morris/example.css">
  <link href='../plugins/fullcalendar/fullcalendar.min.css' rel='stylesheet' />
  <link href='../plugins/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
  <link rel="stylesheet" href="../plugins/bootstrap-select/bootstrap-select.min.css">

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
  <script src="../plugins/morris/alertas.js"></script>
  <script src="../plugins/jspdf/jspdf.min.js"></script>
  <script src="../plugins/jspdf/jspdf.plugin.autotable.js"></script>
  <script src="../plugins/bootstrap-select/bootstrap-select.min.js"></script>
  <script src='../plugins/fullcalendar/moment.min.js'></script>
  <script src='../plugins/fullcalendar/fullcalendar.min.js'></script>

  <!--SweetAlert2-->

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- select 2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>



<body class="<?php if (isset($_SESSION["user_id"])) : ?>  skin-blue sidebar-mini <?php else : ?>login-page<?php endif; ?>">

  <div class="wrapper">

    <!-- Main Header -->

    <?php if (isset($_SESSION["user_id"])) : ?>

      <header class="main-header">

        <!-- Logo -->

        <a href="index.php?view=home" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>IEM</b></span>
          <!-- logo for regular state and mobile devices -->

          <span><img src="../assets/images/logo_blanco_acostado.png" width="100px" height="auto"></span>

        </a> <!-- Header Navbar -->

        <nav class="navbar navbar-static-top" role="navigation">

          <!-- Sidebar toggle button-->

          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">

            <span class="sr-only">Toggle navigation</span>

          </a>

          <!-- Navbar Right Menu -->

          <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

              <!-- Notificaciones -->

              <li class="dropdown">
                <a href="#" id='icono' class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="fa fa-bell" style="font-size:18px;"></span></a>
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
                    <?php if (isset($_SESSION["user_id"])) {
                      echo UserData::getById($_SESSION["user_id"])->name;
                    } ?>
                    <?php if (isset($_SESSION["user_id"])) {
                      echo UserData::getById($_SESSION["user_id"])->lastname;
                    } ?><span class="caret"></span>
                  </span>
                </a>
                
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <!-- Menu Footer-->
                    <li class="user-body">
                    <div class="col-xs-6 text-center">
                      <a href="index.php?view=edituser&id=<?php if (isset($_SESSION["user_id"])) {
                                                            echo UserData::getById($_SESSION["user_id"])->id;
                                                          } ?>">
                        <div><i class="fa fa-briefcase"></i></div>Perfil
                      </a>
                    </div>
                    <div class="col-xs-6 text-center">
                      <a href="index.php?view=password&id=<?php if (isset($_SESSION["user_id"])) {
                                                            echo UserData::getById($_SESSION["user_id"])->id;
                                                          } ?>">
                        <div><i class="fa fa-lock"></i></div>Contraseña
                      </a>
                    </div>
                  </li>
                  
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

          <!-- Para Icono de Usuario -->

          <div class="user-panel">

            <div class="pull-left image">

              <img src="../assets/images/undraw_profile.svg" class="img-circle" alt="User Image" />

            </div>

            <div class="pull-left info">

              <p><?php if (isset($_SESSION["user_id"])) {

                    echo UserData::getById($_SESSION["user_id"])->name;

                  } ?>

                <?php if (isset($_SESSION["user_id"])) {

                  echo UserData::getById($_SESSION["user_id"])->lastname;

                } ?></p>

              

              <p><?php if (isset($_SESSION["user_id"])) {

                    echo UserData::getById($_SESSION["user_id"])->email;

                  } ?>

                </p>
                
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>

          </div>

          <!-- Aqui Termina Para Icono de Usuario -->

          <!-- Sidebar Menu -->

          	<ul class="sidebar-menu">
				<?php if (isset($_SESSION["user_id"])) : ?>
					<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'administracionG')): ?>
						<li class="header">ADMINISTRACION</li>

						<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'inicio')): ?>
							<li>
							<a href="./index.php?view=home"><i class='fa fa-dashboard'></i> <span>Inicio</span></a>
							</li>
						<?php endif; ?>

						<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'ciclos_escolares')): ?>
							<li class="treeview">
								<a href="#"><i class='fa fa-institution'></i> <span>Ciclos Escolares</span> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<?php foreach (PeriodData::getAllActive() as $p) : ?>
									<li>
										<a href="./?view=teams&opt=byperiod&id=<?php echo $p->id; ?>">
										<i class='fa fa-angle-right'></i> <span>Periodo: <?php echo $p->name; ?></span>
										</a>
									</li>
									<?php endforeach; ?>

									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'navegar_periodos')): ?>
									<li><a href="./?view=selectperiod"><i class='fa fa-angle-right'></i> <span>Navegar Periodos</span></a></li>
									<?php endif; ?>
									
									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'nueva_inscripcion')): ?>
									<li><a href="./?view=inscription"><i class='fa fa-angle-right'></i> <span>Nueva Inscripcion</span></a></li>
									<?php endif; ?>
									
									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'inscripciones')): ?>
									<li><a href="./?view=inscriptions"><i class='fa fa-angle-right'></i> <span>Inscripciones</span></a></li>
									<?php endif; ?>

								</ul>
							</li>
						<?php endif; ?>
					<?php endif; ?>

					<!-- Convenios -->
					 <?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'convenios')): ?>
						<li class="header">CONVENIOS</li>

						<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'centros_de_vinculacion')): ?>
							<li>
							<a href="./?view=centroVinculacion&opt=all"><i class='fa fa-book'></i><span>Centro de Vinculación</span></a>
							</li>
						<?php endif; ?>

						
					<?php endif; ?>
              		<!-- solo se ve por un cierto usuario  que tnega el kind a 9 -->
              
              		<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'nuevo_ingreso')): 
                    // if (Core::$user->kind == 9 or Core::$user->kind == 1 or Core::$user->kind == 10 ) : ?>
                 	
						<li class="header">NUEVO INGRESO</li>

						<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'relaciones_publicas')): ?>
						<li class="treeview">

							<a href="#"><i class="glyphicon glyphicon-folder-open"></i><span>Relaciones publicas</span> <i class="fa fa-angle-left pull-right"></i></a>

							<ul class="treeview-menu">

								<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'aspirante')): ?>
								<li><a href="./?view=aspirante&opt=all"><i class='fa fa-angle-right'></i>
									<i class='fa fa-buysellads'></i>
									<span>Aspirante</span></a></li>
								<?php endif; ?>

								<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'becas')): ?>
								<li><a href="./?view=becas&opt=all"><i class='fa fa-angle-right'></i>
									<i class="fa fa-usd"></i>
									<span>Becas</span></a></li> <!-- 3312 -->
								<?php endif; ?>

								<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'promo_inscripcion')): ?>
								<li><a href="./?view=promociones&opt=all"><i class='fa fa-angle-right'></i>
									<i class="fa fa-thumbs-o-up"></i>
									<span>Promo Inscripción</span></a></li> <!-- 3312 -->
								<?php endif; ?>
							</ul>
						</li>
						<?php endif; ?>
					<?php endif; ?>


              		<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'servicios_escolares')): 
					//if (Core::$user->kind == 1) : ?>
              
						<li class="header">SERVICIOS ESCOLARES</li>

						<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'control_escolar')): ?>
							<li class="treeview">
								<a href="#"><i class='fa fa-book'></i> <span>Control Escolar</span> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">

									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'alta_periodos')): ?>	
										<li><a href="./?view=periods&opt=all"><i class='fa fa-angle-right'></i>
											<i class='fa fa-calendar'></i>
											<span>Alta de Periodos</span></a></li>
									<?php endif; ?>
									
									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'programas_educativos')): ?>	
										<li><a href="./?view=educationalprogram&opt=all"><i class='fa fa-angle-right'></i>
											<i class="fa fa-bookmark-o"></i>
											<span>Programas Educativos</span></a></li>
									<?php endif; ?>

									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'asignaturas')): ?>	
										<li><a href="./?view=asignatures&opt=all"><i class='fa fa-angle-right'></i>
											<i class='fa fa-bookmark'></i>
											<span>Asignaturas</span></a></li>
									<?php endif; ?>
									
									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'grupos')): ?>
										<li><a href="./?view=teams&opt=all"><i class='fa fa-angle-right'></i>
											<i class='fa fa-users'></i>
											<span>Grupos</span></a></li>
									<?php endif; ?>

									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'salones')): ?>
										<li><a href="./?view=rooms&opt=all"><i class='fa fa-angle-right'></i>
											<i class='fa fa-th'></i>
											<span>Salones</span></a></li>
									<?php endif; ?>

									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'cursos')): ?>
										<li><a href="./?view=courses&opt=all"><i class='fa fa-angle-right'></i>
											<i class="fa fa-eye"></i>
											<span>Cursos</span></a></li>
									<?php endif; ?>

									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'registro_asistencia')): ?>
										<li><a href="./?view=lista&opt=all"><i class='fa fa-angle-right'></i>
											<i class="glyphicon glyphicon-time"></i>
											<span>Registro Asistencia</span></a></li>
									<?php endif; ?>	
								</ul>
							</li>
							
							
												<!-- Modulo de perfiles -->

						<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'perfiles')): 
							//if (Core::$user->kind == 9 or Core::$user->kind == 1 or Core::$user->kind == 10) : ?>

							<li class="treeview">
								<a href="#"><i class='fa fa-male'></i> <span>Perfiles</span> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'estudiantes')): ?>
										<li><a href="./?view=alumns"><i class='fa fa-angle-right'></i>
											<i class='fa fa-graduation-cap'></i>
											<span>Estudiantes</span></a></li>
									<?php endif; ?>         

									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'docentes')):
									//if (Core::$user->kind == 1 or Core::$user->kind == 10) : ?>
										<li><a href="./?view=teachers"><i class='fa fa-angle-right'></i>
											<i class='fa fa-pencil'></i>
											<span>Docentes</span></a></li>
									<?php endif; ?> 

									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'padres')): ?>
										<li><a href="./?view=parents"><i class='fa fa-angle-right'></i>
											<i class='fa fa-user-secret'></i>
											<span>Padres</span></a></li>
									<?php endif; ?> 
								</ul>

							</li>
						<?php endif; ?>
						<?php endif; ?>
						
						
							<!-- Modulo de credenciales -->
						
						
						<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'credenciales')) : ?>
    <li class="header">CREDENCIALES</li>

    <?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'credenciales_dashboard')) : ?>
        <li>
            <a href="./?view=credenciales_dashboard">
                <i class='fa fa-dashboard'></i>
                <span>Dashboard de Credenciales</span>
            </a>
        </li>
    <?php endif; ?>

    <?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'credenciales_lista')) : ?>
        <li>
            <a href="./?view=credenciales_lista">
                <i class='fa fa-list-alt'></i>
                <span>Listado de Estudiantes</span>
            </a>
        </li>
    <?php endif; ?>
<?php endif; ?>
						
						

	
					<?php endif; ?>
             
					<!--CMS-->

					<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'notificacionesG')):  
					//if (Core::$user->kind == 1 or Core::$user->kind == 10 or Core::$user->kind == 8) : ?>

						<li class="header">NOTIFICACIONES</li>

						<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'cms')): ?>
							<li class="treeview">
								<a href="#"><i class='fa fa-file-text-o'></i> <span>CMS</span> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">

									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'avisos')): ?>
										<li><a href="./?view=posts&opt=all"><i class='fa fa-angle-right'></i>
												<i class='fa fa-newspaper-o'></i>
												<span>Avisos</span></a></li>
									<?php endif; ?>

									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'eventos')): ?>
										<li><a href="./?view=events&opt=all"><i class='fa fa-angle-right'></i>
											<i class='fa fa-clock-o'></i>
											<span>Eventos</span></a></li>
									<?php endif; ?>
									
									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'notificaciones')): ?>
										<li><a href="./?view=notificaciones&opt=all"><i class='fa fa-angle-right'></i>
											<i class='fa fa-bell'></i>
											<span>Notificaciones</span></a></li>
									<?php endif; ?>
										<!------fin menu notificaciones-->

								</ul>
							</li>
						<?php endif; ?>
					<?php endif; ?>

					<!--Reportes-->
					<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'REPORTES')):  
					//if (Core::$user->kind == 1 or Core::$user->kind == 10 or Core::$user->kind == 8) : ?>

						<li class="header">REPORTES</li>

						<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'reportes_1')): ?>
							<li class="treeview">
								<a href="#" ><i class='fa fa-file-text-o'></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i></a>

								<ul class="treeview-menu">

									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'reportes_1')): ?>
										<li><a id="btn_modalreporte1"><i class='fa fa-angle-right'></i> <span>Deudores</span></a></li>
									<?php endif; ?>

								</ul>
								<ul class="treeview-menu">

									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'reportes_1')): ?>
										<li><a id="btn_modalreporte2"><i class='fa fa-angle-right'></i> <span>Pagos</span></a></li>
									<?php endif; ?>

								</ul>
								<ul class="treeview-menu hidden">

									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'reportes_1')): ?>
										<li><a id="btn_modalreporte3"><i class='fa fa-angle-right'></i> <span>Bajas</span></a></li>
									<?php endif; ?>

								</ul>
							</li>
						<?php endif; ?>
					<?php endif; ?>


             		<!-- Catalogo de ventas -->

              		<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'estados_de_cuenta')): 
					//if (Core::$user->kind == 1 or Core::$user->kind == 12) : ?>

                		<li class="header">ESTADOS DE CUENTA</li>

						<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'catalogos')): ?>
							<li class="treeview">

								<a href="#"><i class='fa fa-briefcase'></i> <span>Catalogos</span> <i class="fa fa-angle-left pull-right"></i></a>

								<ul class="treeview-menu">

									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'categorias')): ?>
										<li><a href="./?view=categorias&opt=all"><i class='fa fa-angle-right'></i> <span>Categorias</span></a></li>
									<?php endif; ?>
									
									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'conceptos')): ?>
										<li><a href="./?view=productos&opt=all"><i class='fa fa-angle-right'></i> <span>Conceptos</span></a></li>
									<?php endif; ?>
									
								</ul>

							</li>

							<!-- Historial -->

							<!--    <li class="treeview">

							<a href="#"><i class="glyphicon glyphicon-th-list"></i> <span>Historial</span> <i class="fa fa-angle-left pull-right"></i></a>

							<ul class="treeview-menu">

								<li><a href="./?view=ventas&opt=all"><i class='fa fa-angle-right'></i> <span>Tickets de Venta</span></a></li>

							<li><a href="./?view=certifications&opt=all"><i class='fa fa-angle-right'></i> <span>Certificaciones</span></a></li>

							</ul>

							</li> -->
						<?php endif; ?>
                	

						<!-- Ventas -->
						<?php  if (Permisos::usuarioTieneModulo(Core::$user->kind, 'ventas')):  
						//if (Core::$user->kind == 1 or Core::$user->kind == 12 or Core::$user->kind == 11) : ?>

							<li class="treeview">

								<a href="#"><i class='fa fa-dollar'></i> <span>Ventas</span> <i class="fa fa-angle-left pull-right"></i></a>

								<ul class="treeview-menu">

									<!--  <li><a href="./?view=sell&opt=alumn"><i class='fa fa-angle-right'></i> <span>Vender</span></a></li>

									<li><a href="./?view=concepts&opt=all"><i class='fa fa-angle-right'></i> <span>Conceptos</span></a></li> -->

									<!-- <li><a href="./?view=calendar&opt=all"><i class='fa fa-angle-right'></i> <span>Calendario de Pagos</span></a></li> -->

						
									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'caja_virtual')): ?>
										<li><a href="pos.php" target="_blank"><i class='fa fa-angle-right'></i> <i class="fa fa-credit-card" aria-hidden="true"></i><span>Caja Virtual</span></a></li>
									<?php endif; ?>

									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'historial_pagos')): ?>
										<li><a href="./?view=payments&opt=all"><i class='fa fa-angle-right'></i> <i class="fa fa-history" aria-hidden="true"></i><span>Historial de pagos</span></a></li>
									<?php endif; ?>

									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'comprobantes_pago')): ?>
										<li><a href="./?view=recibos&opt=all"><i class="fa fa-angle-right"></i> <i class="fa fa-file-text" aria-hidden="true"></i><span>Comprobantes de Pago</span></a></li>
									<?php endif; ?>
								</ul>

							</li>
						<?php endif; ?>
				
						<!--Gestion-->

						<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'planes_pago')): 
						//if (Core::$user->kind == 1 or  Core::$user->kind == 12) : ?>

							<li class="treeview">

								<a href="#"><i class="glyphicon glyphicon-calendar"></i> <span>Planes de Pagos</span> <i class="fa fa-angle-left pull-right"></i></a>

								<ul class="treeview-menu">

									<!-- Plan de Pagos -->
									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'control_planes')): ?>
										<li><a href="./?view=planpago&opt=all"><i class='fa fa-angle-right'></i>
											<i class="fa fa-dollar"></i>
											<span>Control de Planes</span></a></li>
									<?php endif; ?>
								</ul>

							</li>

						<?php endif; ?>
				
						<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'facturacion4.0')):  
						//if (Core::$user->kind == 10 or  Core::$user->kind == 12 or  Core::$user->kind == 11) : ?>

							<li class="treeview">

								<a href="#"><i class="glyphicon glyphicon-folder-open"></i> <span>Facturación 4.0</span> <i class="fa fa-angle-left pull-right"></i></a>

								<ul class="treeview-menu">
									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'receptores')): ?>
										<li><a href="./?view=receptoresform&opt=all"><i class='fa fa-angle-right'></i> <i class="fa fa-user-plus"></i><span> Receptores</span></a></li>
									<?php endif; ?>

									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'administración_de_facturas')): ?>
										<li><a href="./?view=facturas&opt=all"><i class='fa fa-angle-right'></i><i class="fa fa-file-pdf-o"></i><span> Administración de facturas</span></a></li>
									<?php endif; ?>
									
								</ul>

							</li>

						<?php endif; ?>
						
						<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'recargos')):  ?>

							<li class="treeview">
								<a href="./?view=recargos&opt=all"><i class="glyphicon glyphicon-folder-open"></i> <span>Recargos</span> <i class="fa fa-angle-left pull-right"></i></a>
							</li>
							
						<?php endif; ?>
					<?php endif; ?>
							

							<?php //if (Core::$user->kind == 1) : ?>

							 <!-- <li class="treeview">

								<a href="#"><i class='fa fa-briefcase'></i> <span>Finanzas</span> <i class="fa fa-angle-left pull-right"></i></a>

								<ul class="treeview-menu">

									<li><a href="./?view=sell&opt=alumn"><i class='fa fa-angle-right'></i> <span>Vender</span></a></li>

									<li><a href="./?view=concepts&opt=all"><i class='fa fa-angle-right'></i> <span>Conceptos</span></a></li>

								</ul>

								</li> -->

							<?php //endif; ?>

							<!-- <li><a href="./?view=reports"><i class='fa fa-area-chart'></i> <span>Reportes</span></a></li>  -->

              		<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'control')):  
					//if (Core::$user->kind == 10 or Core::$user->kind == 8 or Core::$user->kind == 1) : ?>

                		<li class="header">CONTROL</li>

						<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'administracion')): ?>
							<li class="treeview">
								<a href="#"><i class='fa fa-cog'></i> <span>Administración</span> <i class="fa fa-angle-left pull-right"></i></a>
								
								<ul class="treeview-menu">
									
									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'expedientes_docente')): ?>
										<li><a href="./?view=contenedordocente&id=<?php if (isset($_SESSION["user_id"])) {
																					echo UserData::getById($_SESSION["user_id"])->id;
																				} ?>"><i class="fa fa-folder-open"></i>Expedientes Docente</a></li>
									<?php endif; ?>
									
									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'usuarios')): ?>
										<li><a href="./?view=users"><i class='fa fa-users'></i> <span>Usuarios</span></a></li>
									<?php endif; ?>

									<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'roles')): ?>
										<li><a href="./?view=roles"><i class='fa fa-users'></i> <span>Roles</span></a></li>
									<?php endif; ?>

								</ul>
							</li>
						<?php endif; ?>
              		<?php endif; ?>
            	<?php endif; ?>
            	<!-- cierre del menu -->
          	</ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
    <?php endif; ?>



    <!-- Content Wrapper. Contains page content -->
    <?php if (isset($_SESSION["user_id"])) : ?>
      <div class="content-wrapper">
        <div class="content">
          <?php View::load("index"); ?>
        </div>
      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 4.0
        </div>
        <strong>Copyright &copy; <?php echo date('Y') ?> | Sistema de Control Administrativo | Powered by <a href="http://iemueem.edu.mx/" target="_blank">Instituto Ejecutivo Mexicano</a><br></strong>
      </footer>

    <?php else : ?>

      <!-- Entrada a una vista diferente -->

      <div class="login-box">
        <div class="login-logo">
          <img src="../assets/images/logo_IEM.png" width="40%" height="auto">
          <h4><strong>Bienvenido Control</strong></h4>

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
                <a href="../" class="btn btn-default btn-block btn-flat"><i class="fa fa-arrow-left"></i> Ir al Inicio</a>
              </div><!-- /.col -->
            </div>
          </form>

        </div><!-- /.login-box-body -->
        

      </div><!-- /.login-box -->

    <?php endif; ?>

  </div><!-- ./wrapper -->
<center>© <?php echo date('Y') ?> System V4.0 - Instituto Ejecutivo Mexicano <br> Powered - <small>by CodigoVAP</small></center>

 <!-- Modal Reporte de Deudores -->
<div class="modal fade" id="m_reporte1" tabindex="-1" role="dialog" aria-labelledby="m_reporte1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generación de reporte de adeudos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h5>Seleccione un rango de fechas a generar el reporte:</h4>
                    <div class="row">
                        <div class="input-group input-daterange">
                            <div class="input-group-addon" for="start_date">De</div>
                            <input type="date" name="start_date" id="start_date" class="form-control" require>
                            <div class="input-group-addon" for="end_date">Hasta</div>
                            <input type="date" name="end_date" id="end_date" class="form-control" require>
                        </div>
                    </div>
					<br>
					<div class="row">
                        <div class="input-group input-daterange">
                            <div class="input-group-addon" for="start_date">Opciones</div>
                            <select name="opcion" id="opcion" class="form-control">
								<option value="0" selected>Todos activos</option>
								<option value="1">Solo Baja administrativa</option>
								<option value="2">Solo Baja temporal</option>
								<option value="3">Solo Baja definitiva</option>
								<option value="4">Solo Baja académica</option>
								<option value="6">Solo Egresados titulado</option>
								<option value="7"> Solo Egresados en vía de titulación</option>
							</select>
                        </div>
                    </div>
                    <h5 id="errorMessage" class="text-danger text-center"></h5>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-img" id="generar_reporte1">
                    <img src="https://download.logo.wine/logo/Microsoft_Excel/Microsoft_Excel-Logo.wine.png" alt="Imagen" height="20px">
                    Generar Reporte
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal Reporte de Pagos -->
<div class="modal fade" id="m_reporte2" tabindex="-1" role="dialog" aria-labelledby="m_reporte2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Generación de reporte de pagos</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <!-- FECHAS -->
                <h6>Seleccione un rango de fechas:</h6>
                <div class="row mb-3">
                    <div class="col">
                        <label>De</label>
                        <input type="date" name="start_date2" id="start_date2" class="form-control" required>
                    </div>
                    <div class="col">
                        <label>Hasta</label>
                        <input type="date" name="end_date2" id="end_date2" class="form-control" required>
                    </div>
                </div>

                <!-- TIPO DE REPORTE -->
                <h6>Tipo de reporte:</h6>
                <div class="form-group">
                    <select name="tipo_reporte2" id="tipo_reporte2" class="form-control">
                        <option value="general">General (Todos los alumnos)</option>
                        <option value="alumno">Por alumno</option>
                    </select>
                </div>

                
                <div class="form-group" id="contenedor_alumno2" style="display:none;">
					<label>Seleccionar alumno:</label>
					<select name="alumno_id2" id="alumno_id2" class="form-control">
						<option value="">Cargando alumnos...</option>
					</select>
				</div>

                <!-- PERIODO (FILTRO OPCIONAL) -->
                <!-- <div class="form-group">
                    <label>Periodo (opcional):</label>
                    <select name="periodo_id2" id="periodo_id2" class="form-control">
                        <option value="">Cargando periodos</option>
                    </select>
                </div> -->

                <!-- ERROR -->
                <h6 id="errorMessage2" class="text-danger text-center"></h6>

            </div>

            <div class="modal-footer">
                <button class="btn btn-success" id="generar_reporte2">
                    Generar Reporte
                </button>
            </div>

        </div>
    </div>
</div>
</body>

</html>

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

        url: "core/app/ajax/ajax_notificaciones.php",

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



    setInterval(function() {

      load_unseen_notification();;

    }, 5000);



  });

	//Modal Adeudos
	$(document).on("click", "#btn_modalreporte1", function(e) {
		$('#m_reporte1').modal('show');
	});
	
	$(document).on("click", "#generar_reporte1", function(e) {
		var start_date = $("#start_date").val();
		var end_date = $("#end_date").val();
		var opcion = $("#opcion").val();

		// console.log(start_date);
		// console.log(end_date);
		// console.log(opcion);
		// return
		if (start_date.length === 0 || end_date.length === 0) {
			$("#errorMessage").html("Debes colocar una fecha de inicio y fin para generar el reporte");
			setTimeout(function() {
				$("#errorMessage").empty(); // Vaciar el contenido del elemento
			}, 5000); // 5000 milisegundos = 5 segundos
		} else {
			
			window.open("index.php?view=reporte_adeudos&start_date=" + start_date + "&end_date=" + end_date + "&opcion=" + opcion);

			setTimeout(function() {
				$("#start_date").val("");
				$("#end_date").val("");
				$("#opcion").val("0");
				$('#m_reporte1').modal('hide');
			}, 1500);
		}

	});

	//Modal pagos
	$(document).on("click", "#btn_modalreporte2", function(e) {
		$("#m_reporte2").modal('show');
	});

	//Al abrir el modal se cargan alumnos
	$('#m_reporte2').on('shown.bs.modal', function () {
		$.ajax({
			url: './core/app/ajax/get_alumnos.php',
			success: function(response) {
				$('#alumno_id2').html(response);

				// ACTIVAR SELECT2 AQUÍ
				$('#alumno_id2').select2({
					dropdownParent: $('#m_reporte2'),
					placeholder: "Buscar alumno...",
					allowClear: true,
					width: '100%'
				});
			}
		});

		// $.ajax({
		// 	url: './core/app/ajax/get_periodos.php',
		// 	success: function(response) {
		// 		$('#periodo_id2').html(response);

		// 		// ACTIVAR SELECT2 AQUÍ
		// 		$('#periodo_id2').select2({
		// 			dropdownParent: $('#m_reporte2'),
		// 			placeholder: "Buscar periodo...",
		// 			allowClear: true,
		// 			width: '100%'
		// 		});
		// 	}
		// });
	});

	// Generar reporte
	$(document).on("click", "#generar_reporte2", function(e) {

		var start_date = $("#start_date2").val();
		var end_date = $("#end_date2").val();
		var tipo_reporte = $("#tipo_reporte2").val();
		var alumno_id = $("#alumno_id2").val();
		// var periodo_id = $("#periodo_id2").val();

		if (start_date.length === 0 || end_date.length === 0) {
			$("#errorMessage2").html("Debes colocar una fecha de inicio y fin");
			setTimeout(() => $("#errorMessage2").empty(), 5000);
			return;
		}

		// Validación extra si es por alumno
		if (tipo_reporte === 'alumno' && alumno_id === "") {
			$("#errorMessage2").html("Debes seleccionar un alumno");
			setTimeout(() => $("#errorMessage2").empty(), 5000);
			return;
		}

		// URL dinámica
		var url = "index.php?view=reporte_pagos"
			+ "&start_date=" + start_date
			+ "&end_date=" + end_date
			+ "&tipo_reporte=" + tipo_reporte
			+ "&alumno_id=" + (alumno_id || "")
			// + "&periodo_id=" + (periodo_id || "");

		window.open(url);

		// Limpiar y cerrar
		setTimeout(function() {
			$("#start_date2").val("");
			$("#end_date2").val("");
			$("#tipo_reporte2").val("general");
			$("#alumno_id2").val("");
			// $("#periodo_id2").val("");
			$("#contenedor_alumno2").hide();
			$('#m_reporte2').modal('hide');
		}, 1000);

	});

	// Mostrar/ocultar selector de alumno
	$(document).on("change", "#tipo_reporte2", function () {
		if ($(this).val() === 'alumno') {
			$("#contenedor_alumno2").show();
		} else {
			$("#contenedor_alumno2").hide();
			$("#alumno_id2").val("");
		}
	});
</script>