<?php $user = PersonData::getById($_GET["id"]); ?>

<!--------------->
<meta charset="UTF-8">
<html lang="es">
<a href="./?view=home" class="btn btn-dark" style="color: #62AED2;"><i class="fa fa-arrow-left"></i> Regresar</a>
<form class="form-horizontal" method="post" id="addproduct" action="" role="form">


	<div class="small-box bg-yellow">
		<div class="inner">
			<h5 align="left"><i class='fa fa-tasks'></i> <strong>Los Datos del Expediente Digital IEM son resguardados y tratados bajo la normatividad del Aviso de Privacidad.</strong></h5>
		</div>
	</div>



	  <div class="col-xl-3 col-sm-9 mb-xl-5 mb-4">
        <div class="card" >
            <div class="card-header p-3 pt-2">
               
                <div class="icon icon-3xl icon-shape shadow-dark text-center border-radius-xl mt-n4 position-absolute" style="background-color: #d2a12a;">
                    <i class="material-icons opacity-10">inventory_2</i>
                    
                </div>
                <div class="text-end pt-1">
                    <p class="text-5xl mb-0 text-capitalize">Expediente Docente</p>
                    <img src="../storage/posts/aguila_dorada.png" width="100px" style="opacity: 0.3;position: absolute;top: 45px;left: 50%;">
                    <h4 class="mb-0" style="color: #FFFFFF;">.</h4>
                </div>    
                <div class="pt-1">    
                    <label for="inputEmail1" class="col-lg control-label">Est&aacute;tus:</label>
                    <input type="checkbox" name="is_active" disabled="disabled" <?php if ($user->is_active) {
																					echo "checked";
																				} ?>> Activo
                    <br>
                    <label for="inputEmail1" class="col-lg control-label text-left">Nombre completo:</label>
                    <input type="text" name="name" value="<?php echo $user->name . ' ' . $user->lastname; ?>" class="form-control" id="name" placeholder="Nombre" disabled="disabled">
                    <label for="inputEmail1" class="col-lg control-label">Usuario de Sistema::</label>
                    <input type="text" name="username" value="<?php echo $user->code; ?>" class="form-control" required id="username" placeholder="Nombre de usuario" disabled="disabled">
                    <label for="inputEmail1" class="col-lg control-label">Correo Institucional:</label>
                    <input type="text" name="email" value="<?php echo $user->email; ?>" class="form-control" id="email" placeholder="Email" disabled="disabled">
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">

                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"> </span>Para poder ingresar es necesario ingresar su a&ntildeo de nacimiento*</p>
                
</form>
<br>
<!-- Log de acceso-->
<!-- Localhost -->
<!--<form name="form1" method="post" action="http://localhost/Zettatronics/iem/teacher/index.php?view=verificar">-->

<!-- Developer -->
<!-- <form name="form1" method="post" action="https://aula.iemueem.edu.mx/Developer/iem/teacher/index.php?view=verificar"> -->

<!-- UAT -->
<!-- <form name="form1" method="post" action="https://aula.iemueem.edu.mx/UAT/iem/teacher/index.php?view=verificar"> -->

<!-- Servicios -->
 <form name="form1" method="post" action="https://aula.iemueem.edu.mx/Servicios/iem/teacher/index.php?view=verificar"> 


	<div class="form-group">

		<div class="col-md-6">
			<select name="year" type="password" class="form-control" aria-describedby="sizing-addon1" required style="width: 200px" required>
				<option value="" selected>A&ntilde;o de Nacimiento</option>
				<option value="2016">2016</option>
				<option value="2015">2015</option>
				<option value="2014">2014</option>
				<option value="2013">2013</option>
				<option value="2012">2012</option>
				<option value="2011">2011</option>
				<option value="2010">2010</option>
				<option value="2009">2009</option>
				<option value="2008">2008</option>
				<option value="2007">2007</option>
				<option value="2006">2006</option>
				<option value="2005">2005</option>
				<option value="2004">2004</option>
				<option value="2003">2003</option>
				<option value="2002">2002</option>
				<option value="2001">2001</option>
				<option value="2000">2000</option>
				<option value="1999">1999</option>
				<option value="1998">1998</option>
				<option value="1997">1997</option>
				<option value="1996">1996</option>
				<option value="1995">1995</option>
				<option value="1994">1994</option>
				<option value="1993">1993</option>
				<option value="1992">1992</option>
				<option value="1991">1991</option>
				<option value="1990">1990</option>
				<option value="1989">1989</option>
				<option value="1988">1988</option>
				<option value="1987">1987</option>
				<option value="1986">1986</option>
				<option value="1985">1985</option>
				<option value="1984">1984</option>
				<option value="1983">1983</option>
				<option value="1982">1982</option>
				<option value="1981">1981</option>
				<option value="1980">1980</option>
				<option value="1979">1979</option>
				<option value="1978">1978</option>
				<option value="1977">1977</option>
				<option value="1976">1976</option>
				<option value="1975">1975</option>
				<option value="1974">1974</option>
				<option value="1973">1973</option>
				<option value="1972">1972</option>
				<option value="1971">1971</option>
				<option value="1970">1970</option>
				<option value="1969">1969</option>
				<option value="1968">1968</option>
				<option value="1967">1967</option>
				<option value="1966">1966</option>
				<option value="1965">1965</option>
				<option value="1964">1964</option>
				<option value="1963">1963</option>
				<option value="1962">1962</option>
				<option value="1961">1961</option>
				<option value="1960">1960</option>
				<option value="1959">1959</option>
				<option value="1958">1958</option>
				<option value="1957">1957</option>
				<option value="1956">1956</option>
				<option value="1955">1955</option>
				<option value="1954">1954</option>
				<option value="1953">1953</option>
				<option value="1952">1952</option>
				<option value="1951">1951</option>
				<option value="1950">1950</option>
				<option value="1949">1949</option>
				<option value="1948">1948</option>
				<option value="1947">1947</option>
				<option value="1946">1946</option>
				<option value="1945">1945</option>
				<option value="1944">1944</option>
				<option value="1943">1943</option>
				<option value="1942">1942</option>
				<option value="1941">1941</option>
				<option value="1940">1940</option>
				<option value="1939">1939</option>
				<option value="1938">1938</option>
				<option value="1937">1937</option>
				<option value="1936">1936</option>
				<option value="1935">1935</option>
				<option value="1934">1934</option>
				<option value="1933">1933</option>
				<option value="1932">1932</option>
				<option value="1931">1931</option>
				<option value="1930">1930</option>
			</select>


		</div>
	</div>

	<button class="btn btn-lg btn-info btn-block btn-signin" id="IngresoLog" type="submit">Ingresar al Contenedor</button>

        </div><!-- Cierre de Card-->
    </div><!-- Cierre de Card-->
</div><!-- Cierre de Card-->
    

	<div class="form-group" style="visibility:hidden;">
		<label for="inputEmail1" class="col-lg-2 control-label">
			Usuario Validador*</label>
		<div class="col-md-6">
			<input name="code" type="tel" class="form-control" placeholder="Usuario" id="username" aria-describedby="sizing-addon1" value="<?php echo $user->code; ?>">
		</div>
	</div>


</form>

<!--Errores-->
<?php  if ($_GET["errorusuario"] == "si") {
?>
	<div id="ErrorMensaje">

		<i class="glyphicon glyphicon-remove"></i>
		<font color="#550404"><b>Error! </b></font>
		<font color="#B10C0C"><b>Tus datos son incorrectos.</b></font></i>
	</div>
<?php 
}
if ($_GET["errorusuario"] == "false") {
?>
	<div id="ErrorMensaje2">
		<i class="glyphicon glyphicon-remove"></i>
		<font color="#550404"><b>Acceso Denegado! </b></font></br>
		<font color="#B10C0C"><b>No tienes permiso para igresar.</b></font></i>
	</div>

<?php
}
if ($_GET["ayuda"] == "no") {
?>
	<div id="ErrorMensaje3">
		<i class="glyphicon glyphicon-ok"></i>
		<font color="#550404"><b>Acceso Denegado</b></font></br>
		<font color="##92840C"><b>No se pueden recuperar los datos</b></font></i>
	</div>

<?php 
}
?>