<!DOCTYPE html>
<html>

<head>
	<title>BigWin | Logg Inn</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="icon" type="image/x-icon" href="Logo/Favicon.png">
</head>

<body style="background-color:#2B3D5D">
	<form action="login.php" method="post">
		<h2>Logg Inn</h2>
		<?php if (isset($_GET['error'])) { ?>
			<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
		<label>Brukernavn</label>
		<input type="text" name="uname" placeholder="Brukernavn"><br>

		<label>Passord</label>
		<input type="password" name="password" placeholder="Passord"><br>

		<button type="submit">Logg Inn</button>
		<a href="signup.php" class="ca">Registrer deg</a>
	</form>
</body>

</html>