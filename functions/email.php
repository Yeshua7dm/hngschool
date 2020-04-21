<?php
include_once('alert.php');
require_once('functions/token.php');
function completeResetEmail($email)
{
  //send a mail to the user to notify him of the change in password
  $to = $email;
  $subject = "Password Reset Completed";
  $message = "Your account has just been updated, your password has changed. If you did not initiate the password change, visit localhost/hngschool and reset your password immediately";
  $headers = 'FROM: no-reply@test.com' . "\r\n" . "CC: yeshua7dm@gmail.com";
  mail($to, $subject, $message, $headers);

  //send session to login for user to login
  setAlert('info', "Password reset Successful.");
  $_SESSION['email'] = $email;
  header("Location:login.php");
}

function sendForgotEmail($email)
{
  $token = generateToken();
  $to = $email;
  $subject = "Password Reset Link";
  $message = "A password reset has been initiated on your account.\n If you did not initiate this request, please ignore this message. Otherwise, visit http://localhost/hngschool/reset.php?token=" . $token;
  $headers = 'FROM: no-reply@test.com' . "\r\n" . "CC: yeshua7dm@gmail.com";
  file_put_contents("db/tokens/" . $email . ".json", json_encode(["token" => $token]));
  $sendMail = mail($to, $subject, $message, $headers);

  if ($sendMail) {
    setAlert('info', 'Password reset link has been sent to your email!');
    $_SESSION['token'] = $token;
    header("Location: login.php");
  } else {
    setAlert('error', 'Something went wrong, we could not send email!');
    header("Location: forgot.php");
  }
}
