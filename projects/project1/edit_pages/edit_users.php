<?php
  include_once dirname(__FILE__) . '/../base.php';
  include_once BASE_PATH . '/controllers/DataByRole.class.php';
  include_once BASE_PATH . '/PDO_DB.class.php';
  include_once BASE_PATH . '/model/user.class.php';

  startblock('title');
  echo "Edit User";
  endblock();

  startblock('body');

  // to prevent unauthorized access (if someone typed the url directly)
  if (!isset($_SESSION['user_edit']) || !$_SESSION['user_edit']) {
    echo "<div class='alert alert-danger' role='alert'>You do not have permission to access this page!</div>";
    endblock();
    exit();
  }

  $new_user = isset($_GET['Username']) ? false : true;

  if (!$new_user) {
    $filtered_id = filter_var($_GET['Username'], FILTER_SANITIZE_STRING);
    $data = DataByRole::get_user($filtered_id);

    if (!$data) {
      echo "<div class='alert alert-danger' role='alert'>User not found</div>";
      endblock();
      exit();
    }
  }

  $roles_data = DataByRole::get_all_roles();
  $league_data = DataByRole::get_all_leagues();
  $team_data = DataByRole::get_all_teams();

  $err_msg = "";

  // form processing
  if (isset($_POST['cancel'])) {
    header("Location: " . ADMIN_PAGE);
  }
  if (isset($_POST['save'])) {
    if ($new_user && isset($_POST['username']) && isset($_POST['password'])) { // NEW ENTRY
      $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
      if (User::validate_username($username) && User::validate_password($_POST['password'])) {
        if (filter_var($_POST['role'], FILTER_VALIDATE_INT) &&
            filter_var($_POST['team'], FILTER_VALIDATE_INT) &&
            filter_var($_POST['league'], FILTER_VALIDATE_INT)) {
          $values = array(
            "username" => filter_var($_POST['username'], FILTER_SANITIZE_STRING),
            "password" => password_hash($_POST['password'], PASSWORD_DEFAULT),
            "role" => $_POST['role'],
            "team" => $_POST['team'],
            "league" => $_POST['league']
          );
          PDO_DB::getInstance()->insert("server_user", $values);
          header("Location: " . ADMIN_PAGE);
        }
        else {
          $err_msg = "Invalid selection!";
        }
      } else { // invalid username or password
        $err_msg = "Invalid username or password";
      }
    } else { // editing an existing user
      if (filter_var($_POST['role'], FILTER_VALIDATE_INT) &&
          filter_var($_POST['team'], FILTER_VALIDATE_INT) &&
          filter_var($_POST['league'], FILTER_VALIDATE_INT)) {
            $query = "UPDATE server_user SET role=:role, team=:team, league=:league
            WHERE username=:uname";
            $values = array(
              ":role" => $_POST['role'],
              ":team" => $_POST['team'],
              ":league" => $_POST['league'],
              ":uname" => $data[0]->__get('Username')
            );
            PDO_DB::getInstance()->update($query, $values);
            header("Location: " . ADMIN_PAGE);
        } else { // at least one of (role, team, or league) are not ints
          $err_msg = "Invalid selection!";
        }
    }
  }

  if (isset($_POST['delete'])) {
    $query = "DELETE FROM server_user WHERE username=:uname";
    $values = array(
      ":uname" => $data[0]->__get('Username')
    );
    PDO_DB::getInstance()->delete($query, $values);
    header("Location: " . ADMIN_PAGE);
  }
  // end of form processing
?>

<div class='container'>
  <form method="POST" class="form-group">
    <label>Username</label>
    <?php
      if ($new_user) {
        $url = JS_VALIDATOR_PATH;
        echo "<input name='username' onkeyup='validate(\"{$url}\", this, usernameFeedback)' type='text' class='form-control'>";
        echo "<div id='usernameFeedback'></div>";
      } else {
        echo "<input name='username' type='text' class='form-control' value=" . $data[0]->__get('Username') . " disabled>";
      }
    ?>
    <?php
      if ($new_user) {
        $feedback_div = "passwordfb";
        echo "<br><label>Password</label>";
        echo "<input name='password' onkeyup='validate(\"{$url}\", this, passwordfb)' type='password' class='form-control'>";
        echo "<div id='passwordfb'></div>";
      }
    ?>
    <br>
    <label>Role</label>
    <select name='role' class="form-control">
      <?php
        foreach($roles_data as $role) {
          if (!$new_user && $data[0]->__get('Role') == $role->__get('Name')) {
            echo "<option value=" . $role->__get('ID') . " selected>" . $role->__get('Name') . "</option>";
          } else {
            echo "<option value=" . $role->__get('ID') . ">" . $role->__get('Name') . "</option>";
          }
        }
      ?>
    </select>
    <br>
    <label>League</label>
    <select name='league' class="form-control">
      <?php
        foreach($league_data as $league) {
          if (!$new_user && $data[0]->__get('League') == $league->__get('Name')) {
            echo "<option value=" . $league->__get('ID') . " selected>" . $league->__get('Name') . "</option>";
          } else {
            echo "<option value=" . $league->__get('ID') . ">" . $league->__get('Name') . "</option>";
          }
        }
      ?>
    </select>
    <br>
    <label>Team</label>
    <select name='team' class="form-control">
      <?php
        foreach($team_data as $team) {
          if (!$new_user && $data[0]->__get('Team') == $team->__get('Name')) {
            echo "<option value=" . $team->__get('ID') . " selected>" . $team->__get('Name') . "</option>";
          } else {
            echo "<option value=" . $team->__get('ID') . ">" . $team->__get('Name') . "</option>";
          }
        }
      ?>
    </select>
    <br>
    <?php
      if ($new_user) {
        echo "<button name='save' type='submit' class='btn btn-default'>Save User</button>";
        echo "<button name='cancel' type='submit' class='btn btn-default'>Cancel</button>";
      } else {
        echo "<button name='save' type='submit' class='btn btn-default'>Save Changes</button>";
        echo "<button name='delete' type='submit' class='btn btn-default'>Delete User</button>";
        echo "<button name='cancel' type='submit' class='btn btn-default'>Cancel</button>";
      }
    ?>
  </form>
  <p class="bg-danger"><?= $err_msg ?></p>
</div>

<?php endblock() ?>
