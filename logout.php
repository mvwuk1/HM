<?php session_start();
	unset($_SESSION['LoginStatus']);
	session_destroy();
	header("location:hm.php");
?>