<?php
session_start();
require_once('functions/alert.php');
require_once('functions/redirect.php');

//check if user is logged in first
if (!isset($_SESSION['userID'])) {
  setAlert('info', "You do not have access to that page");
  redirect("login.php");
}
//create an empty array
$paidAppointments = [];
// scan through directory
$arrayOfAppointments = scandir("db/appointments/");
for ($i = 0; $i < count($arrayOfAppointments); $i++) {
  $fileContents = file_get_contents("db/appointments/" . $arrayOfAppointments[$i]);
  $appointment = json_decode($fileContents);

  if ($appointment->payment_date) {
    array_push($paidAppointments, $appointment);
  }
}
// print_r($paidAppointments);
// die();
// pass the array to the session and route
$_SESSION['paidAppointments'] = $paidAppointments;

redirect("paidappointments.php");
