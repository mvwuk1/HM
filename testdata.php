<html>
<head>
    <?php
        include_once "inc/lib1.php"; // jQuery and Bootstrap
    ?>
    <script>
        $(document).ready(function(){

            $('#status1').text('Started');
            $.ajax({
                url: 'process1.php',
                type: 'POST',
                success: function(data) {
                    $('#status1').text('Complete');;
                },
                error: function(data) {
                    $('#status1').text('error');;
                }
            });
        });
    </script>
</head>
	<body>
		<p>
			<div id="status1"></div>
		</p>
		<p>
			<div id="status2"></div>
		</p>
		<p>			
			<div id="status3"></div>
		</p>
	</body>
</html>