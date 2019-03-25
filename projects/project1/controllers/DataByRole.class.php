<?php
  // Note: I wanted to put all of the this functionality in the
  // sub-classes of UserController but I could not figure out a way to make
  // the instance global between php files and I did not want to make a new
  // instance in each page.

  include_once dirname(__FILE__) . '/../PDO_DB.class.php';

  abstract class DataByRole {

    /********************* BASE QUERY CONSTANTS *********************/
    // Base queries to select ALL of the information from each of their
    // corresponding tables
    // users query
    const USERS_QUERY   = "SELECT server_user.username AS Username,
                          server_roles.name AS Role,
                          server_team.name AS Team,
                          server_league.name AS League
                          FROM server_user
                          LEFT JOIN server_roles ON server_user.role = server_roles.id
                          LEFT JOIN server_team ON server_user.team = server_team.id
                          LEFT JOIN server_league ON server_user.league = server_league.id";
    // roles query
    const ROLES_QUERY   = "SELECT id AS ID, name AS Name FROM server_roles";
    // teams query
    const TEAMS_QUERY   = "SELECT server_team.id AS ID,
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
    // sports query
    const SPORTS_QUERY  = "SELECT id AS ID, name AS Name FROM server_sport";
    // schedules query
    const SCHED_QUERY   = "SELECT
                          Sport.name AS Sport,
                          Sport.id AS 'Sport ID',
                          League.name AS League,
                          League.id AS 'League ID',
                          Season.year AS Season,
                          Season.id AS 'Season ID',
                          Home.name AS Home,
                          Home.id AS 'Home ID',
                          Away.name AS Away,
                          Away.id AS 'Away ID',
                          homescore AS Homescore,
                          awayscore AS Awayscore,
                          scheduled AS Scheduled,
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
                          ON schedule.awayteam = Away.id";
    // players query
    const PLAYER_QUERY  = "SELECT
                          server_player.id AS ID,
                          firstname AS 'First Name',
                          lastname AS 'Last Name',
                          dateofbirth AS 'Date of Birth',
                          jerseynumber AS 'Jersey Number',
                          server_position.name AS 'Position',
                          server_team.name AS Team
                          FROM server_player, server_playerpos, server_position, server_team
                          WHERE server_player.id = player
                          AND server_player.team = server_team.id
                          AND server_position.id = position";
    // position query
    const POS_QUERY     = "SELECT id AS ID, name AS Name FROM server_position";
    // leagues query
    const LEAGUES_QUERY = "SELECT id AS ID, name AS Name FROM server_league";
    // seasons query
    const SEASON_QUERY  = "SELECT id AS ID, year AS Year,
                          description AS Description FROM server_season";
    // slseason query
    const SLSE_QUERY    = "SELECT server_sport.id AS 'Sport ID',
                          server_sport.name AS Sport,
                          server_league.id AS 'League ID',
                          server_league.name AS League,
                          server_season.id AS 'Season ID',
                          server_season.year AS Season
                          FROM server_sport, server_league, server_season, server_slseason
                          WHERE server_sport.id = server_slseason.sport
                          AND server_league.id = server_slseason.league
                          AND server_season.id = server_slseason.season";

    /*******************************  METHODS *********************************/
    // The functions below take in an identifier and return the values from the
    // data base based on that identifier and the role thats stored in the
    // session. For example, a session with a coach role will not be able
    // to retrieve an admin's information from the database.

    // get one user's data based on role
    public static function get_user($username) {
      $query = DataByRole::USERS_QUERY . " WHERE server_user.username = :uname";
      $params = array(
        ":uname" => $username
      );
      return PDO_DB::getInstance()->select($query, $params);
    }

    // get one sport data based on roles
    public static function get_sport($id) {
      if ($_SESSION['role'] == ADMIN_ROLE) {
        $query =  DataByRole::SPORTS_QUERY . " WHERE id = :id";
        $params = array(
          ":id" => $id
        );
        return PDO_DB::getInstance()->select($query, $params);
      }
      return null;
    }

    public static function get_slseason($sport, $league, $season) {
      $query =  DataByRole::SLSE_QUERY . " AND server_slseason.sport = :sport
                                           AND server_slseason.league = :league
                                           AND server_slseason.season = :season";
      $params = array(
        ":sport" => $sport,
        ":league" => $league,
        ":season" => $season
      );
      return PDO_DB::getInstance()->select($query, $params);
    }

    public static function get_team($id) {
      $query = DataByRole::TEAMS_QUERY . " AND server_team.id = :id";
      $params = array(
        ":id" => $id
      );
      return PDO_DB::getInstance()->select($query, $params);
    }

    public static function get_season($id) {
      if ($_SESSION['role'] == ADMIN_ROLE || $_SESSION['role'] == L_MANAGER_ROLE) {
        $query = DataByRole::SEASON_QUERY . " WHERE id = :id";
        $params = array(
          ":id" => $id
        );
      }
      return PDO_DB::getInstance()->select($query, $params);
    }

    public static function get_schedule($sport, $league, $season, $away, $home) {
      $query = DataByRole::SCHED_QUERY . " AND Away.id = :away
                                            AND Home.id = :home
                                            AND Season.id = :season
                                            AND Sport.id = :sport
                                            AND League.id = :league";
      $params = array(
        ":away" => $away,
        ":home" => $home,
        ":sport" => $sport,
        ":league" => $league,
        ":season" => $season
      );
      return PDO_DB::getInstance()->select($query, $params);
    }

    public static function get_player($id) {
      if ($_SESSION['role'] == ADMIN_ROLE) {
        $query = DataByRole::PLAYER_QUERY . " AND server_player.id = :id";
        $params = array(
          ":id" => $id
        );
      // if the user is not an admin they must have a team set in session
      } else if (isset($_SESSION['team']) &&
                ($_SESSION['role'] == T_MANAGER_ROLE || $_SESSION['role'] == COACH_ROLE)) {
        $query = DataByRole::PLAYER_QUERY . " AND server_player.id = :id
                                              AND server_player.team = :team";
        $params = array(
          ":id" => $id,
          ":team" => $_SESSION['team']
        );
      } else {
        $query = "";
        $params = array();
      }
      return PDO_DB::getInstance()->select($query, $params);
    }

    public static function get_pos($id) {
      if ($_SESSION['role'] == ADMIN_ROLE || $_SESSION['role'] == T_MANAGER_ROLE ||
          $_SESSION['role'] == COACH_ROLE) {
        $query = DataByRole::POS_QUERY . " WHERE id = :id";
        $params = array(
          ":id" => $id
        );
      }
      return PDO_DB::getInstance()->select($query, $params);
    }

    /* -----------------------------------------------------------------------*/

    // The functions below return ALL of the data from a single database table
    // based on the role. For example, a session with a team manager's role will
    // not be able to retrive ALL user info, just the ones they are allowed to
    // access

    public static function get_all_users() {
      if ($_SESSION['role'] == ADMIN_ROLE) {
        $query = DataByRole::USERS_QUERY;
        $params = array();
      } else if ($_SESSION['role'] == L_MANAGER_ROLE) {
        $query = DataByRole::USERS_QUERY . " WHERE server_user.role > :role";
        $params = array(
          ":role" => $_SESSION['role']
        );
      } else if ($_SESSION['role'] == T_MANAGER_ROLE || $_SESSION['role'] == COACH_ROLE) {
        $query = DataByRole::USERS_QUERY . " WHERE server_user.role = :role";
        $params = array(
          ":role" => PARENT_ROLE
        );
      } else {
        $query = "";
        $params = array();
      }
      return PDO_DB::getInstance()->select($query, $params);
    }

    public static function get_all_players() {
      if ($_SESSION['role'] == ADMIN_ROLE) {
        $query = DataByRole::PLAYER_QUERY;
        $params = array();
      } else if (isset($_SESSION['team']) && // must have a team in session
                ($_SESSION['role'] == T_MANAGER_ROLE || $_SESSION['role'] == COACH_ROLE)) {
        $query = DataByRole::PLAYER_QUERY . " AND server_player.team = :team";
        $params = array(
          ":team" => $_SESSION['team']
        );
      } else {
        $query = "";
        $params = array();
      }
      return PDO_DB::getInstance()->select($query, $params);
    }

    public static function get_all_pos() {
      if ($_SESSION['role'] == ADMIN_ROLE || $_SESSION['role'] == T_MANAGER_ROLE
          || $_SESSION['role'] == COACH_ROLE) {
        $query = DataByRole::POS_QUERY;
        $params = array();
        return PDO_DB::getInstance()->select($query, $params);
      } else {
        $query = "";
        $params = array();
      }
      return null;
    }

    public static function get_all_schedules() {
      if ($_SESSION['role'] == ADMIN_ROLE) {
        $query = DataByRole::SCHED_QUERY;
        $params = array();
      // if user is not admin, they must have a league set in the session
      } else if (isset($_SESSION['league']) && $_SESSION['role'] == L_MANAGER_ROLE) {
        $query = DataByRole::SCHED_QUERY . " WHERE League.id = :league";
        $params = array(
          ":league" => $_SESSION['league']
        );
      // if the user is not admin or league manager, they must have a league set in session
      // and can only view games related to their team
      } else if (isset($_SESSION['team']) && $_SESSION['role'] == T_MANAGER_ROLE || $_SESSION['role'] == COACH_ROLE
                || $_SESSION['role'] == PARENT_ROLE) {
        $query = DataByRole::SCHED_QUERY . " WHERE Away.id = :team OR Home.id = :team";
        $params = array(
          ":team" => $_SESSION['team']
        );
      } else {
        $query = "";
        $params = array();
      }
      return PDO_DB::getInstance()->select($query, $params);
    }

    public static function get_all_slseasons() {
      if ($_SESSION['role'] == ADMIN_ROLE) {
        $query = DataByRole::SLSE_QUERY;
        $params = array();
      // if the current user is not an admin, they must have a league set in session
      } else if (isset($_SESSION['league']) && $_SESSION['role'] == L_MANAGER_ROLE) {
        $query = DataByRole::SLSE_QUERY . " AND server_slseason.league = :league";
        $params = array(
          ":league" => $_SESSION['league']
        );
      } else {
        $query = "";
        $params = array();
      }
      return PDO_DB::getInstance()->select($query, $params);
    }

    public static function get_all_sports() {
      if ($_SESSION['role'] == ADMIN_ROLE || $_SESSION['role'] == L_MANAGER_ROLE) {
        $query = DataByRole::SPORTS_QUERY;
        $params = array();
      } else {
        $query = "";
        $params = array();
      }
      return PDO_DB::getInstance()->select($query, $params);
    }

    // get all roles based on the current user's role
    public static function get_all_roles() {
      if ($_SESSION['role'] == ADMIN_ROLE) {
        $query = DataByRole::ROLES_QUERY; // get all roles as admin
        $params = array();
      // if the current role is between league manager and coach (2, 3, or 4), then show all the roles
      // UNDER than that role
      } else if ($_SESSION['role'] >= L_MANAGER_ROLE && $_SESSION['role'] <= COACH_ROLE) {
        $query = DataByRole::ROLES_QUERY . " WHERE server_roles.id > :role";
        $params = array(
          ":role" => $_SESSION['role']
        );
      } else {
        $query = "";
        $params = array();
      }
      return PDO_DB::getInstance()->select($query, $params);
    }

    public static function get_all_seasons() {
      if ($_SESSION['role'] == ADMIN_ROLE || $_SESSION['role'] == L_MANAGER_ROLE) {
        $query = DataByRole::SEASON_QUERY;
        $params = array();
      } else {
        $query = "";
        $params = array();
      }
      return PDO_DB::getInstance()->select($query, $params);
    }

    // get league data based on role
    public static function get_all_leagues() {
      if ($_SESSION['role'] == ADMIN_ROLE) { // show all leagues for admin
        $query = DataByRole::LEAGUES_QUERY;
        $params = array();
      // if the current role is between league manager and coach (2, 3, or 4), then
      // only query for THEIR specific league and must have a league set in session
      } else if (isset($_SESSION['league']) && $_SESSION['role'] >= L_MANAGER_ROLE && $_SESSION['role'] <= COACH_ROLE) {
        $query = DataByRole::LEAGUES_QUERY . " WHERE ID = :league";
        $params = array(
          ":league" => $_SESSION['league']
        );
      } else {
        $query = "";
        $params = array();
      }
      return PDO_DB::getInstance()->select($query, $params);
    }

    // get team names and ids based on roles
    public static function get_all_teams() {
      if ($_SESSION['role'] == ADMIN_ROLE) {
        $query = DataByRole::TEAMS_QUERY; // get everything
        $params = array();
      // if the user is not an admin they must have a league set in session
      } else if (isset($_SESSION['league']) && $_SESSION['role'] == L_MANAGER_ROLE) {
        $query = DataByRole::TEAMS_QUERY . " AND server_league.id = :league"; // only their league
        $params = array(
          ":league" => $_SESSION['league']
        );
      // if the user is not an admin or a league manager, they must have a team set in session
      } else if (isset($_SESSION['team']) &&
                ($_SESSION['role'] == T_MANAGER_ROLE || $_SESSION['role'] == COACH_ROLE
                || $_SESSION['role'] == PARENT_ROLE)) {
        $query = DataByRole::TEAMS_QUERY . " AND server_team.id = :team"; // only their team
        $params = array(
          ":team" => $_SESSION['team']
        );
      } else {
        $query = "";
        $params = array();
      }
      return PDO_DB::getInstance()->select($query, $params);
    }
  }
?>
