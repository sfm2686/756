<?php
  include 'base.php';
  include 'log.php';

  // Log::record_log($e->getMessage());

  session_destroy();
  header("Location: login.php");

?>
