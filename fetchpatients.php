<?php
session_start();
include_once("lib/header.php");
require_once('functions/alert.php');

//check if user is logged in first
if (!isset($_SESSION['userID'])) {
  setAlert('info', "You do not have access to that page");
  header("Location:login.php");
}
?>
  <?php
  /**
   * TODO: Loop through the Users db folder
   * collect an array of users
   * create a new empty array called staff
   * 
   * now in the loop, for every user that designation is medical team
   * concatenate their firstname and lastname into name
   * add the username to the array *staff*
   * 
   * when done, loop through the *staff* array
   * display the users in the staff array 
   * 
   */
  //create an empty array
  $patients = [];
  // scan through directory
  $arrayOfUsers = scandir("db/users/");
  print_r($arrayOfUsers);
  for ($i = 0; $i < count($arrayOfUsers); $i++) {
    $currentUser = $arrayOfUsers[$i];
    //decode the json files
    // print_r($currentUser);
    $fileContents = file_get_contents("db/users/" . $currentUser);
    $userData = json_decode($fileContents);
    // print_r($userData);
    if ($userData->designation == "Patients") {
      $patient = $userData->first_name . " " . $userData->last_name;
      array_push($patients, $patient);
    }
  }
  print_r($patients);
  $_SESSION['patients'] = $patients;
  header('location: allpatients.php');
  ?>