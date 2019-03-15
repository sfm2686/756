<?php
  include 'base.php';
  require_once 'db.class.php';

  startblock('title');
  echo "Team";
  endblock();

  // if ($_SESSION['role'] == 5) {
  startblock('body');
  if (true) {
    include 'view_team_form.php';
  }
  endblock();
?>
