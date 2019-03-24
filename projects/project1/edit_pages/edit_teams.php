<?php
  include_once dirname(__FILE__) . '/../base.php';
  include_once BASE_PATH . '/controllers/DataByRole.class.php';
  include_once BASE_PATH . '/PDO_DB.class.php';
  include_once BASE_PATH . '/model/team.class.php';

  startblock('title');
  echo "Edit SLSeason";
  endblock();

  startblock('body');

  // to prevent unauthorized access (if someone typed the url directly)
  if (!isset($_SESSION['teams_edit']) || !$_SESSION['teams_edit']) {
    echo "<div class='alert alert-danger' role='alert'>You do not have permission to access this page!</div>";
    endblock();
    exit();
  }

  $new = isset($_GET['ID']) ? false : true;

  if (!$new) {
    $id = filter_var($_GET['ID'], FILTER_SANITIZE_NUMBER_INT);
    $data = DataByRole::get_team($id=$id);

    if (!$data) {
      echo "<div class='alert alert-danger' role='alert'>No data found on record</div>";
      endblock();
      exit();
    }
    $curr_img = substr($data[0]->__get('Team Picture'), strrpos($data[0]->__get('Team Picture'), '/') + 1) . "";
  }

  $sports_data = DataByRole::get_all_sports();
  $league_data = DataByRole::get_all_leagues();
  $season_data = DataByRole::get_all_seasons();

  $err_msg = "";

  function validate_all($name, $mascot, $homecolor, $awaycolor, $maxplayers) {
    $valid = true;
    $valid = $valid && Team::validate_name($name);
    $valid = $valid && Team::validate_mascot($mascot);
    $valid = $valid && Team::validate_color($homecolor);
    $valid = $valid && Team::validate_color($awaycolor);
    $valid = $valid && Team::validate_maxplayers($maxplayers);
    return $valid;
  }

  // form processing
  if (isset($_POST['cancel'])) {
    header("Location: " . ADMIN_PAGE);
  }
  if (isset($_POST['save'])) {
    if (isset($_POST['team_name']) && isset($_POST['team_mascot']) && isset($_POST['sport']) &&
        isset($_POST['league']) && isset($_POST['season']) && isset($_POST['team_homecolor']) &&
        isset($_POST['team_awaycolor']) && isset($_POST['team_maxplayers'])) {

          $valid = validate_all($name=$_POST['team_name'], $mascot=$_POST['team_mascot'],
          $homecolor=$_POST['team_homecolor'], $awaycoloro=$_POST['team_awaycolor'],
          $maxplayers=$_POST['team_maxplayers']);

          $sport = filter_var($_POST['sport'], FILTER_SANITIZE_NUMBER_INT);
          $league = filter_var($_POST['league'], FILTER_SANITIZE_NUMBER_INT);
          $season = filter_var($_POST['season'], FILTER_SANITIZE_NUMBER_INT);
          $name = filter_var($_POST['team_name'], FILTER_SANITIZE_STRING);
          $mascot = filter_var($_POST['team_mascot'], FILTER_SANITIZE_STRING);
          $homecolor = filter_var($_POST['team_homecolor'], FILTER_SANITIZE_STRING);
          $awaycolor = filter_var($_POST['team_awaycolor'], FILTER_SANITIZE_STRING);
          $maxplayers = filter_var($_POST['team_maxplayers'], FILTER_SANITIZE_NUMBER_INT);
          // TODO process image
          // $target_file = BASE_PATH . "static/images/" . basename($_FILES["team_pic"]["name"]);
          // $upload = true;
          // $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
          // // check for size &
          // if (isset($_POST["save"])) {
          //     $check = getimagesize($_FILES["team_pic"]["tmp_name"]);
          //     if ($check !== false) {
          //         $err_msg = "File is an image - " . $check["mime"] . ".\n";
          //         $upload = true;
          //     } else {
          //         $err_msg = "The uploaded file is not an image.\n";
          //         $upload = false;
          //     }
          // }
          //
          // if ($_FILES["team_pic"]["size"] > 500000) { // file size
          //     $upload = false;
          // }
          // // Allow certain file formats
          // if ($file_type != "jpg" && $file_type != "png") {
          //     $err_msg .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.\n";
          //     $upload = false;
          // }
          // // Check if $upload is set to 0 by an error
          // if ($upload == 0) {
          //     echo "Sorry, your file was not uploaded.";
          // // if everything is ok, try to upload file
          // } else {
          //     if (move_uploaded_file($_FILES["team_pic"]["tmp_name"], $target_file)) {
          //         echo "The file ". basename( $_FILES["team_pic"]["name"]). " has been uploaded.";
          //     } else {
          //         echo "Sorry, there was an error uploading your file.";
          //     }
          // }
          if ($valid) { // checked everything other than pic ..
            if (!$new) { // UPDATE
              $query = "UPDATE server_team SET name = :name, mascot = :mascot,
              homecolor = :homecolor, awaycolor = :awaycolor, maxplayers = :maxplayers,
              sport = :sport, league = :league, season = :season
              WHERE id = :id";
              $values = array(
                ":name" => $name,
                ":mascot" => $mascot,
                ":homecolor" => $homecolor,
                ":awaycolor" => $awaycolor,
                ":maxplayers" => $maxplayers,
                ":sport" => $sport,
                ":league" => $league,
                ":season" => $season,
                ":id" => $data[0]->__get('ID')
                // TODO add pic
              );
              if (PDO_DB::getInstance()->update($query, $values) == 0) {
                $err_msg .= "\nThe sport, league, season combination you select was not found on record. Please make a different selection";
              } else { // data integrity issue
                header("Location: " . ADMIN_PAGE);
              }
            } else { // INSERT
              $table = "server_team";
              $values = array(
                "name" => $name,
                "mascot" => $mascot,
                "homecolor" => $homecolor,
                "awaycolor" => $awaycolor,
                "maxplayers" => $maxplayers,
                "sport" => $sport,
                "league" => $league,
                "season" => $season
                // TODO add pic
              );
              if (PDO_DB::getInstance()->insert($table, $values) == 0) {
                $err_msg .= "\nThe sport, league, season combination you select was not found on record. Please make a different selection";
              } else { // data integrity issue
                header("Location: " . ADMIN_PAGE);
              }
            }
          } else { // something is invalid ..
            $err_msg .= "\nPlease make sure all the fields are valid. All the
            fields only take letters and numbers except for the team picture and
            the maxplayers fields";
          }
    } else { // invalid or not set
      $err_msg = "Year can only take 4 characters of letters and numbers,
      description can be between 6 and 50 characters of letters and numbers";
    }
  }

  if (isset($_POST['delete'])) { // DELETE ENTRY
    // delete pic file first
    if (file_exists($data[0]->__get('Team Picture'))) { // TODO test further
        unlink($data[0]->__get('Team Picture'));
    }
    $query = "DELETE FROM server_team WHERE id = :id";
    $values = array(
      ":id" => $data[0]->__get("ID")
    );
    PDO_DB::getInstance()->delete($query, $values);
    header("Location: " . ADMIN_PAGE);
  }
  // end of form processing
?>

<div class='container'>
  <form method="POST" class="form-group" enctype="multipart/form-data">
    <label>Name</label>
    <input name='team_name' onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, team_name_fb)"
    <?php
      if (!$new) {
        $name = $data[0]->__get('Name');
        echo "value='$name'";
      }
    ?>
    type='text' class='form-control'>
    <div id='team_name_fb'></div>
    <br>
    <label>Mascot</label>
    <input name='team_mascot' onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, mascot_fb)"
    <?php
      if (!$new) {
        $name = $data[0]->__get('Mascot');
        echo "value='$name'";
      }
    ?>
    type='text' class='form-control'>
    <div id='mascot_fb'></div>
    <br>
    <label>Sport</label>
    <select name="sport" class="form-control">
      <?php
        foreach($sports_data as $sport) {
          if (!$new && $data[0]->__get('Sport ID') == $sport->__get('ID')) {
            echo "<option value=" . $sport->__get('ID') . " selected>" . $sport->__get('Name') . "</option>";
          } else {
            echo "<option value=" . $sport->__get('ID') . ">" . $sport->__get('Name') . "</option>";
          }
        }
      ?>
    </select>
    <br>
    <label>League</label>
    <select name="league" class="form-control">
      <?php
        foreach($league_data as $league) {
          if (!$new && $data[0]->__get('League ID') == $league->__get('ID')) {
            echo "<option value=" . $league->__get('ID') . " selected>" . $league->__get('Name') . "</option>";
          } else {
            echo "<option value=" . $league->__get('ID') . ">" . $league->__get('Name') . "</option>";
          }
        }
      ?>
    </select>
    <br>
    <label>Season</label>
    <select name="season" class="form-control">
      <?php
        foreach($season_data as $season) {
          if (!$new && $data[0]->__get('ID') == $season->__get('ID')) {
            echo "<option value=" . $season->__get('ID') . " selected>" . $season->__get('Year') . "</option>";
          } else {
            echo "<option value=" . $season->__get('ID') . ">" . $season->__get('Year') . "</option>";
          }
        }
      ?>
    </select>

    <br>
    <label>Picture</label>
    <input name="team_pic" type="file"
    <?php
      if (!$new) {
        echo "value='" . $curr_img . "'";
      }
    ?>
    id="team_pic">
    <p class="help-block">Only png and jpg allowed</p>
    <?php
      if (!$new && file_exists($data[0]->__get('Team Picture'))) {
        echo "<img src='" . BASE_URL . '/' . $data[0]->__get('Team Picture') . "'>";
      }
    ?>
    <br><br>

    <label>Homecolor</label>
    <input name='team_homecolor' onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, homecolor_fb)"
    <?php
      if (!$new) {
        $color = $data[0]->__get('Homecolor');
        echo "value='$color'";
      }
    ?>
    type='text' class='form-control'>
    <div id='homecolor_fb'></div>
    <br>
    <label>Awaycolor</label>
    <input name='team_awaycolor' onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, awaycolor_fb)"
    <?php
      if (!$new) {
        $color = $data[0]->__get('Awaycolor');
        echo "value='$color'";
      }
    ?>
    type='text' class='form-control'>
    <div id='awaycolor_fb'></div>
    <br>

    <label>Maxplayers</label>
    <input name='team_maxplayers' onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, maxplayers_fb)"
    <?php
      if (!$new) {
        $color = $data[0]->__get('Maxplayers');
        echo "value='$color'";
      }
    ?>
    type='text' class='form-control'>
    <div id='maxplayers_fb'></div>
    <br>
    <?php
      if ($new) {
        echo "<button name='save' type='submit' class='btn btn-default'>Save Team</button>";
        echo "<button name='cancel' type='submit' class='btn btn-default'>Cancel</button>";
      } else {
        echo "<button name='save' type='submit' class='btn btn-default'>Save Changes</button>";
        echo "<button name='delete' type='submit' class='btn btn-default'>Delete Team</button>";
        echo "<button name='cancel' type='submit' class='btn btn-default'>Cancel</button>";
      }
    ?>
    <br><br>
    <div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
      Warning: Deleting this record could result in other data deletions in the database
    </div>
  </form>
  <p class="bg-danger"><?= $err_msg ?></p>
</div>
<?php endblock() ?>
