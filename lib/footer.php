 <p>
   <a href="/index.php">Home</a> |
   <?php if (!isset($_SESSION['userID'])) { ?>
     <a href="/login.php">Login</a> |
     <a href="/register.php">Register</a> |
     <a href="/forgot.php">Forgot Password</a>
   <?php
    } else {
      echo "<a href='/logout.php'>LogOut</a> |";
      echo "<a href='/reset.php'>Reset Password</a>";
    }

    if (isset($_SESSION['designation']) && $_SESSION['designation'] == 'SuperAdmin') {
      echo " | <a href='/adduser.php'>Add A New User</a>";
    }
    ?>

 </p>
 </body>

 </html>