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
    <?php if (isset($_SESSION['lastLoginTime']) && isset($_SESSION['lastLoginDate'])) { ?>
      <p>Last Logged In at: <?= $_SESSION['lastLoginTime'] ?>, Date: <?= $_SESSION['lastLoginDate'] ?></p>
  </div>
  <div class="col-8">
    <p>
      <button class="btn btn-success"><a class="p-2 text-white" href='adduser.php'>Add A New User</a></button>
      <button class="btn btn-primary"><a class="p-2 text-white" href='fetchstaff.php'>View All Staff</a></button>
      <button class="btn btn-primary"><a class="p-2 text-white" href='fetchpatients.php'>View All Patients</a></button>
    </p>
  </div>

</div>
<?php
    }
    include_once("lib/footer.php") ?>