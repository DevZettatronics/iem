<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../plugins/morris/alertas.js"></script>
<body>
<?php

// define('LBROOT',getcwd()); // LegoBox Root ... the server root
// include("core/controller/Database.php");

if(!isset($_SESSION["user_id"])) {
$user = $_POST['username'];
$pass = sha1(md5($_POST['password']));

$base = new Database();
$con = $base->connect();
$sql = "select * from user where (((email= \"".$user."\" or  username= \"".$user."\")  and password= \"".$pass."\") and is_active=1)  ";
//print $sql;
$query = $con->query($sql);
$found = false;
$userid = null;
while($r = $query->fetch_array()){
	$found = true ;
	$userid = $r['id'];
}

if($found==true) {
//	session_start();
//	print $userid;
	$_SESSION['user_id']=$userid ;
//	setcookie('userid',$userid);
//	print $_SESSION['userid'];
	echo "<script>
	inicio_correcto('Inicio de sesion correcto','Cargando ... $user');    
	window.setTimeout(function() {
		window.location='index.php?view=home';
	}, 2500);
	</script>";
	
}else {
	echo "<script>
	inicio_mal('ERROR','Los datos ingresados no son correctos')
	window.setTimeout(function() {
		window.location='index.php?view=home';
	}, 2500);
	</script>";
}

}else{
	print "<script>window.location='index.php?view=home';</script>";
	
}
?>
</body>