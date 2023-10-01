<!DOCTYPE html>
<html>

<head>
	<title>LOGIN</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<form action="login.php" method="post">
		<h2>LOGIN</h2>
		<?php if (isset($_GET['error'])) { ?>
			<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
		<label>Brukernavn</label>
		<input type="text" name="uname" placeholder="User Name"><br>

		<label>Passord</label>
		<input type="password" name="password" placeholder="Password"><br>

		<button type="submit">Logg Inn</button>
		<a href="signup.php" class="ca">Registrer deg</a>
	</form>
</body>

</html>