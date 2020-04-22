<?php session_start();

session_unset();
session_destroy();
require_once('functions/redirect.php');
redirect("index.php");
