<?php
  include 'base.php';
  include 'PDO_DB.class.php';
  include 'model/user.class.php';
  include_once 'log.php';

  startblock('title');
  echo "Log in";
  endblock();

  startblock('body');
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header("Location: team.php");
  }
  $err_msg = "";

  // TODO add captcha for login/registration
  // TODO validators for username are now in user.class.php

  if (isset($_POST['username']) && isset($_POST['password'])) {
      $f_username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    if (User::validate_username($f_username) && User::validate_password($_POST['password'])) {
        $db = PDO_DB::getInstance();
        $results = $db->get_user_by_username($f_username);
        $user = count($results) == 1 ? $results[0] : null;
        if ($user) {
          if (password_verify($_POST['password'], $user->__get('password'))) {
              $msg = "$f_username logged in";
              Log::record_log($msg);
              $_SESSION['loggedin'] = true;
              $_SESSION['username'] = $f_username;
              $_SESSION['role'] = $user->__get('role');
              $_SESSION['team'] = $user->__get('team');
              $_SESSION['league'] = $user->__get('league');
              header("Location: team.php");
          } else { // invalid password
            $err_msg = "Wrong password";
          }
        } else { // no username found
          $err_msg = "Username was not found in record";
        }
    } else { // invalid username
      $err_msg = "Username should be between 25 and 8 characters.
      Password should be between 20 and 8 characters";
    }
  }
?>
<div class='container'>
  <form method='POST'>
    <label>Username</label>
    <input name='username'>
    <label>Password</label>
    <input type='password' name='password'>
    <br>
    <button type="submit" class="btn btn-default">Login</button>
    <p class="text-danger"><?= $err_msg ?></p>
  </form>
</div>
<?php endblock() ?>
