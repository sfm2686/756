<?php
  session_start(); // default name is: PHPSESSID

  // check the GET request
  if (isset($_GET["user"]) && isset($_GET["password"])) {
    if ($_GET["user"] == "admin" && $_GET["password"] == "password") {
      // set session variable
      $_SESSION["loggedIn"] = true;
      // set the cookie
      setcookie("loggedIn", date("F j, Y, g:i a"), time() + (60 * 10));
    }
  }
  if (isset($_SESSION["loggedIn"])) {
    header("Location: admin.php");
    exit();
  }
  $msg = "Invalid Login";
  if (!empty($_GET["msg"])) {
    $msg = $_GET["msg"];
  }
?>

<!doctype html>
<html lang="en-us">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
  </head>
  <body>
    <p><?= $msg ?></p>
  </body>
</html>
