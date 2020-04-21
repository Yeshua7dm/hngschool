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
//get thr next ID to use
function nextIDCount($url = '')
{
  return count(scandir($url)) - 1;
}
//save user
function saveUser($userObject)
{
  file_put_contents("db/users/" . $userObject['email'] . ".json", json_encode($userObject));
}
//update user on login
function updateUser($userObject)
{
  file_put_contents("db/users/" . $userObject->email . ".json", json_encode($userObject));
}

function validateEmail($email = '', $location = '')
{
  //validate email : valid, >=5, not empty, have @ and .
  if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email)) {
    setAlert('error', 'Your email is invalid! Please enter a valid email!');
    header('Location: ' . $location);
    die();
  }
  if (strlen($email) < 5) {
    setAlert('error', 'Your email should contain at least 5 characters!');
    header('Location: ' . $location);
    die();
  }
}

function validateNames($firstname = '', $lastname = '', $location = '')
{
  if (strlen($firstname) < 2 || strlen($lastname) < 2) {
    setAlert('error', 'Your Name is shorter than the required length!');
    header('Location: ' . $location);
    die();
  }
  if (!preg_match("/^[a-zA-Z]*$/", $firstname) || !preg_match("/^[a-zA-Z]*$/", $lastname)) {
    setAlert('error', 'Your name should only contain letters, no numbers!');
    header('Location: ' . $location);
    die();
  }
}
