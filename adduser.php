<?php
session_start();
include_once("lib/header.php");
require_once('functions/alert.php');
?>
<h3>Admin: Add New User</h3>
<p>As Super Admin, you have rights to add a new user to the system</p>

<p>Kindly Note: All Fields are Required</p>
<form method="POST" action="processadduser.php">
  <p>
    <?php

    if (!isset($_SESSION['userID']) && $_SESSION['designation'] !== 'SuperAdmin') {
      $_SESSION['info'] = "You do not have access to that page";
      header("Location:login.php");
    }
    printAlert();
    ?>
  </p>


  <p>
    <label for="firstName">First Name</label> <br>
    <input <?php
            if (isset($_SESSION['firstname'])) {
              echo "value=" . $_SESSION['firstname'];
            }
            ?> type="text" name="firstname" required placeholder="First Name">
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
              ?>>Male
      </option>
      <option <?php
              if (isset($_SESSION['gender']) && $_SESSION['gender'] == 'Female') {
                echo 'selected';
              }
              ?>>Female
      </option>
    </select>
  </p>
  <p>
    <label for="designation">Degination and Role</label> <br>
    <select name="designation" id="" required>
      <option value="">---Select---</option>
      <option>SuperAdmin</option>
      <option>Medical Team (MT)</option>
      <option>Patients</option>
    </select>
  </p>
  <p>
    <label for="department">Department</label> <br>
    <input type="text" name="department" id="" required placeholder="Department">
  </p>
  <p>
    <label for="email">Email Address</label> <br>
    <input type="email" name="email" id="" required placeholder="Email Address">
  </p>
  <p>
    <label for="password">Password</label> <br>
    <input type="password" name="password" required id="" placeholder="password here">
  </p>
  <p><input type="submit" value="Add New User" name="register"></p>

</form>

<?php
include_once("lib/footer.php");
