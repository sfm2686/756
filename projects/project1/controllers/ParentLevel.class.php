<?php
  include_once 'UserController.class.php';
  include_once 'DataByRole.class.php';

  class ParentLevel extends UserController {

    public function display_admin_data() {;} // no admin date for parents

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
