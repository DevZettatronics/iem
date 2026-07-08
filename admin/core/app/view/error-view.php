<?php $user = UserData::getById($_GET["id"]);?>
		
		
<!--------------->
			
			
<form class="form-horizontal" method="post" id="addproduct" action="" role="form">
			
		<div class="small-box bg-yellow">
		<div class="inner">
			<h5 align="left"><i class='fa fa-tasks'></i> <strong>Bienvenido Administrador</strong></h5>
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
    <label for="inputEmail1" class="col-lg-2 control-label">Te haz identificado como:</label>
    <div class="col-md-6">
      <input type="text" name="name" value="<?php echo $user->name;?> <?php echo $user->lastname;?>" class="form-control" id="name" placeholder="Nombre" disabled="disabled">
    </div>
  </div>

		<div class="form-group">
    		<label for="inputEmail1" class="col-lg-2 control-label">
				<i class="	glyphicon glyphicon-user"></i> Usuario de Sistema*</label>
    		<div class="col-md-6">
      		<input type="text" name="username" value="<?php echo $user->username;?>" class="form-control" required id="username" placeholder="Nombre de usuario" disabled="disabled">
    		</div>
  		</div>		
	
<!-- Log de acceso-->
	
<form class="form-horizontal" name="form1" method="post" action="http://cals.ugestalt.edu.mx/viserion/teacher/index.php?view=verificar">  
	
		 		<div class="form-group">
				<label for="inputEmail1" class="col-lg-2 control-label">
					Para ingresar al contenedor, deberás ingresar tu año de nacimiento*</label>
					<div class="col-md-6">

				<div id="ErrorMensaje">	
					
				<h3><i class="glyphicon glyphicon-remove"></i> <font color="#550404"><b>Error! </b></font><font color="#B10C0C" ><b>Tus datos son incorrectos.</b></font></h3>
				</i>
				</div>

					</div>
				</div>
						
				<a href="./?view=contenedordocente&id=<?php if (isset($_SESSION["user_id"])) {
                                                            echo UserData::getById($_SESSION["user_id"])->id;
                                                          } ?>" class="btn btn-lg btn-danger btn-block btn-signin"><i class="fa fa-arrow-left"></i> Volver a Intentar</a> 

		 		<div class="form-group" style="visibility:hidden;">
				<label for="inputEmail1" class="col-lg-2 control-label">
					Usuario Validador*</label>
					<div class="col-md-6">
						<input name="code" type="tel" class="form-control" placeholder="Usuario" id="username" aria-describedby="sizing-addon1" value="<?php echo $user->code;?>">
					</div>
				</div>
		 	
	

		 
</form>
