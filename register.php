<?php
session_start();
include_once("lib/header.php");
require_once('functions/alert.php');

?>
<div class="container">
  <div class="row col-6">
    <h3>Register</h3>
  </div>
  <div class="row col-6">
    <p><strong>Welcome to HNG School, Please Register</strong></p>
  </div>
  <div class="row col-6">
    <p>All Fields are Required</p>
  </div>

  <div class="row col-6">
    <form method="POST" action="processregister.php">
      <p>
        <?php printAlert(); ?>
      </p>
      <p>
        <label for="firstName">First Name</label> <br>
        <input class="form-control" <?php if (isset($_SESSION['firstname'])) {
                                      echo "value=" . $_SESSION['firstname'];
                                    } ?> type="text" name="firstname" id="" placeholder="First Name">
      </p>
      <p>
        <label for="lastName">Last Name</label> <br>
        <input <?php if (isset($_SESSION['lastname'])) {
                  echo "value=" . $_SESSION['lastname'];
                } ?> class="form-control" type="text" name="lastname" id="" placeholder="Last Name">
      </p>
      <p>
        <label for="gender">Gender</label> <br>
        <select class="form-control" name="gender" id="" required>
          <option value="">---Select---</option>
          <option <?php if (isset($_SESSION['gender']) && $_SESSION['gender'] == 'Male') {
                    echo 'selected';
                  } ?> value="Male">Male</option>
          <option <?php if (isset($_SESSION['gender']) && $_SESSION['gender'] == 'Female') {
                    echo 'selected';
                  } ?> value="Female">Female</option>
        </select>
      </p>
      <p>
        <label for="designation">Degination and Role</label> <br>
        <select class="form-control" name="designation" id="" required>
          <option value="">---Select---</option>
          <option <?php
                  if (isset($_SESSION['designation']) && $_SESSION['designation'] == 'Medical Team (MT)') {
                    echo 'selected';
                  } ?>>Medical Team (MT)
          </option>
          <option <?php if (isset($_SESSION['designation']) && $_SESSION['designation'] == 'Patients') {
                    echo 'selected';
                  } ?>>Patients
          </option>
        </select>
      </p>
      <p>
        <label for="department">Department</label> <br>
        <input <?php if (isset($_SESSION['department'])) {
                  echo "value=" . $_SESSION['department'];
                } ?> class="form-control" type="text" name="department" id="" required placeholder="Department">
      </p>
      <p>
        <label for="email">Email Address</label> <br>
        <input <?php if (isset($_SESSION['email'])) {
                  echo "value=" . $_SESSION['email'];
                } ?> class="form-control" type="email" name="email" id="" required placeholder="Email Address">
      </p>
      <p>
        <label for="password">Password</label> <br>
        <input class="form-control" type="password" name="password" required id="" placeholder="password here">
      </p>
      <p><button class="btn btn-sm btn-success" type="submit">Register</button></p>

      <p>
        <a href="forgot.php">Forgot Password?</a> <br>
        <a href="login.php">Already have an Account? Log In</a>
      </p>

    </form>
  </div>

</div>


<?php
session_unset();
include_once("lib/footer.php")
?>