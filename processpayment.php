<?php
session_start();
include_once('functions/redirect.php');
include_once('functions/alert.php');

print_r($_POST);
print_r($_SESSION);

if (isset($_POST['appointmentDate']) &&  !empty($_POST['appointmentDate'])) {
  $_SESSION['appointmentDate'] = $_POST['appointmentDate'];
} else {
  setAlert('error', 'You have to select an appointment first!');
  redirect("paybill.php");
  die();
}

// $_SESSION['appointmentDate']

$email = $_SESSION['email'];
$fullname = $_SESSION['username'];
$name = explode(' ', $fullname);
$firstname = $name[0];
$lastname = $name[1];
$amount = $_POST['bill'];
$_SESSION['amount'] = $amount;

$curl = curl_init();

$amount = $amount;
$txref = "rave-" . mt_rand(); // ensure you generate unique references per transaction.
$PBFPubKey = "FLWPUBK_TEST-d4fff0538e6ee48f25bd02ed2a5c136f-X"; // get your public key from the dashboard.
$redirect_url = "http://localhost/hngschool/verifypayment.php";


curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'amount' => $amount,
    'customer_email' => $email,
    'currency' => 'NGN',
    'txref' => $txref,
    'PBFPubKey' => $PBFPubKey,
    'custom_title' => 'SNG Hospital',
    'redirect_url' => $redirect_url
  ]),
  CURLOPT_HTTPHEADER => [
    "content-type: application/json",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);

if ($err) {
  // there was an error contacting the rave API
  die('Curl returned error: ' . $err);
}

$transaction = json_decode($response);

if (!$transaction->data && !$transaction->data->link) {
  // there was an error from the API
  print_r('API returned error: ' . $transaction->message);
}

// redirect to page so User can pay
redirect($transaction->data->link);
