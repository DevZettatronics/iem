<?php $user = PersonData::getById($_GET["id"]);?>
		
		
<!--------------->
			
<form class="form-horizontal" method="post" id="addproduct" action="" role="form">
			
		<div class="small-box bg-yellow">
		<div class="inner">
			<h5 align="left"><i class='fa fa-tasks'></i> <strong>Datos de Acceso del Docente</strong></h5>
		</div>
        </div>
					
	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-2 control-label" >Esta activo</label>
    	<div class="col-md-6">
			<div class="checkbox">
    			<label>
      		<input type="checkbox" name="is_active" disabled="disabled"<?php if($user->is_active){ echo "checked";}?>> 
    			</label>
  			</div>
    	</div>
  	</div>
						
<div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Correo Institucional*</label>
    <div class="col-md-6">
      <input type="text" name="email" value="<?php echo $user->email;?>" class="form-control" id="email" placeholder="Email" disabled="disabled">
    </div>
  </div>
				
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="name" value="<?php echo $user->name;?>" class="form-control" id="name" placeholder="Nombre" disabled="disabled">
    </div>
  </div>
	
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Apellido*</label>
    <div class="col-md-6">
      <input type="text" name="lastname" value="<?php echo $user->lastname;?>" required class="form-control" id="lastname" placeholder="Apellido" disabled="disabled">
    </div>
	</div>

		<div class="form-group">
    		<label for="inputEmail1" class="col-lg-2 control-label">
				<i class="	glyphicon glyphicon-user"></i> Usuario de Sistema*</label>
    		<div class="col-md-6">
      		<input type="text" name="username" value="<?php echo $user->code;?>" class="form-control" required id="username" placeholder="Nombre de usuario" disabled="disabled">
    		</div>
  		</div>			
</form>	
	
<!-- Log de acceso-->
	
<form class="form-horizontal" name="form1" method="post" action="http://cals.gestalt.app/viserion/teacher/index.php?view=verificar">  
	
		 		<div class="form-group">
				<label for="inputEmail1" class="col-lg-2 control-label">
					Para validar tu información es necesario ingresar tu año de nacimiento*</label>
					<div class="col-md-6">

				<div id="ErrorMensaje">	
					
				<h3><i class="glyphicon glyphicon-remove"></i> <font color="#550404"><b>Error! </b></font><font color="#B10C0C" ><b>Tus datos son incorrectos.</b></font></h3>
				</i>
				</div>

					</div>
				</div>
						
				<a href="index.php?view=miexpediente&id=<?php if (isset($_SESSION["teacher_id"])) {
                                                            echo PersonData::getById($_SESSION["teacher_id"])->id;
                                                          } ?>" class="btn btn-lg btn-danger btn-block btn-signin"><i class="fa fa-arrow-left"></i> Volver a Intentar</a> 

		 		<div class="form-group" style="visibility:hidden;">
				<label for="inputEmail1" class="col-lg-2 control-label">
					Usuario Validador*</label>
					<div class="col-md-6">
						<input name="code" type="tel" class="form-control" placeholder="Usuario" id="username" aria-describedby="sizing-addon1" value="<?php echo $user->code;?>">
					</div>
				</div>
		 	
	

		 
</form>
