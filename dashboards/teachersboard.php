<?php
session_start();
include_once("../lib/header.php");
require_once('../functions/alert.php');

//check if user is logged in first
if (!isset($_SESSION['userID'])) {
  $_SESSION['info'] = "You need to login to access the Dashboard";
  header("Location:../login.php");
}
?>
<h3><?= $_SESSION['designation'] ?> Dashboard</h3>
<?php
printAlert();
?>

<p>Welcome, <?= $_SESSION['username'] ?>. Your UserID is: <?= $_SESSION['userID'] ?></p>
<p>Department: <?= $_SESSION['department'] ?></p>
<p>Registration Date: <?= $_SESSION['registrationDate'] ?></p>
<?php if (isset($_SESSION['lastLoginTime']) && isset($_SESSION['lastLoginDate'])) { ?>
  <p>Last Logged In at: <?= $_SESSION['lastLoginTime'] ?>, Date: <?= $_SESSION['lastLoginDate'] ?></p>
<?php
}
include_once("../lib/footer.php") ?>