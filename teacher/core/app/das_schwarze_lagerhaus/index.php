<?PHP


include ("seguridad1B.php");

//include ("seguridad1A.php");



?>



<?php include "gestor.php"; ?>



<html>

<html lang="es">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	

	<title>Gestor de Documentos</title>

	

	<link rel="shortcut icon" href="1344869552_icontexto-green-01.ico" type="image/x-icon" />

   	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>

	

	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; minimum-scale=1.0; user-scalable=no; target-densityDpi=device-dpi" />

	<meta charset="UTF-8">

	

	<?php if($listing->enableTheme): ?>

		<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/yeti/bootstrap.min.css" rel="stylesheet" integrity="sha256-gJ9rCvTS5xodBImuaUYf1WfbdDKq54HCPz9wk8spvGs= sha512-weqt+X3kGDDAW9V32W7bWc6aSNCMGNQsdOpfJJz/qD/Yhp+kNeR+YyvvWojJ+afETB31L0C4eO0pcygxfTgjgw==" crossorigin="anonymous">

	<?php endif; ?>

	

	

	

    <link href="../css/estilos.css" rel="stylesheet" type="text/css">

	<link href="css/estilos_adv.css" rel="stylesheet" type="text/css">	

	

	

	<!--Barra de Navegacion-->

	

	<meta charset="utf-8">

  	<meta name="viewport" content="width=device-width, initial-scale=1">

  	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

  	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>



</head>

	

<body>

	

<?php



if($_SESSION['1A']=true) 

{

?>

<div id="salir"><a href="../salida.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('logout','','images/logout-2.png',1)"><img src="../images/logout.png" alt="logout" name="logout" width="100" height="22" border="0" hidden="false"></a></div>

<?php

}

else {



{

	?>

	 

	<div id="salir"><a href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('login','','images/login-2.png',1)"><img src="../images/login.png" alt="login" name="login" width="100" height="22" border="0" ></a></div>

	<p>

	  <?php

	}		

}		

?>

  

	

	

	<!-- Barra de Navegacion  -->

	<nav class="navbar navbar-inverse" style="background-color: #222d32;">

  <div class="container-fluid">

    <div class="navbar-header">

      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">

        <span class="icon-bar"></span>

        <span class="icon-bar"></span>

        <span class="icon-bar"></span>                        

      </button>

		

    <!-- Localhost -->
	<!--<span><img src="http://localhost/Zettatronics/iem/assets/images/logo_blanco_acostado.png" width="100px" height="auto"></span>-->

	<!-- Developer -->
	<!-- <span><img src="https://aula.iemueem.edu.mx/Developer/iem/assets/images/logo_blanco_acostado.png" width="100px" height="auto"></span> -->

	<!-- UAT -->
	<!-- <span><img src="https://aula.iemueem.edu.mx/UAT/iem/assets/images/logo_blanco_acostado.png" width="100px" height="auto"></span> -->

	<!-- Servicios -->
	 <span><img src="https://aula.iemueem.edu.mx/Servicios/iem/assets/images/logo_blanco_acostado.png" width="100px" height="auto"></span> 


    </div>

    <div class="collapse navbar-collapse" id="myNavbar">

      <ul class="nav navbar-nav">

			<li class="active"><a href="#">Contenedor Digital</a></li>

		  	<li ><a href="../../../index.php?view=home">Regresar a Inicio</a></li>

      </ul>

      <ul class="nav navbar-nav navbar-right">

        <li><a href="../das_schwarze_lagerhaus/salida.php"><span class="glyphicon glyphicon-log-in"></span> Cerrar Sesion</a></li>

      </ul>

    </div>

  </div>

</nav> 



	

 	<!-- Datos del Usuario 

	

	<div id="usuario" class="container_principal" style="height: 159px;">

			

			<span>

				<h4>Información del Estudiante</h4</br>			

				<div>

    				<h4> <strong style=" color: #07224B; font-size: 12px;">

						Nombre:</br>

						Apellido Paterno: </br>

						Apellido Materno: </br>

						Tipo de Estudios: </br>

						Oferta Educativa: </br>

						Modalidad: </br>

						Folio Control: </br>

					</h4>

  				</div>



  				<div i style="position: relative; border-color: transparent; left: 122px; top: -140px; color: #FC6;">

    			 <strong style="font-family: 'Times New Roman', Times, serif; color: #666; font-size: 14px;"><?PHP echo $_SESSION['nombre'];?></strong>   

				</div>

				

				<div i style="position: relative; border-color: transparent; left: 122px; top: -135px; color: #FC6;">

    			 <strong style="font-family: 'Times New Roman', Times, serif; color: #666; font-size: 14px;"><?PHP echo $_SESSION['apellido_paterno'];?></strong>   

				</div>

	

				<div i style="position: relative; border-color: transparent; left: 122px; top: -130px; color: #FC6;">

    			 <strong style="font-family: 'Times New Roman', Times, serif; color: #666; font-size: 14px;"><?PHP echo $_SESSION['apellido_materno'];?></strong>   

				</div>

	

				<div i style="position: relative; border-color: transparent; left: 122px; top: -125px; color: #FC6;">

    			 <strong style="font-family: 'Times New Roman', Times, serif; color: #666; font-size: 14px;"><?PHP echo $_SESSION['tel'];?></strong>   

				</div>

			

				<div i style="position: relative; border-color: transparent; left: 122px; top: -120px; color: #FC6;">

    			 <strong style="font-family: 'Times New Roman', Times, serif; color: #666; font-size: 14px;"><?PHP echo $_SESSION['tipo_tel'];?></strong>   

				</div>



				<div i style="position: relative; border-color: transparent; left: 122px; top: -115px; color: #FC6;">

    			 <strong style="font-family: 'Times New Roman', Times, serif; color: #666; font-size: 14px;"><?PHP echo $_SESSION['tipo_registro'];?></strong>   

				</div>

				

				<div i style="position: relative; border-color: transparent; left: 122px; top: -110px; color: #FC6;">

    			 <strong style="font-family: 'Times New Roman', Times, serif; color: #666; font-size: 14px;"><?PHP echo $_SESSION['folio_control'];?></strong>   

				</div>

            </span>

		</div>



	-->

	<div class="container-fluid" style="margin: 20px;">

	

		<div class="small-box bg-yellow" style="background-color: #f39c12 !important; border-left: 15px solid #092944; box-shadow: 0 12px 20px -10px rgb(0 0 0 / 78%), 0 4px 20px 0px rgb(0 0 0 / 12%), 0 7px 8px -5px rgb(0 188 212 / 20%);padding-top: 12px;">

			

		<div class="inner">

			<h4 align="left" style="margin-left: 13px"><strong><?php echo $listing->pageTitle; ?></strong></h4>

			

			<h4 align="left" style="margin-left: 13px">

				<i class="	glyphicon glyphicon-list-alt"></i>

				<strong style=" color: #FFFFFF; font-size: 12px;">

					No de Registro: <?PHP echo $_SESSION['id'];?></strong></br>

			</h4>

			<h4 align="left" style="margin-left: 13px"> 

				<i class="	glyphicon glyphicon-user"></i> 

				<strong style=" color: #FFFFFF; font-size: 13px;">

					Nombre Completo: <?PHP echo $_SESSION['name'];?> <?PHP echo $_SESSION['lastname'];?></strong> </br></br>

			</h4>	

		</div>

    </div>		

			

</div>



	<!-- Contenedor  Principal -->

	

     <div id="contenido_interior">

      

		<div id="repositorio">

		<div id="container">



	<div class="container-fluid" style="margin-left: 50px; margin-right: 50px;">

<?php /*?>		<?php if (! empty($listing->pageTitle)): ?><br />

			<div class="row">

				<div class="col-xs-12">

					<h1 class="text-center"><?php echo $listing->pageTitle; ?></h1>

				</div>

			</div>

		<?php endif; ?><?php */?>



		<?php if (! empty($successMsg)): ?>

			<div class="alert alert-success"><?php echo $successMsg; ?></div>

		<?php endif; ?>



		<?php if (! empty($errorMsg)): ?>

			<div class="alert alert-danger"><?php echo $errorMsg; ?></div>

		<?php endif; ?>





		<?php if ($data['requirePassword'] && !isset($_SESSION['evdir_loggedin'])): ?>



			<div class="row">

				<div class="col-xs-12">

				<hr>

					<form action="" method="post" class="text-center form-inline">

						<div class="form-group">

							<label for="password">Password:</label>

							<input type="password" name="password" class="form-control">

							<button type="submit" class="btn btn-primary">Login</button>

						</div>

					</form>

				</div>

			</div>



		<?php else: ?>



			<?php if(! empty($data['directoryTree'])): ?>

				<div class="row">

					<div class="col-xs-12">

						<ul class="breadcrumb">

						<?php foreach ($data['directoryTree'] as $url => $name): ?>

							<li>

								<?php

								$lastItem = end($data['directoryTree']);

								if($name === $lastItem):

									echo $name;

								else:

								//echo "aquí estoy";

								?>

									<!--<a href="?dir=<?php //echo $url; ?>">-->

										<?php //echo $name;

										//echo $_SESSION["directorio"];

										 ?>

									<!--</a>-->

								<?php

								endif;

								?>

							</li>

						<?php endforeach; ?>

						</ul>

					</div>

				</div>

			<?php endif; ?>



<?php /*?>

			<?php if(! empty($data['directoryTree'])): ?>

				<div class="row">

					<div class="col-xs-12">

						<ul class="breadcrumb">

						<?php foreach ($data['directoryTree'] as $url => $name): ?>

							<li>

								<?php

								$lastItem = end($data['directoryTree']);

								if($name === $lastItem):

									echo $name;

								else:

								//echo "aquí estoy";

								?>

									<a href="?dir=<?php echo $url; ?>">-->

										<?php echo $name;

										echo $_SESSION["directorio"];

										 ?>

									</a>

								<?php

								endif;

								?>

							</li>

						<?php endforeach; ?>

						</ul>

					</div>

				</div>

			<?php endif; ?><?php */?>



<!--Crea un nuevo directorio-->

				<div class="row">

					<div class="col-xs-12">

						<div class="table-container">

							<table class="table table-striped table-bordered">

								<?php if (! empty($data['directories'])): ?>

									<thead>

										<th>Directorio</th>

									</thead>

									<tbody>

										<?php foreach ($data['directories'] as $directory): ?>

											<tr>

												<td>

													<a href="<?php echo $directory['url']; ?>" class="item dir">

														<?php echo $directory['name']; ?>

													</a>



													<?php if ($listing->enableDirectoryDeletion): ?>

														<span class="pull-right">

															<a href="<?php echo $directory['url']; ?>&delete=true" class="btn btn-danger btn-xs" onClick="return confirm('Estas a punto de borrar un directorio. La información contenida se eliminará sin poder recuperar. ¿Deseas continuar? ')">Eliminar Directorio</a>

														</span>

													<?php endif; ?>

												</td>



											</tr>

										<?php endforeach; ?>

									</tbody>

								<?php endif; ?>



								<?php if($listing->enableDirectoryCreation): ?>

								<tfoot>

<!--									<tr>

										<td>

											<form action="" method="post" class="text-center form-inline">

												<div class="form-group">

													<label for="directory">Nombre de nuevo directorio:</label>

													<input type="text" name="directory" id="directory" class="form-control">

													<button type="submit" class="btn btn-primary" name="submit">Crear directorio</button>

												</div>

											</form>

										</td>

									</tr>-->

								</tfoot>

								<?php endif; ?>

							</table>

						</div>

					</div>

				</div>

<!--Crea un nuevo directorio-->

		

		

			<?php if ($data['enableUploads']): ?>

				<div class="row">

					<div class="col-xs-12">

                    <p align="justify">

					Para generar la contratación de nuestro equipo docente, deberá hacernos llegar por este medio su documentación en fortmato PDF.<br><br>

					<strong>1.- Datos Personales</strong> <br>

						<ul>

						<li>CURP,</li>

						<li>Acta de Nacimiento,</li>

						<li>INE, </li>

						<li>Comprobante de Domicilio</li>

						</ul>

					<strong>2.- Datos Profesionales</strong>

						<ul>

						<li>CV Actualizado, </li>

						<li>Título y Cédula de Licenciatura, </li>

						<li>Título y Cédula Posgrado (en caso de contar con elos)</li>

						</ul>

					<strong>3.- Para Efectuar su Pago</strong>

						<ul>

						<li>Carátula del Estado de Cuenta Bancaria - Deberá mostrar, el nombre del docente, el número de cuenta y CLABE interbancaria</li> 

						<li>Cédula de Identificación Fiscal (SAT) que incluya el régimen fiscal</li></br>

                  </div>

		

<!--  Agrega otro archivo -->  

		

                  <div class="col-xs-12">

						<form action="" method="post" enctype="multipart/form-data" class="text-center upload-form form-vertical">

							<h4>Subir archivo</h4>

							<div class="row upload-field">

								<div class="col-xs-12">

									<div class="form-group">

										<div class="row">

											<div class="col-sm-2 col-md-2 col-md-offset-3 text-right">

												<label for="upload">Archivo:</label>

											</div>

											<div class="col-sm-10 col-md-4">

												<input type="file" name="upload[]" id="upload" class="form-control">

											</div>

										</div>

									</div>

								</div>

							</div>

							<hr>

							<?php if ($listing->enableMultiFileUploads): ?>

								<div class="row">

									<div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-2 col-lg-3 col-lg-offset-2">

										<button type="button" class="btn btn-success btn-block" name="add_file">Agregar otro archivo</button>

									</div>

									<div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-1 col-lg-3 col-lg-offset-2">

										<button type="submit" class="btn btn-primary btn-block" name="submit">Subir archivos</button>

									</div>

								</div>

							<?php else: ?>

								<div class="row">

									<div class="col-xs-12 col-sm-6 col-sm-offset-3">

										<button type="submit" class="btn btn-primary btn-block" name="submit">Subir archivo</button>

									</div>

								</div>

							<?php endif; ?>

						</form>

					</div>

				</div>

			<?php endif; ?>



			

			<?php if (! empty($data['files'])): ?>

				<div class="row">

					<div class="col-xs-12">

						<div class="table-container">

							<table class="table table-striped table-bordered">

								<thead>

									<tr>

										<th>

											<a href="<?php echo $listing->sortUrl('name'); ?>">Archivo <span class="<?php echo $listing->sortClass('name'); ?>"></span></a>

										</th>

										<th class="text-right xs-hidden">

											<a href="<?php echo $listing->sortUrl('size'); ?>">Tamaño <span class="<?php echo $listing->sortClass('size'); ?>"></span></a>

										</th>

										<th class="text-right sm-hidden">

											<a href="<?php echo $listing->sortUrl('modified'); ?>">Última modificación <span class="<?php echo $listing->sortClass('modified'); ?>"></span></a>

										</th>

									</tr>

								</thead>

								<tbody>

								<?php foreach ($data['files'] as $file): ?>

									<tr>

										<td>

											<a href="<?php echo $file['url']; ?>" target="<?php echo $file['target']; ?>" class="item _blank <?php echo $file['extension']; ?>">

												<?php echo $file['name']; ?>

											</a>

											<?php if (isset($file['preview']) && $file['preview']): ?>

												<span class="preview"><img src="?preview=<?php echo $file['relativePath']; ?>"><i class="preview_icon"></i></span>

											<?php endif; ?>

											

											<?php if ($listing->enableFileDeletion == true): ?>

												<a href="?deleteFile=<?php echo urlencode($file['relativePath']); ?>" class="pull-right btn btn-danger btn-xs" onClick="return confirm('¿Estas seguro que deseas borrar el Documento?')">Borrar</a>

											<?php endif; ?> 

										</td>

										<td class="text-right xs-hidden"><?php echo $file['size']; ?></td>

										<td class="text-right sm-hidden"><?php echo date('M jS Y \a\t g:ia', $file['modified']); ?></td>

									</tr>

								<?php endforeach; ?>

								</tbody>

							</table>

						</div>

					</div>

				</div>

			<?php else: ?>

				<div class="row">

					<div class="col-xs-12">

						<p class="alert alert-info text-center">El directorio no contiene ningún archivo.</p>

					</div>

				</div>

			<?php endif; ?>

		<?php endif; ?>

		<div class="row">

		</div>

	</div>

	<?php if ($listing->enableMultiFileUploads): ?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

		<script>

			$('button[name=add_file]').on('click', function(e) {

				e.preventDefault();

				$('.upload-field:last').clone().insertAfter('.upload-field:last').find('input').val('');



			});

		</script>

	<?php endif; ?>



         </div>





</div>

</div>

</div>

</div>

</body>

</html>