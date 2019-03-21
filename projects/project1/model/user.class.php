<?php
  class User {
    const MAX_USERNAME = 25;
    const MIN_USERNAME = 8;
    const MAX_PASS = 20;
    const MIN_PASS = 8;

    function validate_username($username) {
      if (strlen($username) > MAX_USERNAME || strlen($username) < MIN_USERNAME) {
        return false;
      }
      return true;
    }

    function validate_password($password) {
      if (strlen($password) < MIN_PASS || strlen($password) > MAX_PASS) {
        return false;
      }
      return true;
    }
  }
?>
