<?php
session_start();
include_once("lib/header.php");
require_once('functions/alert.php');

//check if user is logged in first
if (!isset($_SESSION['userID'])) {
  $_SESSION['info'] = "You need to login to access the Dashboard";
  header("Location:login.php");
}
?>
<h3>Dashboard</h3>
<?php
printAlert();
?>

<p>User ID:<?= $_SESSION['userID'] ?></p>
<p>Welcome, <?= $_SESSION['username'] ?>. You are logged in as a <?= $_SESSION['userRole'] ?></p>


<?php
include_once("lib/footer.php") ?>