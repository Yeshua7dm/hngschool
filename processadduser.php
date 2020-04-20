<?php
session_start();
require_once('functions/alert.php');
print_r($_POST);


$errorCount = 0;
// use tenary operator to check if the fields are empty
//compared to long list of if statements
$firstname = $_POST["firstname"] != "" ? $_POST["firstname"] : $errorCount++;
$lastname = $_POST["lastname"] != "" ? $_POST["lastname"] : $errorCount++;
$gender = $_POST["gender"] != "" ? $_POST["gender"] : $errorCount++;
$designation = $_POST["designation"] != "" ? $_POST["designation"] : $errorCount++;
$department = $_POST["department"] != "" ? $_POST["department"] : $errorCount++;
$email = $_POST["email"] != "" ? $_POST["email"] : $errorCount++;
$password = $_POST["password"] != "" ? $_POST["password"] : $errorCount++;

// checks if the fields are empty

if ($errorCount > 0) {

  $sessionError = "You have " . $errorCount . " empty field";
  if ($errorCount > 1) {
    $sessionError .= "s";
  }
  $_SESSION['error'] = $sessionError . " in your form submission";
  header("Location: adduser.php");
} else {
  //TODO: validate name : no numbers+, >=2+, not empty+
  if (strlen($firstname) < 2 || strlen($lastname) < 2) {
    $_SESSION['error'] = 'The Name is shorter than the required length!';
    header('Location: adduser.php');
    die();
  }
  if (!preg_match("/^[a-zA-Z]*$/", $firstname) || !preg_match("/^[a-zA-Z]*$/", $lastname)) {
    $_SESSION['error'] = 'The name should only contain letters, no numbers!';
    header('Location: adduser.php');
    die();
  }
  //TODO: validate email : valid, >=5, not empty, have @ and .
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'The email is invalid! Please enter a valid email!';
    header('Location: adduser.php');
    die();
  }
  if (strlen($email) < 5) {
    $_SESSION['error'] = 'The email should contain at least 5 characters!';
    header('Location: adduser.php');
    die();
  }



  //check the db/users directory for thr files in it
  $arrayOfUsers = scandir("./db/users/");
  $usersCount = count($arrayOfUsers);
  $newUserID = $usersCount - 1;
  // save the data into an array and then json_encode the array
  $userData = [
    'id' => $newUserID,
    'first_name' => $firstname,
    'last_name' => $lastname,
    'email' => $email,
    'gender' => $gender,
    'password' => password_hash($password, PASSWORD_DEFAULT),
    'designation' => $designation,
    'department' => $department,
    'registrationDate' => date('l, d M, Y')
  ];

  for ($i = 0; $i < $usersCount; $i++) {
    # code...
    $currentUser = $arrayOfUsers[$i];
    if ($currentUser == $email . ".json") {
      $_SESSION['error'] = "This User is Already Registered";
      header("Location: adduser.php");
      die();
    }
  }
  // write the data into a json file in the DB
  // require('db/')
  file_put_contents("db/users/" . $email . ".json", json_encode($userData));

  //send the user to the login page after a succesful login by the user
  $_SESSION["message"] = "New User Registration Successful!!";
  header("Location: ./dashboards/adminboard.php");
}
