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
    <h4>SNG Hospital: Patients</h4>
  </div>

  <div class="row col-12">
    <?php if (isset($_SESSION['patients']) && !empty($_SESSION['patients'])) { ?>
      <table class="table table-sm table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Gender</th>
            <th scope="col">Email</th>
          </tr>
        </thead>
        <tbody>
          <?php
          for ($i = 0; $i < count($_SESSION['patients']); $i++) { ?>
            <tr>
              <th scope="row"><?= $i + 1 ?></th>
              <td><?= $_SESSION['patients'][$i]->first_name ?></td>
              <td><?= $_SESSION['patients'][$i]->last_name ?></td>
              <td><?= $_SESSION['patients'][$i]->gender ?></td>
              <td><?= $_SESSION['patients'][$i]->email ?></td>
            </tr>
          <?php }
          ?>
        </tbody>
      </table>
    <?php } else { ?>
      <p>You have no registered patient</p>
    <?php }
    ?>
  </div>
</div>
<?php
include_once("lib/footer.php") ?>