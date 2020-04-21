<?php
session_start();
include_once("lib/header.php");
require_once('functions/alert.php');

//check if user is logged in first
if (!isset($_SESSION['userID'])) {
  $_SESSION['info'] = "You need to login to access the Dashboard";
  header("Location:login.php");
}
?>
  <?php
  //create an empty array
  $staff = [];
  // scan through directory
  $arrayOfUsers = scandir("db/users/");
  print_r($arrayOfUsers);
  for ($i = 0; $i < count($arrayOfUsers); $i++) {
    $currentUser = $arrayOfUsers[$i];
    //decode the json files
    $fileContents = file_get_contents("db/users/" . $currentUser);
    $userData = json_decode($fileContents);
    // if the deisgnation is MT, push into the staff array
    if ($userData->designation == "Medical Team (MT)") {
      $member = $userData->first_name . " " . $userData->last_name;
      array_push($staff, $member);
    }
  }
  // pass the array to the session and route
  $_SESSION['staff'] = $staff;
  header('location: allstaff.php');
  ?>