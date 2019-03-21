<?php
  require_once 'base.php';
  // include 'validators.php';
  include_once 'log.php';
  // include 'PDO_DB.class.php';

  include_once 'controllers/AdminLevel.class.php';

  // ROLES CONSTANTS
  define("ADMIN_ROLE", 1);
  define("L_MANAGER_ROLE", 2);
  define("T_MANAGER_ROLE", 3);
  define("COACH_ROLE", 4);
  define("PARENT_ROLE", 5);

  // in case an unauthorized user found the admin page link
  if ($_SESSION['role'] == PARENT_ROLE) {
    header("Location: team.php");
  }

  startblock('title');
  echo "Admin";
  endblock();

  echo isset($_POST['form1']);

  $msg = $_SESSION['username'] . " visited admin page";
  Log::record_log($msg);

  startblock('body');

  $err_msg = "";
  $display = "";

  $db = PDO_DB::getInstance();

  $controller = null;
  // ADMIN ROLE
  if ($_SESSION['role'] == ADMIN_ROLE) {
    $controller = new AdminLevel();
  } // ADMIN ROLE
  $controller->display_editable_tables();

  print_r($_POST);


  endblock();
  //
  // // LEAGUE MANAGER ROLE
  // if ($_SESSION['role'] == 2 || $_SESSION['role'] == 1) {
  //   $display .= "<div class='container'>";
  //
  //   if ($_SESSION['role'] == 2) { // Team managers & coachs table
  //     $query = "SELECT
  //     server_user.username AS Username,
  //     server_roles.name AS Role,
  //     server_team.name AS Team,
  //     server_league.name AS League
  //     FROM server_user, server_roles, server_team, server_league
  //     WHERE server_user.role = server_roles.id
  //     AND server_user.team = server_team.id
  //     AND server_user.league = server_league.id
  //     AND (server_roles.id BETWEEN :role1 AND :role2)
  //     AND server_league.id = :league";
  //     $params = array(
  //       ":role1" => 3,
  //       ":role2" => 4,
  //       ":league" => $_SESSION['league']
  //     );
  //     $data = $db->select($query, $params, true);
  //     if ($data) {
  //       $display .= display($data, "Users");
  //       $display .= "<button type='submit' class='btn btn-default'>Edit</button>";
  //     } else {
  //       $display .= "<p class='text-danger'>No users were found on record</p>";
  //     }
  //   }
  //
  //   $display .= "<br><br><br>";
  //   $query = "SELECT
  //   server_season.id AS ID,
  //   server_season.year AS Year,
  //   server_season.description AS Description
  //   FROM server_season";
  //   $data = $db->select($query);
  //   if ($data) {
  //     $display .= display($data, "Seasons");
  //     $display .= "<button type='submit' class='btn btn-default'>Edit</button>";
  //   } else {
  //     $display .= "<p class='text-danger'>No seasons were found on record</p>";
  //   }
  //
  //   $display .= "<br><br><br>";
  //   $query = "SELECT
  //   server_sport.name AS Sport,
  //   server_league.name AS League,
  //   server_season.year AS Year,
  //   server_season.description AS Description
  //   FROM server_season, server_sport, server_league, server_slseason
  //   WHERE server_slseason.sport = server_sport.id
  //   AND server_slseason.league = server_league.id
  //   AND server_slseason.season = server_season.id";
  //   $data = $db->select($query);
  //   if ($data) {
  //     $display .= display($data, "SLSeason");
  //     $display .= "<button type='submit' class='btn btn-default'>Edit</button>";
  //   } else {
  //     $display .= "<p class='text-danger'>No SLSeason were found on record</p>";
  //   }
  //
  //   $display .= "<br><br><br>";
  //   $query = "SELECT
  //   server_team.id AS ID,
  //   server_team.name AS Name,
  //   server_team.mascot AS Mascot,
  //   server_sport.name AS Sport,
  //   server_league.name AS League,
  //   server_season.year AS 'Season Year',
  //   server_season.description AS 'Season Description',
  //   server_team.picture AS 'Team Picture',
  //   server_team.homecolor AS Homecolor,
  //   server_team.awaycolor AS Awaycolor,
  //   server_team.maxplayers AS Maxplayers
  //   FROM server_team, server_season, server_league, server_sport
  //   WHERE server_team.sport = server_sport.id
  //   AND server_team.league = server_league.id
  //   AND server_team.season = server_season.id
  //   AND server_team.league = :league";
  //   $params = array(
  //     ":league" => $_SESSION['league']
  //   );
  //   $data = $db->select($query, $params, true);
  //   if ($data) {
  //     $display .= display($data, "Teams");
  //     $display .= "<button type='submit' class='btn btn-default'>Edit</button>";
  //   } else {
  //     $display .= "<p class='text-danger'>No teams were found on record</p>";
  //   }
  //
  //   $display .= "<br><br><br>";
  //   // TODO fix query to include both away and home teams
  //   $query = "SELECT
  //   server_sport.name AS Sport,
  //   server_league.name AS League,
  //   server_season.year AS Year,
  //   server_season.description AS Description,
  //   server_team.name AS Awayteam,
  //   -- server_team.name AS Hometeam,
  //   server_schedule.homescore AS Homescore,
  //   server_schedule.awayscore AS Awayscore,
  //   server_schedule.scheduled AS Scheduled,
  //   server_schedule.completed AS Completed
  //   FROM server_schedule, server_sport, server_league, server_season, server_team
  //   WHERE server_schedule.sport = server_sport.id
  //   AND server_schedule.league = server_league.id
  //   AND server_schedule.season = server_season.id
  //   AND server_schedule.hometeam = server_team.id
  //   -- AND server_schedule.awayteam = server_team.id
  //   AND server_schedule.league = :league";
  //   $params = array(
  //     ":league" => $_SESSION['league']
  //   );
  //   $data = $db->select($query, $params, true);
  //   if ($data) {
  //     $display .= display($data, "Games");
  //     $display .= "<button type='submit' class='btn btn-default'>Edit</button>";
  //   } else {
  //     $display .= "<p class='text-danger'>No schedules were found on record</p>";
  //   }
  //   $display .= "</div>";
  // } // LEAGUE MANAGER ROLE
  //
  // // TEAM MANAGER/COACH ROLE
  // if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3 || $_SESSION['role'] == 1) {
  //   $display .= "<div class='container'>";
  //
  //   if ($_SESSION['role'] == 3 || $_SESSION['role'] == 4) { // Parents table
  //     // TODO fix query to include parents of the same team
  //     $query = "SELECT
  //     server_user.username AS Username,
  //     server_roles.name AS Role,
  //     server_team.name AS Team,
  //     server_league.name AS League
  //     FROM server_user, server_league, server_roles, server_team
  //     WHERE server_user.role = server_roles.id
  //     AND server_user.league = server_league.id
  //     AND server_user.team = server_team.id
  //     AND server_roles.id = :role
  //     AND server_team.id = :team";
  //     $params = array(
  //       ":role" => 5,
  //       ":team" => $_SESSION['team']
  //     );
  //     $data = $db->select($query, $params, true);
  //     if ($data) {
  //       $display .= display($data, "Parents");
  //       $display .= "<button type='submit' class='btn btn-default'>Edit</button>";
  //     } else {
  //       $display .= "<p class='text-danger'>No parents were found on record</p>";
  //     }
  //   }
  //
  //   $display .= "<br><br><br>";
  //   $query = "SELECT
  //   server_player.id AS ID,
  //   server_player.firstname AS Firstname,
  //   server_player.lastname AS Lastname,
  //   server_player.dateofbirth AS 'Date of birth',
  //   server_player.jerseynumber AS 'Jersey number',
  //   server_team.name AS Team
  //   FROM server_player, server_team
  //   WHERE server_player.team = server_team.id
  //   AND server_team.id = :team";
  //   $params = array(
  //     ":team" => $_SESSION['team']
  //   );
  //   $data = $db->select($query, $params, true);
  //   if ($data) {
  //     $display .= display($data, "Players");
  //     $display .= "<button type='submit' class='btn btn-default'>Edit</button>";
  //   } else {
  //     $display .= "<p class='text-danger'>No players were found on record</p>";
  //   }
  //
  //   $display .= "<br><br><br>";
  //   $query = "SELECT
  //   server_position.id AS ID, server_position.name AS Name
  //   FROM server_position";
  //   $data = $db->select($query);
  //   if ($data) {
  //     $display .= display($data, "Positions");
  //     $display .= "<button type='submit' class='btn btn-default'>Edit</button>";
  //   } else {
  //     $display .= "<p class='text-danger'>No positions were found on record</p>";
  //   }
  //   $display .= "</div>";
  // } // TEAM MANAGER/COACH ROLE

  // echo $display;
?>
<script>
  function mod_view(href, element) {
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById(element.id).innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", href, true);
    xmlhttp.send();
  }
</script>
