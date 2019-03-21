<?php
  include 'base.php';
  include 'log.php';
  include 'validators.php';
  include 'PDO_DB.class.php';

  startblock('title');
  echo "Register";
  endblock();

  // TODO add captcha for login/registration
  // TODO users can only register as parents
  // TODO validators for username are now in user.class.php

  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header("Location: admin.php");
  }

  startblock('body');

  $db = PDO_DB::getInstance();
  $teams = $db->select("select * from server_team");
  $roles = $db->select("select * from server_roles");
  $leagues = $db->select("select * from server_league");
  $err_msg = "";

  if (isset($_POST['username']) && isset($_POST['password1']) && isset($_POST['password2'])) {
      $f_username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    if (validate_username($f_username) && validate_password($_POST['password1'])) {
      if ($_POST['password1'] == $_POST['password2']) {
        $results = $db->get_user_by_username($f_username);
        $user = count($results) >= 1 ? $results[0] : null;
        if (!$user) {
          $table = "server_user";
          $hash = password_hash($_POST['password1'], PASSWORD_DEFAULT);
          echo "role: " . $_POST['role'];
          $values = array(
                          "username"  => $_POST['username'],
                          "role"      => $_POST['role'],
                          "password"  => $hash,
                          "team"      => $_POST['team'],
                          "league"    => $_POST['league']);
          $db->insert($table, $values);
          $msg = $_POST['username'] . " registered";
          Log::record_log($msg);
          header("Location: login.php");
        } else { // username already taken
          $err_msg = "Username already taken, please choose another one";
        }
      } else  {  // passwords dont match
        $err_msg = "Both passwords must match";
      }
    } else { // invalid username or password
      $err_msg = "Invalid username or password. Username should be between 8 and 25 characters.
      Password should  be between 20 and 8 characters";
    }
  }
?>

<div class="container">
  <form method="POST">
  <label>Username</label><input name="username"><br>
  <label>Password</label><input type="password" name="password1"><br>
  <label>Confirm Password</label><input type="password" name="password2"><br>
  <label>Team</label>
  <select name='team'>
    <?php
      foreach($teams as $team) {
        $id = $team['id'];
        $name = $team['name'];
        echo "<option value=$id>$name</option>";
      }
    ?>
  </select><br>
  <label>Role</label>
  <select name='role'>
    <?php
      foreach($roles as $role) {
        $id = $role['id'];
        $name = $role['name'];
        echo "<option value=$id>$name</option>";
      }
    ?>
  </select><br>

  <label>League</label>
  <select name='league'>
    <?php
      foreach($leagues as $league) {
        $id = $league['id'];
        $name = $league['name'];
        echo "<option value=$id>$name</option>";
      }
    ?>
  </select><br>
  <button type="submit" class="btn btn-default">Register</button>
  <p class="text-danger"><?= $err_msg ?></p>
  </form>
</div>
<?php endblock() ?>
