<?php session_start();

$errorCount = 0;
// use tenary operator to check if the fields are empty
//compared to long list of if statements
$firstname = $_POST["firstname"] != "" ? $_POST["firstname"] : $errorCount++;
$lastname = $_POST["lastname"] != "" ? $_POST["lastname"] : $errorCount++;
$gender = $_POST["gender"] != "" ? $_POST["gender"] : $errorCount++;
$designation = $_POST["designation"] != "" ? $_POST["designation"] : $errorCount++;
$department = $_POST["department"] != "" ? $_POST["department"] : $errorCount++;
$email = $_POST["email"] != "" ? $_POST["email"] : $errorCount++;
$password = $_POST["password"] != "" ? $_POST["password"] : $errorCount++;

// checks if the fields are empty
$_SESSION['firstname'] = $firstname;
$_SESSION['lastname'] = $lastname;
$_SESSION['gender'] = $gender;
$_SESSION['designation'] = $designation;
$_SESSION['department'] = $department;
$_SESSION['email'] = $email;
// $_SESSION['password'] = $password;

if ($errorCount > 0) {

  $sessionError = "You have " . $errorCount . " empty field";
  if ($errorCount > 1) {
    $sessionError .= "s";
  }
  $_SESSION['error'] = $sessionError . " in your form submission";
  header("Location: register.php");
} else {
  //validate name : no numbers+, >=2+, not empty+
  if (strlen($firstname) < 2 || strlen($lastname) < 2) {
    $_SESSION['error'] = 'Your Name is shorter than the required length!';
    header('Location: register.php');
    die();
  }
  if (!preg_match("/^[a-zA-Z]*$/", $firstname) || !preg_match("/^[a-zA-Z]*$/", $lastname)) {
    $_SESSION['error'] = 'Your name should only contain letters, no numbers!';
    header('Location: register.php');
    die();
  }
  //validate email : valid, >=5, not empty, have @ and .
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Your email is invalid! Please enter a valid email!';
    header('Location: register.php');
    die();
  }
  if (strlen($email) < 5) {
    $_SESSION['error'] = 'Your email should contain at least 5 characters!';
    header('Location: register.php');
    die();
  }



  //check the db/users directory for thr files in it
  $arrayOfUsers = scandir("./db/users/");
  $usersCount = count($arrayOfUsers);
  $newUserID = $usersCount - 1;
  // save the data into an array and then json_encode the array
  $userData = [
    'id' => $newUserID,
    'first_name' => $firstname,
    'last_name' => $lastname,
    'email' => $email,
    'gender' => $gender,
    'password' => password_hash($password, PASSWORD_DEFAULT),
    'designation' => $designation,
    'department' => $department,
    'registrationDate' => date('l, d M, Y')
  ];

  for ($i = 0; $i < $usersCount; $i++) {
    # code...
    $currentUser = $arrayOfUsers[$i];
    if ($currentUser == $email . ".json") {
      $_SESSION['error'] = "Registration failed! User Already Exists";
      header("Location: register.php");
      die();
    }
  }
  // write the data into a json file in the DB
  // require('db/')
  file_put_contents("db/users/" . $email . ".json", json_encode($userData));

  //send the user to the login page after a succesful login by the user
  $_SESSION["message"] = "Registration Successful!!";
  header("Location: login.php");
}
