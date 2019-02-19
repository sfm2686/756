<?php
  require_once("DB.class.php");

  $db = new DB();

  $data = $db->getPeopleFirstName("dennis");
  foreach ($data as $row) {
    echo "<pre>";
    print_r($row);
    echo "</pre>";
  }
  echo "<hr>";
  $data = $db->getPeopleParameterized(1);
  foreach ($data as $row) {
    echo "<pre>";
    print_r($row);
    echo "</pre>";
  }
  echo "<hr>";

  // insert row (commented out so it doesnt keep adding it)
  // $last_id = $db->insert("Bush", "Vannevar", "Mr.science");
  // echo "<p>Person ID: $last_id</p>";

  // return as object
  $people = $db->getAllObjects();
  foreach ($people as $person) {
    echo "<p>{$person->who_am_i()}</p>";
  }

?>
