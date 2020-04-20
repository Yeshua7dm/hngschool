<?php
session_start();
include_once("lib/header.php");
require_once("functions/alert.php");
?>

<div class="container">
  <div class="row col-6">
    <h3>Forgot Password? Fix it</h3>
  </div>
  <div class="row col-6">
    <?php
    printAlert();
    ?>
  </div>
  <div class="row col-6">
    <p>Provide the email you registered your account</p>
  </div>
  <div class="row col-6">
    <form action="processforgot.php" method="post">
      <p>
        <label for="email">Email Address</label> <br>
        <input <?php if (isset($_SESSION['email'])) {
                  echo "value=" . $_SESSION['email'];
                } ?> class="form-control" type="email" name="email" id="" placeholder="Email Address">
      </p>
      <button class="btn btn-sm btn-primary" type="submit">Send Reset Message</button>

      <p>
        <a href="register.php">Don't have an account yet? Register</a> <br>
        <a href="login.php">Already have an Account? Log In</a>
      </p>
    </form>
  </div>
</div>
<?php
// session_unset();
include_once("lib/footer.php") ?>