<?php

  abstract class UserController {

    /********************* CONCRETE METHODS *********************/
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

    public function display_editable($data, $title, $link, $ids) {
      $html = "<div class='container'>";
      $html .="<h4>$title</h4>";
      if (!$data) {
        $html .= "<div class='alert alert-warning' role='alert'>No data found on record</div>";
      } else {
        $html .= "<table class='table table-striped table-bordered table-hover table-condensed'><tr>";
        $html .= "<th>Select</th>";
        foreach($data[0] as $col => $f) {
          $html .= "<th>$col</th>";
        }
        $html .= "</tr>";
        foreach($data as $row) {
          $html .= "<tr>";
          // constructing query string for the edit page to populate fields
          $ids_str = "";
          foreach($ids as $id) {
            $ids_str .= str_replace(" ", "", $id) . "=" . $row->__get($id) . "&";
          }
          $ids_str = substr($ids_str, 0, -1); // removing last '&'
          $href = "'" . $link . "?" . $ids_str . "'";
          $html .= '<td><a class="btn btn-default" href=' . $href . '>Edit</a></td>';
          foreach($row as $field) {
            if (file_exists($field)) { // pic ..
              $html .= "<td><img src=$field style='width:60px;height:60px;'></td>";
            } else { // normal str
              $html .= "<td>$field</td>";
            }
          }
         $html .= "</tr>";
        }
        $html .= "</table>";
      }
      // no object to display
      $href = "'" . $link . "'";
      $html .= '<a class="btn btn-default" href=' . $href . '>Add New</a></div><br><br>';
      return $html;
    }

    /********************* ABSTRACT METHODS *********************/

    abstract public function display_admin_data();
    abstract public function display_team_data();
    abstract public function display_schedule_data();
  }
?>
