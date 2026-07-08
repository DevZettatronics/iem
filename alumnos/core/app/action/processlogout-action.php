<?php
unset($_SESSION["alumn_id"]);
session_destroy();
Core::redir("./");
?>