<?php

session_start();
$_SESSION = array();
session_destroy();
$redirect_url = "../index.php?timestamp=" . time();
header("Location: $redirect_url");
exit();
?>
