<?php

  include_once 'model.class.php';

  class Team {
    const MAX_NAME = 50;
    const MIN_NAME = 4;  // randomly selected number
    const MAX_MASCOT = 50;
    const MIN_MASCOT = 4; // randomly selected number
    const MAX_PIC = 50;
    const MIN_PIC = 10; // randomly selected number
    const MAX_COLOR = 25;
    const MIN_COLOR = 3; // randomly selected number
    const MAX_MAXPLAYERS = 3; // cannot have more than 999 players in a team!!
    const MIN_MAXPLAYERS = 1;

    public static function validate_name($name) {
      if (strlen($name) > Team::MAX_NAME || strlen($name) < Team::MIN_NAME) {
        return false;
      }
      if (!preg_match('/^[a-zA-Z0-9\s]+$/', $name)) {
        return false;
      }
      return true;
    }

    public static function validate_mascot($name) {
      if (strlen($name) > Team::MAX_MASCOT || strlen($name) < Team::MIN_MASCOT) {
        return false;
      }
      if (!preg_match('/^[a-zA-Z0-9\s]+$/', $name)) {
        return false;
      }
      return true;
    }

    public static function validate_pic($pic) {
      if (strlen($pic) > Team::MAX_PIC || strlen($pic) < Team::MIN_PIC) {
        return false;
      }
      if (!preg_match('/^[a-zA-Z0-9\s]+$/', $pic)) {
        return false;
      }
      return true;
    }

    public static function validate_color($color) {
      if (strlen($color) > Team::MAX_COLOR || strlen($color) < Team::MIN_COLOR) {
        return false;
      }
      if (!preg_match('/^[a-zA-Z0-9\s]+$/', $color)) {
        return false;
      }
      return true;
    }

    public static function validate_maxplayers($maxplayers) {
      if (strlen($maxplayers) > Team::MAX_MAXPLAYERS || strlen($maxplayers) < Team::MIN_MAXPLAYERS) {
        return false;
      }
      if (!preg_match('/^[0-9]*$/', $maxplayers)) {
        return false;
      }
      return true;
    }
  }
?>
