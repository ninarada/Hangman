<?php
 
// Starting the session, necessary
// for using session variables
session_start();
  
// Declaring and hoisting the variables
$username = "";
$email = "";
$errors = array();
$_SESSION['success'] = "";

// DBMS connection code -> hostname, username, password, database name
$db = mysqli_connect('localhost', 'zavrsni', 'zrad', 'zavrsni');
$_SESSION['db'] = $db;
  
// Registration code
if (isset($_POST['reg_user'])) {
  
    // Receiving the values entered and storing in the variables
    // Data sanitization is done to prevent SQL injections
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  
    // Ensuring that the user has not left any input field blank
    // error messages will be displayed for every blank input
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
  
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
        // Checking if the passwords match
    }

    $query0 = "SELECT * FROM Users WHERE Username='$username'";
    $results0 = mysqli_query($db, $query0);

    $query01 = "SELECT * FROM Users WHERE Email='$email'";
    $results01 = mysqli_query($db, $query01);

    // $results = 1 means that one user with the entered username exists
    if(mysqli_num_rows($results0) == 1) {
        // If the username and password doesn't match
        array_push($errors, "Username already exist");
    }
    if(mysqli_num_rows($results01) == 1) {
        // If the username and password doesn't match
        array_push($errors, "Email already exist");
    }
  
    
    // If the form is error free, then register the user
    if (count($errors) == 0) {
         
        // Password encryption to increase data security
        $password = md5($password_1);
         
        // Inserting data into table
        $query = "INSERT INTO Users (Username,  Password, Email)
                  VALUES('$username', '$password', '$email')";

        $query2 = "INSERT INTO Statistics (Username,  GamesPlayed, GamesWon, WinsWithNoMistakes, BestWinStreak, CurrentWinStreak)
                  VALUES('$username', 0, 0, 0, 0, 0)";
         
        mysqli_query($db, $query);

        mysqli_query($db, $query2);
  
        // Storing username of the logged in user, in the session variable
        $_SESSION['username'] = $username;
         
        // Welcome message
        $_SESSION['success'] = "You have logged in";
         
        // Page on which the user will be redirected after logging in
        header('location: index.php');
    }
}
  
// User login
if (isset($_POST['login_user'])) {
     
    // Data sanitization to prevent SQL injection
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    // Error message if the input field is left blank
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    // Checking for the errors
    if (count($errors) == 0) {
         
        // Password matching
        $password = md5($password);
         
        $query = "SELECT * FROM Users WHERE Username=
                '$username' AND Password='$password'";
        $results = mysqli_query($db, $query);
  
        // $results = 1 means that one user with the entered username exists
        if (mysqli_num_rows($results) == 1) {
             
            // Storing username in session variable
            $_SESSION['username'] = $username;
             
            // Welcome message
            $_SESSION['success'] = "You have logged in!";
             
            // Page on which the user is sent to after logging in
            header('location: index.php');
        }
        else {
             
            // If the username and password doesn't match
            array_push($errors, "Username or password incorrect");
        }
    }
}

function profile(){
    $username = $_SESSION['username'];
    $db = $_SESSION['db'];
    $query = "SELECT * FROM Users WHERE Username = '$username'";

    $results = mysqli_query($db, $query);

    if (mysqli_num_rows($results) == 1) {
        $row = mysqli_fetch_array($results);
        $_SESSION['email'] = $row['Email'];
        $_SESSION['UserID'] = $row['UserID'];

        $query2 = "SELECT * FROM Statistics WHERE Username = '$username'";

        $results2 = mysqli_query($db, $query2);

        if(mysqli_num_rows($results2) == 1) {
            $row2= mysqli_fetch_array($results2);

            $_SESSION['GamesPlayed'] = $row2['GamesPlayed'];
            $_SESSION['GamesWon'] = $row2['GamesWon'];
            $_SESSION['WinsWithNoMistakes'] = $row2['WinsWithNoMistakes'];
            if($_SESSION['GamesPlayed'] != 0) {
                $_SESSION['WinRate'] = round(($_SESSION['GamesWon'] / $_SESSION['GamesPlayed'] * 100), 2);
            } else {
                $_SESSION['WinRate'] = 0;
            }
            $_SESSION['BestWinStreak'] = $row2['BestWinStreak'];
            $_SESSION['CurrentWinStreak'] = $row2['CurrentWinStreak'];
        }
    }
}

?>