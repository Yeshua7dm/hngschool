<?php session_start();
include_once("lib/header.php");
require_once('functions/user.php');
require_once('functions/email.php');

$errorCount = 0;
$email = $_POST["email"] != "" ? $_POST["email"] : $errorCount++;

if ($errorCount > 0) {
  setAlert('error', "Please put in your email address");
  header("Location: forgot.php");
} else {
  $_SESSION['email'] = $email;

  //validate
  validateEmail($email, 'forgot.php');

  // check if the user with the email exists
  $userExists = findUser($email);
  if ($userExists) {
    sendForgotEmail($email);
  } else {
    setAlert('error', 'Sorry, Email Not registered with  us!');
    header("Location: forgot.php");
    // session_destroy();
  }
}
