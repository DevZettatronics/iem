<?php
session_start();

$connect=mysqli_connect("external-db.s202512.gridserver.com","db202512","Cronos1987@","db202512_viserion");
if ($connect) {
		echo "conexion exitosa. <br />";

	$code = $_POST["code"];
	$name = $_POST["name"];
	$email = $_POST["email"];
	$is_active = $_POST["is_active"];
	$kind = ($_POST["kind"]);
	$course1 = $_POST["course1"];
	$course2 = $_POST["course2"];
	
	
	
		$consulta="insert into courses (code, name, email, is_active, kind, course1, course2) values ('$code','$name','$email','$is_active','$kind','$course1','$course2')";
		
		$resultado=mysqli_query($connect,$consulta);
		
		if ($resultado) {
			echo "perfil almacenado. <br />";
		}
		else {
			echo "error en la ejecución de la consulta. <br />";
		}
		
		if (mysqli_close($connect)){ 
			echo "desconexion realizada. <br />";
		} 
		else {
			echo "error en la desconexión";
		}
}

$servername = "external-db.s202512.gridserver.com";
$username = "db202512";
$password = "Cronos1987@";
$dbname = "db202512_viserion";
function mostrarDatos ($resultados) {
if ($resultados !=NULL) {
echo "- Primer nombre: ".$resultados['name']."<br/> ";
echo "- Primer apellido: ".$resultados['email']."<br/>";
echo "- Segundo apellido: ".$resultados['is_active']."<br/>";
echo "- Nombre de acudiente: ".$resultados['kind']."<br/>";
echo "- Curso 1 : ".$resultados['course1']."<br/> ";
echo "- Curso 2 : ".$resultados['course2']."<br/>";

echo "**********************************<br/>";}
else {echo "<br/>No hay más datos!!! <br/>";}
}
$link = mysqli_connect($servername,$username,$password);
mysqli_select_db($link, $dbname);
$tildes = $link->query("SET NAMES 'utf8'"); //Para que se muestren las tildes correctamente
$result = mysqli_query($link, "SELECT * FROM courses");
while ($fila = mysqli_fetch_array($result)){
mostrarDatos($fila);
}
mysqli_free_result($result);
mysqli_close($link);


		
if (mysqli_error()) 
			{ 
				?>
	
				<script type="text/javascript">
				location.href="error.php";
				</script>

				<?
			} 

		else
		{
		?>
	
		<script type="text/javascript">
		location.href="http://cals.ugestalt.edu.mx/viserion/teacher/index.php?view=entrada-curso";
		</script>

		<?
		}	

?>

