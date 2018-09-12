<html>
	<head>
		<title>BuzzApp Mobile Media Manager</title>
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>			
	</head>
	<body>
		<div class="cLogoTop"><img src="images/BuzzApp_Logo.png"></div>
		<div class="cLoginControl">
			<span>Welcome to BUZZAP</span>
			<form name="LoginForm" id="LoginForm" method="post" action="checklogin.php">
				<div class="cLoginEntry"><span>username</span><input name="pin" type="text" size="25"></div>
				<div class="cLoginEntry"><span>password</span><input name="strPassword" type="password" size="25"></div>
				<input class="cLoginButton" type="submit" name="Submit" value="Login">
			</form>
			<?php
				$strErrMsg = '';
				if ($_REQUEST['errCode'] == 1) {
					$strErrMsg = 'Please enter a username and password';
				}
				if ($_REQUEST['errCode'] == 2) {
					$strErrMsg = 'Invalid username and/or password entered';
				}
				if ($_REQUEST['errCode'] == 51) {
					$strErrMsg = 'Database connection issue. Please retry.';
				}					
				if ($strErrMsg != '') {
					echo '<br/><div class="cError">' . $strErrMsg . '</div';
				}
			?>
		</div>
	</body>
</html>