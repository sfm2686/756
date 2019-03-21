<?php

  define("MAX_USERNAME", 25);
  define("MIN_USERNAME", 8);
  define("MAX_PASS", 20);
  define("MIN_PASS", 8);

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
?>
