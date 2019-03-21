<?php
  include_once 'UserController.class.php';

  class AdminLevel extends UserController {

    private $users_query, $sports_query, $season_query, $slseason_query,
            $team_query, $sch_query, $pos_query, $players_query;

    function __construct() {
      $this->users_query = "SELECT
      server_user.username AS Username,
      server_roles.name AS Role,
      server_team.name AS Team,
      server_league.name AS League
      FROM server_user, server_roles, server_team, server_league
      WHERE server_user.role = server_roles.id
      AND server_user.team = server_team.id
      AND server_user.league = server_league.id";
    }

    private function display_user_editable_table() {
      $div_id = "users_div";
      $display = "<div class='container' id='" . $div_id . "'>";
      $data = PDO_DB::getInstance()->select($this->users_query, array(), true);
      $title = "Users";
      if ($data) {
        $display .= $this->display_editable($data, $title, "edit_users.php", "Username", "users_div");
      } else {
        $display .= "<p class='text-danger'>No users were found on record</p>";
      }
      $display .= "</div><br><br><br>";
      return $display;
    }

    // public function get_user_data($user) {
    //   $query = "SELECT
    //   server_user.username,
    //   server_roles.name AS role,
    //   server_team.name AS Team,
    //   server_league.name AS League
    //   FROM server_user, server_roles, server_team, server_league
    //   WHERE server_user.role = server_roles.id
    //   AND server_user.team = server_team.id
    //   AND server_user.league = server_league.id
    //   AND server_user.username = :uname";
    //   $params = array(
    //     ":uname" => $_GET['id']
    //   );
    //   return PDO_DB::getInstance()->select($query, $params, true);
    // }

    public function display_editable_tables() {
      $display = $this->display_user_editable_table();


      // $display .= "<div class='container' id='sports_id'>";
      // $query = "SELECT server_sport.id AS ID, server_sport.name AS Name FROM server_sport";
      // $data = $db->select($query, array(), true);
      // if ($data) {
      //   $display .= $this->display_editable($data, "Sports", "edit_sports.php", "ID");
      //   // $display .= "<button type='submit' class='btn btn-default'>Edit</button>";
      // } else {
      //   $display .= "<p class='text-danger'>No sports were found on record</p>";
      // }
      // $display .= "</div>";

      // $display .= "<form name='form1' method='post' action=''>
      //   <input name='input1'>
      //   <button type='submit'>Button</button>
      //   </form>";
      //
      // $display .= "<form name='form2' method='post' action=''>
      //   <input name='input2'>
      //   </form>";

      echo $display;
  }

  public function display_team_data(){;}
  public function display_schedule_data(){;}

  public function fill_user_query() {
    $query = "SELECT
    server_user.username,
    server_roles.name AS role,
    server_team.name AS Team,
    server_league.name AS League
    FROM server_user, server_roles, server_team, server_league
    WHERE server_user.role = server_roles.id
    AND server_user.team = server_team.id
    AND server_user.league = server_league.id
    AND server_user.username = :uname";
    $param_name = ":uname";
    $_SESSION['user_query'] = $query;
    $_SESSION['user_param_name'] = $param_name;
  }
}
?>
