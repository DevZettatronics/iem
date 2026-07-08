<?php
session_start();


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
	


	
</head>

<body>
	<div class="container-contact3-carga">
	<div class="wrap-contact3-carga">
	<div id="Contenedor">
		
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	  	<tr>
    	<td height="0" align="center" valign="middle"  class="verde">
			
			<!--<img src="images/1341501451_clean.png" width="50" height="50">-->
	   		<h2>Registro Completado</h2>

			</br>
	  	</td>
  	  	</tr>
		
  		<tr>
    	<td height="35" align="center" valign="top"  class="msjnegritas">He enviado la información de forma correcta.</br> </br> 
		<a href="index.php?view=registroexitoso&id=<?php if (isset($_SESSION["teacher_id"])) {
                                                            echo PersonData::getById($_SESSION["teacher_id"])->id;
                                                          } ?>" class="btn btn-lg btn-warning btn-block btn-signin"><i class="fa fa-arrow-left"></i> Regresar</a> 
		</td>
  		</tr>
	
	

</table>
</div>
</div>
</div>
</body>
</html>