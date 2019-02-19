<?php
  session_name("TEST-PHP-SESSION"); // have to specify the same name before starting (thats the name on the client's side)
  session_start();
 ?>

<!doctype html>
<html lang="en-us">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Session 3</title>
  </head>
  <body>
    <?php
      if (isset($_SESSION["name"])) {
        echo "Hi, " . $_SESSION["name"] . ".";
        echo "See? I remembered your name!";

        // tear down the session
        // #1 unset the session variable
        unset($_SESSION["name"]); // this is just good practice, session_destory takes care of it
        // you can also call session_unset(), it will unset all of the vars in the session
        unset($_COOKIE[session_name()]);

        // #2 remove session cookies
        setcookie(session_name(), "", 1,  "/");

        // #3 end session on the server
        session_destroy();
      } else {
        echo "Who are you? <a href='session1.php'>Back to login</a>";
        // header("Location: session1.php");
      }
    ?>
  </body>
</html>
