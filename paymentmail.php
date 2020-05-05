<?php

session_start();
include_once('functions/email.php');
include_once('functions/redirect.php');
include_once('functions/alert.php');

$email = $_SESSION['email'];
$amount = $_SESSION['amount'];
$fullname = $_SESSION['username'];
$date = $_SESSION['appointmentDate'];
$nature = $_SESSION['currentAppointment'];
$department = $_SESSION['currentDepartment'];

// $paidAppointment = $email . '-' . $date . '.json';
// $currentAppointment = json_decode(file_get_contents('db/appointments/' . $paidAppointment));
// $currentAppointment->paid = true;
// $currentAppointment->amount_paid = "NGN " . $amount;
// $currentAppointment->payment_date = date('l, d M, Y');
// //put the contents back in
// file_put_contents('db/appointments/' . $paidAppointment, json_encode($currentAppointment));


$mailSubject = 'Confirmation of Bill Payment';
$headers = 'FROM: no-reply@test.com' . "\r\n" . "CC: yeshua7dm@gmail.com";
$mailBody = "Hello " . $fullname . ",\nYour payment for an appointment for " . $nature . " in the " . $department . " Department set for " . $date . " has been completed.";
// $sendmail = sendEmail($mailSubject, $mailBody, $email);
$sendmail = mail($email, $mailSubject, $mailBody, $headers);
if ($sendMail) {
  setAlert('message', 'Your Payment was successful! Mail has been sent');
  redirect("patientsboard.php");
} else {
  setAlert('message', 'Your Payment was successful; Mail could not be sent');
  redirect("patientsboard.php");
}
