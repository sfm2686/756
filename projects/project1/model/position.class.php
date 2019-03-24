<?php

class Position {

  static function validate_name($name) {
    if (strlen($name) > 50 || strlen($name) < 4) {
      return false;
    }
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $name)) {
      return false;
    }
    return true;
  }
}
?>
