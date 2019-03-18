<?php
  class Model {
    public function __set($prop, $val) {
      $this->$prop = $val;
    }

    public function __get($prop) {
      if ($prop != "props") {
        return $this->$prop;
      }
    }
  }
?>
