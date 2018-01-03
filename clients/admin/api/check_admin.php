<?php
  require("./api.php");
  session_start();

  if (!(isset($_SESSION['email']))) {
    die ("You are required to login to access this.");
  }

  $user_email = $_SESSION['email'];

  foreach(get_pdo()->query("SELECT * FROM users WHERE email='$user_email'") as $row) {
    if ($row['isadmin'] == 'f') {
      die("You are not an administative user.");
    }
  }
?>
