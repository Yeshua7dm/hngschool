<?php
session_start();
require_once('functions/alert.php');
date_default_timezone_set("Africa/Lagos"); //set the default time zone to Lagos

$errorCount = 0;
// use tenary operator to check if the fields are empty
$email = $_POST["email"] != "" ? $_POST["email"] : $errorCount++;
$password = $_POST["password"] != "" ? $_POST["password"] : $errorCount++;

$_SESSION['email'] = $email;


if ($errorCount > 0) {
  $sessionError = "You have " . $errorCount . " error";

  if ($errorCount > 1) {
    $sessionError .= "s";
  }
  setAlertType("error", $sessionError . " in your form submission");
  // $_SESSION['error'] = $sessionError . " in your form submission";
  // require('dashboards/')
  header("Location: login.php");
} else {
  //enter the database and save into 
  $arrayOfUsers = scandir("db/users/");
  $foundUser = false;
  $passwordMatch = false;
  //check if the user with the email exists
  for ($i = 0; $i < count($arrayOfUsers); $i++) {
    // check if the user exists
    $currentUser = $arrayOfUsers[$i];
    if ($currentUser == $email . ".json") {
      // then check the password, get file content and json_decode
      $userData = json_decode(file_get_contents("db/users/" . $currentUser));
      //check if the passwords match, then go to dashboard
      if ($userData->password == password_verify($password, $userData->password)) {
        // setAlertType('message', "Logged in!<br>");
        $userData->LastLoggedTime = date("h:ia");
        $userData->LastLoggedDate = date('l, d M, Y');
        //get all the data from the DB
        $_SESSION['email'] = $userData->email;
        $_SESSION['userID'] = $userData->id;
        $_SESSION['username'] = $userData->first_name . " " . $userData->last_name;
        $_SESSION['designation'] = $userData->designation;
        $_SESSION['department'] = $userData->department;
        //current logged in time and date here
        $_SESSION['registrationDate'] = $userData->registrationDate;
        //
        $email = $_POST["email"] != "" ? $_POST["email"] : $errorCount++;
        //
        $_SESSION['lastLoginTime'] = $userData->LastLoggedTime != "" ? $userData->LastLoggedTime : "";
        $_SESSION['lastLoginDate'] = $userData->LastLoggedDate != "" ? $userData->LastLoggedDate : "";
        //then set the last logged in date to current date
        $userData->LastLoggedTime = date("h:ia");
        $userData->LastLoggedDate = date('l, d M, Y');
        //put this back into user data
        file_put_contents("db/users/" . $currentUser, json_encode($userData));

        switch ($userData->designation) {
          case 'Teacher':
            header("Location: dashboards/teachersboard.php");
            break;
          case 'Student':
            header('Location: dashboards/studentboard.php');
            break;
          case 'SuperAdmin':
            header("Location: dashboards/adminboard.php");
            break;
          case 'Non-Teaching Staff':
            header("Location: dashboards/ntsboard.php");
            break;
          default:
            header("Location: dashboard.php");
            break;
        }
      } else {
        setAlertType('error', 'Invalid Password supplied');
        header("Location: login.php");
      }
      $foundUser = true;
    }
  }

  if ($foundUser == false) {
    setAlertType('error', 'Sorry, User not found! Register here!');
    // $_SESSION['error'] = 'Sorry, User not found! Register here!';
    header("Location: register.php");
    // session_destroy();
  }
}
