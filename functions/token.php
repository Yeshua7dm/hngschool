<?php
//function for generating token
function generateToken()
{
  $stringToUse = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
  $token = substr(str_shuffle($stringToUse), 0, 15);
  return $token;
}

// TODO: function for validating token
