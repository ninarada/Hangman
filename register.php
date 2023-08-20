<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Hangman</title>
	<link rel="stylesheet" href="styles/login.css"/>
</head>

<body>
	<div class="card-container">
		<h1>Create Your Account</h1>
		<form method="post" action="register.php">
			<?php include('errors.php'); ?>
			<input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>">
			<input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
			<input type="password" name="password_1" placeholder="Password">
			<input type="password" name="password_2" placeholder="Re-enter Password">
			<button type="submit" class="log-btn" name="reg_user">Register</button>
			<h3>Already having an account?
				<a href="login.php">Log In</a>
			</h3>
		</form>
	</div>
</body>
</html>

