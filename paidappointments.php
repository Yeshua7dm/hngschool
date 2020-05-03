<?php
session_start();
include_once("lib/header.php");
require_once('functions/alert.php');
require_once('functions/redirect.php');


//check if user is logged in first
if (!isset($_SESSION['userID'])) {
  setAlert('info', "You do not have access to that page");
  redirect("login.php");
}
?>
<div class="container">
  <div class="row col-6">
    <h4>SNG Hospital: Paid Appointments</h4>
  </div>

  <div class="row col-12">
    <?php if (isset($_SESSION['paidAppointments']) && !empty($_SESSION['paidAppointments'])) { ?>
      <table class="table table-sm table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Patient Name</th>
            <th scope="col">Appointment Date</th>
            <th scope="col">Appointment Time</th>
            <th scope="col">Department</th>
            <th scope="col">Payment Date</th>
            <th scope="col">Amount Paid</th>
          </tr>
        </thead>
        <tbody>
          <?php
          for ($i = 0; $i < count($_SESSION['paidAppointments']); $i++) { ?>
            <tr>
              <th scope="row"><?= $i + 1 ?></th>
              <td><?= $_SESSION['paidAppointments'][$i]->name ?></td>
              <td><?= $_SESSION['paidAppointments'][$i]->date ?></td>
              <td><?= $_SESSION['paidAppointments'][$i]->time ?></td>
              <td><?= $_SESSION['paidAppointments'][$i]->department ?></td>
              <td><?= $_SESSION['paidAppointments'][$i]->payment_date ?></td>
              <td><?= $_SESSION['paidAppointments'][$i]->amount_paid ?></td>
            </tr>
          <?php }
          ?>
        </tbody>
      </table>
    <?php } else { ?>
      <p>No patient has paid for any appointment</p>
    <?php }
    ?>
  </div>
</div>
<?php
include_once("lib/footer.php") ?>