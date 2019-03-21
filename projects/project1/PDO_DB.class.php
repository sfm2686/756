<?php
  include_once 'log.php';
  include_once 'model/model.class.php';

  class PDO_DB {

    // Store the single instance of DB
    private static $db_instance;

    private $db;

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
        echo $e;
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
        die();
      }
    }

      function get_all_objects($table = "") {
        try {
          $data = array();
          $stm = $this->db->prepare("SELECT * FROM $table");
          $stm->execute();
          $stm->setFetchMode(PDO::FETCH_CLASS, "Model");
          while ($obj = $stm->fetch()) {
            $data[] = $obj;
          }
          return $data;
        } catch (PDOException $e) {
          Log::record_log($e->getMessage());
          die();
        }
      }

      function select($query ,$values=array(), $obj=false) {
        try {
          $stm = $this->db->prepare($query);
          if ($values) {
            foreach($values as $param => $value)
            $stm->bindValue($param, $value);
          }

          $stm->execute();

          if ($obj) {
            $stm->setFetchMode(PDO::FETCH_CLASS, "Model");
          }

          return $stm->fetchAll();
        } catch (PDOException $e) {
          Log::record_log($e->getMessage());
        }
      }

      function update($query) {
        ;
      }

      function delete($query) {
        ;
      }

      function get_user_by_username($username) {
        try {
          $stm = $this->db->prepare("SELECT * FROM server_user WHERE username = :uname");
          $stm->bindParam(":uname", $username, PDO::PARAM_STR);
          $stm->execute();
          $stm->setFetchMode(PDO::FETCH_CLASS, "Model");
          return $stm->fetchAll();
        } catch (PDOException $e) {
          Log::record_log($e->getMessage());
          die();
        }
      }

      function get_schedules_for_user($team) {
        try {
          $stm = $this->db->prepare("SELECT * FROM server_schedule
            WHERE hometeam = :team OR awayteam = :team
            ORDER BY completed");
          $stm->bindParam(":team", $team, PDO::PARAM_INT);
          $stm->execute();
          $data = $stm->fetchAll();
          return $data;
        } catch (PDOException $e) {
          Log::record_log($e->getMessage());
          die();
        }
      }

      function get_object_by_id($table, $id) {
        try {
          $stm = $this->db->prepare("SELECT * FROM $table
            WHERE id = :id");
          $stm->bindParam(":id", $id, PDO::PARAM_INT);
          $stm->execute();
          $data = $stm->fetchAll();
          return $data;
        } catch (PDOException $e) {
          Log::record_log($e->getMessage());
          die();
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
