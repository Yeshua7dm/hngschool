<?php
session_start();
include_once("lib/header.php");
require_once('functions/alert.php');

?>

<h2>Welcome to HNG School, Please Register</h2>
<p>All Fields are Required</p>
<form method="POST" action="processregister.php">
  <p>
    <?php
    printAlert();
    ?>
  </p>


  <p>
    <label for="firstName">First Name</label> <br>
    <input <?php
            if (isset($_SESSION['firstname'])) {
              echo "value=" . $_SESSION['firstname'];
            }
            ?> type="text" name="firstname" id="" placeholder="First Name">
  </p>
  <p>
    <label for="lastName">Last Name</label> <br>
    <input <?php
            if (isset($_SESSION['lastname'])) {
              echo "value=" . $_SESSION['lastname'];
            }
            ?> type="text" name="lastname" id="" placeholder="Last Name">
  </p>
  <p>
    <label for="gender">Gender</label> <br>
    <select name="gender" id="" required>
      <option value="">---Select---</option>
      <option <?php
              if (isset($_SESSION['gender']) && $_SESSION['gender'] == 'Male') {
                echo 'selected';
              }
              ?> value="Male">Male</option>
      <option <?php
              if (isset($_SESSION['gender']) && $_SESSION['gender'] == 'Female') {
                echo 'selected';
              }
              ?> value="Female">Female</option>
    </select>
  </p>
  <p>
    <label for="designation">Degination and Role</label> <br>
    <select name="designation" id="" required>
      <option value="">---Select---</option>
      <option <?php
              if (isset($_SESSION['designation']) && $_SESSION['designation'] == 'Non-Teaching Staff') {
                echo 'selected';
              }
              ?> value="Non-Teaching Staff">Non-Teaching Staff</option>
      <option <?php
              if (isset($_SESSION['designation']) && $_SESSION['designation'] == 'Teacher') {
                echo 'selected';
              }
              ?> value="Teacher">Teacher</option>Teacher
      <option <?php
              if (isset($_SESSION['designation']) && $_SESSION['designation'] == 'Student') {
                echo 'selected';
              }
              ?> value="Student">Student</option>
    </select>
  </p>
  <p>
    <label for="department">Department</label> <br>
    <input <?php
            if (isset($_SESSION['department'])) {

              echo "value=" . $_SESSION['department'];
            }
            ?> type="text" name="department" id="" required placeholder="Department">
  </p>
  <p>
    <label for="email">Email Address</label> <br>
    <input <?php
            if (isset($_SESSION['email'])) {

              echo "value=" . $_SESSION['email'];
            }
            ?> type="email" name="email" id="" required placeholder="Email Address">
  </p>
  <p>
    <label for="password">Password</label> <br>
    <input type="password" name="password" required id="" placeholder="password here">
  </p>
  <p><input type="submit" value="Register" name="register"></p>

</form>

<?php
session_unset();
include_once("lib/footer.php")
?>