<?php
  require_once 'libs/phpti/ti.php';
  session_start();

  // get current page without full url
  $curr_page = substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1) . "";

  define("BASE_URL", "http://serenity.ist.rit.edu/~sfm2686/756/projects/project1/");
  define("BASE_PATH", dirname(__FILE__)); // starts from project1 directory
  define("LOGIN_PAGE", BASE_URL . 'login.php');
  define("LOGOUT_PAGE", BASE_URL . 'logout.php');
  define("ADMIN_PAGE", BASE_URL . 'admin.php');
  define("TEAM_PAGE", BASE_URL . 'team.php');
  define("SCHEDULE_PAGE", BASE_URL . 'schedule.php');
  define("REGISTER_PAGE", BASE_URL . 'register.php');

  define("CSS_FILE", BASE_URL . '/static/style.css?' . time());
  define("JS_FILE", BASE_URL . '/static/ajax_caller.js?' . time());
  define("JS_VALIDATOR_PATH", BASE_URL . "/ajax_validators.php");
  define("LOG_FILE", BASE_PATH . "/log.txt");

  $login_button = "Login";
  $button_href = LOGIN_PAGE;
  $loggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true ? true : false;
  if ($loggedIn) { // user loggedd in
    $login_button = "Logout";
    $button_href = LOGOUT_PAGE;
  } else {
    // ensure user logs before visting any page
    if ($curr_page != "login.php" && $curr_page != "register.php") {
      header("Location: " . LOGIN_PAGE);
    }
  }

  // ROLES CONSTANTS
  define("ADMIN_ROLE", 1);
  define("L_MANAGER_ROLE", 2);
  define("T_MANAGER_ROLE", 3);
  define("COACH_ROLE", 4);
  define("PARENT_ROLE", 5);
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
    <link rel="stylesheet" href=<?= CSS_FILE ?>>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="<?= JS_FILE ?>"></script>
  </head>
  <body>

    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <?php
          if ($loggedIn) {
            echo "<div class='navbar-header'>
              <p class='navbar-brand'>" . $_SESSION['username'] . "</p>
            </div>";
          }
        ?>
        <ul class="nav navbar-nav">
          <li><a
            <?php
              if (!isset($_SESSION['role']) || $_SESSION['role'] > 4) {
                echo "style='display: none'";
              }
            ?>
            href=<?= ADMIN_PAGE ?>>Admin</a></li>

          <li><a href=<?= TEAM_PAGE ?>>Team</a></li>
          <li><a href=<?= SCHEDULE_PAGE ?>>Schedule</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a
            <?php
              if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                echo "style='display: none'";
              }
            ?>
            href=<?= REGISTER_PAGE ?>><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
          <li><a href=<?= $button_href ?>><span class="glyphicon glyphicon-log-in"></span> <?= $login_button ?></a></li>
        </ul>
      </div>
    </nav>

    <div class="main-container">
      <?php startblock('body'); ?>
      <?php endblock(); ?>
    </div>

  </body>
  <!-- <footer class="template-footer">
    @copyright <?= date("Y"); ?>
  </footer> -->
</html>
