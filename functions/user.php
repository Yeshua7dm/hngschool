<?php
include_once('alert.php');

// token set in get
function _isTokenSetinGet()
{
  return isset($_GET['token']);
}
// token set in session
function _isTokenSetinSession()
{
  return isset($_SESSION['token']);
}
// token set at all
function _isTokenSet()
{
  return _isTokenSetinGet() || _isTokenSetinSession();
}
// user logged
function _isUserLogged()
{
  return isset($_SESSION['userID']) && !empty($_SESSION['userID']);
}
// email check
function _isEmailSet()
{
  return isset($_SESSION['email']) && !empty($_SESSION['email']);
}

//find user from db
function findUser($email = "")
{
  if (!$email) {
    setAlert('error', "User Email is not set");
    die();
  }
  $arrayOfUsers = scandir("db/users/");

  for ($i = 0; $i < count($arrayOfUsers); $i++) {
    $currentUser = $arrayOfUsers[$i];

    if ($currentUser == $email . ".json") {
      // get user object
      $userData = json_decode(file_get_contents("db/users/" . $currentUser));
      return $userData;
    }
  }
  return false;
}
