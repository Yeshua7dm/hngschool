<?php
include_once('user.php');
include_once('email.php');
//function for generating token
function generateToken()
{
  $stringToUse = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
  $token = substr(str_shuffle($stringToUse), 0, 15);
  return $token;
}


function findToken($email = '')
{
  if (!$email) {
    setAlert('error', "User Email is not set");
    die();
  }
  $tokenDir = scandir("db/tokens/");

  for ($i = 0; $i < count($tokenDir); $i++) {
    // check if the user exists
    $currentTokenFile = $tokenDir[$i];
    if ($currentTokenFile == $email . '.json') {
      $tokenObject = json_decode(file_get_contents("db/tokens/" . $currentTokenFile));
      return $tokenObject;
    }
  }
  return false;
}

// function for validating token
function validateToken($email = '', $token = '', $password = '')
{
  $checkToken = findToken($email);
  if ($checkToken) {
    if ($checkToken->token == $token) {
      // get the substring that is email
      $userData = json_decode(file_get_contents("db/users/" . $email . ".json"));
      $userData->password = password_hash($password, PASSWORD_DEFAULT);
      updateUser($userData);
      unlink("db/tokens/" . $email . ".json");

      //send a mail to the user to notify him of the change in password
      $subject = "Password Reset Completed";
      $message = "Your account has just been updated, your password has changed. If you did not initiate the password change, visit localhost/hngschool and reset your password immediately";

      sendEmail($subject, $message, $email);

      //send session to login for user to login
      setAlert('info', "Password reset Successful. Please Log in with New password");
      $_SESSION['email'] = $email;
      redirect("login.php");
      die();
    } else {
      setAlert('error', 'Password Reset Failed. Invalid/Expired Token!');
      redirect("forgot.php");
      die();
    }
  }
}
