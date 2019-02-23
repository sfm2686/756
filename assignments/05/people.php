<?php
  require "DB.class.php";
  require "FN.class.php";


  $db = DB::getInstance();


	$query = "SELECT *
	          FROM people
	          ORDER BY PersonID";
  $db->do_query( $query, array(), array() );

  $results = $db->fetch_all_array();

  // changing the array before sending it to the FN class does not work
  // foreach($results as $result) {
  //   $result['PersonId'] = "<a href='editphones.php?PersonId=" . $result['PersonId'] . "'>" . $result['PersonId'] . "</a>";
  // }
  // echo FN::build_table($results);
  if ( count($results) ) {
  	$display = "<table border='1'>\n<tr>\n";
    	foreach ( $results[0] as $column => $field ) {
    		$display .= "<th>$column</th>\n";
    	}
  	$display .= "</tr>\n";
  	foreach ( $results as $record ) {
  		$display .= "<tr>\n";

  		foreach ( $record as $field ) {
        $display .= "<td><a href='editphones.php?PersonId=" . $record['PersonId'] . "'>" . $field . "</a></td>";
  		}
  		$display .= "</tr>\n";
  	}

  	$display .= "</table>\n";

    echo $display;
  }
?>
<p><a href="phones.php">go to phones</a></p>
<p><a href="adduser.php">Add user</a></p>
