<?php

class Season {

  const YEAR_LENGTH = 4;
  const MAX_DESC = 50;
  const MIN_DESC = 6; // randomly selected number

  public static function validate_year($year) {
    if (strlen($year) == Season::YEAR_LENGTH && preg_match('/^[a-zA-Z0-9\s]+$/', $year)) {
      return true;
    }
    return false;
  }

  public static function validate_desc($desc) {
    if (strlen($desc) < Season::MAX_DESC && strlen($desc) > Season::MIN_DESC &&
    preg_match('/^[a-zA-Z0-9\s]+$/', $desc)) {
      return true;
    }
    return false;
  }
}
?>
