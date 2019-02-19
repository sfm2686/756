<?php

  // add this in the path specified below
  /* db_conn.php
  <?php
  $db_host = "localhost";
  $db_user = "sfm2686";
  $db_pass = <DB PASS>;
  $db_name = "sfm2686";
  ?>
  */

  require_once "DB.class.php"

  $db = new DB();
  $db->print_people();

  $id = $db->insertPerson("Brown", "Charlie", "Chuck");
  echo "You insert a record with ID: $id<br/>";

  echo "<pre>";
  print_r($db->get_people());
  echo "</pre>";

?>
