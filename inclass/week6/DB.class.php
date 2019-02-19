<?php
class DB {

  private $dbh;

  function __construct() {
    require_once ("/home/MAIN/sfm2686/Sites/db_conn.php");

    try {
      //open a connection
      $this->dbh = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user,$db_pass);

      //change error reporting
      $this->dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
      echo $e->getMessage();
      die();
    }
  }

  function getPeopleFirstName($name) {
    try {
      $data = $this->dbh->query("select * from people where FirstName = ".
      $this->dbh->quote($name));
      return $data;
    }
    catch (PDOException $e) {
      echo $e->getMessage();
      die();
    }
  }

  function getPeopleParameterized($id) {
    try {
      $data = array();
      $stmt = $this->dbh->prepare("SELECT * FROM people WHERE PersonID = :id");
      $stmt->execute(array('id'=>$id));

      while ($row = $stmt->fetch() ) {
        $data[] = $row;
      }

      return $data;
    }
    catch (PDOException $e) {
      echo $e->getMessage();
      die();
    }
  }

  function getPeopleParameterizedAlt($id) {
    try {
      $data = array();
      $stmt = $this->dbh->prepare("SELECT * FROM people WHERE PersonID = :id");
      $stmt->bindParam(":id",$id,PDO::PARAM_INT);
      $stmt->execute();

      while ($row = $stmt->fetch() ) {
        $data[] = $row;
      }

      return $data;
    }
    catch (PDOException $e) {
      echo $e->getMessage();
      die();
    }
  }

  function getPeopleParameterizedAlt2($id) {
    try {
      $data = array();
      $stmt = $this->dbh->prepare("SELECT * FROM people WHERE PersonID = :id");
      $stmt->bindParam(":id",$id,PDO::PARAM_INT);
      $stmt->execute();
      $data = $stmt->fetchAll();

      return $data;
    }
    catch (PDOException $e) {
      echo $e->getMessage();
      die();
    }
  }

  function insert($last,$first,$nick) {
    try {
      $stmt = $this->dbh->prepare("INSERT INTO people (LastName,FirstName,Nickname)
                                    VALUES (:lastName,:firstName,:nickName)");
      $stmt->execute(array(
        "lastName" => $last,
        "firstName" => $first,
        "nickName" => $nick
      ));

      return $this->dbh->lastInsertId();
    }
    catch (PDOException $e) {
      echo $e->getMessage();
      die();
    }

  }

  function getAllObjects() {
    try {
      //object mapping
      include "Person.class.php";
      $data = array();
      $stmt = $this->dbh->prepare("SELECT * FROM people");
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_CLASS,"Person");

      while ($person = $stmt->fetch()) {
        $data[] = $person;
      }

      return $data;
    }
    catch (PDOException $e) {
      echo $e->getMessage();
      die();
    }

  }

} //class
?>
