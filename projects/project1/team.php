<?php
  include 'base.php';
  include 'model/model.class.php';
  include 'PDO_DB.class.php';

  startblock('title');
  echo "Team";
  endblock();

  $db = PDO_DB::getInstance();
  $results = $db->get_object_by_id("server_team", $_SESSION['team']);
  $data = count($results) == 1 ? $results[0] : null;
  $err_msg = "";
  if (!$data) {
    // Log::record_log($e->getMessage());
    $err_msg = "The record does not show a team for you";
  } else {
    $data = $results[0];
  }

  startblock('body');

  if ($data) {
    $display = "<h2>Team</h2>";
    $display .= "<label>Name: " . $data['name'] . "</label><br>";
    $display .= "<label>Mascot: " . $data['mascot'] . "</label><br>";

    $sport = $db->get_object_by_id("server_sport", $data['sport'])[0]['name'];
    $display .= "<label>Sport: $sport</label><br>";

    $league = $db->get_object_by_id("server_league", $data['league'])[0]['name'];
    $display .= "<label>League: $league</label><br>";

    $season = $db->get_object_by_id("server_season", $data['season'])[0];
    $s_year = $season['year'];
    $s_desc = $season['description'];
    $display .= "<label>Current season year: $s_year</label><br>";
    $display .= "<label>Current season description: $s_desc</label><br>";

    $img_src = $data['picture'];
    // TODO fix pic
    $display .= "<label>Team Picture:<img src=$img_src></label><br>";

    $display .= "<label>Home color: " . $data['homecolor'] . "</label><br>";
    $display .= "<label>Away color: " . $data['awaycolor'] . "</label><br>";
    $display .= "<label>Max players: " . $data['maxplayers'] . "</label><br>";
  } else {
    $display = "<p class='text-danger'>$err_msg</p>";
  }
  echo $display;

  endblock();
?>
