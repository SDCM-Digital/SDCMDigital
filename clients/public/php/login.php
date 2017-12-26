<?php
  session_start();
  require_once("configuration.php");
  try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $allowedDomains = array("clients.sdcmdigital.com");
    $domain = parse_url($_SERVER['HTTP_REFERER']);

    if (isset($_POST['submit']) && in_array($domain['host'], $allowedDomains)) {
      $email = $_POST['email'];
      $pass = $_POST['pass'];

      if (!isset($email)) {
        die ("No email address provided");
      }

      if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
        die("Invalid email");
      }

      if (!isset($pass)) {
        die("No password provided");
      }

      if ($r = $conn->query("SELECT COUNT(*) FROM users WHERE email='$email'")) {
        if ($r->fetchColumn() > 0) {
          foreach($conn->query("SELECT * FROM users WHERE email='$email'") as $row) {
            if (password_verify($pass, $row['password'])) {
              $_SESSION['name'] = $row['first'];
              $_SESSION['email'] = $email;
              header ("Location: ../../home");
            }
          }
        } else {
          die ('You do not have an account. Please <a href="./">Register</a>');
        }
      }
    } else {
      die ("You did not submit a form from the official website.");
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
?>
