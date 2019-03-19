<?php

  include_once 'PDO_DB.class.php';

  define("MAX_USERNAME", 25);
  define("MIN_USERNAME", 8);
  define("MAX_PASS", 20);
  define("MIN_PASS", 8);

  function validate_username($username) {
    if (strlen($username) > MAX_USERNAME || strlen($username) < MIN_USERNAME) {
      return false;
    }
    return true;
  }

  function validate_password($password) {
    if (strlen($password) < MIN_PASS || strlen($password) > MAX_PASS) {
      return false;
    }
    return true;
  }

  function display($data) {
    $html = "<table class='table table-striped table-bordered table-hover table-condensed'><tr>";
    foreach($data[0] as $col => $f) {
      // TODO emit id??
      // if ($col == "id") {
      //   continue;
      // }
      $html .= "<th>$col</th>";
    }
    $html .= "</tr>";
    foreach($data as $row) {
      $html .= "<tr>";
      foreach($row as $field) {
        $html .= "<td>$field</td>";
      }
    }
    $html .= "</table>";
    return $html;
  }

  function make_select_option($id, $name) {
    return "<option value=$id>$name</option>";
  }

  // function replace_id_with_val($row, $table, $key) {
  //   $db = PDO_DB::getInstance();
  //   if (array_key_exists($key, $row)) {
  //     $name = $db->get_object_by_id("server_sport", $row[$key])[0]['name'];
  //     $row[$key] = $name;
  //   }
  //   return $row;
  // }

  // function get_u_friendly_data(& $data) {
  //   $db = PDO_DB::getInstance();
  //   foreach($data as $row) {
  //     if (array_key_exists('sport', $row)) {
  //       $sport = $db->get_object_by_id("server_sport", $row['sport'])[0]['name'];
  //       $row['sport'] = $sport;
  //     }
  //     if (array_key_exists('league', $row)) {
  //       $league = $db->get_object_by_id("server_league", $row['league'])[0]['name'];
  //       $row['league'] = $league;
  //     }
  //     if (array_key_exists('season', $row)) {
  //       $season_info =  $db->get_object_by_id("server_season", $row['season'])[0];
  //       $season_year = $season_info['year'];
  //       $row['season'] = $season_info['year'];
  //       $row['season description'] = $season_info['description'];
  //     }
  //     if (array_key_exists('awayteam', $row)) {
  //       $name = $db->get_object_by_id("server_team", $row['awayteam'])[0]['name'];
  //       $row['awayteam'] = $name;
  //     }
  //     if (array_key_exists('hometeam', $row)) {
  //       $name = $db->get_object_by_id("server_team", $row['hometeam'])[0]['name'];
  //       $row['hometeam'] = $name;
  //     }
      // if (array_key_exists('completed', $row)) {
      //
      //   $row['hometeam'] = $name;
      // }
  //   }
  // }

?>
