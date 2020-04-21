<?php
session_start();
include_once('lib/header.php');
require_once('functions/alert.php');

?>
<div class="container">
  <div class="row col-6">
    <h3>Book Appointment</h3>
  </div>
  <div class="row col-6">
    <p>Book an appointment with a Department of the Hospital</p>
  </div>
  <div class="row col-6"></div>
  <div class="row col-6">
    <form action="processappointment.php" method="post">
      <p>
        <label for="appointmentDate">Date of Appointment</label> <br>
        <input <?php if (isset($_SESSION['appointmentDate'])) {
                  echo "value=" . $_SESSION['appointmentDate'];
                } ?> class="form-control" type="date" required name="appointmentDate">
      </p>
      <p>
        <label for="appointmentTime">Time of Appointment</label> <br>
        <input <?php if (isset($_SESSION['appointmentTime'])) {
                  echo "value=" . $_SESSION['appointmentTime'];
                } ?> class="form-control" type="time" required name="appointmentTime">
      </p>
      <p>
        <label for="appointmentNature">Nature of Appointment</label> <br>
        <input <?php if (isset($_SESSION['appointmentNature'])) {
                  echo "value=" . $_SESSION['appointmentNature'];
                } ?> class="form-control" type="text" required name="appointmentNature" placeholder="Nature of Appointment">
      </p>
      <p>
        <label for="initialComplaint">Initial Complaint</label> <br>
        <input <?php if (isset($_SESSION['initialComplaint'])) {
                  echo "value=" . $_SESSION['firstname'];
                } ?> class="form-control" type="text" required name="initialComplaint" placeholder="Initial Complaint">
      </p>
      <p>
        <label for="appointmentDepartment">Department of Appointment</label> <br>
        <input <?php if (isset($_SESSION['appointmentDepartment'])) {
                  echo "value=" . $_SESSION['appointmentDepartment'];
                } ?> class="form-control" type="text" required name="appointmentDepartment" id="" placeholder="Department">
      </p>
      <p>
        <button class="btn btn-primary" type="submit">Book Appointment</button>
      </p>
    </form>
  </div>



</div>
<?php
include_once('lib/footer.php');
