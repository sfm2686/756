<?php

  class Log {
    static function record_log($msg) {
      $file = fopen('log.txt', 'w');
      $d_and_t = new DateTime();
      $d_and_t->format('Y-m-d-H-i-s');
      fwrite($file, $d_and_t . ": " . $msg);
      $file.close();
    }
  }
?>
