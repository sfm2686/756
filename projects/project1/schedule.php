<?php
  include 'base.php';
  include 'log.php';
  // TODO FIX
  // include 'display.php';
  include 'PDO_DB.class.php';

  startblock('title');
  echo "Schedule";
  endblock();

  $msg = $_SESSION['username'] . " visited schedule page";
  Log::record_log($msg);

  startblock('body');

  $db = PDO_DB::getInstance();

  $query = "SELECT
  Sport.name AS Sport, League.name AS League, Home.name AS Home,
  Season.year AS 'Season Year', Season.description AS 'Season Description',
  Away.name AS Away,
  homescore AS Homescore, awayscore AS Awayscore, scheduled AS Scheduled,
  completed AS Completed
  FROM server_schedule AS schedule
  JOIN server_sport AS Sport
  ON schedule.sport = Sport.id
  JOIN server_league AS League
  ON schedule.league = League.id
  JOIN server_season AS Season
  ON schedule.season = Season.id
  JOIN server_team AS Home
  ON schedule.hometeam = Home.id
  JOIN server_team AS Away
  ON schedule.awayteam = Away.id
  WHERE schedule.hometeam = :team OR schedule.awayteam = :team";
  $params = array(
    ":team" => $_SESSION['team']
  );
  $data = $db->select($query, $params, true);

  $display = "<div class='container'>";
  if (count($data) > 0) {
    for($i = 0; $i < count($data); $i ++) {
      $data[$i]->__set('Completed', $data[$i]->__get('Completed') == 1 ? "yes" : "no");
    }
    $display .= display($data, "Games");
  } else {
    $display .= "<p class='text-danger'>No schedules were found in record</p>";
  }
  $display .= "</div>";

  echo $display;
  endblock();
?>
