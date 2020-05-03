<?php
session_start();
include_once("lib/header.php");

//check if user is logged in first
if (!isset($_SESSION['userID'])) {
  setAlert('info', "You do not have access to that page");
  header("Location:login.php");
}
?>
<div class="container">
  <div class="row col-12">
    <h4><?= $_SESSION['department'] ?> Department: Booked Appointments</h4>
  </div>
  <div class="row col-12">
    <?php if (isset($_SESSION['appointments']) && !empty($_SESSION['appointments'])) { ?>
      <table class="table  table-sm table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Patient Name</th>
            <th scope="col">Appointment Date</th>
            <th scope="col">Nature</th>
            <th scope="col">Initial Complaint</th>
            <th scope="col">Payment Date</th>
            <th scope="col">Amount</th>
          </tr>
        </thead>
        <tbody>
          <?php
          for ($i = 0; $i < count($_SESSION['appointments']); $i++) { ?>
            <tr>
              <th scope="row"><?= $i + 1 ?></th>
              <td><?= $_SESSION['appointments'][$i]->name ?></td>
              <td><?= $_SESSION['appointments'][$i]->date ?></td>
              <td><?= $_SESSION['appointments'][$i]->nature ?></td>
              <td><?= $_SESSION['appointments'][$i]->complaint ?></td>
              <?php if (isset($_SESSION['appointments'][$i]->paid) && $_SESSION['appointments'][$i]->paid) { ?>
                <td class="bg-success text-white"><?= $_SESSION['appointments'][$i]->payment_date ?></td>
                <td class="bg-success text-white"><?= $_SESSION['appointments'][$i]->amount_paid ?></td>
              <?php } else { ?>
                <td class="bg-warning text-dark">Yet To Pay</td>
                <td class="bg-warning text-dark">Yet To Pay</td>
              <?php } ?>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    <?php } else { ?>
      <p>You have no pending appointments</p>
    <?php }
    ?>
  </div>
</div>
<?php

include_once("lib/footer.php") ?>