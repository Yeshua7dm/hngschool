<?php
session_start();
require_once('functions/user.php');
require_once("functions/redirect.php");

// die();
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
  setAlert('error', $sessionError . " in your form submission");
  redirect("adduser.php");
} else {
  // validate names
  validateNames($firstname, $lastname, 'adduser.php');

  //validate email : valid, >=5, not empty, have @ and .
  validateEmail($email, 'adduser.php');

  // save the data into an array and then json_encode the array
  $userData = [
    'id' => nextIDCount("db/users/"),
    'first_name' => $firstname,
    'last_name' => $lastname,
    'email' => $email,
    'gender' => $gender,
    'password' => password_hash($password, PASSWORD_DEFAULT),
    'designation' => $designation,
    'department' => $department,
    'registrationDate' => date('l, d M, Y')
  ];
  $userExists = findUser($email);
  if ($userExists) {
    setAlert('error', "This User is Already Registered");
    redirect("adduser.php");
    die();
  } else {
    // write the data into a json file in the DB
    saveUser($userData);
    //send the user to the login page after a succesful login by the user
    setAlert('message', "New User Registration Successful!!");
    redirect("adminboard.php");
  }
}
