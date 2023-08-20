<?php 
require_once("server.php");

if(session_status() == PHP_SESSION_NONE){
    session_start();
}
profile();

if(isset($_POST['action'])) {
    if($_POST['action'] == 'playerLostGame') {
        playerLostGame();
    } 
    else if($_POST['action'] == 'playerWonGame') {
        playerWonGame();
    } 
    else if ($_POST['action'] == 'playerWonGameWithNoMistakes'){
        playerWonGameWithNoMistakes();
    } 
    else if ($_POST['action'] == 'saveChosenCategory'){
        $categoryName = $_POST['arg'];
        saveChosenCategory($categoryName);
    }
    else if ($_POST['action'] == 'getRandomTitle'){
        $filename = $_POST['arg'];
        getRandomTitle($filename);
    } else if ($_POST['action'] == 'playerLeftGame'){
        $started = $_POST['arg'];
        playerLeftGame($started);
    }
}

function playerLostGame(){
    $username = $_SESSION['username'];
    $db = $_SESSION['db'];
    $currentWinStreak = $_SESSION['CurrentWinStreak'];
    $bestWinStreak = $_SESSION['BestWinStreak'];
    
    $gamesPlayed = $_SESSION['GamesPlayed'] + 1;

    $currentWinStreak = 0;
    $query = "UPDATE Statistics SET GamesPlayed='$gamesPlayed', 
            BestWinStreak='$bestWinStreak', CurrentWinStreak='$currentWinStreak' 
            WHERE Username = '$username'";
    $results = mysqli_query($db, $query);
}

function playerWonGame() {
    $username = $_SESSION['username'];
    $db = $_SESSION['db'];
    $currentWinStreak = $_SESSION['CurrentWinStreak'];
    $bestWinStreak = $_SESSION['BestWinStreak'];
    $gamesPlayed = $_SESSION['GamesPlayed'] + 1;
    $gamesWon = $_SESSION['GamesWon'] + 1;
    $currentWinStreak = $_SESSION['CurrentWinStreak'] + 1;

    if($currentWinStreak > $bestWinStreak) {
        $bestWinStreak = $currentWinStreak;
    }
    $query = "UPDATE Statistics SET GamesPlayed='$gamesPlayed', 
            GamesWon='$gamesWon', BestWinStreak='$bestWinStreak', 
            CurrentWinStreak='$currentWinStreak'  WHERE Username='$username'";
    $results = mysqli_query($db, $query);          
}

function playerWonGameWithNoMistakes() {
    $username = $_SESSION['username'];
    $db = $_SESSION['db'];
    $currentWinStreak = $_SESSION['CurrentWinStreak'];
    $bestWinStreak = $_SESSION['BestWinStreak'];
    $gamesPlayed = $_SESSION['GamesPlayed'] + 1;
    $gamesWon = $_SESSION['GamesWon'] + 1;
    $winsWithNoMistakes = $_SESSION['WinsWithNoMistakes'] + 1;
    $currentWinStreak = $_SESSION['CurrentWinStreak'] + 1;

    if($currentWinStreak > $bestWinStreak) {
        $bestWinStreak = $currentWinStreak;
    }
    $query = "UPDATE Statistics SET GamesPlayed='$gamesPlayed', GamesWon='$gamesWon', 
            BestWinStreak='$bestWinStreak', CurrentWinStreak='$currentWinStreak', 
            WinsWithNoMistakes='$winsWithNoMistakes' WHERE Username = '$username'";
    $results = mysqli_query($db, $query);
}

function playerLeftGame($started) {
    $username = $_SESSION['username'];
    $db = $_SESSION['db'];
    $gamesPlayed = $_SESSION['GamesPlayed'] + 1;
    $currentWinStreak = 0;

    if($started == 1) {
        $query = "UPDATE Statistics SET GamesPlayed='$gamesPlayed', 
            CurrentWinStreak='$currentWinStreak' WHERE Username='$username'";
        $results = mysqli_query($db, $query);
    }
}

function saveChosenCategory($categoryName){
    $_SESSION['guessingCategory'] = $categoryName;
    echo $_SESSION['guessingCategory'];
}

function getRandomTitle($filename){
    $titles = file($filename);
    $title = $titles[array_rand($titles)];
    $_SESSION['guessing'] = $title;
    echo $_SESSION['guessing'];
}

?>