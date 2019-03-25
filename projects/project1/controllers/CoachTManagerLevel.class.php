<?php
  include_once 'UserController.class.php';
  include_once 'DataByRole.class.php';

  class CoachTManagerLevel extends UserController {

    public function display_admin_data() {
      // Users table
      $data = DataByRole::get_all_users();
      // edit permission
      $_SESSION['user_edit'] = true;
      $edit_page = "edit_pages/edit_users.php";
      $display = $this->display_editable($data=$data, $title="Users", $link=$edit_page, $id=array("Username"));

      // Positions table
      $data = DataByRole::get_all_pos();
      // edit permission
      $_SESSION['pos_edit'] = true;
      $edit_page = "edit_pages/edit_pos.php";
      $display .= $this->display_editable($data=$data, $title="Positions", $link=$edit_page, $id=array("ID"));

      // Players table
      $data = DataByRole::get_all_players();
      // edit permission
      $_SESSION['player_edit'] = true;
      $edit_page = "edit_pages/edit_player.php";
      $display .= $this->display_editable($data=$data, $title="Players", $link=$edit_page, $id=array("ID"));

      return $display;
  }

  public function display_team_data(){
    // Teams table
    $data = DataByRole::get_all_teams();
    return $this->display($data=$data, $title="Team");
  }
  public function display_schedule_data(){
    // Schedules table
    $data = DataByRole::get_all_schedules();
    return $this->display($data=$data, $title="Schedules");
  }
}
?>
