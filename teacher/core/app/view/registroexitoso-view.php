
<?php $user = PersonData::getById($_GET["id"]);?>

<section class="content-header">
      <h1>Mis Cursos <small>Gestalt y Más...</small></h1>
</section>

<?php /*?><section class="content">
<div class="row">
  <div class="col-md-12">

      <div class="row">

        <div class="col-lg-3 col-xs-6"></div>
		  

		<div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-maroon">
            <div class="inner">
              <h3><i class='fa fa-user'></i></h3>
              <p>Mis Constancias Digitales</p>
            </div>
            <div class="icon">
              <i class="fa fa-heart"></i>
            </div>
            <a href="index.php?view=miexpediente&id=<?php if (isset($_SESSION["teacher_id"])) {
                                                            echo PersonData::getById($_SESSION["teacher_id"])->id;
                                                          } ?>" class="small-box-footer">Ir <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <!--- - - - - - - - - - - - - - - - - - -->

</div>
</div>
</div>



</section><?php */?>


<form class="form-horizontal" method="post" id="addproduct" action="" role="form">
			
		<div class="small-box bg-aqua">
		<div class="inner">
			<h5 align="left"><i class='fa fa-tasks'></i> <strong>Datos de Registro del Docente</strong></h5>
		</div>
        </div>
	

<!--	<div class="form-group">
    	<label for="inputEmail1" class="col-lg-2 control-label" >Esta activo</label>
    	<div class="col-md-6">
			<div class="checkbox">
    			<label>
      		<input type="checkbox" name="is_active" disabled="disabled"<?php if($user->is_active){ echo "checked";}?>> 
    			</label>
  			</div>
    	</div>
  	</div>-->
	
</form>	
	
<!-- Log de acceso-->
	
<form class="form-horizontal" name="form" method="post" >  

<div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Correo Institucional</label>
    <div class="col-md-6">
      <input type="text" name="email" value="<?php echo $user->email;?>" class="form-control" id="email" placeholder="Email" disabled="disabled">
    </div>
  </div>
	
	<div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre del Docente</label>
    <div class="col-md-6">
      <input type="text" name="name" value="<?php echo $user->name;?> <?php echo $user->lastname;?>" class="form-control" id="name" placeholder="Nombre" disabled="disabled">
    </div>
  </div>
	
			 	<div class="form-group" >
    	<label for="inputEmail1" class="col-lg-2 control-label" >Usted ya tiene un registro</label>
    	<div class="col-md-6">
			<div class="checkbox">
    			<label>
      		<input type="checkbox" name="is_active" disabled="disabled"<?php if($user->is_active){ echo "checked";}?>> 
    			</label>
  			</div>
    	</div>
  	</div>
	<!---  Botones -->
	<div class="form-group" >
    	<label for="inputEmail1" class="col-lg-2 control-label" >Curso Moodle - 16:00 a 18:00 hrs</label>
    	<div class="col-md-6">
			<div class="checkbox">
    			<label>
      		
					<a href="https://meet.google.com/ocz-fenw-oxj" target="_blank" class="btn btn-sm btn-success btn-block btn-signin">Clic aquí para ir a la Sesión de Meet  <i class="fa fa-arrow-right"></i> </a>
					
					
    			</label>
  			</div>
    	</div>
  	</div>

	
		<div class="form-group" >
    	<label for="inputEmail1" class="col-lg-2 control-label" >Diseño de Cursos a Distancia - 18:00 a 20:00 hrs</label>
    	<div class="col-md-6">
			<div class="checkbox">
    			<label>
      		
					<a href="https://meet.google.com/zof-ieiv-yog" target="_blank" class="btn btn-sm btn-success btn-block btn-signin">Clic aquí para ir a la Sesión de Meet  <i class="fa fa-arrow-right"></i></a>
					
					
    			</label>
  			</div>
    	</div>
  	</div>
		
	<!---  Hasta aquí llegan los Botones -->
	
	
				<a href="index.php?view=home" class="btn btn-lg btn-danger btn-block btn-signin"><i class="fa fa-arrow-left"></i> Regresar</a>
	

		 	
		 		<div class="form-group" style="visibility:hidden;">
				<label for="inputEmail1" class="col-lg-2 control-label">
					Usuario Validador*</label>
					<div class="col-md-6">
						<input name="code" type="tel" class="form-control" placeholder="Usuario" id="username" aria-describedby="sizing-addon1" value="<?php echo $user->code;?>">
					</div>
				</div>	


</form>

