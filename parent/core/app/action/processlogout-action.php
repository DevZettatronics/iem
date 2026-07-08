<?php
unset($_SESSION["parent_id"]);
session_destroy();
Core::redir("./");
?>