<?php
session_start();
include_once("lib/header.php");
require_once('functions/alert.php');

//check if user is logged in first
if (!isset($_SESSION['userID'])) {
  setAlert('info', "You do not have access to that page");
  header("Location:login.php");
}
?>
<div class="container">
  <div class="row col-6">
    <h4>SNG Hospital: Patients</h4>
  </div>
  <?php
  /**
   * TODO: Loop through the Users db folder
   * 
   * when done, loop through the *staff* array
   * display the users in the staff array 
   * 
   */
  //create an empty array
  ?>
  <div class="row col-6">
    <ul class="list-group list-group-flush">
      <?php
      for ($i = 0; $i < count($_SESSION['patients']); $i++) { ?>
        <li class="list-group-item"><?= "" . $i + 1 . "  " . $_SESSION['patients'][$i] ?></li>
      <?php } ?>
    </ul>
  </div>
</div>
<?php
include_once("lib/footer.php") ?>