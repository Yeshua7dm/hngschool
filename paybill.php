<?php
session_start();
require_once('lib/header.php');
include_once('functions/alert.php');

$email = $_SESSION['email'];
$appointments = scandir("db/appointments/");

$unpaidAppointments = [];

for ($i = 0; $i < count($appointments); $i++) {
  if (strpos($appointments[$i], $email) !== false) {
    $decoded = json_decode(file_get_contents("db/appointments/" . $appointments[$i]));
    if (!isset($decoded->paid) || !$decoded->paid) {
      array_push($unpaidAppointments, $decoded);
    }
  }
}
// print_r($unpaidAppointments);
$_SESSION['unpaidAppointments'] = $unpaidAppointments;
?>

<div class="container">
  <div class="row col-12 text-center">
    <h4> Unpaid Patient's Booked Appointments</h4>
  </div>
  <div class="row col-6">
    <p>
      <?php printAlert(); ?>
    </p>
  </div>

  <!-- the table of appointments -->
  <div class="row col-8">
    <?php if (isset($_SESSION['unpaidAppointments']) && !empty($_SESSION['unpaidAppointments'])) { ?>
      <form method="post" action="processpayment.php">
        <h5 for="payBill">Select a Booked Appointment</h5>
        <select class="btn btn-lg btn-outline-primary dropdown-toggle form-control" data-toggle="dropdown" aria-expanded="false" name="appointmentDate">
          <option value="">---Select an Appointment---</option>
          <?php for ($i = 0; $i < count($_SESSION['unpaidAppointments']); $i++) { ?>
            <option value="<?= $_SESSION['unpaidAppointments'][$i]->date ?>">
              <?= $_SESSION['unpaidAppointments'][$i]->date . ': ' .
                $_SESSION['unpaidAppointments'][$i]->department . ' Department for ' .
                $_SESSION['unpaidAppointments'][$i]->nature ?>
            </option>
            <div class="dropdown-divider"></div>
          <?php } ?>
        </select>
        <p><label for="bill"></label><br>
          <input class="form-control" type="number" name="bill" placeholder="Amount to be paid in NGN">
        </p>
        <p class="text-center"><button class="btn btn-success" type="submit">Pay Bill</button></p>

      </form>

    <?php } else { ?>
      <p>You have paid for No Unpaid Appointments</p>
  </div>
</div>
<?php }
    include_once('lib/footer.php');
