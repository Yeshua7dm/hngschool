<?php
session_start();
include_once("lib/header.php");
require_once("functions/alert.php");
?>
<h3>Forgot Password? Fix it</h3>
<?php
printAlert();
?>

<p>Provide the email you registered your account</p>
<form action="processforgot.php" method="post">
  <p>
    <label for="email">Email Address</label> <br>
    <input <?php
            if (isset($_SESSION['email'])) {
              echo "value=" . $_SESSION['email'];
            }
            ?> type="email" name="email" id="" placeholder="Email Address">
  </p>
  <p><input type="submit" value="Send Reset Message"></p>
</form>
<?php
// session_unset();
include_once("lib/footer.php") ?>