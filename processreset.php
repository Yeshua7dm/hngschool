<?php
session_start();
require_once('functions/user.php');
require_once('functions/email.php');

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
  setAlert('error', $sessionError . " in your form submission");
  if (!isset($_SESSION['userID'])) {
    header("Location: reset.php?token=" . $token);
  } else {
    header("Location: reset.php");
  }
} else {

  if (!isset($_SESSION['userID'])) {
    //loop through the dir of and find the file
    $tokenDir = scandir("db/tokens/");
    $foundUser = false;
    for ($i = 0; $i < count($tokenDir); $i++) {
      // check if the user exists
      $currentTokenFile = $tokenDir[$i];
      if ($currentTokenFile == $email . '.json') {
        $foundUser = true;
        $tokenObject = json_decode(file_get_contents("db/tokens/" . $currentTokenFile));

        if ($tokenObject->token === $token) {
          // get the substring that is email
          $userData = json_decode(file_get_contents("db/users/" . $currentTokenFile));
          $userData->password = password_hash($password, PASSWORD_DEFAULT);
          file_put_contents("db/users/" . $currentTokenFile, json_encode($userData));
          unlink("db/tokens/" . $currentTokenFile);

          //send a mail to the user to notify him of the change in password
          completeResetEmail($email);
          die();
        } else {
          setAlert('error', 'Password Reset Failed. Invalid/Expired Token!');
          header('Location:forgot.php');
          die();
        }
      }
    }
    if (!$foundUser) {
      setAlert('error', 'Password Reset Failed. Invalid Email Address!');
      header('Location:login.php');
    }
    // if user is logged in and not using token
  } else {
    $userExists = findUser($email);
    if ($userExists) {
      $userData->password = password_hash($password, PASSWORD_DEFAULT);
      updateUser($userExists);
    }
    //send a mail to the user to notify him of the change in password
    completeResetEmail($email);
  }
}

?>
<?php
include_once("lib/footer.php");
