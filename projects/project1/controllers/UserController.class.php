<?php
  include_once dirname(__FILE__) . '/../PDO_DB.class.php';

  abstract class UserController {

    const USERS_QUERY   = "SELECT
                          server_user.username AS Username,
                          server_roles.name AS Role,
                          server_team.name AS Team,
                          server_league.name AS League
                          FROM server_user, server_roles, server_team, server_league
                          WHERE server_user.role = server_roles.id
                          AND server_user.team = server_team.id
                          AND server_user.league = server_league.id";
    const ROLES_QUERY   = "SELECT id AS ID, name AS Name from server_roles";
    const TEAMS_QUERY   = "SELECT
                          server_team.id AS ID,
                          server_team.name AS Name,
                          server_team.mascot AS Mascot,
                          server_sport.name AS Sport,
                          server_league.name AS League,
                          server_season.year AS 'Season Year',
                          server_season.description AS 'Season Description',
                          server_team.picture AS 'Team Picture',
                          server_team.homecolor AS Homecolor,
                          server_team.awaycolor AS Awaycolor,
                          server_team.maxplayers AS Maxplayers
                          FROM server_team, server_season, server_league, server_sport
                          WHERE server_team.sport = server_sport.id
                          AND server_team.league = server_league.id
                          AND server_team.season = server_season.id";
    const SPORTS_QUERY  = "SELECT id AS ID, name AS Name FROM server_sport";
    const SCHED_QUERY   = "";
    const PLAYER_QUERY  = "";
    const POS_QUERY     = "";
    const LEAGUES_QUERY = "SELECT id AS ID, name AS Name FROM server_league";
    const SEASON_QUERY  = "SELECT id AS ID, year AS Year,
                          description AS Description FROM server_season";
    const SLSE_QUERY    = "";

    /********************* INSTANCE METHODS *********************/
    public function display($data, $title) {
      $html ="<h4>$title</h4>";
      $html .= "<table class='table table-striped table-bordered table-hover table-condensed'><tr>";
      foreach($data[0] as $col => $f) {
        $html .= "<th>$col</th>";
      }
      $html .= "</tr>";
      foreach($data as $row) {
        $html .= "<tr>";
        foreach($row as $field) {
          $html .= "<td>$field</td>";
        }
       $html .= "</tr>";
      }
      $html .= "</table>";
      return $html;
    }

    public function display_editable($data, $title, $link, $id, $div_id) {
      $html ="<h4>$title</h4>";
      $html .= "<table class='table table-striped table-bordered table-hover table-condensed'><tr>";
      $html .= "<th>Select</th>";
      foreach($data[0] as $col => $f) {
        $html .= "<th>$col</th>";
      }
      $html .= "</tr>";
      foreach($data as $row) {
        $html .= "<tr>";
        // query string contains id for the user to search for
        $href = "'" . $link . "?id=" . $row->__get($id) . "'";
        // $html .= '<td><button class="btn btn-default" onclick="mod_view(' . $href . ',' . $div_id . ')">Edit</button></td>';
        $html .= '<td><a class="btn btn-default" href=' . $href . '>Edit</a></td>';
        foreach($row as $field) {
          $html .= "<td>$field</td>";
        }
       $html .= "</tr>";
      }
      $html .= "</table>";
      $href = "'" . $link . "'";
      $html .= '<td><a class="btn btn-default" href=' . $href . '>Add New</a></td>';
      return $html;
    }

    /********************* ABSTRACT METHODS *********************/

    abstract public function display_admin_data();
    abstract public function display_team_data();
    abstract public function display_schedule_data();

    /********************* STATIC METHODS *********************/

    // get one user's data based on role
    public static function get_user($username) {
      if ($_SESSION['role'] == ADMIN_ROLE) {
        $query = UserController::USERS_QUERY . " AND server_user.username = :uname";
        $params = array(
          ":uname" => $username
        );
      } else {
        return null;
      }
      return PDO_DB::getInstance()->select($query, $params, true);
    }

    // get one sport data based on roles
    public static function get_sport($id) {
      if ($_SESSION['role'] == ADMIN_ROLE) {
        $query =  UserController::SPORTS_QUERY . " WHERE id = :id";
        $params = array(
          ":id" => $id
        );
        return PDO_DB::getInstance()->select($query, $params);
      }
      return null;
    }

    public static function get_all_users() {
      if ($_SESSION['role'] == ADMIN_ROLE) {
        $query = UserController::USERS_QUERY;
        $params = array();
      } // TODO add else for other permissions
      return PDO_DB::getInstance()->select($query, $params);
    }

    public static function get_all_sports() {
      if ($_SESSION['role'] == ADMIN_ROLE) {
        $query = UserController::SPORTS_QUERY;
        $params = array();
      } // TODO add else for other permissions
      return PDO_DB::getInstance()->select($query, $params);
    }

    // get all roles based on the current user's role
    public static function get_all_roles() {
      if ($_SESSION['role'] == ADMIN_ROLE) {
        $query = UserController::ROLES_QUERY;
        $params = array();
      }
      // } else if ($_SESSION['role'] == L_MANAGER_ROLE) {
      //   $query = "SELECT id AS ID, name AS Name FROM server_roles WHERE id = :t_manager_role OR id = :coach_role";
      //   $params = array(
      //     ":t_manager_role" => T_MANAGER_ROLE,
      //     ":coach_role" => COACH_ROLE
      //   );
      // } else if ($_SESSION['role'] == T_MANAGER_ROLE || $_SESSION['role'] == COACH_ROLE) {
      //   $query = "SELECT id AS ID, name AS Name FROM server_roles WHERE id = :parents_role";
      //   $params = array(
      //     ":parents_role" => PARENT_ROLE
      //   );
      // } else {
      //   return null;
      // }
      return PDO_DB::getInstance()->select($query, $params);
    }

    public static function get_all_seasons() {
      if ($_SESSION['role'] == ADMIN_ROLE) {
        $query = UserController::SEASON_QUERY;
        $params = array();
      }
      return PDO_DB::getInstance()->select($query, $params);
    }

    // get league data based on role
    public static function get_all_leagues() {
      if ($_SESSION['role'] == ADMIN_ROLE) {
        $query = UserController::LEAGUES_QUERY;
        $params = array();
      }
      // } else if ($_SESSION['role'] == L_MANAGER_ROLE) {
      //   $query = "SELECT id AS ID, name AS Name FROM server_league WHERE id = :league";
      //   $params = array(
      //     ":league" => $_SESSION['league']
      //   );
      // } else { // TODO allow lower permissions to change??
      //   return null;
      // }
      return PDO_DB::getInstance()->select($query, $params);
    }

    // get team names and ids based on roles
    public static function get_all_teams() { // TODO make query for all team's info
      if ($_SESSION['role'] == ADMIN_ROLE) {
        $query = UserController::TEAMS_QUERY;
        $params = array();
      }
      // } else if ($_SESSION['role'] == L_MANAGER_ROLE) {
      //   // $query = "SELECT id, name FROM server_team WHERE league = :league";
      //   $params = array(
      //     ":league" => $_SESSION['league']
      //   );
      // } else { // TODO add other permissions
      //   return null;
      // }
      return PDO_DB::getInstance()->select($query, $params);
    }

    // public static function get_user
  }
?>
