<?php
  include_once dirname(__FILE__) . '/../base.php';
  include_once BASE_PATH . '/controllers/UserController.class.php';
  include_once BASE_PATH . '/PDO_DB.class.php';
  include_once BASE_PATH. '/model/season.class.php';

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

  $new = isset($_GET['id']) ? false : true;

  if (!$new) {
    $data = UserController::get_seasons($_GET['id']);

    if (!$data) {
      echo "<div class='alert alert-danger' role='alert'>Sport not found</div>";
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
    if ($new && isset($_POST['sport'])) { // BRAND NEW ENTRY
      if (Sport::validate_name($_POST['sport'])) {
        $values = array(
          "name" => filter_var($_POST['sport'], FILTER_SANITIZE_STRING)
        );
        PDO_DB::getInstance()->insert("server_sport", $values);
        header("Location: " . ADMIN_PAGE);
      } else { // invalid
        $err_msg = "Invalid sport name";
      }
    } else { // UPDATE ENTRY
      $query = "UPDATE server_sport SET id = :id";
      $values = array(
        ":id" => $data[0]['ID']
      );
      PDO_DB::getInstance()->update($query, $values);
      header("Location: " . ADMIN_PAGE);
    }
  }

  if (isset($_POST['delete'])) { // DELETE ENTRY
    $query = "DELETE FROM server_sport WHERE id = :id";
    $values = array(
      ":id" => $data[0]['ID']
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
        $id = $data[0]['ID'];
        echo "<label>ID</label>";
        echo "<input name='sport' value=$id type='text' class='form-control' disabled>";
      }
    ?>
    <br>
    <label>Year</label>
    <input name="year" onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, y_feedback_div)"
    <?php
      if (!$new) {
        echo "value='" . $data[0]['Year'] . "'";
      }
    ?>
    type="text" class="form-control">
    <div id='y_feedback_div'></div>
    <br>
    <label>Description</label>
    <textarea name="year" onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, y_feedback_div)"
    <?php
      if (!$new) {
        echo "value='" . $data[0]['Year'] . "'";
      }
    ?>
    type="text" class="form-control">
    <div id='y_feedback_div'></div>
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
