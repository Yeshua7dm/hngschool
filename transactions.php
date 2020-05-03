<?php
session_start();
require_once('lib/header.php');
$appointments = scandir("db/appointments/");
$email = $_SESSION['email'];

$paidAppointments = [];

for ($i = 0; $i < count($appointments); $i++) {
  if (strpos($appointments[$i], $email) !== false) {
    $decoded = json_decode(file_get_contents("db/appointments/" . $appointments[$i]));
    if (isset($decoded->paid) && $decoded->paid) {
      array_push($paidAppointments, $decoded);
    }
  }
}
$_SESSION['paidAppointments'] = $paidAppointments;
?>
<div class="container">
  <div class="row col-12">
    <h4>Patient's Paid Appointments</h4>
  </div>

  <!-- the table of appointments -->
  <div class="row col-12">
    <?php if (isset($_SESSION['paidAppointments']) && !empty($_SESSION['paidAppointments'])) { ?>
      <table class="table table-sm table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Appointment Date</th>
            <th scope="col">Department</th>
            <th scope="col">Appointment Nature</th>
            <th scope="col">Initial Complaint</th>
            <th scope="col">Payment Date</th>
          </tr>
        </thead>
        <tbody>
          <?php
          for ($i = 0; $i < count($_SESSION['paidAppointments']); $i++) { ?>
            <tr>
              <th scope="row"><?= $i + 1 ?></th>
              <td><?= $_SESSION['paidAppointments'][$i]->date ?></td>
              <td><?= $_SESSION['paidAppointments'][$i]->department ?></td>
              <td><?= $_SESSION['paidAppointments'][$i]->nature ?></td>
              <td><?= $_SESSION['paidAppointments'][$i]->complaint ?></td>
              <td><?= $_SESSION['paidAppointments'][$i]->payment_date ?></td>
            </tr>
          <?php }
          ?>
        </tbody>
      </table>
    <?php } else { ?>
      <p>You have paid for No Appointments</p>
    <?php }
    ?>
  </div>
</div>
<?php
include_once("lib/footer.php") ?>