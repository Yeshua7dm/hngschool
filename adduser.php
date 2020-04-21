<?php
session_start();
include_once("lib/header.php");
require_once('functions/alert.php');
?>

<div class="container">
  <div class="row col-6">
    <h3>Add New User</h3>
  </div>
  <div class="row col-6">
    <p>Kindly Note: All Fields are Required</p>
  </div>
  <div class="row col-6">
    <p>
      <?php
      if (!isset($_SESSION['userID']) && $_SESSION['designation'] !== 'SuperAdmin') {
        setAlert('info', "You do not have access to that page");
        header("Location:login.php");
      }
      printAlert();
      ?>
    </p>
  </div>
  <div class="row col-6">
    <form method="POST" action="processadduser.php">
      <p>
        <label for="firstName">First Name</label> <br>
        <input class="form-control" name="firstname" placeholder="First Name">
      </p>
      <p>
        <label for="lastName">Last Name</label> <br>
        <input class="form-control" type="text" name="lastname" id="" placeholder="Last Name">
      </p>
      <p>
        <label for="gender">Gender</label> <br>
        <select class="form-control" name="gender" id="" required>
          <option value="">---Select---</option>
          <option>Male</option>
          <option>Female</option>
        </select>
      </p>
      <p>
        <label for="designation">Degination and Role</label> <br>
        <select class="form-control" name="designation" id="" required>
          <option value="">---Select---</option>
          <option>SuperAdmin</option>
          <option>Medical Team (MT)</option>
          <option>Patients</option>
        </select>
      </p>
      <p>
        <label for="department">Department</label> <br>
        <input class="form-control" type="text" name="department" id="" required placeholder="Department">
      </p>
      <p>
        <label for="email">Email Address</label> <br>
        <input class="form-control" type="email" name="email" id="" required placeholder="Email Address">
      </p>
      <p>
        <label for="password">Password</label> <br>
        <input class="form-control" type="password" name="password" required id="" placeholder="password here">
      </p>
      <p>
        <button class="btn btn-sm btn-primary" type="submit">Add New User</button>
      </p>

    </form>
  </div>
</div>


<?php
include_once("lib/footer.php");
