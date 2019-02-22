<?php
  require "DB.class.php";
  require "FN.class.php";


  $db = DB::getInstance();


	$query = "SELECT *
	          FROM people
	          ORDER BY PersonID";
  $db->do_query( $query, array(), array() );
  echo FN::build_table( $db->fetch_all_array(), "adduser.php");


?>
<p><a href="phones.php">go to phones</a></p>
