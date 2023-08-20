<?php
if(session_status() == PHP_SESSION_NONE){
  session_start();
}

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: login.php');
}

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
    <link rel="stylesheet" href="styles/game.css"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text&family=Sora:wght@500&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  </head>

  <body>
    <header>
        <a>Hangman</a>
        <a href="profile.php?logout='1'">Log Out</a>
        <a href="profile.php">Account</a>
        <a href="index.php">New Game</a>
    </header>
    

    <div class="main">
      <div class="drawing-container">
        <canvas id="hangman" width="600" height="400"></canvas>
      </div>
      <div class="guessing-container">
        <div class="words-container">
          <p id="guess-words"></p>
          <div class="wrapper">
            <p id="categoryName" data-category ="<?php echo $_SESSION['guessingCategory']; ?>" >Category:</p>
            <p id="lives">Lives left:</p>
          </div>
        </div>
        <div id="buttons"></div>
      </div>
    </div>

    <div id="game-over">
      <h1>GAME OVER</h1>
      <p id="correct-answer"></p>
      <button type="button" class="new-game" onclick="window.location.href='index.php';">New Game</button>
    </div>
    <div id="game-won">
      <h1>CONGRATS YOU WON!</h1>
      <button type="button" class="new-game" onclick="window.location.href='index.php';">New Game</button>
    </div>

    <script src="js/game.js"></script>    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  </body>
</html>

