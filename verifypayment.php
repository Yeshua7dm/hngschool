<?php
session_start();
include_once('functions/redirect.php');
include_once('functions/alert.php');

$email = $_SESSION['email'];
$amount = $_SESSION['amount'];
$fullname = $_SESSION['username'];
$date = $_SESSION['appointmentDate'];

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

  if (($chargeResponsecode == "00" || $chargeResponsecode == "0") && ($chargeAmount == $amount)  && ($chargeCurrency == $currency)) {
    // transaction was successful...
    // please check other things like whether you already gave value for this ref
    // if the email matches the customer who owns the product etc
    // update appointments db'
    $paidAppointment = $email . '-' . $date . '.json';
    $currentAppointment = json_decode(file_get_contents('db/appointments/' . $paidAppointment));
    $currentAppointment->paid = true;
    $currentAppointment->amount_paid = "NGN " . $amount;
    $currentAppointment->payment_date = date('l, d M, Y');
    //put the contents back in
    file_put_contents('db/appointments/' . $paidAppointment, json_encode($currentAppointment));
    // //put these into the session then route
    $_SESSION['currentAppointment'] = $currentAppointment->nature;
    $_SESSION['currentDepartment'] = $currentAppointment->department;
    //redirect to email sender
    redirect('paymentmail.php');
  } else {
    //Dont Give Value and return to Failure page
    setAlert('error', 'Your Payment Could not be Completed. Please Try Again!');
    redirect("paybill.php");
  }
}
