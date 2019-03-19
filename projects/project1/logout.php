<?php
  include 'base.php';
  include 'log.php';

  // recording logout in the log
  $msg = $_SESSION['username'] . " logged out";
  Log::record_log($msg);

  // cleaning the session
  unset($_SESSION['loggedin']);
  unset($_SESSION['username']);
  unset($_SESSION['role']);
  unset($_SESSION['team']);
  unset($_SESSION['league']);
  session_destroy();
  
  // redirecting  to login page
  header("Location: login.php");

?>
