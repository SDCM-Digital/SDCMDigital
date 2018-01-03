<?php
  require_once("../../public/php/configuration.php");
  $key = file_get_contents("../privateSite/key.txt");

  function get_pdo() {
    try {
      $conn = new PDO("mysql:host=localhost;dbname=billing_area", "sdcm", "SamCaleb2017!");
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      return $conn;
    } catch (PDOException $e) {
      $e->getMessage();
    }
  }

  function ban_client($email) {
    if ($r = get_pdo()->query("SELECT COUNT(*) FROM users WHERE email='$email'")) {
      if ($r->fetchColumn() > 0) {
        $sql = "UPDATE users SET isbanned='t', isadmin='f' WHERE email='$email'";
        $stmt = get_pdo()->prepare($sql);
        $stmt->execute();
      }
    }
  }

  function unban_client($email) {
    if ($r = get_pdo()->query("SELECT COUNT(*) FROM users WHERE email='$email'")) {
      if ($r->fetchColumn() > 0) {
        $sql = "UPDATE users SET isbanned='f' WHERE email='$email'";
        $stmt = get_pdo()->prepare($sql);
        $stmt->execute();
      }
    }
  }
?>
