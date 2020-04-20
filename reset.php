<?php
session_start();
include_once("lib/header.php");
require_once("functions/alert.php");
require_once("functions/user.php");
?>
<div class="container">
  <div class="row col-6">
    <h3>SNG Dashboard: Reset Password</h3>
  </div>
  <div class="row col-6">
    <p>Reset Password associated with your account</p>
  </div>
  <div class="row col-6">
    <?php
    if (!_isTokenSet() && !_isUserLogged()) {
      setAlertType('error', "You are not authorized to view that page");
      header("Location: login.php");
    }
    printAlert();
    ?>
  </div>
  <div class="row col-6">
    <form action="processreset.php" method="post">
      <p>
        <label for="email">Email Address</label> <br>
        <input <?php if (_isEmailSet()) {
                  echo "value='" . $_SESSION['email'] . "' readonly";
                } ?> class="form-control" type="email" name="email" placeholder="Email Address">
      </p>
      <p>
        <label for="password">New Password</label> <br>
        <input class="form-control" type="password" name="password" id="" placeholder="New Password">
      </p>

      <?php
      if (_isEmailSet()) { ?>
        <input type="hidden" name="token" value="<?= $_GET['token'] ?>">
      <?php
      }
      ?>
      <p>
        <button class="btn btn-primary" type="submit">Reset Password</button>
      </p>
    </form>
  </div>
</div>



<?php
// session_unset();
include_once("lib/footer.php");
