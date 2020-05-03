<?php

function printAlert()
{
  $types = ['message', 'error', 'info'];
  $color = ['success', 'danger', 'primary'];

  for ($i = 0; $i < count($types); $i++) {
    if (isset($_SESSION[$types[$i]]) && !empty($_SESSION[$types[$i]])) {
      echo "<div class='alert alert-" . $color[$i] . "' role='alert'>" . $_SESSION[$types[$i]] . " </div>";
      $_SESSION[$types[$i]] = '';
    }
  }
}

function setAlert($type = "message", $content = "")
{
  switch ($type) {
    case "message":
      $_SESSION['message'] = $content;
      break;
    case "error":
      $_SESSION['error'] = $content;
      break;
    case "info":
      $_SESSION['info'] = $content;
      break;
    default:
      $_SESSION['message'] = $content;
      break;
  }
}
