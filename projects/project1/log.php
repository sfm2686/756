<?php

  define ("LOG_FILE", "log.txt");

  class Log {

    /* Takes in a message as a string and appends it to the log file defined as
    a constant */
    static function record_log($msg) {
      $file = fopen(LOG_FILE, 'a');
      $d_and_t = new DateTime();
      $time_str = $d_and_t->format('Y-m-d-H-i-s');
      fwrite($file, $time_str . ": " . $msg . "\n");
      fclose($file);
    }
  }
?>
