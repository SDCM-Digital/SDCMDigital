<?php
  session_start();
  require_once("./public/php/configuration.php");
  try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    ?>
<html>
  <head>
    <title>Client Portal | SDCMDigital</title>
    <link type="text/css" rel="stylesheet" href="assets/css/main.css"/>
    <link type="text/css" rel="stylesheet" href="assets/css/animate.css"/>
    <link type="text/css" rel="stylesheet" href="assets/fa/css/font-awesome.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,300i,700,700i" rel="stylesheet"/>
  </head>
  <body>
    <nav class="animated">
      <ul id="branding">
        <li>Client Portal</li>
      </ul>
      <ul id="navLinks">
        <li><a href="../">HOME</a></li>
        <li><a href="./home">BILLING</a></li>
        <li><a href="./downloads">CONTENT</a></li>
        <li><a href="./invoices">ORDERS</a></li>
        <?php
          if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            if ($r = $conn->query("SELECT COUNT(*) FROM users WHERE email='$email' AND isadmin='t'")) {
              if ($r->fetchColumn() > 0) {
                echo '<li><a href="./admin">ADMIN</a></li>';
              }
            }
          }
        ?>
      </ul>
      <ul class="loginLink">
        <?php if (!isset($_SESSION['email'])) { ?>
          <li><a href="#" id="lr">Login</a></li>
        <?php } else { ?>
          <li><a href="./php/logout.php">Logout</a></li>
        <?php } ?>
      </ul>
    </nav>
    <div class="mainHeader">
      <br/>
      <h1>Welcome to the client portal.</h1>
      <p>Here you can access your order history, billing, and content you've ordered.</p>
    </div>
    <div class="information">
      <h1>Information</h1>
      <hr/>
      <?php
        if ($r = $conn->query("SELECT COUNT(*) FROM news ORDER BY `id` DESC")) {
          if ($r->fetchColumn() > 0) {
            foreach($conn->query("SELECT * FROM news ORDER BY `id` DESC") as $row) {
      ?>
      <div class="infoItem single">
        <div>
          <h1><?php echo $row['subject']; ?></h1>
          <h2><?php echo date("M d, Y", strtotime($row['date'])); ?></h2>
        </div>
        <p><?php echo $row['content']; ?></p>
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

    <div id="modalCover"></div>
    <div class="login">
      <div class="body">
        <div class="head">
          <h1>Login</h1>
          <a href="#" id="close"><i class="fa fa-close"></i></a>
        </div>

        <form method="post" action="./public/php/login.php">
          <input type="email" name="email" class="formInput" placeholder="Email address" autocomplete="off" required>
          <input type="password" name="pass" class="formInput" placeholder="Password" autocomplete="off" required>

          <div class="submit">
            <button type="submit" class="formSubmit" name="submit">Confirm Login</button>
          </div>
        </form>
      </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/modal.js"></script>
  </body>
</html>
<?php
} catch (PDOException $e) {
$e->getMessage();
}
?>
