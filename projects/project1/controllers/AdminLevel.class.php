<?php
  include_once 'UserController.class.php';

  class AdminLevel extends UserController {

    private function display_user_editable_table() {
      $div_id = "users_div";
      $display = "<div class='container' id='" . $div_id . "'>";
      $data = parent::get_all_users();
      $title = "Users";
      if ($data) {
        // permission to access user edit
        $_SESSION['user_edit'] = true;
        $display .= $this->display_editable($data, $title, "edit_pages/edit_users.php", "Username", $div_id);
      } else {
        $display .= "<p class='text-danger'>No users were found on record</p>";
      }
      $display .= "</div><br><br><br>";
      return $display;
    }

    private function display_sports_editable_table() {
      $div_id = "sports_div";
      $display = "<div class='container' id='" . $div_id . "'>";
      $data = parent::get_all_sports();
      $title = "Sports";
      if ($data) {
        // permission to access user edit
        $_SESSION['sports_edit'] = true;
        $display .= $this->display_editable($data, $title, "edit_pages/edit_sports.php", "ID", $div_id);
      } else {
        $display .= "<p class='text-danger'>No sports were found on record</p>";
      }
      $display .= "</div><br><br><br>";
      return $display;
    }

    private function display_seasons_editable_table() {
      $div_id = "seasons_div";
      $display = "<div class='container' id='" . $div_id . "'>";
      $data = parent::get_all_seasons();
      $title = "Seasons";
      if ($data) {
        // permission to access user edit
        $_SESSION['seasons_edit'] = true;
        $display .= $this->display_editable($data, $title, "edit_pages/edit_seasons.php", "ID", $div_id);
      } else {
        $display .= "<p class='text-danger'>No seasons were found on record</p>";
      }
      $display .= "</div><br><br><br>";
      return $display;
    }

    public function display_admin_data() {
      $display = $this->display_user_editable_table();
      $display .= $this->display_sports_editable_table();
      $display .= $this->display_seasons_editable_table();

      echo $display;
  }

  public function display_team_data(){;}
  public function display_schedule_data(){;}
}
?>
