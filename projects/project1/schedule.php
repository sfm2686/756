<?php
  include 'base.php';
  include 'log.php';

  include 'PDO_DB.class.php';
  // require_once 'db.class.php';

  // if ($_SESSION['loggedin'] != true) {
  //   header("Location: login.php");
  // }
  // session_start();

  startblock('title');
  echo "Schedule";
  endblock();

  startblock('body');
  $db = PDO_DB::getInstance();
  $data = $db->get_schedules_for_user($_SESSION['team']);
  print_r($data);

  $err_msg = "";

  // TODO
  endblock();
?>

<script>
function view_schedule(keys) {
  alert("Keys: " + keys);
    // if (str.length == 0) {
    //     document.getElementById("txtHint").innerHTML = "";
    //     return;
    // } else {
    //     var xmlhttp = new XMLHttpRequest();
    //     xmlhttp.onreadystatechange = function() {
    //         if (this.readyState == 4 && this.status == 200) {
    //             document.getElementById("txtHint").innerHTML = this.responseText;
    //         }
    //     }
    //     xmlhttp.open("GET", "gethint.php?q="+str, true);
    //     xmlhttp.send();
    // }
}
</script>

<h2>Games</h2>
<ul>
  <li>
</ul>
