<?php
session_start();
require_once('functions/user.php');
require_once('functions/email.php');
require_once('functions/redirect.php');
require_once('functions/token.php');

$errorCount = 0;

if (!_isUserLogged()) {
  $token = $_POST["token"] != "" ? $_POST["token"] : $errorCount++;
  $_SESSION['token'] = $token;
}
$email = $_POST["email"] != "" ? $_POST["email"] : $errorCount++;
$password = $_POST["password"] != "" ? $_POST["password"] : $errorCount++;

// sessions here
$_SESSION['email'] = $email;
$_SESSION['password'] = $password;
print_r($_SESSION);
print_r($errorCount);
// die();
if ($errorCount > 0) {
  $sessionError = "You have " . $errorCount . " error";
  if ($errorCount > 1) {
    $sessionError .= "s";
  }
  setAlert('error', $sessionError . " in your form submission");
  if (!_isUserLogged()) {
    redirect("reset.php?token=" . $token);
  } else {
    redirect("reset.php");
  }
} else {
  validateEmail($email, "reset.php");
  if (!_isUserLogged()) {
    validateToken($email, $token, $password);

    setAlert('error', 'Sorry, You have not asked to reset Email!');
    redirect("forgot.php");
    die();
  }
  // if user is logged in and not using token
  else {
    $userExists = findUser($email);
    if ($userExists) {
      // $updatesPwd = password_hash($password, PASSWORD_DEFAULT);
      $userExists->password = password_hash($password, PASSWORD_DEFAULT);
      updateUser($userExists);
    }
    //send a mail to the user to notify him of the change in password
    $subject = "Password Reset Completed";
    $message = "Your account has just been updated, your password has changed. If you did not initiate the password change, visit localhost/hngschool and reset your password immediately";

    sendEmail($subject, $message, $email);

    //send session to login for user to login
    setAlert('info', "Password reset Successful.");
    $_SESSION['email'] = $email;
    redirect("login.php");
  }
}
