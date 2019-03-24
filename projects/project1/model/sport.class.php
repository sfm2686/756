<?php

class Sport {

  const MAX_NAME = 50;
  const MIN_NAME = 4;  // randomly selected number (shortest sport is 'golf'..)

  public static function validate_name($sport) {
    if (strlen($sport) > Sport::MAX_NAME || strlen($sport) < Sport::MIN_NAME) {
      return false;
    }
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $sport)) {
      return false;
    }
    return true;
  }
}
?>
