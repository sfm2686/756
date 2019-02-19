<?php
  class DB {

    private $mysqli;

    function __construct() {
      require_once "/home/MAIN/sfm2686/Sites/db_conn.php";

      // 1) open the db connection
      $this->mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

      // 2) check the connection
      if ( $this->mysqli->connect_error) {
        echo "Connection failed: " . $this->mysqli->connect_ereror;
        exit();
      }
    }

    function print_people() {
      // 3) send a query
      $query = "SELECT * FROM PEOPLE";
      $result = $this->mysqli->query($query);

      // there are results AND if affected_rows > 0 -> to ensure there are results
      if ($result && $this->mysqli->affected_rows) {
        // fetch_assoc() returns the first row (record), it has its own iterator
        while ($row = $result->fetch_assoc()) { // while there are rows returned by the result iterator
          echo $row["FirstName"] . " " . $row["LastName"] . "<br/>";
        }
      }
    }

    function insert_person($last, $first,  $nick) {
      $query = "INSERT INTO (LastName, FirstName, Nickname) VALUES(?, ?, ?)";

      // bind paramaters
      // first param indicates data types, one char per variable (s is for string here)
      if ($statement = $this->mysqli->preepare($query)) {
        $statement->bind_param("sss", $last,  $first, $nick);
        $statement->execute();

        // check success
        $statement->store_result(); // execution results
        $num_rows = $statement->affected_rows;  // should be one row in this case!!

        $insert_id = $statement->insert_id; // primary key, it would return an error if you did not have auto increment

        return $insert_id;
      }
    }

    function get_people() {
      $people = [];

      $query = "SELECT * FROM people";

      if ($stmt = $this->mysqli->prepare($query)) {
        $stmt->execute();
        $stmt->store_result();

        $num_rows =  $stmt->affected_rows();
        $stmt->bind_result($id, $first, $last, $nick);

        if  ($num_rows > 0) {
          while ($stmt->fetch()) {
            $people[] = array(
              "id"    => $id,
              "first" => $first,
              "last"  => $last,
              "nick"  => $nick
            );
          }
        }
        return $people;
      }
    }
  }
?>
