<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Hangman</title>
    <link rel="stylesheet" href="styles/login.css"/>
</head>
<body>
    <div class="card-container">
        <h1>Welcome Back!</h1>
        <form method="post" action="login.php">
            <?php include('errors.php'); ?>
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <button type="submit" class="log-btn" name="login_user">Log In</button>
            <h3>Don't have an account?
                <a href="register.php">Sign Up</a>
            </h3>
        </form>
    </div>
</body>
</html>


