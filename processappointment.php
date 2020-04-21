<?php
session_start();

print_r($_POST);
print_r($_SESSION);

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
  $_SESSION['error'] = $sessionError . " in your form submission";
  header("Location: bookappointment.php");
  die();
}

// scan directory and count for number of appointments
$appointments = scandir("db/appointments/");
$count = count($appointments);
$appointmentID = $count - 1;
// save the data into an array and then json_encode the array
$appointment = [
  'id' => $appointmentID,
  'name' => $name,
  'date' => $date,
  'time' => $time,
  'nature' => $nature,
  'complaint' => $complaint,
  'department' => $department,
];
//push the array into a file saved with email of patient and date of appointment
file_put_contents("db/appointments/" . $email . "-" . $date . ".json", json_encode($appointment));

$to = $email;
$subject = "Appointment Booked";
$message = "You have successfully booked an appointment stated for " . $time . " on " . $date . " with the " . $department . " department. Please keep to time.\nThanks";
$headers = 'FROM: no-reply@test.com' . "\r\n" . "CC: yeshua7dm@gmail.com";
$sendMail = mail($to, $subject, $message, $headers);

// return to dashboard
$_SESSION["message"] = "Appointment Booked! A mail has been sent to you.";
header("Location: patientsboard.php");
