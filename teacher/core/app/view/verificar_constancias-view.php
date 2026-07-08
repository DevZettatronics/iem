<?PHP

session_start();

include("conexion.php");



$conexion=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(!$conexion){

	die("imposible conectarse: ".mysqli_error($conexion));

}

if (@mysqli_connect_errno()) {

	die("Conexión falló: ".mysqli_connect_errno()." : ". mysqli_connect_error());

}

 		

$code = $_POST["code"];

$year = $_POST["year"];



		

//$busqueda= mysql_query("SELECT * FROM `usuarios` WHERE `user` ='$user' AND `registro_int` ='$registro_int'");

//$result=mysql_num_rows($busqueda);



$busqueda= "SELECT * FROM `person` WHERE `code` ='$code' AND `year` ='$year'";

$resultado= mysqli_query($conexion,$busqueda);

$result=mysqli_num_rows($resultado);





if ($result>=1)

{ 

while ($res = mysqli_fetch_assoc($resultado)) {

    

  $is_active= $res['is_active'];

  $kind= $res['kind'];



// 11111111111111111111111111111111111111111111111111111111111111



	

	

	

	if ($is_active=="1" && $kind=="1")     //1B

	{ 

	session_start();

	$_SESSION['1B']=true;

	$_SESSION['id']=$res['id'];

	$_SESSION['name']=$res['name'];

	$_SESSION['lastname']=$res['lastname'];

	$_SESSION["directorio"]=$res['directorio'];	

    ?>

		

	<script type="text/javascript">

		location.href="https://aula.iemueem.edu.mx/Servicios/iem/teacher/index.php?view=entrada_constancias";

	</script>



	<?

	} 

	

	

	

	

	else                              // Ninguno de los anteriores

	{



	?>

		

	<script type="text/javascript">

		location.href="index.php?errorusuario=yes";

	</script>



	<?

	

	

	}	

	



} // Fin del While principal

} // Fin del IF principla





	else                 //Else principal

	{

	?>

		

	<script type="text/javascript">

		location.href="index.php?view=error&id=<?php if (isset($_SESSION["teacher_id"])) {

                                                            echo PersonData::getById($_SESSION["teacher_id"])->id;

                                                          } ?>";

	//location.href="error.php?errorusuario=si";

	</script>





	<?

	

	

	}		



// mysql_close($conexion);

?>



