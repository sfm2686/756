<?php

class FN {

  public static function build_table( $db_array ) {

  	$display = "<table border='1'>\n<tr>\n";
    if ( count($db_array) ) {
    	foreach ( $db_array[0] as $column => $field ) {
    		$display .= "<th>$column</th>\n";
    	}
    }
  	$display .= "</tr>\n";
  	foreach ( $db_array as $record ) {
  		$display .= "<tr>\n";
  		foreach ( $record as $field ) {
  			$display .= "<td>$field</td>\n";
  		}
  		$display .= "</tr>\n";
  	}

  	$display .= "</table>\n";

  	return $display;
  }

}

?>
