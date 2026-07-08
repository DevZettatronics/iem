<?php
if($_GET["id"]!=$_SESSION["user_id"]){
$user = UserData::getById($_GET["id"]);
$user->del();
}
print "<script>window.location='index.php?view=users';</script>";

?>