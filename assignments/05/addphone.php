<?php

  require_once "/home/MAIN/sfm2686/db_conn.php";

  $person_id = "";
  if (isset($_GET['PersonId'])) {
    $person_id = $_GET['PersonId'];
    echo "got";
  }

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

  if (!empty($_GET['areaCode']) && !empty($_GET['phone']) && !empty($_GET['personID'])) {
    // field validation here

    if (!($stmt = $mysqli->prepare("INSERT INTO phonenumbers(AreaCode, PhoneNumber, PersonId, PhoneTypeId) VALUES (?, ?, ?, ?)"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    echo($phoneTypesIds[$_GET['type']]);

    if (!$stmt->bind_param("iiii", $_GET['areaCode'], $_GET['phone'], $_GET['personID'], $phoneTypesIds[$_GET['type']])) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $stmt->close();
    header('Location: phones.php');
  }
  /* close connection */
  $mysqli->close();
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
    <Label>Area Code</label> <input name="areaCode"/><br>
    <Label>Phone</label> <input name="phone"/><br>
    <Label>Type</label>
    <select name="type">
      <option value=<?= $phoneTypesIds[1] ?>><?= $phoneTypes[1] ?></option>
      <option value=<?= $phoneTypesIds[2] ?>><?= $phoneTypes[2] ?></option>
      <option value=<?= $phoneTypesIds[3] ?>><?= $phoneTypes[3] ?></option>
    </select><br>
    <Label>Person ID</label> <input name="personID" value=<?= $person_id ?>><br>
    <input type="submit"/>
  </form>

</body>
</html>
