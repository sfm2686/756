<?php
  include_once dirname(__FILE__) . '/../base.php';
  include_once BASE_PATH . '/controllers/DataByRole.class.php';
  include_once BASE_PATH . '/PDO_DB.class.php';

  startblock('title');
  echo "Edit SLSeason";
  endblock();

  startblock('body');

  // to prevent unauthorized access (if someone typed the url directly)
  if (!isset($_SESSION['slseasons_edit']) || !$_SESSION['slseasons_edit']) {
    echo "<div class='alert alert-danger' role='alert'>You do not have permission to access this page!</div>";
    endblock();
    exit();
  }

  $new = (isset($_GET['SportID']) && isset($_GET['SeasonID']) && isset($_GET['LeagueID'])) ? false : true;

  if (!$new) {
    $orig_sport = filter_var($_GET['SportID'], FILTER_SANITIZE_NUMBER_INT);
    $orig_leage = filter_var($_GET['LeagueID'], FILTER_SANITIZE_NUMBER_INT);
    $orig_season = filter_var($_GET['SeasonID'], FILTER_SANITIZE_NUMBER_INT);
    $data = DataByRole::get_slseason($sport=$orig_sport, $league=$orig_leage,
                                    $season=$orig_season);

    if (!$data) {
      echo "<div class='alert alert-danger' role='alert'>No data found on record</div>";
      endblock();
      exit();
    }
  }

  $sports_data = DataByRole::get_all_sports();
  $league_data = DataByRole::get_all_leagues();
  $season_data = DataByRole::get_all_seasons();

  $err_msg = "";

  // form processing
  if (isset($_POST['cancel'])) {
    header("Location: " . ADMIN_PAGE);
  }
  if (isset($_POST['save'])) {
    if (isset($_POST['sport']) && isset($_POST['league']) && isset($_POST['season'])) {
      $sport = filter_var($_POST['sport'], FILTER_SANITIZE_NUMBER_INT);
      $league = filter_var($_POST['league'], FILTER_SANITIZE_NUMBER_INT);
      $season = filter_var($_POST['season'], FILTER_SANITIZE_NUMBER_INT);
      if ($new) { // INSERT TO DB
        $values = array(
          "sport" => $sport,
          "league" => $league,
          "season" => $season
        );
        PDO_DB::getInstance()->insert("server_slseason", $values);
        header("Location: " . ADMIN_PAGE);
      } else { // UPDATE DB
        $query = "UPDATE server_slseason SET sport = :sport, league = :league,
        season = :season WHERE sport = :old_sport AND league = :old_league AND season = :old_season";
        $values = array(
          ":sport" => $sport,
          ":league" => $league,
          ":season" => $season,
          ":old_sport" => $orig_sport,
          ":old_league" => $orig_leage,
          ":old_season" => $orig_season
        );
        PDO_DB::getInstance()->update($query, $values);
        header("Location: " . ADMIN_PAGE);
      }
    } else { // invalid or not set
      $err_msg = "Year can only take 4 characters of letters and numbers,
      description can be between 6 and 50 characters of letters and numbers";
    }
  }

  if (isset($_POST['delete'])) { // DELETE ENTRY
    $query = "DELETE FROM server_slseason WHERE sport = :old_sport AND league = :old_league AND season = :old_season";
    $values = array(
      ":old_sport" => $orig_sport,
      ":old_league" => $orig_leage,
      ":old_season" => $orig_season
    );
    PDO_DB::getInstance()->delete($query, $values);
    header("Location: " . ADMIN_PAGE);
  }
  // end of form processing
?>

<div class='container'>
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
    <?php
      if ($new) {
        echo "<button name='save' type='submit' class='btn btn-default'>Save Combination</button>";
        echo "<button name='cancel' type='submit' class='btn btn-default'>Cancel</button>";
      } else {
        echo "<button name='save' type='submit' class='btn btn-default'>Save Changes</button>";
        echo "<button name='delete' type='submit' class='btn btn-default'>Delete Combination</button>";
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
