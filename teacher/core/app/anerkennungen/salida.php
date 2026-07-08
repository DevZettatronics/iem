<?php
session_start();
session_unset();
session_destroy();

header('refresh:2; url=https://viserion.gestalt.education/teacher/');

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Gestor de Archivos</title>
<link rel="shortcut icon" href="1344869552_icontexto-green-01.ico" type="image/x-icon" />
<link href="estilos.css" rel="stylesheet" type="text/css">
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
	
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	  	<tr>
    	<td height="0" align="center" valign="middle" bgcolor="#FFFFFF" class="verde">
			</br></br></br>
			<!--<img src="images/1341501451_clean.png" width="50" height="50">-->
	   		<h2>Cerrando Sesión</h2>
			<div class="loader"></div>
			</br>
	  	</td>
  	  	</tr>
		
  		<tr>
    	<td height="35" align="center" valign="top" bgcolor="#FFFFFF" class="msjnegritas">Su sesión se cerró correctamente.</br> Gracias por visitarnos.</td>
  		</tr>

</table>
</body>
</html>