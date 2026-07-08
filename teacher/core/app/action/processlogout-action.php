<?php
unset($_SESSION["teacher_id"]);
session_destroy();
Core::redir("./");
?>