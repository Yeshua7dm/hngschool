<?php
session_start();
require_once('functions/redirect.php');

/**
 * scan the directory of appointments into an array
 * isolate each appointment with filegetcontents
 * check where the department is the same as in session
 * if departments match, move into an array to be passed into session as appointments
 * 
 */
$appointments = [];
$arrayAppointments = scandir("db/appointments");

for ($i = 0; $i < count($arrayAppointments); $i++) {

  $appointment = json_decode(file_get_contents("db/appointments/" . $arrayAppointments[$i]));
  if ($_SESSION['department'] == $appointment->department) {
    array_push($appointments, $appointment);
  }
}

print_r($appointments);
$_SESSION['appointments'] = $appointments;
redirect("appointments.php");
