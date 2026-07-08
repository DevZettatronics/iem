<?php
session_start();
//session_unset();
//session_destroy();

//header('refresh:4; url=asignar_certificado.php');

header('refresh:4; url=http://cals.ugestalt.edu.mx/viserion/teacher/index.php?view=confirmacion_registro_curso');


?>


<!DOCTYPE HTML>
<html>
	
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Bienvenida</title>
	
<link rel="shortcut icon" href="1344869552_icontexto-green-01.ico" type="image/x-icon" />
<link href="admin/estilos.css" rel="stylesheet" type="text/css">
	
<style type="text/css">
#apDiv1 {
	position:absolute;
	width:200px;
	height:115px;
	z-index:0;
}

</style>
	
	<!--Loader-->	
	
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
	
</head>

<body>
	<div class="container-contact3-carga">
	<div class="wrap-contact3-carga">
	<div id="Contenedor">
		
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	  	<tr>
    	<td height="0" align="center" valign="middle"  class="verde">
			
			<!--<img src="images/1341501451_clean.png" width="50" height="50">-->
	   		<h2>Generando Registro</h2>
			<div class="loader"></div>
			</br>
	  	</td>
  	  	</tr>
		
  		<tr>
    	<td height="35" align="center" valign="top"  class="msjnegritas">Estoy Registrando su Información</br></br> Por favor Espere...</td>
  		</tr>

</table>
</div>
</div>
</div>
</body>
</html>