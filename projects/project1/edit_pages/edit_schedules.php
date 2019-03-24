<?php
  include_once dirname(__FILE__) . '/../base.php';
  include_once BASE_PATH . '/controllers/DataByRole.class.php';
  include_once BASE_PATH . '/PDO_DB.class.php';
  include_once BASE_PATH . '/model/schedule.class.php';

  startblock('title');
  echo "Edit Schedules";
  endblock();

  startblock('body');

  // to prevent unauthorized access (if someone typed the url directly)
  if (!isset($_SESSION['sch_edit']) || !$_SESSION['sch_edit']) {
    echo "<div class='alert alert-danger' role='alert'>You do not have permission to access this page!</div>";
    endblock();
    exit();
  }

  $new = (isset($_GET['SportID']) && isset($_GET['SeasonID'])
          && isset($_GET['LeagueID']) && isset($_GET['AwayID'])
          && isset($_GET['HomeID'])) ? false : true;

  if (!$new) {
    $orig_sport = filter_var($_GET['SportID'], FILTER_SANITIZE_NUMBER_INT);
    $orig_league = filter_var($_GET['LeagueID'], FILTER_SANITIZE_NUMBER_INT);
    $orig_season = filter_var($_GET['SeasonID'], FILTER_SANITIZE_NUMBER_INT);
    $orig_away = filter_var($_GET['AwayID'], FILTER_SANITIZE_NUMBER_INT);
    $orig_home = filter_var($_GET['HomeID'], FILTER_SANITIZE_NUMBER_INT);

    $data = DataByRole::get_schedule($sport=$orig_sport, $league=$orig_league,
                                    $season=$orig_season, $away=$orig_away,
                                    $home=$orig_home);
    if (!$data) {
      echo "<div class='alert alert-danger' role='alert'>No data found on record</div>";
      endblock();
      exit();
    }
  }

  $sports_data = DataByRole::get_all_sports();
  $league_data = DataByRole::get_all_leagues();
  $season_data = DataByRole::get_all_seasons();
  $teams_data =  DataByRole::get_all_teams();
  $completed_data = array('1' => "Yes", '0' => "No");

  $err_msg = "";

  // form processing
  if (isset($_POST['cancel'])) {
    header("Location: " . ADMIN_PAGE);
  }

  // if (PDO_DB::getInstance()->update($query, $values) == 0) {
  //   $err_msg .= "\nThe sport, league, season combination you select was not found on record. Please make a different selection";
  // } else { // data integrity issue
  //   header("Location: " . ADMIN_PAGE);
  // }

  // no time to check for data integrity like if the game has scores and not completed yet and some other cases..
  if (isset($_POST['save'])) {
    if (isset($_POST['sport']) && isset($_POST['league']) && isset($_POST['season'])
    && isset($_POST['hometeam']) && isset($_POST['awayteam']) && isset($_POST['sche_away_score'])
    && isset($_POST['sche_home_score']) && isset($_POST['completed']) && isset($_POST['date'])) {
      if ($_POST['hometeam'] == $_POST['awayteam']) {
        $err_msg = "The same team cannot play against itself";
      } else if (Schedule::validate_score($_POST['sche_away_score']) &&
                Schedule::validate_score($_POST['sche_home_score'])) {
        $sport = filter_var($_POST['sport'], FILTER_SANITIZE_NUMBER_INT);
        $league = filter_var($_POST['league'], FILTER_SANITIZE_NUMBER_INT);
        $season = filter_var($_POST['season'], FILTER_SANITIZE_NUMBER_INT);
        $ateam = filter_var($_POST['hometeam'], FILTER_SANITIZE_STRING);
        $hteam = filter_var($_POST['awayteam'], FILTER_SANITIZE_STRING);
        $away_score = filter_var($_POST['sche_away_score'], FILTER_SANITIZE_NUMBER_INT);
        $home_score = filter_var($_POST['sche_home_score'], FILTER_SANITIZE_NUMBER_INT);
        $date = preg_replace("([^0-9/])", "", $_POST['date']); // sanitizing date
        $completed = filter_var($_POST['completed'], FILTER_SANITIZE_NUMBER_INT);
        if (!$new) { // UPDATE
          $query = "UPDATE server_schedule SET
          sport = :sport,
          league = :league,
          season = :season,
          hometeam = :hometeam,
          awayteam = :awayteam,
          homescore = :homescore,
          awayscore = :awayscore,
          scheduled = :scheduled,
          completed = :completed
          WHERE sport = :old_sport
          AND season = :old_season
          AND league = :old_league
          AND hometeam = :old_home_team
          AND awayteam = :old_away_team";
          $values = array(
            ":sport" => $sport,
            ":league" => $league,
            ":season" => $season,
            ":hometeam" => $hteam,
            ":awayteam" => $ateam,
            ":homescore" => $home_score,
            ":awayscore" => $away_score,
            ":scheduled" => $date,
            ":completed" => $completed,
            ":old_sport" => $orig_sport,
            ":old_league" => $orig_league,
            ":old_season" => $orig_season,
            ":old_away_team" => $orig_away,
            ":old_home_team" => $orig_home
          );
          if (PDO_DB::getInstance()->update($query, $values) == 23000) { // data integrity issue
            $err_msg .= "\nThe sport, league, season combination you select was not found on record. Please make a different selection";
          } else {
            header("Location: " . ADMIN_PAGE);
          }
        } else { // INSERT
          $table = "server_schedule";
          $values = array(
            "sport" => $sport,
            "league" => $league,
            "season" => $season,
            "hometeam" => $hteam,
            "awayteam" => $ateam,
            "homescore" => $home_score,
            "awayscore" => $away_score,
            "scheduled" => $date,
            "completed" => $completed
          );
          PDO_DB::getInstance()->insert($table, $values);
          header("Location: " . ADMIN_PAGE);
        }
      } else {
        $err_msg = "Invalid scores";
      }
    }
  }

  if (isset($_POST['delete'])) { // DELETE ENTRY
    $query = "DELETE FROM server_schedule
    WHERE sport = :old_sport
    AND league = :old_league
    AND season = :old_season
    AND hometeam = :home
    AND awayteam = :away";
    $values = array(
      ":old_sport" => $orig_sport,
      ":old_league" => $orig_league,
      ":old_season" => $orig_season,
      ":home" => $orig_home,
      ":away" => $orig_away
    );
    PDO_DB::getInstance()->delete($query, $values);
    header("Location: " . ADMIN_PAGE);
  }
  // end of form processing
?>

<div class='container'>
  <div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>Write 0 in the score fields if the game is still to be played</div>
  <form method="POST" class="form-group">
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
          if (!$new && $data[0]->__get('Season ID') == $season->__get('ID')) {
            echo "<option value=" . $season->__get('ID') . " selected>" . $season->__get('Year') . "</option>";
          } else {
            echo "<option value=" . $season->__get('ID') . ">" . $season->__get('Year') . "</option>";
          }
        }
      ?>
    </select>
    <br>
    <label>Home Team</label>
    <select name='hometeam' class="form-control">
      <?php
        foreach($teams_data as $team) {
          if (!$new && $data[0]->__get('Home') == $team->__get('Name')) {
            echo "<option value=" . $team->__get('ID') . " selected>" . $team->__get('Name') . "</option>";
          } else {
            echo "<option value=" . $team->__get('ID') . ">" . $team->__get('Name') . "</option>";
          }
        }
      ?>
    </select>
    <br>
    <label>Away Team</label>
    <select name='awayteam' class="form-control">
      <?php
        foreach($teams_data as $team) {
          if (!$new && $data[0]->__get('Away') == $team->__get('Name')) {
            echo "<option value=" . $team->__get('ID') . " selected>" . $team->__get('Name') . "</option>";
          } else {
            echo "<option value=" . $team->__get('ID') . ">" . $team->__get('Name') . "</option>";
          }
        }
      ?>
    </select>
    <br>
    <label>Home Score</label>
    <input name='sche_away_score' onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, sche_home_score_fb)"
    <?php
      if (!$new) {
        $score = $data[0]->__get('Homescore');
        echo "value='$score'";
      }
    ?>
    type='text' class='form-control'>
    <div id='sche_home_score_fb'></div>
    <br>
    <label>Away Score</label>
    <input name='sche_home_score' onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, sche_away_score_fb)"
    <?php
      if (!$new) {
        $score = $data[0]->__get('Awayscore');
        echo "value='$score'";
      }
    ?>
    type='text' class='form-control'>
    <div id='sche_away_score_fb'></div>
    <br>
    <label>Scheduled</label>
    <input name='date' type="datetime-local" class='form-control'>
    <br>
    <label>Completed</label>
    <select name='completed' class="form-control">
      <?php
        foreach($completed_data as $k => $v) {
            if (!$new && $k == $data[0]->__get('Completed')) {
              echo "<option value=$k selected>$v</option>";
            } else {
              echo "<option value=$k>$v</option>";
            }
        }
      ?>
    </select>
    <br>
    <?php
      if ($new) {
        echo "<button name='save' type='submit' class='btn btn-default'>Save Schedule</button>";
        echo "<button name='cancel' type='submit' class='btn btn-default'>Cancel</button>";
      } else {
        echo "<button name='save' type='submit' class='btn btn-default'>Save Changes</button>";
        echo "<button name='delete' type='submit' class='btn btn-default'>Delete Schedule</button>";
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
