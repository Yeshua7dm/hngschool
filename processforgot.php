<?php session_start();
include_once("lib/header.php");
require_once('functions/token.php');

$errorCount = 0;
$email = $_POST["email"] != "" ? $_POST["email"] : $errorCount++;

if ($errorCount > 0) {
  setAlert('error', "Please put in your email address");
  header("Location: forgot.php");
} else {
  $_SESSION['email'] = $email;

  //validate email : valid, >=5, not empty, have @ and .
  if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email)) {
    setAlert('error', 'Invalid Email Address! Please enter a valid email!');
    header('Location: forgot.php');
    die();
  }
  if (strlen($email) < 5) {
    setAlert('error', 'Your email should contain at least 5 characters!');
    header('Location: forgot.php');
    die();
  }

  $arrayOfUsers = scandir("db/users/");
  $foundUser = false;
  // check if the user with the email exists
  for ($i = 0; $i < count($arrayOfUsers); $i++) {
    // check if the user exists
    $currentUser = $arrayOfUsers[$i];
    if ($currentUser == $email . ".json") {
      $foundUser = true;
      // generate token
      $token = generateToken();

      $to = $email;
      $subject = "Password Reset Link";
      $message = "A password reset has been initiated on your account.\n If you did not initiate this request, please ignore this message. Otherwise, visit http://localhost/hngschool/reset.php?token=" . $token;
      $headers = 'FROM: no-reply@test.com' . "\r\n" . "CC: yeshua7dm@gmail.com";
      file_put_contents("db/tokens/" . $email . ".json", json_encode(["token" => $token]));
      $sendMail = mail($to, $subject, $message, $headers);

      if ($sendMail) {
        setAlert('info', 'Password rest link has been sent to your email!');
        $_SESSION['token'] = $token;
        header("Location: login.php");
      } else {
        setAlert('error', 'Something went wrong, we could not send email!');
        header("Location: forgot.php");
      }

      die();
    }
  }

  if ($foundUser == false) {
    setAlert('error', 'Sorry, Email Not registered with  us!');
    header("Location: forgot.php");
    // session_destroy();
  }
}


?>

<?php include_once("lib/footer.php") ?>
