<?php
  session_start();
  session_unset();
  setcookie(session_name(), null, 1, "/"); // remove session cookie
  setcookie("loggedIn", null, 1); // remove the timestamp cookie
  session_destroy(); // destory session in server
 ?>

<!doctype html>
<html lang="en-us">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Logout</title>
  </head>
  <body>
    <p>You are logged out</p>
  </body>
</html>
