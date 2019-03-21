<?php
  include_once 'PDO_DB.class.php';

  abstract class UserController {

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
      // populate the session super global with required params to perform db lookup
      $this->fill_user_query();
      foreach($data[0] as $col => $f) {
        $html .= "<th>$col</th>";
      }
      $html .= "</tr>";
      foreach($data as $row) {
        $html .= "<tr>";
        // query string contains id for the user to search for
        $href = "'" . $link . "?id=" . $row->__get($id) . "'";
        $html .= '<td><button class="btn btn-default" onclick="mod_view(' . $href . ',' . $div_id . ')">Edit</button></td>';
        foreach($row as $field) {
          $html .= "<td>$field</td>";
        }
       $html .= "</tr>";
      }
      $html .= "</table>";
      $href = "'" . $link . "'";
      $html .= '<td><button class="btn btn-default" onclick="mod_view(' . $href . ',' . $div_id . ')">Add New</button></td>';
      return $html;
    }

    // page specific data
    abstract public function display_editable_tables();
    abstract public function display_team_data();
    abstract public function display_schedule_data();

    abstract public function fill_user_query();
}
?>
