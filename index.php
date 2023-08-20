<?php
// Starting the session, to use and store data in session variable
if(session_status() == PHP_SESSION_NONE){
  session_start();
}
  
// If the session variable is empty, this means the user is yet to login
// User will be sent to 'login.php' page to allow the user to login
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: login.php');
}

// Logout button will destroy the session, and will unset the session variables
// User will be headed to 'login.php' after logging out
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Hangman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/nav.css"/>
    <link rel="stylesheet" href="styles/categories.css"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text&family=Sora:wght@500&display=swap" rel="stylesheet">
  </head>

  <body>
    <header>
        <a>Hangman</a>
        <a href="profile.php?logout='1'">Log Out</a>
        <a href="profile.php">Account</a>
        <a href="index.php">New Game</a>
    </header>

    <main>
        <div id="choose-category">Choose the category you would like to play:</div>
        <div id="categories-container">
            <a class="categories-label" href="game.php">Movies</a>
            <a class="categories-label" href="game.php">TV shows</a>
            <a class="categories-label" href="game.php">Countries</a>
            <a class="categories-label" href="game.php">Celebrities</a>
            <a class="categories-label" href="game.php">Food</a>
            <a class="categories-label" href="game.php">Cities</a>
        </div>
    </main>

    <script src="js/index.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  </body>
</html>
