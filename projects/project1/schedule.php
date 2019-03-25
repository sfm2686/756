<?php
  include 'base.php';
  include_once 'controllers/AdminLevel.class.php';
  include_once 'controllers/LeagueManagerLevel.class.php';
  include_once 'controllers/CoachTManagerLevel.class.php';
  include_once 'controllers/ParentLevel.class.php';

  startblock('title');
  echo "Schedule";
  endblock();

  $msg = $_SESSION['username'] . " visited schedule page";
  Log::record_log($msg);

  startblock('body');

  $err_msg = "";

  $controller = null;
  // make UserController sub-class instance based on role
  if ($_SESSION['role'] == ADMIN_ROLE) {
    $controller = new AdminLevel();
  } else if ($_SESSION['role'] == L_MANAGER_ROLE) {
    $controller = new LeagueManagerLevel();
  } else if ($_SESSION['role'] == T_MANAGER_ROLE || $_SESSION['role'] == COACH_ROLE) {
    $controller = new CoachTManagerLevel();
  } else if ($_SESSION['role'] == PARENT_ROLE) {
    $controller = new ParentLevel();
  }

  // display schedule data from the sub-class
  echo $controller->display_schedule_data();
  endblock();
?>
