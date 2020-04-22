<?php session_start();
include_once("lib/header.php");
require_once('functions/user.php');
require_once('functions/email.php');
require_once('functions/token.php');
require_once('functions/redirect.php');

$errorCount = 0;
$email = $_POST["email"] != "" ? $_POST["email"] : $errorCount++;

if ($errorCount > 0) {
  setAlert('error', "Please put in your email address");
  redirect("forgot.php");
} else {
  $_SESSION['email'] = $email;

  //validate
  validateEmail($email, 'forgot.php');

  // check if the user with the email exists
  $userExists = findUser($email);
  if ($userExists) {
    $token = generateToken();
    $subject = "Password Reset Link";
    $message = "A password reset has been initiated on your account.\n If you did not initiate this request, please ignore this message. Otherwise, visit http://localhost/hngschool/reset.php?token=" . $token;
    file_put_contents("db/tokens/" . $email . ".json", json_encode(["token" => $token]));
    sendEmail($subject, $message, $email);

    setAlert('info', 'Password reset link has been sent to your email!');
    $_SESSION['token'] = $token;
    redirect("login.php");
  } else {
    setAlert('error', 'Sorry, Email Not registered with  us!');
    redirect("forgot.php");
    // session_destroy();
  }
}
