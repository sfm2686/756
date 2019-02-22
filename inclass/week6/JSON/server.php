<?php
  $payload = $_GET['payload'];
  $payload = json_decode($payload);

  header("Access-Control-Allow-Origin: *");

  print_r($payload);
?>
