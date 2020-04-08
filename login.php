<?php
session_start();
include_once("lib/header.php");
require_once("functions/alert.php");
?>
<h3>Login Here</h3>

<?php

//functions instead of writing out all the code
printAlert();
session_unset();
session_destroy();
?>

<form method="POST" action="processlogin.php">
  <p>
    <label for="email">Email Address</label> <br>
    <input <?php
            if (isset($_SESSION['email'])) {

              echo "value=" . $_SESSION['email'];
            }
            ?> type="email" name="email" id="" placeholder="Email Address">
  </p>
  <p>
    <label for="password">Password</label> <br>
    <input type="password" name="password" id="" placeholder="password here">
  </p>
  <p><input type="submit" value="Login" name="Login"></p>

</form>

<?php
// session_unset();
include_once("lib/footer.php") ?>