<?php
	//Database connection information
	$host="vwrs.net"; // Host name 
	$username="vwrsnet_HM"; // Mysql username 
	$password="CheeseCake101"; // Mysql password 
	$db_name="vwrsnet_HM"; // Database name 
	
	$con = mysql_connect("$host", "$username", "$password")or die("Cannot connect to server"); 
	// Check connection
	if (mysqli_connect_errno())
	{
		header("location:index.php?errCode=51");
	}
	mysql_select_db("$db_name")or die("Cannot select database");
	
?>