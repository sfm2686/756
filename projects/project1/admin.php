<?php
  require_once 'base.php';
  include_once 'log.php';
  include_once 'controllers/AdminLevel.class.php';
  include_once 'controllers/LeagueManagerLevel.class.php';
  include_once 'controllers/CoachTManagerLevel.class.php';

  // in case an unauthorized user found the admin page link
  if ($_SESSION['role'] == PARENT_ROLE) {
    header("Location: team.php");
  }

  startblock('title');
  echo "Admin";
  endblock();

  $msg = $_SESSION['username'] . " visited admin page";
  Log::record_log($msg);

  startblock('body');

  $err_msg = "";
  // make UserController sub-class instance based on role
  if ($_SESSION['role'] == ADMIN_ROLE) {
    $controller = new AdminLevel();
  } else if ($_SESSION['role'] == L_MANAGER_ROLE) {
    $controller = new LeagueManagerLevel();
  }  else if ($_SESSION['role'] == T_MANAGER_ROLE || $_SESSION['role'] == COACH_ROLE) {
    $controller = new CoachTManagerLevel();
  }
  echo $controller->display_admin_data();

  endblock();
?>
