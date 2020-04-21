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
<div class="container">
  <div class="row col-6">
    <h3>SNG Hospital: Dashboard</h3>
  </div>
  <div class="row col-6">
    <?php
    printAlert();
    ?>
  </div>
  <div class="column col-6">
    <p>Welcome, <?= $_SESSION['username'] ?>. Your UserID is: <?= $_SESSION['userID'] ?></p>
    <p>Designation: <?= $_SESSION['designation'] ?></p>
    <p>Department: <?= $_SESSION['department'] ?></p>
    <p>Registration Date: <?= $_SESSION['registrationDate'] ?></p>
    <?php if (isset($_SESSION['lastLoginTime']) && $_SESSION['lastLoginTime'] != "" && isset($_SESSION['lastLoginDate']) && $_SESSION['lastLoginDate'] != '') { ?>
      <p>Last Logged In at: <?= $_SESSION['lastLoginTime'] ?>, Date: <?= $_SESSION['lastLoginDate'] ?></p>
    <?php } else { ?>
      <p>This is your first Log In</p>
    <?php } ?>
  </div>

  <div class="row col-6">
    <p class="m-1">
      <button class="btn btn-outline-primary"><a class="p-1 text-info" href='bookappointment.php'>Book Appointment</a></button>
    </p>
    <p class="m-1">
      <button class="btn btn-outline-success"><a class="p-1 text-success" href='paybill.php'>Pay Bill</a></button>
    </p>
  </div>
</div>
<?php
include_once("lib/footer.php") ?>