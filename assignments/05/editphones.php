<?php
  require "DB.class.php";
  require "FN.class.php";

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  if (isset($_GET['delete'])) {
    if (isset($_GET['phoneid'])) {
      $query = "DELETE FROM phonenumbers WHERE PhoneId = (?)";
      if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $_GET['phoneid']);
        $stmt->execute();
        $stmt->close();
      }
    } else {
      echo "<h3 style='color:red;'>Make a selection</h3>";
    }
  } else if (isset($_GET['update'])) {
    if (isset($_GET['phoneid'])) {
      $query = "UPDATE phonenumbers set AreaCode = (?), PhoneNumber = (?), PhoneTypeId = (?) WHERE PhoneId = (?)";
      if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("iiii", $_GET["AreaCode" . $_GET['phoneid']], $_GET["PhoneNumber" . $_GET['phoneid']], $_GET["PhoneType" . $_GET['phoneid']], $_GET['phoneid']);
        $stmt->execute();
        $stmt->close();
      }
    } else {
      echo "<h3 style='color:red;'>Make a selection</h3>";
    }
  }

  if (!empty($_GET['PersonId'])) {
    $db = DB::getInstance();
    $query = "SELECT *
              FROM phonenumbers WHERE PersonId = ?";

    $db->do_query($query, array($_GET['PersonId']), array("i"));
    $results = $db->fetch_all_array();

    /* populate dropdown */

    $phoneTypesIds = [];
    $phoneTypes = [];

    $query = "SELECT * FROM phonetypes";

    if ($stmt = $mysqli->prepare($query)) {
      $stmt->execute();
      $stmt->store_result();

      $num_rows = $mysqli->affected_rows; // number of results
      $stmt->bind_result($id, $type);

      $i = 1;
      while ($stmt->fetch()) {
        $phoneTypesIds[$i] = $id;
        $phoneTypes[$i] = $type;
        $i += 1;
      }
      /* close statement */
      $stmt->close();
    } /* end of dropdown population */
    $mysqli->close();

      echo "<form method='GET'>";
      if ( count($results) ) {
        // $display = "<select name=type>";
      	$display = "<table border='1'>\n<tr>\n";
        	foreach ( $results[0] as $column => $field ) {
        		$display .= "<th>$column</th>\n";
        	}
      	$display .= "</tr>\n";
      	foreach ( $results as $record ) {
      		$display .= "<tr>\n";

          $display .= "<td><input name=AreaCode" . $record['PhoneId'] . " value='" . $record['AreaCode'] . "'/></td>";
          $display .= "<td><input name=PhoneNumber" . $record['PhoneId'] . " value='" . $record['PhoneNumber'] . "'/></td>";
          $display .= "<td>" . $record['PersonId'] . "</td>";
          $display .= "<input type='hidden' name='PersonId' value=" . $_GET['PersonId'] . ">";

          $display .= "<td><select name=PhoneType" . $record['PhoneId'] . ">";
          $selected = $record['PhoneTypeId'] == $phoneTypesIds[1] ? "selected='selected'": "";
          $display .= "<option value=" . $phoneTypesIds[1] . " " . $selected . ">" . $phoneTypes[1] . "</option>";

          $selected = $record['PhoneTypeId'] == $phoneTypesIds[2] ? "selected='selected'": "";
          $display .= "<option value=" . $phoneTypesIds[2] . " " . $selected . ">" . $phoneTypes[2] . "</option>";

          $selected = $record['PhoneTypeId'] == $phoneTypesIds[3] ? "selected='selected'": "";
          $display .= "<option value=" . $phoneTypesIds[3] . " " . $selected . ">" . $phoneTypes[3] . "</option>";
          $display .= "</select></td>";

          $display .= "<td><input type='radio' name='phoneid' value='" . $record['PhoneId'] . "'>" . $record['PhoneId'] . "</td>";

      		$display .= "</tr>\n";
      	}
      	$display .= "</table>\n";

        echo $display;
        echo "<button type=submit name='delete'>Delete Selected</button>";
        echo "<button type=submit name='update'>Update Selected</button>";
        echo "</form>";
      } else {
        echo "No data for this person";
      }
  }
?>
