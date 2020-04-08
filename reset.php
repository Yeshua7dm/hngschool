<?php
session_start();
include_once("lib/header.php");
require_once("functions/alert.php");
require_once("functions/user.php");
?>
<h3>Reset Password</h3>
<p>Reset Password associated with your account</p>
<?php

if (_isTokenSet() && _isUserLogged()) {
  setAlertType('error', "You are not authorized to view that page");
  header("Location: login.php");
}

printAlert();
?>

<form action="processreset.php" method="post">
  <p>
    <label for="email">Email Address</label> <br>
    <input <?php
            if (_isEmailSet()) {
              echo "value='" . $_SESSION['email'] . "' readonly";
            }
            ?> type="email" name="email" placeholder="Email Address">
  </p>
  <p>
    <label for="password">New Password</label> <br>
    <input type="password" name="password" id="" placeholder="New Password">
  </p>

  <?php
  if (_isEmailSet()) { ?>
    <input type="hidden" name="token" value="<?= $_GET['token'] ?>">
  <?php
  }
  ?>


  <p><input type="submit" value="Reset Password"></p>
</form>

<?php
// session_unset();
include_once("lib/footer.php");
