<?php
  session_start();
  require_once("../../public/php/configuration.php");
  try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_SESSION['email'])) {
      $email = $_SESSION['email'];
      if ($r = $conn->query("SELECT COUNT(*) FROM users WHERE email='$email' AND isadmin='t'")) {
        if ($r->fetchColumn() > 0) {
    ?>
<html>
  <head>
    <title>Client Portal | SDCMDigital</title>
    <link type="text/css" rel="stylesheet" href="../../assets/css/main.css"/>
    <link type="text/css" rel="stylesheet" href="../../assets/css/animate.css"/>
    <link type="text/css" rel="stylesheet" href="../../assets/fa/css/font-awesome.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,300i,700,700i" rel="stylesheet"/>
  </head>
  <body>
    <nav class="animated">
      <ul id="branding">
        <li>Client Portal</li>
      </ul>
      <ul id="navLinks">
        <li><a href="../">HOME</a></li>
        <li><a href="../../downloads">ADD DOWNLOAD</a></li>
        <li><a href="../../invoices">CREATE INVOICE</a></li>
        <li><a href="./">CLIENT LIST</a></li>
      </ul>
      <ul class="loginLink">
        <?php if (!isset($_SESSION['email'])) { ?>
          <li><a href="#" id="lr">Login</a></li>
        <?php } else { ?>
          <li><a href="../../php/logout.php">Logout</a></li>
        <?php } ?>
      </ul>
    </nav>
    <div class="mainHeader">
      <br/>
      <h1>Welcome to the client portal.</h1>
      <p>Here you can access your order history, billing, and content you've ordered.</p>
    </div>
    <div class="information">
      <h1>Client List</h1>
      <hr/>
      <?php
        if ($r = $conn->query("SELECT COUNT(*) FROM users ORDER BY `id` DESC")) {
          if ($r->fetchColumn() > 0) {
            foreach($conn->query("SELECT * FROM users ORDER BY `id` DESC") as $row) {
      ?>
            <div class="infoItem">
              <div>
                <h1>&#35;<?php echo $row['id']; ?></h1>
                <h2><?php echo $row['email']; ?></h2>
              </div>

              <div class="links">
                <?php if ($row['isbanned'] == 'f') { ?>
                  <a href="#" id="ban">Ban Client</a>
                <?php } else { ?>
                  <a href="#" id="unban">Unban Client</a>
                <?php } ?>

                <?php if ($row['isadmin'] == 'f') { ?>
                  <a href="#" id="promote">Make Admin</a>
                <?php } else { ?>
                  <a href="#" id="revoke">Revoke Admin</a>
                <?php } ?>

                <a href="#" id="invoice">See Invoices</a>
                <a href="#" id="cInfo">Client Info</a>
              </div>
            </div>
      <?php
            }
          }
        }
      ?>
    </div>
    <div class="footer">
      <p id="copyright">Copyright &copy; 2017 SDCMDigital</p>
      <p id="email"><a href="mailto:admin@sdcmdigital.com">Email Us</a></p>
    </div>

    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/modal.js"></script>
  </body>
</html>
<?php
        } else {
          include("../404.html");
        }
      }
    } else {
      include("../404.html");
    }
  } catch (PDOException $e) {
    $e->getMessage();
  }
?>
