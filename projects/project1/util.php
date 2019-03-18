<?php

  function validate_username($username) {
    if (strlen($_POST['username']) > 25) {
      return false;
    }
    return true;
  }

?>
