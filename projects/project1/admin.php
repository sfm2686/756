<?php
  include 'base.php';
  include 'PDO_DB.class.php';

  // in case an unauthorized user found the admin page link
  if ($_SESSION['role'] == 5) {
    header("Location: team.php");
  }

  startblock('title');
  echo "Admin";
  endblock();

  function display($data) {
    $html = "<table class='table table-striped table-bordered table-hover table-condensed'><tr>";
    foreach($data[0] as $col => $f) {
      $html .= "<th>$col</th>";
    }
    $html .= "</tr>";
    foreach($data as $row) {
      $html .= "<tr>";
      foreach($row as $field) {
        $html .= "<td>$field</td>";
      }
    }
    $html .= "</table>";
    return $html;
  }

  startblock('body');

  $db = PDO_DB::getInstance();
  $err_msg = "";
  $display = "";

  if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3 || $_SESSION['role'] == 1) {
      $results = $db->get_all_data("server_position");
      $display .= "<div class='container'>";
      $div_id = "pos_mod";
      if ($results) {
        $display .= display($results);
        $display .= "<button onclick=mod_view('$div_id') class='btn btn-default'>Edit</button>";
      } else {
        $err_msg = "No positions were found";
        $display .= "<p class='text-danger'>$err_msg</p>";
      }
      $display .= "</div>";
      $display .= "<div id='$div_id'></div>";
  }

  echo $display;
  endblock();
?>

<script>
  function mod_view(id) {
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById(id).innerHTML = this.responseText;
        }
    };
    str = id;
    xmlhttp.open("GET","getuser.php?q=" + str,true);
    xmlhttp.send();
  }
</script>
