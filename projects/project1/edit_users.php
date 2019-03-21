<?php
  require_once 'PDO_DB.class.php';
  // include_once dirname(__FILE__) . '/model/user.class.php';
  session_start();

  $db = PDO_DB::getInstance();

  $new_user = isset($_GET['id']) ? false : true;

  if (!$new_user) {
    // to prevent unauthorized access (if someone typed the url directly),
    // get query info from session super global
    if (!isset($_SESSION['user_query']) || !isset($_SESSION['user_param_name'])) {
      exit("You do not have permission to access this page!");
    }
    $query = $_SESSION['user_query'];
    $params = array($_SESSION['user_param_name'] => $_GET['id']);
    $data = $db->select($query, $params, true);

    if (!$data) {
      // TODO put a back button
      exit("No record found");
    }
  }

  $query = "SELECT * FROM server_roles";
  $roles_data = $db->select($query);

  $query = "SELECT * FROM server_league";
  $league_data = $db->select($query);

  $query = "SELECT id, name FROM server_team";
  $team_data = $db->select($query);
?>

<div class='container'>
  <form method="POST" class="form-group">
    <label>Username</label>
    <?php
      if ($new_user) {
        echo "<input name='username' type='text' class='form-control'>";
      } else {
        echo "<input type='text' class='form-control' value=" . $data[0]->__get('username') . " disabled>";
      }
    ?>
    <?php
      if ($new_user) {
        echo "<br><label>Password</label>";
        echo "<input name='password' type='password' class='form-control'>";
      }
    ?>
    <br>
    <label>Role</label>
    <select name='role' class="form-control">
      <?php
        foreach($roles_data as $role) {
          if (!$new_user && $data[0]->__get('role') == $role['name']) {
            echo "<option value=" . $role['id'] . " selected>" . $role['name'] . "</option>";
          } else {
            echo "<option value=" . $role['id'] . ">" . $role['name'] . "</option>";
          }
        }
      ?>
    </select>
    <br>
    <label>League</label>
    <select name='league' class="form-control">
      <?php
        foreach($league_data as $league) {
          if (!$new_user && $data[0]->__get('role') == $league['name']) {
            echo "<option value=" . $league['id'] . " selected>" . $league['name'] . "</option>";
          } else {
            echo "<option value=" . $league['id'] . ">" . $league['name'] . "</option>";
          }
        }
      ?>
    </select>
    <br>
    <label>Team</label>
    <select name='team' class="form-control">
      <?php
        foreach($team_data as $team) {
          if (!$new_user && $data[0]->__get('role') == $team['name']) {
            echo "<option value=" . $team['id'] . " selected>" . $team['name'] . "</option>";
          } else {
            echo "<option value=" . $team['id'] . ">" . $team['name'] . "</option>";
          }
        }
      ?>
    </select>
    <br>
    <?php
      if ($new_user) {
        // since the form is submitted to the admin.php page, one option is to
        // disable the submit button and connect it to an ajax request to validate
        // on keyup and only enable it when everything is valid
        echo "<button type='submit' class='btn btn-default'>Save User</button>";
      } else {
        echo "<button type='submit' class='btn btn-default'>Save Changes</button>";
        echo "<button type='submit' class='btn btn-default'>Delete User</button>";
        echo "<button type='submit' class='btn btn-default'>Cancel</button>";
      }
    ?>
  </form>
</div>
