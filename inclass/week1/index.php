<?php
  $feedback = "";

  // super global variables (given to us by PHP, there is also $_GET.. and one for cookies)
  echo "<pre>";
  print_r($_POST);
  echo "</pre>";
?>

<!doctype html>
<html lang="en-us">

<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
  <?php
    echo "<h1>Hello World!!</h1>";
   ?>
   <form methodd="POST">
     <input name="num1"/> + <input name="num2"/><br/>
     <input type="submit"/>
   </form>
</body>
</html>
