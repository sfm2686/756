<?php
  include_once 'log.php';
  include_once 'model/model.class.php';

  class PDO_DB {

    // Store the single instance of DB
    private static $db_instance;

    private $db;
    private $error = "";

    private function __construct() {
      require_once "/home/MAIN/sfm2686/db_conn.php";

      try {
        // open connection
        $host = DB_HOST;
        $db = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;
        $this->db = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

        //change error reporting
        $this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
        Log::record_log($e->getMessage());
        die();
      }
    }

    function insert($table, $values = array()) {
      try {
        foreach($values as $f => $v) {
          $vals[] = ":" . $f;
        }

        $vals = implode(",", $vals);
        $cols = implode(",", array_keys($values));
        $query = "INSERT INTO $table ($cols) VALUES ($vals)";

        $stm = $this->db->prepare($query);

        foreach ($values as $f => $v) {
          $stm->bindValue(":" . $f, $v);
        }
        $stm->execute();
        return $this->db->lastInsertID();
      } catch (PDOException $e) {
        Log::record_log($e->getMessage());
      }
    }

    function select($query ,$values = array()) {
      try {
        $stm = $this->db->prepare($query);
        if ($values) {
          foreach($values as $param => $value)
          $stm->bindValue($param, $value);
        }
        $stm->execute();
        $stm->setFetchMode(PDO::FETCH_CLASS, "Model");

        return $stm->fetchAll();
      } catch (PDOException $e) {
        Log::record_log($e->getMessage());
        return 0;
      }
    }

    function update($query, $values=array()) {
      try {
        $stm = $this->db->prepare($query);
        if ($values) {
          foreach($values as $param => $value)
          $stm->bindValue($param, $value);
        }
        $stm->execute();
      } catch (PDOException $e) {
        Log::record_log($e->getMessage());
        return $this->db->errorCode();
      }
    }

    function delete($query, $values) {
      try {
        $stm = $this->db->prepare($query);
        if ($values) {
          foreach($values as $param => $value)
          $stm->bindValue($param, $value);
        }
        $stm->execute();
      } catch (PDOException $e) {
        Log::record_log($e->getMessage());
        return 0;
      }
    }

    /**
     * singleton function
     * ensure there's only one instance of the DB object
     */
    public static function getInstance() {
      if (!self::$db_instance) {
        self::$db_instance = new PDO_DB();
      }
      return self::$db_instance;
    }
  }

?>
