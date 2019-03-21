<?php
  include_once 'model/model.class.php';
  // include_once 'PDO_DB.class.php';

  function display($data, $title) {
    $html ="<h4>$title</h4>";
    $html .= "<table class='table table-striped table-bordered table-hover table-condensed'><tr>";
    foreach($data[0] as $col => $f) {
      // TODO emit id??
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

  // function edit_display($opts) {
  //   $html ="<h4>" . $opts['title']. "</h4>";
  //   $html .= "<table class='table table-striped table-bordered table-hover table-condensed'><tr>";
  //   $db = PDO_DB::getInstance();
  //   // $data = $db->select($query, );
  //   foreach($data[0] as $col => $f) {
  //     // TODO emit id??
  //     $html .= "<th>$col</th>";
  //   }
  //   $html .= "<th>Select</th>";
  //   $html .= "</tr>";
  //   $i = 0;
  //   foreach($data as $row) {
  //     $html .= "<tr id=$i>";
  //     foreach($row as $field) {
  //       $html .= "<td><input value='$field'></td>";
  //     }
  //     $html .= "<td><input type='checkbox'></td></tr>";
  //   }
  //   $html .= "</table>";
  //   return $html;
  // }

  function view_display_table($data) {
    // $db = PDO_DB::getInstance();

  }

  // function get_text_from_id($table, $id, $col) {
  //   $db = PDO_DB::getInstance();
  //   $query = "select $col from $table where id = :id";
  //   $params = array(
  //     ":id" => $id
  //   );
  //   return $db->select($query, $params)[0][$col];
  // }

  // function view_display_schedules($data) {
  //   // $data =
  //   for($i = 0; $i < count($data); $i ++) {
  //     // change sport id -> text
  //     $sport = get_text_from_id("server_sport", $data[$i]->__get('sport'), "name");
  //     $data[$i]->__set('sport', $sport);
  //
  //     // change league id -> text
  //     $league = get_text_from_id("server_league", $data[$i]->__get('league'), "name");
  //     $data[$i]->__set('league', $league);
  //
  //     // change season id -> text and add season desc
  //     $season_y = get_text_from_id("server_season", $data[$i]->__get('season'), "year");
  //     $season_d = get_text_from_id("server_season", $data[$i]->__get('season'), "description");
  //     $data[$i]->__set('season', $season_y);
  //     $data[$i]->__set('season description', $season_d);
  //
  //     // change teams id -> text
  //     $h_team = get_text_from_id("server_team", $data[$i]->__get('hometeam'), "name");
  //     $a_team = get_text_from_id("server_team", $data[$i]->__get('awayteam'), "name");
  //     $data[$i]->__set('hometeam', $h_team);
  //     $data[$i]->__set('awayteam', $a_team);
  //
  //     // change completed from bit to yes/no
  //     $data[$i]->__set('completed', $data[$i]->__get('completed') == 1 ? "yes" : "no");
  //   }
  //   return display($data);
  // }
?>
