<?php
session_start();
include_once("lib/header.php");
require_once('functions/alert.php');

//check if user is logged in first
if (!isset($_SESSION['userID'])) {
  $_SESSION['info'] = "You need to login to access the Dashboard";
  header("Location:login.php");
}
?>
<div class="container">
  <div class="row col-6">
    <h4>SNG Hospital: Staff</h4>
  </div>
  <div class="row col-6">
    <ul class="list-group list-group-flush">
      <?php
      for ($i = 0; $i < count($_SESSION['staff']); $i++) { ?>
        <li class="list-group-item"><?= "" . $i + 1 . "  " . $_SESSION['staff'][$i] ?></li>
      <?php } ?>
    </ul>
  </div>
</div>
<?php
include_once("lib/footer.php") ?>