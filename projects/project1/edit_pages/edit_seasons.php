<?php
  include_once dirname(__FILE__) . '/../base.php';
  include_once BASE_PATH . '/controllers/DataByRole.class.php';
  include_once BASE_PATH . '/PDO_DB.class.php';
  include_once BASE_PATH . '/model/season.class.php';

  startblock('title');
  echo "Edit Season";
  endblock();

  startblock('body');

  // to prevent unauthorized access (if someone typed the url directly)
  if (!isset($_SESSION['seasons_edit']) || !$_SESSION['seasons_edit']) {
    echo "<div class='alert alert-danger' role='alert'>You do not have permission to access this page!</div>";
    endblock();
    exit();
  }

  $new = isset($_GET['ID']) ? false : true;

  if (!$new) {
    $filtered_id = filter_var($_GET['ID'], FILTER_SANITIZE_NUMBER_INT);
    $data = DataByRole::get_season($filtered_id);

    if (!$data) {
      echo "<div class='alert alert-danger' role='alert'>No data found</div>";
      endblock();
      exit();
    }
  }

  $err_msg = "";

  // form processing
  if (isset($_POST['cancel'])) {
    header("Location: " . ADMIN_PAGE);
  }
  if (isset($_POST['save'])) {
    if (isset($_POST['s_year']) && Season::validate_year($_POST['s_year'])
        && isset($_POST['s_desc']) && Season::validate_desc($_POST['s_desc'])) {
      $year = filter_var($_POST['s_year'], FILTER_SANITIZE_STRING);
      $desc = filter_var($_POST['s_desc'], FILTER_SANITIZE_STRING);
      if ($new) { // INSERT TO DB
        $values = array(
          "year" => $year,
          "description" => $desc
        );
        PDO_DB::getInstance()->insert("server_season", $values);
        header("Location: " . ADMIN_PAGE);
      } else { // UPDATE DB
        $query = "UPDATE server_season SET year = :year, description = :des WHERE id = :id";
        $values = array(
          ":year" => $year,
          ":des" => $desc,
          ":id" => $data[0]->__get('ID')
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
    $query = "DELETE FROM server_season WHERE id = :id";
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
    <label>Year</label>
    <input name="s_year" onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, y_feedback_div)"
    <?php
      if (!$new) {
        echo "value='" . $data[0]->__get('Year') . "'";
      }
    ?>
    type="text" class="form-control">
    <div id='y_feedback_div'></div>
    <br>
    <label>Description</label>
    <textarea name="s_desc" onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, d_feedback_div)"
    type="text" class="form-control"><?= $new ? "" : $data[0]->__get('Description') ?></textarea>
    <div id='d_feedback_div'></div>
    <?php
      if ($new) {
        echo "<button name='save' type='submit' class='btn btn-default'>Save Season</button>";
        echo "<button name='cancel' type='submit' class='btn btn-default'>Cancel</button>";
      } else {
        echo "<button name='save' type='submit' class='btn btn-default'>Save Changes</button>";
        echo "<button name='delete' type='submit' class='btn btn-default'>Delete Season</button>";
        echo "<button name='cancel' type='submit' class='btn btn-default'>Cancel</button>";
      }
    ?>
  </form>
  <p class="bg-danger"><?= $err_msg ?></p>
</div>
<?php endblock() ?>
