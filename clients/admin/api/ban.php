<?php
  require("./check_admin.php");

  $auth = false;

  if (isset($_GET['pKey']) && $_GET['pKey'] == $key) {
    $auth = true;
  }

  if ($auth == false) {
    echo ("Authentication String Required.");
    return;
  }

  echo ban_client($_GET['email']);
  header("Location: https://clients.sdcmdigital.com");
?>
