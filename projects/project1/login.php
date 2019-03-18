<?php
  include 'base.php';
  include 'PDO_DB.class.php';
  include 'util.php';
  include_once 'log.php';

  startblock('title');
  echo "Log in";
  endblock();

  startblock('body');
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header("Location: admin.php");
  }
  $err_msg = "";
  if (isset($_POST['username']) && isset($_POST['password'])) {
    $f_username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    if (!validate_username($f_username)) {
      $err_msg = "Invalid username";
    }
    $db = PDO_DB::getInstance();
    $results = $db->get_user_by_username($f_username);
    $user = count($results) == 1 ? $results[0] : null;
    if (!$user) {
      $err_msg = "No records for this username/password";
    } else if ($user->__get('password') == $_POST['password']) {
      // Log::record_log($e->getMessage());
      $_SESSION['loggedin'] = true;
      $_SESSION['role'] = $user->__get('role');
      $_SESSION['team'] = $user->__get('team');
      $_SESSION['league'] = $user->__get('league');
      header("Location: admin.php");
    }
    // TODO USE HASHING
    // if (password_verify($password, $hash)) {
    //     // Success!
    // }
    // else {
    //     // Invalid credentials
    // }
  }
?>

<form method='POST'>
  <label>Username</label>
  <input name='username'>
  <label>Password</label>
  <input type='password' name='password'>
  <br>
  <button type='submit'>Login</button>
  <p class="text-danger"><?= $err_msg ?></p>
</form>
<?php endblock() ?>
