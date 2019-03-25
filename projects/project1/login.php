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

  if (isset($_POST['username']) && isset($_POST['password'])) {
    // recaptcha logic
    $secret = '6LensJkUAAAAAK22Ff99RAT39JMwX1UGh1r6NaEt';
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    if ($responseData->success) { // recaptcha success
      $f_username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
      if (User::validate_username($f_username) && User::validate_password($_POST['password'])) {
          $db = PDO_DB::getInstance();
          // check if the user is already registered
          $query = "SELECT * FROM server_user WHERE username = :uname";
          $params = array(
            ":uname" => $f_username
          );
          $results = $db->select($query, $params);
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
    } else { // recaptcha failure
      $err_msg = "Failed to verify the recaptcha, please try again";
    }
  }
?>
<!-- reCaptcha js API -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class='container'>
  <form method='POST'>
    <label>Username</label>
    <input type="text" class="form-control" name='username'
    onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, username_feedback)">
    <div id='username_feedback'></div>
    <br>
    <label>Password</label>
    <input class="form-control" type='password' name='password'
    onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, pass_feedback)">
    <div id='pass_feedback'></div>
    <br><br>
    <div class="g-recaptcha" data-sitekey="6LensJkUAAAAAC4J-YDRNBLKx85-h_kJ09P_fnki"></div>
    <br><br>
    <button type="submit" class="btn btn-default">Login</button>
    <p class="text-danger"><?= $err_msg ?></p>
  </form>
</div>
<?php endblock() ?>
