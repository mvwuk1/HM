<?php session_start();
	
    if(!empty($_POST['pin']) and !empty($_POST['rid']) ) {

		$pin = $_POST['pin'];
		$rid = $_POST['rid'];
		$count = 0;
		if ($pin == "2476" && $rid == "34598") {
			$count = 1;
		}

		// If result matched $strUsername and $strPassword, table row must be 1 row
		if($count==1) {
			$_SESSION['LoginStatus'] = "Logged In";
			$_SESSION['rid'] = $rid;
			header("location:reporting.php");
		}
		else{

			$pass_rid = "&s=" . $rid;
			header("location:index.php?errCode=2" . $pass_rid);
		}
	}
	else {
		//Form fields empty
		
		if (isset($_POST['rid'])) {
			$pass_rid = "&s=" . $_POST["rid"];
		}
		else {
			$pass_rid="";
		}
		header("location:index.php?errCode=1" . $pass_rid);
	}
?>
