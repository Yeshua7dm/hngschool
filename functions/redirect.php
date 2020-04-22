<?php

function redirect($url = '')
{
  return header("location: " . $url);
}
