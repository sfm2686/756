<?php
  require "DB.class.php";
  require "FN.class.php";


  $db = DB::getInstance();

  $query = "SELECT *
            FROM people
            JOIN phonenumbers
              ON phonenumbers.PersonId = people.PersonId
            ORDER BY phonenumbers.PersonId, PhoneTypeId";

  $db->do_query( $query, array(), array() );
  $results = $db->fetch_all_array();
  $col = "Add Phone";
  $link = "<a href=addphone.php?PersonId=" . $results[0]["PersonId"] . ">Add Phone</a>";
  $results[0] += [$col => $link];
  echo FN::build_table( $results );

?>
