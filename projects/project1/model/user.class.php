<?php
  class User {

    const MAX_USERNAME = 25;
    const MIN_USERNAME = 8;
    const MAX_PASS = 20;
    const MIN_PASS = 8;

    static function validate_username($username) {
      if (strlen($username) > User::MAX_USERNAME || strlen($username) < User::MIN_USERNAME) {
        return false;
      }
      if (!preg_match('/^[a-zA-Z0-9\s]+$/', $username)) {
        return false;
      }
      return true;
    }

    static function validate_password($password) {
      if (strlen($password) < User::MIN_PASS || strlen($password) > User::MAX_PASS) {
        return false;
      }
      return true;
    }
  }
?>
