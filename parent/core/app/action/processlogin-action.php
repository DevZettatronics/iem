<?php

// define('LBROOT',getcwd()); // LegoBox Root ... the server root
// include("core/controller/Database.php");
//print_r($_SESSION);
if(!isset($_SESSION["parent_id"])) {
$user = $_POST['username'];
$pass = sha1(md5($_POST['password']));

$base = new Database();
$con = $base->connect();
echo $sql = "select * from person where code= \"".$user."\"   and password= \"".$pass."\" and kind=2 ";
//print $sql;
$query = $con->query($sql);
$found = false;
$userid = null;
while($r = $query->fetch_array()){
	$found = true ;
	$userid = $r['id'];
}

if($found==true) {
	//session_start();
//	print $userid;
	$_SESSION['parent_id']=$userid ;
//	setcookie('userid',$userid);
//	print $_SESSION['userid'];
	print "Cargando ... $user";
print "<script>window.location='index.php?view=home';</script>";
}else {
	print "<script>window.location='index.php?view=login';</script>";
}

}else{
	print "<script>window.location='index.php?view=home';</script>";
	
}
?>