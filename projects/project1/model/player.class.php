<?php

  class Player {

    static function validate_fname($name) {
      if (strlen($name) > 50 || strlen($name) < 2) {
        return false;
      }
      if (!preg_match('/^[a-zA-Z]+$/', $name)) {
        return false;
      }
      return true;
    }

    static function validate_lname($name) {
      if (strlen($name) > 50 || strlen($name) < 2) {
        return false;
      }
      if (!preg_match('/^[a-zA-Z]+$/', $name)) {
        return false;
      }
      return true;
    }

    // cannot have a jersey number larger than 2 digits or smaller than 1
    static function validate_jersey($number) {
      if (strlen($number) > 2 || strlen($number) < 1) {
        return false;
      }
      if (!preg_match('/^[0-9]+$/', $number)) {
        return false;
      }
      return true;
    }
  }
?>
