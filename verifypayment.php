<?php
session_start();
include_once('functions/redirect.php');
include_once('functions/email.php');
include_once('functions/alert.php');



//test
$paidAppointment = $email . '-' . $date . '.json';
$currentAppointment = json_decode(file_get_contents('db/appointments/' . $paidAppointment));
$currentAppointment->paid = true;
$currentAppointment->payment_date = date('l, d M, Y');
print_r($currentAppointment);
die();
//test



$email = $_SESSION['email'];
$amount = $_SESSION['amount'];
$fullname = $_SESSION['username'];
$date = $_SESSION['appointmentDate'];

// die();

if (isset($_GET['txref'])) {
  $ref = $_GET['txref'];
  $amount = $amount; //Correct Amount from Server
  $currency = "NGN";

  $query = array(
    "SECKEY" => "FLWSECK_TEST-cb5abe0fac77afe808326d1b42e423bb-X",
    "txref" => $ref
  );

  $data_string = json_encode($query);
  // die();

  $ch = curl_init('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify');
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

  $response = curl_exec($ch);

  $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
  $header = substr($response, 0, $header_size);
  $body = substr($response, $header_size);

  curl_close($ch);

  $resp = json_decode($response, true);
  print_r($resp['data']['status'] . "\n");
  print_r($resp['data']['chargecode'] . "\n");
  print_r($resp['data']['amount'] . "\n");
  print_r($resp['data']['currency'] . "\n");
  // die();

  $paymentStatus = $resp['data']['status'];
  $chargeResponsecode = $resp['data']['chargecode'];
  $chargeAmount = $resp['data']['amount'];
  $chargeCurrency = $resp['data']['currency'];

  if (($chargeResponsecode == "00" || $chargeResponsecode == "0")) { //&& ($chargeCurrency == $currency)
    // transaction was successful...
    // please check other things like whether you already gave value for this ref
    // if the email matches the customer who owns the product etc
    /**
     * TODO: mail user
     * uodate appointments db
     * send successful alert msg
     * return to patientsboard.php
     */
    // update appointments db'
    $paidAppointment = $email . '-' . $date . '.json';
    $currentAppointment = json_decode(file_get_contents('db/appointments/' . $paidAppointment));
    $currentAppointment->paid = true;
    $currentAppointment->payment_date = date('l, d M, Y');
    //put the contents back in
    file_put_contents('db/appointments/' . $paidAppointment, json_encode($currentAppointment));
    $mailSubject = 'Confirmation of Bill Payment';
    $mailBody = "Hello" . $fullname . ",\nYour payment for an appointment for " . $currentAppointment->nature . " in the " . $currentAppointment->department . " Department set for " . $date . " has been completed.";
    $sendmail = sendEmail($mailSubject, $mailBody, $email);
    if ($sendMail) {
      setAlert('message', 'Your Payment was successful');
      redirect("patientsboard.php");
    } else {
      setAlert('message', 'Your Payment was successful');
      redirect("patientsboard.php");
    }
  } else {
    //Dont Give Value and return to Failure page
    setAlert('error', 'Your Payment Could not be Completed. Please Try Again!');
    redirect("paybill.php");
  }
} else {
  die('No reference supplied');
}
