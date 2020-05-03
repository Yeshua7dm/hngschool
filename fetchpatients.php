<?php
session_start();
require_once('functions/alert.php');
require_once('functions/redirect.php');

//check if user is logged in first
if (!isset($_SESSION['userID'])) {
  setAlert('info', "You do not have access to that page");
  redirect("login.php");
}
$patients = [];
// scan through directory
$arrayOfUsers = scandir("db/users/");
print_r($arrayOfUsers);
for ($i = 0; $i < count($arrayOfUsers); $i++) {
  $currentUser = $arrayOfUsers[$i];
  $fileContents = file_get_contents("db/users/" . $currentUser);
  $userData = json_decode($fileContents);

  if ($userData->designation == "Patients") {
    array_push($patients, $userData);
  }
}
print_r($patients);
$_SESSION['patients'] = $patients;
redirect("allpatients.php");
