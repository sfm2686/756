<?php
  session_start();
  $msg = "";
  if (isset($_SESSION["loggedIn"])) { // user session is valid
    if (isset($_COOKIE["loggedIn"])) { // make sure the timestamp the cookie is still valid
      $msg = "You logged in at: " . $_COOKIE["loggedIn"];
    }  else {
      $msg = "Your timestamp cookie expired but your login session is still active";
    }
  } else {
    $msg = "You need to log in";
    header("Location: login.php?msg=$msg");
    exit();
  }
 ?>

<!doctype html>
<html lang="en-us">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin</title>
  </head>
  <body>
    <p><?= $msg ?></p>
    <br>
    <a href='logout.php'>Logout</a>
  </body>
</html>
