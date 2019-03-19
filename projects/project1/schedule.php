<?php
  include 'base.php';
  include 'log.php';
  include_once 'PDO_DB.class.php';

  include 'util.php';

  startblock('title');
  echo "Schedule";
  endblock();

  $msg = $_SESSION['username'] . " visited schedule page";
  Log::record_log($msg);

  startblock('body');

  $db = PDO_DB::getInstance();
  $data = $db->get_schedules_for_user($_SESSION['team']);

  $display = "<div class='container'>";
  $display .= "<h2>Schedule</h2>";
  if (count($data) > 0) {
    for($i = 0; $i < count($data); $i ++) {
      // change sport
      $sport = $db->get_object_by_id("server_sport", $data[$i]['sport'])[0]['name'];
      $data[$i]['sport'] = $sport;

      $league = $db->get_object_by_id("server_league", $data[$i]['league'])[0]['name'];
      $data[$i]['league'] = $league;

      $season_info = $db->get_object_by_id("server_season", $data[$i]['season'])[0];
      $season_y = $season_info['year'];
      $season_d = $season_info['description'];
      $data[$i]['season'] = $season_y;
      $data[$i]['season description'] = $season_d;

      $h_team = $db->get_object_by_id("server_team", $data[$i]['hometeam'])[0]['name'];
      $a_team = $db->get_object_by_id("server_team", $data[$i]['awayteam'])[0]['name'];
      $data[$i]['hometeam'] = $h_team;
      $data[$i]['awayteam'] = $a_team;

      $data[$i]['completed'] = $data[$i]['completed'] == 1 ? "yes" : "no";
    }
    $display .= display($data);
  } else {
    $display .= "<p class='text-danger'>No schedules were found in record</p>";
  }
  $display .= "</div>";

  echo $display;

  
  endblock();
?>
