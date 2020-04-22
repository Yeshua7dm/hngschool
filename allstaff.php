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