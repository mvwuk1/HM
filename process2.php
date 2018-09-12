<?php
	

$strProj = $_POST['strProj'];
//$strQid = 'Q16_Aqua_DD';//$_POST['strQid'];
$strID = $_POST['strID'];
$blnMobile = $_POST['blnMobile'];
$dtRow = $_POST['dtRow'];
$dtCol = $_POST['dtCol'];
$dtValue = $_POST['dtValue'];

//Database connection information
$host="vwrs.net"; // Host name 
$username="vwrsnet_HM"; // Mysql username 
$password="CheeseCake101"; // Mysql password 
$db_name="vwrsnet_HM"; // Database name  
$tbl_name="tblUsers"; // Table name 

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("Cannot connect to server"); 
mysql_select_db("$db_name")or die("Cannot select database");


$strSQL = "INSERT INTO vwrsnet_HM.tblHeatMapData 
(ProjID, 
ID, 
QID, 
blnMobile, 
dtRow, 
dtColumn,
dtValue) 
VALUES 
('$strProj' , 
'$strID', 
'Q16_Aqua_DD', 
$blnMobile, 
$dtRow, 
$dtCol,
$dtValue);";
mysql_query($strSQL);



?>