<!DOCTYPE html> 
<html>
	<head>
	<?php
        include_once "inc/lib1.php"; // jQuery and Bootstrap
    ?>
	</head>
	<body>
		<div class="container">
		<?php
        include_once "inc/header.php"; // jQuery and Bootstrap
   		 ?>
			<div class="cLoginControl">
		    	<div class="title1" >Please enter you Pin Code to Log in</div>
				<form method="post" action="checklogin.php">
					<div class="form-group">
						<label for="pin">PIN:</label>
						<input class="Pin" size="4" maxlength="4" type="password" class="form-control" name="pin">
						<?php
							if (isset($_GET["s"])) {
								$rid = $_GET["s"];
							}
							else {
								$rid = "";
							}
							echo "<input type=\"hidden\" name=\"rid\" value=\"$rid\">";

							
						?>
					</div>
					<input class="cLoginButton" type="submit" name="Submit" value="Submit">
				</form>
				<?php
					$strErrMsg = '';
					if (isset($_REQUEST['errCode'])) {
						if ($_REQUEST['errCode'] == 1) {
							$strErrMsg = 'Please enter a Pin Code';
						}
						if ($_REQUEST['errCode'] == 2) {
							$strErrMsg = 'Invalid Pin Code entered';
						}
						if ($_REQUEST['errCode'] == 51) {
							$strErrMsg = 'Database connection issue. Please retry.';
						}					
						if ($strErrMsg != '') {
							echo '<br/><div class="cError">' . $strErrMsg . '</div';
						}
					}
				?>
			</div>
		</div>
	</body>
</html>