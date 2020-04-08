<?php
session_start();

$errorCount = 0;
// use tenary operator to check if the fields are empty
//compared to long list of if statements

if (!isset($_SESSION['userID'])) {
  $token = $_POST["token"] != "" ? $_POST["token"] : $errorCount++;
  $_SESSION['token'] = $token;
}
$email = $_POST["email"] != "" ? $_POST["email"] : $errorCount++;
$password = $_POST["password"] != "" ? $_POST["password"] : $errorCount++;

// sessions here
$_SESSION['email'] = $email;
$_SESSION['password'] = $password;

if ($errorCount > 0) {

  $sessionError = "You have " . $errorCount . " error";
  if ($errorCount > 1) {
    $sessionError .= "s";
  }
  $_SESSION['error'] = $sessionError . " in your form submission";
  if (!isset($_SESSION['userID'])) {
    header("Location: reset.php?token=" . $token);
  } else {
    header("Location: reset.php");
  }
} else {

  if (!isset($_SESSION['userID'])) {
    # all the code here now
    $foundUser = false;
    //loop through the dir of and find the file
    $tokenDir = scandir("./db/tokens/");
    for ($i = 0; $i < count($tokenDir); $i++) {
      // check if the user exists
      $currentTokenFile = $tokenDir[$i];
      if ($currentTokenFile == $email . '.json') {
        $tokenObject = json_decode(file_get_contents("./db/tokens/" . $currentTokenFile));

        if ($tokenObject->token === $token) {
          // get the substring that is email
          $foundUser = true;
          echo "User can update password";
          $userData = json_decode(file_get_contents("./db/users/" . $currentTokenFile));
          $userData->password = password_hash($password, PASSWORD_DEFAULT);
          file_put_contents("./db/users/" . $currentTokenFile, json_encode($userData));
          unlink("./db/tokens/" . $currentTokenFile);

          //send a mail to the user to notify him of the change in password
          $to = $email;
          $subject = "Password Reset Completed";
          $message = "Your account has just been updated, your password has changed. If you did not initiate the password change, visit localhost:3000 and reset your password immediately";
          $headers = 'FROM: no-reply@test.com' . "\r\n" . "CC: yeshua7dm@gmail.com";
          $sendMail = mail($to, $subject, $message, $headers);

          //send session to login for user to login
          $_SESSION['info'] = "Password reset Successful. Please Log in with New password";
          $_SESSION['email'] = $email;
          header("Location:login.php");
        } else {
          $_SESSION['error'] = 'Password Reset Failed. Invalid/Expired Token!';
          header('Location:forgot.php');
          die();
        }
        $foundUser = true;
        // die();
      }
    }

    if ($foundUser == false) {
      $_SESSION['error'] = 'Password Reset Failed. Invalid Email Address!';
      header('Location:login.php');
    }
    // if user is logged in and not using token
  } else {
    $userData = json_decode(file_get_contents("./db/users/" . $email . ".json"));
    $userData->password = password_hash($password, PASSWORD_DEFAULT);
    file_put_contents("./db/users/" . $email . ".json", json_encode($userData));

    //send a mail to the user to notify him of the change in password
    $to = $email;
    $subject = "Password Reset Completed";
    $message = "Your account has just been updated, your password has changed. If you did not initiate the password change, visit localhost:3000 and reset your password immediately";
    $headers = 'FROM: no-reply@test.com' . "\r\n" . "CC: yeshua7dm@gmail.com";
    $sendMail = mail($to, $subject, $message, $headers);

    //send session to login for user to login
    $_SESSION['info'] = "Password reset Successful.";
    $_SESSION['email'] = $email;
    $_SESSION['message'] = '';
    header("Location:dashboard.php");
  }
}

//check if the user with the email exists



?>

<?php
include_once("lib/footer.php");
