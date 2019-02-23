<?php

// $db = DB::getInstance();
// $query = "SELECT * FROM phonenumbers WHERE PhoneType=? AND AreaCode=?";
// $db->do_query( $query, array( "home", "123" ), array( "s", "s" ) );
// $records = $db->fetch_all_array();

  require_once "DB.class.php";

  require_once "/home/MAIN/sfm2686/db_conn.php";

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  $phoneTypesIds = [];
  $phoneTypes = [];

  $query = "SELECT * FROM phonetypes";

  if ($stmt = $mysqli->prepare($query)) {
    $stmt->execute();
    $stmt->store_result();

    $num_rows =  $mysqli->affected_rows; // number of results
    $stmt->bind_result($id, $type);

    $i = 1;
    while ($stmt->fetch()) {
      $phoneTypesIds[$i] = $id;
      $phoneTypes[$i] = $type;
      $i += 1;
    }
    /* close statement */
    $stmt->close();
  }
  $mysqli->close();
  // end of dropdown population

  $person_id = "";
  if (isset($_GET['PersonId'])) {
    $person_id = $_GET['PersonId'];
  }

  $db = DB::getInstance();

  function validate_phone_number($areaCode, $phoneNumber) {
    return preg_match("/^[0-9]+$/",$areaCode) && preg_match("/^[0-9]+$/",$phoneNumber);
  }

  function validate_name($fname, $lname) {
    return preg_match("/^[a-zA-Z\s]+$/",$fname) && preg_match("/^[a-zA-Z\s]+$/",$lname);
  }

    if (!empty($_GET['fname']) && !empty($_GET['lname'])) {
      if (validate_name($_GET['fname'], $_GET['lname'])) {
        if (!empty($_GET['nickname'])) {
          $query = "INSERT INTO people (LastName, FirstName, NickName) VALUES (?, ?, ?)";

          $db->do_query($query, array($_GET['lname'], $_GET['fname'], $_GET['nickname']), array("s", "s", "s"));
        } else {
          $query = "INSERT INTO people (LastName, FirstName) VALUES (?, ?)";

          $db->do_query($query, array($_GET['lname'], $_GET['fname']), array("s", "s"));
        }
        $personId = $db->get_insert_id();

        if (!empty($_GET['areaCode']) && !empty($_GET['phoneNumber'])) {
          if (validate_phone_number($_GET['areaCode'], $_GET['phoneNumber'])) {
            $query = "INSERT INTO phonenumbers (AreaCode, PhoneNumber, PersonId, PhoneTypeId) VALUES (?, ?, ?, ?)";

            $db->do_query($query, array($_GET['areaCode'], $_GET['phoneNumber'], $personId, $phoneTypesIds[$_GET['type']]), array("i", "i", "i", "i"));
          } else {
            echo "<h3 style='color:red;'>Invalid characters in the phone number or area code fields</h3>";
            die();
          }
        }
        header('Location: people.php');
      } else {
        echo "<h3 style='color:red;'>Invalid characters in the first or last name fields</h3>";
        die();
      }
    }
?>
<!doctype html>
<html lang="en-us">

<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Phone Number</title>

</head>
<body>

  <form method="GET">
    <Label>First Name</label> <input name="fname"/><br>
    <Label>Last Name</label> <input name="lname"/><br>
    <Label>Nick Name</label> <input name="nickname"/><br>
    <Label>Area Code</label> <input name="areaCode"/><br>
    <Label>Phone Number</label> <input name="phoneNumber"/><br>
    <Label>Type</label>
    <select name="type">
      <option value=<?= $phoneTypesIds[1] ?>><?= $phoneTypes[1] ?></option>
      <option value=<?= $phoneTypesIds[2] ?>><?= $phoneTypes[2] ?></option>
      <option value=<?= $phoneTypesIds[3] ?>><?= $phoneTypes[3] ?></option>
    </select><br>
    <button type="submit"/>Add User</button>
  </form>

</body>
</html>
