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
  
  echo FN::build_table( $results );

  echo "<h3>Add Phone</h3>";
  foreach ( $results as $record ) {
    echo "<a href='addphone.php?PersonId=" . $record['PersonId'] . "'>Phone ID:" . $record['PersonId'] . "</a><br>";
  }
?>
