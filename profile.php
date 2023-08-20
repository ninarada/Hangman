<?php
// Starting the session, to use and store data in session variable
require_once('server.php');

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
profile();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Hangman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/nav.css"/>
    <link rel="stylesheet" href="styles/profile.css"/>
    
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
        <div id="user-container">
            <p id="username-container">
                <span class="username-label">username:</span>    
                <?php echo $_SESSION['username']; ?>
            </p>
            <p id="email-container">
                <span class="email-label">email:</span>    
                <?php echo $_SESSION['email']; ?>
            </p>
            <a href="profile.php?logout='1'" class="log-out-click">Log Out</a>
        </div>

        <div id="big-stats-container">
            <div id="stats-container">
                <table id="stats-table">
                    <thead>
                        <tr><td colspan="2">Statistics</td></tr> 
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="stats-label2">Games Played:</span> </td>
                            <td><?php echo $_SESSION['GamesPlayed']; ?></td>
                        </tr>
                        <tr>
                            <td><span class="stats-label2">Games Won:</span></td>
                            <td><?php echo $_SESSION['GamesWon']; ?></td>
                        </tr>
                        <tr>
                            <td><span class="stats-label2">Win Rate:</span></td>
                            <td><?php echo $_SESSION['WinRate']; ?>%</td>
                        </tr>
                        <tr>
                            <td><span class="stats-label2">Wins With No Mistakes:</span></td>
                            <td><?php echo $_SESSION['WinsWithNoMistakes']; ?></td>
                        </tr>
                        <tr>
                            <td><span class="stats-label2">Best Win Streak:</span></td>
                            <td><?php echo $_SESSION['BestWinStreak']; ?></td>
                        </tr>
                        <tr>
                            <td><span class="stats-label2">Current Win Streak:</span></td>
                            <td><?php echo $_SESSION['CurrentWinStreak']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    
  </body>
</html>

