<?php
  require_once 'libs/phpti/ti.php';
  session_start();

  // get current page without full url
  $curr_page = substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1) . "";

  $login_button = "Login";
  $button_href = "login.php";
  $loggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true ? true : false;
  if ($loggedIn) { // user loggedd in
    $login_button = "Logout";
    $button_href = "logout.php";
  } else {
    // ensure user logs before visting any page
    if ($curr_page != "login.php" && $curr_page != "register.php") {
      header("Location: login.php");
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>
      <?php startblock('title'); ?>
      <?php endblock(); ?>
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  </head>
  <body>

  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <!-- <div class="navbar-header">
        <a class="navbar-brand" href="index.php">website name</a>
      </div> -->
      <ul class="nav navbar-nav">

        <!-- hide admin page link from everyone other than admins -->
        <li><a
          <?php
            if (!isset($_SESSION['role']) || $_SESSION['role'] > 4) {
              echo "style='display: none'";
            }
          ?>
          href='admin.php'>Admin</a></li>

        <li><a href="team.php">Team</a></li>
        <li><a href="schedule.php">Schedule</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a
          <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
              echo "style='display: none'";
            }
          ?>
          href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
        <li><a href=<?= $button_href ?>><span class="glyphicon glyphicon-log-in"></span> <?= $login_button ?></a></li>
      </ul>
    </div>
  </nav>

  <?php startblock('body'); ?>
  <?php endblock(); ?>

  <footer class="template-footer">
    @copyright <?= date("Y"); ?>
  </footer>

  </body>
</html>
