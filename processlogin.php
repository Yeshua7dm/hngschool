<?php
session_start();
require_once('functions/user.php');
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
  setAlert("error", $sessionError . " in your form submission");

  header("Location: login.php");
} else {
  //validate email : valid, >=5, not empty, have @ and .
  validateEmail($email, 'login.php');


  $userData = findUser($email);
  if ($userData) {
    if ($userData->password == password_verify($password, $userData->password)) {
      // setAlert('message', "Logged in!<br>");
      //get all the data from the DB
      $_SESSION['email'] = $userData->email;
      $_SESSION['userID'] = $userData->id;
      $_SESSION['username'] = $userData->first_name . " " . $userData->last_name;
      $_SESSION['designation'] = $userData->designation;
      $_SESSION['department'] = $userData->department;
      $_SESSION['registrationDate'] = $userData->registrationDate;
      $_SESSION['lastLoginTime'] = $userData->LastLoggedTime != "" ? $userData->LastLoggedTime : "";
      $_SESSION['lastLoginDate'] = $userData->LastLoggedDate != "" ? $userData->LastLoggedDate : "";
      //then set the last logged in date to current date
      $userData->LastLoggedTime = date("h:ia");
      $userData->LastLoggedDate = date('l, d M, Y');
      //put this back into user data
      updateUser($userData);
      // file_put_contents("db/users/" . $email . ".json", json_encode($userData));

      switch ($userData->designation) {
        case 'Medical Team (MT)':
          header("Location: mtboard.php");
          break;
        case 'Patients':
          header('Location: patientsboard.php');
          break;
        case 'SuperAdmin':
          header("Location: adminboard.php");
          break;
        default:
          header("Location: dashboard.php");
          break;
      }
    } else {
      setAlert('error', 'Invalid Password supplied');
      header("Location: login.php");
    }
  } else {
    setAlert('error', 'Sorry, User not found! Register here!');
    header("Location: register.php");
  }
}
