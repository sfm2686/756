<?php
  include_once 'UserController.class.php';
  include_once 'DataByRole.class.php';

  class LeagueManagerLevel extends UserController {

    public function display_admin_data() {
      // Users table
      $data = DataByRole::get_all_users();
      // edit permission
      $_SESSION['user_edit'] = true;
      $edit_page = "edit_pages/edit_users.php";
      $display = $this->display_editable($data=$data, $title="Users", $link=$edit_page, $id=array("Username"));

      // Seasons table
      $data = DataByRole::get_all_seasons();
      // edit permission
      $_SESSION['seasons_edit'] = true;
      $edit_page = "edit_pages/edit_seasons.php";
      $display .= $this->display_editable($data=$data, $title="Seasons", $link=$edit_page, $id=array("ID"));

      // SLSeasons table
      $data = DataByRole::get_all_slseasons();
      // edit permission
      $_SESSION['slseasons_edit'] = true;
      $edit_page = "edit_pages/edit_slseasons.php";
      $ids = array("Sport ID", "Season ID", "League ID");
      $display .= $this->display_editable($data=$data, $title="SLSeasons", $link=$edit_page, $id=$ids);

      // Teams table
      $data = DataByRole::get_all_teams();
      // edit permission
      $_SESSION['teams_edit'] = true;
      $edit_page = "edit_pages/edit_teams.php";
      $display .= $this->display_editable($data=$data, $title="Teams", $link=$edit_page, $id=array("ID"));
      
      // Schedules table
      $data = DataByRole::get_all_schedules();
      // edit permission
      $_SESSION['sch_edit'] = true;
      $edit_page = "edit_pages/edit_schedules.php";
      $ids = array("Sport ID", "Season ID", "League ID", "Away ID", "Home ID");
      $display .= $this->display_editable($data=$data, $title="Schedules", $link=$edit_page, $id=$ids);

      return $display;
  }

  public function display_team_data(){
    // Teams table
    $data = DataByRole::get_all_teams();
    return $this->display($data=$data, $title="Teams");
  }
  public function display_schedule_data(){
    // Schedules table
    $data = DataByRole::get_all_schedules();
    return $this->display($data=$data, $title="Schedules");
  }
}
?>
