<?php
include 'PDO_DB.class.php';

if (isset($_GET['id'])) {
  echo "<h1>ID: " . $_GET['id'] . "</h1>";
}
?>
