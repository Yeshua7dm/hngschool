<?php
session_start();
require_once('functions/user.php');
require_once('functions/redirect.php');
require_once('functions/email.php');


$errorCount = 0;
// use tenary operator to check if the fields are empty
//compared to long list of if statements
$date = $_POST["appointmentDate"] != "" ? $_POST["appointmentDate"] : $errorCount++;
$time = $_POST["appointmentTime"] != "" ? $_POST["appointmentTime"] : $errorCount++;
$nature = $_POST["appointmentNature"] != "" ? $_POST["appointmentNature"] : $errorCount++;
$complaint = $_POST["initialComplaint"] != "" ? $_POST["initialComplaint"] : $errorCount++;
$department = $_POST["appointmentDepartment"] != "" ? $_POST["appointmentDepartment"] : $errorCount++;
$email = $_SESSION["email"];
$name = $_SESSION["username"];

// check errors and escalate if any
if ($errorCount > 0) {
  $sessionError = "You have " . $errorCount . " empty field";
  if ($errorCount > 1) {
    $sessionError .= "s";
  }
  setAlert('error', $sessionError . " in your form submission");
  redirect("bookappointment.php");
  die();
}

// save the data into an array and then json_encode the array
$appointment = [
  'id' => nextIDCount("db/appointments/"),
  'name' => $name,
  'date' => $date,
  'time' => $time,
  'nature' => $nature,
  'complaint' => $complaint,
  'department' => $department,
];
//push the array into a file saved with email of patient and date of appointment
file_put_contents("db/appointments/" . $email . "-" . $date . ".json", json_encode($appointment));

$subject = "Appointment Booking";
$message = "You have successfully booked an appointment stated for " . $time . " on " . $date . " with the " . $department . " department. Please keep to time.\nThanks";
$sendMail = sendEmail($subject, $message, $email);

// return to dashboard
if ($sendMail) {
  setAlert('message', "Appointment Booked! A mail has been sent to you.");
} else {
  setAlert('message', "Appointment Booked!");
}

redirect("patientsboard.php");
