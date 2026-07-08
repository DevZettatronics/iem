<?php $user = PersonData::getById($_GET["id"]);?>

		

<!--------------->

<html lang="es">	



<a href="./?view=home" class="btn btn-dark" style="color: #62AED2;"><i class="fa fa-arrow-left"></i> Regresar</a>

<form class="form-horizontal" method="post" id="addproduct" action="" role="form">

			

		<div class="small-box bg-maroon">

		<div class="inner">

			<h5 align="left"><i class='fa fa-tasks'></i> <strong>Repositorio de Constancias</strong></h5>

		</div>

        </div>

		



	  <div class="col-xl-3 col-sm-9 mb-xl-5 mb-4">

        <div class="card" >

            <div class="card-header p-3 pt-2">

               

                <div class="icon icon-3xl icon-shape shadow-dark text-center border-radius-xl mt-n4 position-absolute" style="background-color: #d81b60;">

                    <i class="material-icons opacity-10">inventory_2</i>

                    

                </div>

                <div class="text-end pt-1">

                    <p class="text-5xl mb-0 text-capitalize">Expediente IEM</p>

                    <img src="../storage/posts/aguila_dorada.png" width="100px" style="opacity: 0.3;position: absolute;top: 45px;left: 50%;">

                    <h4 class="mb-0" style="color: #FFFFFF;">.</h4>

                </div>    

                

                <div class="pt-1">    

                    <label for="inputEmail1" class="col-lg control-label text-left">Nombre completo:</label>

                    <input type="text" name="name" value="<?php echo $user->name;?> <?php echo $user->lastname;?>" class="form-control" id="name" placeholder="Nombre" disabled="disabled">

                    

                    <label for="inputEmail1" class="col-lg control-label text-left">Correo Institucional:</label>

                    <input type="text" name="email" value="<?php echo $user->email;?>" class="form-control" id="email" placeholder="Email" disabled="disabled">

                    

                </div>

            </div>

            <hr class="dark horizontal my-0">

            <div class="card-footer p-3">



                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"> </span>Descarga las <strong>Constancias</strong> que obtengas de los cursos del Instituto Ejecutivo Mexicano</p>

            



        </div><!-- Cierre de Card-->

    </div><!-- Cierre de Card-->	

		

</form>	

<br>	

<!-- Log de acceso-->

	

<form class="form-horizontal" name="form1" method="post" action="https://aula.iemueem.edu.mx/Servicios/iem/teacher/index.php?view=verificar_constancias">  

						





			 	<div class="form-group" style="visibility:hidden;">

					<div class="col-md-6">

						<select name="year" type="password" class="form-control" aria-describedby="sizing-addon1" required style="width: 255px" required>

						<option value="<?php echo $user->year;?>" selected><?php echo $user->year;?></option>

						</select>

					</div>

				</div>



				<button class="btn btn-lg btn-info btn-block btn-signin" id="IngresoLog" type="submit">Ver Constancias Digitales</button>

				

				

				

		 		<div class="form-group" style="visibility:hidden;">

				<label for="inputEmail1" class="col-lg-2 control-label">

					Usuario Validador*</label>

					<div class="col-md-6">

						<input name="code" type="tel" class="form-control" placeholder="Usuario" id="username" aria-describedby="sizing-addon1" value="<?php echo $user->code;?>">

					</div>

				</div>	





</div><!-- Cierre de Card-->

		 

</form>

		 <!--Errores-->

			<?PHP if ($_GET["errorusuario"]=="si")

			{

			?>

				<div id="ErrorMensaje">	

					

				<i class="glyphicon glyphicon-remove"></i> <font color="#550404"><b>Error! </b></font><font color="#B10C0C" ><b>Tus datos son incorrectos.</b></font></i>

				</div>

			<? 

			}

		 	if ($_GET["errorusuario"]=="false")

			{

			?>

			<div id="ErrorMensaje2">			

				<i class="glyphicon glyphicon-remove"></i> <font color="#550404"><b>Acceso Denegado! </b></font></br><font color="#B10C0C" ><b>No tienes permiso para igresar.</b></font></i>

				</div>



			<? 

			}

		 	if ($_GET["ayuda"]=="no")

			{

			?>

			<div id="ErrorMensaje3">			

				<i class="glyphicon glyphicon-ok"></i> <font color="#550404"><b>Acceso Denegado</b></font></br><font color="##92840C" ><b>No se pueden recuperar los datos</b></font></i>

				</div>



			<? 

			}

			?>



	

		