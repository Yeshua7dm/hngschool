<?php

function sendEmail($subject = '', $message = '', $email = '')
{
  $headers = 'FROM: no-reply@test.com' . "\r\n" . "CC: yeshua7dm@gmail.com";
  mail($email, $subject, $message, $headers);
}
