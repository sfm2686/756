<?php
  require "DB.class.php";
  require "FN.class.php";


  $db = DB::getInstance();

  if (!empty($_GET['PersonId'])) {
      $query = "SELECT *
                FROM phonenumbers WHERE PersonId = ?";

      $db->do_query( $query, array($_GET['PersonId']), array("i"));
      echo FN::build_table( $db->fetch_all_array(), "addphone.php");
  }
?>
