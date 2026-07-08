<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../plugins/morris/alertas.js"></script>

<body>
	<?php

	// define('LBROOT',getcwd()); // LegoBox Root ... the server root
	// include("core/controller/Database.php");

	if (!isset($_SESSION["alumn_id"])) {
	?><script type="text/javascript" src="plugins/morris/alertas.js"></script>
	<?php
		$user = $_POST['username'];
		$pass = sha1(md5($_POST['password']));

		$base = new Database();
		$con = $base->connect();
		$sql = "select * from person where code= \"" . $user . "\"   and password= \"" . $pass . "\" and kind=3 ";
		//print $sql;
		$query = $con->query($sql);
		$found = false;
		$userid = null;

		if ($query->num_rows > 0) {
			while ($r = $query->fetch_array()) {
				$found = true;
				$userid = $r['id'];
				$code = $r['code'];
			}
		}
		if ($found == true) {
			//session_start();
			//	print $userid;
			$_SESSION['alumn_id'] = $userid;
			$_SESSION['code'] = $code;
			//	setcookie('userid',$userid);
			//	print $_SESSION['userid'];
			echo "<script>
					inicio_correcto('Inicio de sesion correcto','Cargando ... $user');    
					window.setTimeout(function() {
						window.location='index.php?view=home';
					}, 2500);
				</script>";
		} else {
			echo "<script>
				inicio_mal('ERROR','Los datos ingresados no son correctos')
				window.setTimeout(function() {
					window.location='index.php?view=home';
				}, 2500);
			</script>";
		}
	} else {
		print "<script>window.location='index.php?view=home';</script>";
	}
	?>
</body>