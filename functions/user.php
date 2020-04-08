<?php

function _isTokenSet()
{
  if (isset($_SESSION['token']) && $_GET['token']) {
    return true;
  }
  return false;
}

function _isUserLogged()
{
  if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
    return true;
  }
  return false;
}

function _isEmailSet()
{
  if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    return true;
  } else {
    return false;
  }
}
