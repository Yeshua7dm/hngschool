<?php
session_start();
include_once("lib/header.php");
require_once('functions/alert.php');
require_once('functions/redirect.php');

//check if user is logged in first
if (!isset($_SESSION['userID'])) {
  setAlert('info', "You do not have access to that page");
  redirect("login.php");
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
    <p>
      <button class="btn btn-bg btn-outline-primary">
        <a class="p-2 text-info" href="fetchappointments.php">View Pending Appointments</a>
      </button>
    </p>

  </div>
</div>
<?php
include_once("lib/footer.php") ?>