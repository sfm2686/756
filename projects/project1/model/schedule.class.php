<?php

include_once 'model.class.php';

class Schedule {

  public static function validate_score($score) {
    if (strlen($score) > 3) {
      return false;
    }
    if (!preg_match('/^[0-9]*$/', $score)) {
      return false;
    }
    return true;
  }
}
?>
