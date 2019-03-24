<?php
  include_once dirname(__FILE__) . '/../base.php';
  include_once BASE_PATH . '/controllers/DataByRole.class.php';
  include_once BASE_PATH . '/PDO_DB.class.php';
  include_once BASE_PATH . '/model/player.class.php';

  startblock('title');
  echo "Edit Player";
  endblock();

  startblock('body');

  // to prevent unauthorized access (if someone typed the url directly)
  if (!isset($_SESSION['player_edit']) || !$_SESSION['player_edit']) {
    echo "<div class='alert alert-danger' role='alert'>You do not have permission to access this page!</div>";
    endblock();
    exit();
  }

  $new = isset($_GET['ID']) ? false : true;

  if (!$new) {
    $filtered_id = filter_var($_GET['ID'], FILTER_SANITIZE_NUMBER_INT);
    $data = DataByRole::get_player($filtered_id);

    if (!$data) {
      echo "<div class='alert alert-danger' role='alert'>No data found</div>";
      endblock();
      exit();
    }
  }

  $team_data = DataByRole::get_all_teams();

  $err_msg = "";

  // form processing
  if (isset($_POST['cancel'])) {
    header("Location: " . ADMIN_PAGE);
  }
  if (isset($_POST['save'])) {
    if (isset($_POST['player_fname']) && isset($_POST['player_lname']) &&
        isset($_POST['player_dob']) && isset($_POST['player_jersey']) && isset($_POST['team'])) {
      if (Player::validate_fname($_POST['player_fname']) && Player::validate_lname($_POST['player_lname'])
          && Player::validate_jersey($_POST['player_jersey'])) {
            $fname = filter_var($_POST['player_fname'], FILTER_SANITIZE_STRING);
            $lname = filter_var($_POST['player_lname'], FILTER_SANITIZE_STRING);
            $date = preg_replace("([^0-9/])", "", $_POST['player_dob']); // sanitizing date
            $jersey = filter_var($_POST['player_jersey'], FILTER_VALIDATE_INT);
            $team = filter_var($_POST['team'], FILTER_VALIDATE_INT);

            if ($new) { // INSERT TO DB
              $values = array(
                "firstname" => $fname,
                "lastname" => $lname,
                "dateofbirth" => $date,
                "jerseynumber" => $jersey,
                "team" => $team
              );
              PDO_DB::getInstance()->insert("server_player", $values);
              header("Location: " . ADMIN_PAGE);
            } else { // UPDATE DB
              $query = "UPDATE server_player SET
                        firstname = :fname,
                        lastname = :lname,
                        dateofbirth = :dob,
                        jerseynumber = :jnumber,
                        team = :team
                        WHERE id = :id";
              $values = array(
                ":fname" => $fname,
                ":lname" => $lname,
                ":dob" => $date,
                ":jnumber" => $jersey,
                "team" => $team,
                ":id" => $data[0]->__get('ID')
              );
              PDO_DB::getInstance()->update($query, $values);
              header("Location: " . ADMIN_PAGE);
            }
          }
    } else { // invalid or not set
      $err_msg = "First and last name fields only take numbers and characters while the jersey field only takes numbers";
    }
  }

  if (isset($_POST['delete'])) { // DELETE ENTRY
    $query = "DELETE FROM server_position WHERE id = :id";
    $values = array(
      ":id" => $data[0]->__get('ID')
    );
    PDO_DB::getInstance()->delete($query, $values);
    header("Location: " . ADMIN_PAGE);
  }
  // end of form processing
  $url = JS_VALIDATOR_PATH;
?>

<div class='container'>
  <form method="POST" class="form-group">
    <?php
      if (!$new) {
        $id = $data[0]->__get('ID');
        echo "<label>ID</label>";
        echo "<input value=$id type='text' class='form-control' disabled>";
      }
    ?>
    <br>
    <label>First Name</label>
    <input name="player_fname" onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, fname_feedback)"
    <?php
      if (!$new) {
        echo "value='" . $data[0]->__get('First Name') . "'";
      }
    ?>
    type="text" class="form-control">
    <div id='fname_feedback'></div>
    <br>
    <label>Last Name</label>
    <input name="player_lname" onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, lname_feedback)"
    <?php
      if (!$new) {
        echo "value='" . $data[0]->__get('Last Name') . "'";
      }
    ?>
    type="text" class="form-control">
    <div id='lname_feedback'></div>
    <br>
    <label>Date of Birth</label>
    <input name="player_dob"
    <?php
      if (!$new) {
        echo "value='" . $data[0]->__get('Date of Birth') . "'";
      }
    ?>
    type="date" class="form-control">
    <div id='lname_feedback'></div>
    <br>
    <label>Jersey Number</label>
    <input name="player_jersey" onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, jnumber_feedback)"
    <?php
      if (!$new) {
        echo "value='" . $data[0]->__get('Jersey Number') . "'";
      }
    ?>
    type="text" class="form-control">
    <div id='jnumber_feedback'></div>
    <br>
    <label>Team</label>
    <select name='team' class="form-control">
      <?php
        foreach($team_data as $team) {
          if (!$new && $data[0]->__get('Team') == $team->__get('Name')) {
            echo "<option value=" . $team->__get('ID') . " selected>" . $team->__get('Name') . "</option>";
          } else {
            echo "<option value=" . $team->__get('ID') . ">" . $team->__get('Name') . "</option>";
          }
        }
      ?>
    </select>
    <br>
    <?php
      if ($new) {
        echo "<button name='save' type='submit' class='btn btn-default'>Save Player</button>";
        echo "<button name='cancel' type='submit' class='btn btn-default'>Cancel</button>";
      } else {
        echo "<button name='save' type='submit' class='btn btn-default'>Save Changes</button>";
        echo "<button name='delete' type='submit' class='btn btn-default'>Delete Player</button>";
        echo "<button name='cancel' type='submit' class='btn btn-default'>Cancel</button>";
      }
    ?>
  </form>
  <p class="bg-danger"><?= $err_msg ?></p>
</div>
<?php endblock() ?>
