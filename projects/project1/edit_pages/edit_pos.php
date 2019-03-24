<?php
  include_once dirname(__FILE__) . '/../base.php';
  include_once BASE_PATH . '/controllers/DataByRole.class.php';
  include_once BASE_PATH . '/PDO_DB.class.php';
  include_once BASE_PATH . '/model/position.class.php';

  startblock('title');
  echo "Edit Position";
  endblock();

  startblock('body');

  // to prevent unauthorized access (if someone typed the url directly)
  if (!isset($_SESSION['pos_edit']) || !$_SESSION['pos_edit']) {
    echo "<div class='alert alert-danger' role='alert'>You do not have permission to access this page!</div>";
    endblock();
    exit();
  }

  $new = isset($_GET['ID']) ? false : true;

  if (!$new) {
    $filtered_id = filter_var($_GET['ID'], FILTER_SANITIZE_NUMBER_INT);
    $data = DataByRole::get_pos($filtered_id);

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
    if (isset($_POST['pos_name']) && Position::validate_name($_POST['pos_name'])) {
      $name = filter_var($_POST['pos_name'], FILTER_SANITIZE_STRING);
      if ($new) { // INSERT TO DB
        $values = array(
          "name" => $name
        );
        PDO_DB::getInstance()->insert("server_position", $values);
        header("Location: " . ADMIN_PAGE);
      } else { // UPDATE DB
        $query = "UPDATE server_position SET name = :name WHERE id = :id";
        $values = array(
          ":name" => $name,
          ":id" => $data[0]->__get('ID')
        );
        PDO_DB::getInstance()->update($query, $values);
        header("Location: " . ADMIN_PAGE);
      }
    } else { // invalid or not set
      $err_msg = "Name can only contain letters and characters";
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
    <label>Name</label>
    <input name="pos_name" onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, pos_feedback)"
    <?php
      if (!$new) {
        echo "value='" . $data[0]->__get('Name') . "'";
      }
    ?>
    type="text" class="form-control">
    <div id='pos_feedback'></div>
    <br>
    <?php
      if ($new) {
        echo "<button name='save' type='submit' class='btn btn-default'>Save Position</button>";
        echo "<button name='cancel' type='submit' class='btn btn-default'>Cancel</button>";
      } else {
        echo "<button name='save' type='submit' class='btn btn-default'>Save Changes</button>";
        echo "<button name='delete' type='submit' class='btn btn-default'>Delete Position</button>";
        echo "<button name='cancel' type='submit' class='btn btn-default'>Cancel</button>";
      }
    ?>
  </form>
  <p class="bg-danger"><?= $err_msg ?></p>
</div>
<?php endblock() ?>
