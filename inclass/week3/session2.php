<?php
  //  initialize the session
  session_name("TEST-PHP-SESSION"); // optional to name sessions
  session_start(); // default name is: PHPSESSID

  // print_r($_POST);
  // check if the form was submitted
  if (isset($_POST["Submit"])) {
    // set session variable
    $_SESSION["name"] = $_POST["name"];
  }
?>

<!doctype html>
<html lang="en-us">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Session 2</title>
  </head>
  <body>
    <?php
      if (isset($_SESSION["name"])) {
        echo "Hi, " . $_SESSION["name"] . ".";
        echo "<a href='session3.php'>Next</a>";
      } else {
        echo "Who are you? <a href='session1.php'>Back to login</a>";
      }
    ?>
  </body>
</html>
