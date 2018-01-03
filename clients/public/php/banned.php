<?php
  session_start();
  try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_SESSION['email'])) {
      $email = $_SESSION['email'];
      if ($r = $conn->query("SELECT COUNT(*) FROM users WHERE email='$email' AND isbanned='t'")) {
        if ($r->fetchColumn() > 0) {
          die("You're account has been banned from this site.");
        }
      }
    }
  } catch (PDOException $e) {
    $e->getMessage();
  }
?>
