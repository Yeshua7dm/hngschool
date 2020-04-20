<?php
session_start();
include_once("lib/header.php");
require_once("functions/alert.php");
?>
<div class="container">
  <div class="row col-6">
    <h3>Log In</h3>
  </div>

  <div class="row col-6">
    <?php
    //functions instead of writing out all the code
    printAlert();
    session_unset();
    ?>
  </div>
  <div class="row col-6">
    <p>All Fields are Required</p>
  </div>
  <div class="row col-6">
    <form method="POST" action="processlogin.php">
      <p>
        <label for="email">Email Address</label> <br>
        <input <?php if (isset($_SESSION['email'])) {
                  echo "value=" . $_SESSION['email'];
                } ?> class="form-control" type="email" name="email" id="" placeholder="Email Address">
      </p>
      <p>
        <label for="password">Password</label> <br>
        <input class="form-control" type="password" name="password" id="" placeholder="password here">
      </p>
      <p><button class="btn btn-sm btn-success" type="submit">Log In</button></p>

      <p>
        <a href="forgot.php">Forgot Password?</a> <br>
        <a href="register.php">Don't have an Account? Register</a>
      </p>
    </form>
  </div>
</div>



<?php
// session_unset();
include_once("lib/footer.php") ?>