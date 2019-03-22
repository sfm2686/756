<?php
  include_once 'model/user.class.php';
  include_once 'model/sport.class.php';

  session_start();

  // username validation
  if (isset($_SESSION['user_edit']) && isset($_GET['username'])) {
    echo json_encode(User::validate_username($_GET['username']));
  }

  if (isset($_SESSION['user_edit']) && isset($_GET['password'])) {
    echo json_encode(User::validate_password($_GET['password']));
  }

  if (isset($_SESSION['sports_edit']) && isset($_GET['sport'])) {
    echo json_encode(Sport::validate_name($_GET['sport']));
  }

  // seasons_edit
?>
