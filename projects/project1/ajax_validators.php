<?php
  include_once 'model/user.class.php';
  include_once 'model/sport.class.php';
  include_once 'model/season.class.php';
  include_once 'model/team.class.php';
  include_once 'model/schedule.class.php';
  include_once 'model/position.class.php';
  include_once 'model/player.class.php';

  session_start();

  /******************************** USER **************************************/
  if (isset($_SESSION['user_edit']) && isset($_GET['username'])) {
    echo json_encode(User::validate_username($_GET['username']));
  }

  if (isset($_SESSION['user_edit']) && isset($_GET['password'])) {
    echo json_encode(User::validate_password($_GET['password']));
  }

  /******************************** SPORT *************************************/
  if (isset($_SESSION['sports_edit']) && isset($_GET['sport'])) {
    echo json_encode(Sport::validate_name($_GET['sport']));
  }

  /******************************* SEASON *************************************/
  if (isset($_SESSION['seasons_edit']) && isset($_GET['s_year'])) {
    echo json_encode(Season::validate_year($_GET['s_year']));
  }

  if (isset($_SESSION['seasons_edit']) && isset($_GET['s_desc'])) {
    echo json_encode(Season::validate_desc($_GET['s_desc']));
  }

  /******************************** TEAM **************************************/
  if (isset($_SESSION['teams_edit']) && isset($_GET['team_name'])) {
    echo json_encode(Team::validate_name($_GET['team_name']));
  }

  if (isset($_SESSION['teams_edit']) && isset($_GET['team_mascot'])) {
    echo json_encode(Team::validate_mascot($_GET['team_mascot']));
  }

  if (isset($_SESSION['teams_edit']) && isset($_GET['team_homecolor'])) {
    echo json_encode(Team::validate_color($_GET['team_homecolor']));
  }

  if (isset($_SESSION['teams_edit']) && isset($_GET['team_awaycolor'])) {
    echo json_encode(Team::validate_color($_GET['team_awaycolor']));
  }

  if (isset($_SESSION['teams_edit']) && isset($_GET['team_maxplayers'])) {
    echo json_encode(Team::validate_maxplayers($_GET['team_maxplayers']));
  }

  /****************************** SCHEDULE ************************************/
  if (isset($_SESSION['sch_edit']) && isset($_GET['sche_away_score'])) {
    echo json_encode(Schedule::validate_score($_GET['sche_away_score']));
  }

  if (isset($_SESSION['sch_edit']) && isset($_GET['sche_home_score'])) {
    echo json_encode(Schedule::validate_score($_GET['sche_home_score']));
  }

  /****************************** POSITION ************************************/
  if (isset($_SESSION['pos_edit']) && isset($_GET['pos_name'])) {
    echo json_encode(Position::validate_name($_GET['pos_name']));
  }

  /******************************* PLAYER *************************************/
  if (isset($_SESSION['player_edit']) && isset($_GET['player_fname'])) {
    echo json_encode(Player::validate_fname($_GET['player_fname']));
  }

  if (isset($_SESSION['player_edit']) && isset($_GET['player_lname'])) {
    echo json_encode(Player::validate_lname($_GET['player_lname']));
  }

  if (isset($_SESSION['player_edit']) && isset($_GET['player_jersey'])) {
    echo json_encode(Player::validate_jersey($_GET['player_jersey']));
  }
?>
