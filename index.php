<?php
	if(!isset($_SESSION)) {
			session_start();
	}
?>
<html>
	<head>
		<title>IT-Support</title>
		<meta charset='UTF-8'>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="styles/custom.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="scripts/general.js"></script>

		<!-- rich text -->
		<script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>

	</head>
	<body>
		<?php
			include('content/navigation.php');
		?>
		<div class="container">
		<?php
			if(!isset($_SESSION['user'])) {
				include('content/login.php');
			} else if($_SESSION['user'] === 'it-support') {
				switch($_GET['content']) {
					case 'requests': include('content/requests.php'); break;
					case 'notebook': include('content/notebook.php'); break;
					default: include('content/error.php'); break;
				}
			}
		?>
		</div>
		<footer>
		<p class="text-center" style="color: white;">Cornelius Matejka &copy; 2015</p>
		</footer>
	</body>
</html>
