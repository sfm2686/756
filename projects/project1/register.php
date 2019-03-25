<?php
  include 'base.php';
  include 'log.php';
  include 'PDO_DB.class.php';
  include_once BASE_PATH . '/model/user.class.php';
  include_once BASE_PATH . '/libs/recaptchalib.php';

  startblock('title');
  echo "Register";
  endblock();

  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header("Location: admin.php");
  }

  startblock('body');

  $db = PDO_DB::getInstance();
  $err_msg = "";

  if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password1'])) {
    // recaptcha logic
    $secret = '6LensJkUAAAAAK22Ff99RAT39JMwX1UGh1r6NaEt';
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    if ($responseData->success) { // recaptcha success
      $f_username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
      if (User::validate_username($f_username) && User::validate_password($_POST['password'])) {
        if ($_POST['password'] == $_POST['password1']) {
          // check if the user is already registered
          $query = "SELECT * FROM server_user WHERE username = :uname";
          $params = array(
            ":uname" => $f_username
          );
          $results = $db->select($query, $params);
          $user = count($results) >= 1 ? $results[0] : null;
          if (!$user) { // new user, all good
            $table = "server_user";
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT); // hashing the password
            // insert user to db
            $values = array(
                            "username"  => $_POST['username'],
                            "role"      => PARENT_ROLE,
                            "password"  => $hash,);
            $db->insert($table, $values);
            $msg = $_POST['username'] . " registered";
            Log::record_log($msg);
            header("Location: login.php");
          } else { // username already taken
            $err_msg = "Username already taken, please choose another one or login if thats you!";
          }
        } else  {  // passwords dont match
          $err_msg = "Both passwords must match";
        }
      } else { // invalid username or password
        $err_msg = "Invalid username or password. Username should be between 8 and 25 characters.
        Password should  be between 20 and 8 characters";
      }
    } else { // recaptcha failure
      $err_msg = "Failed to verify the recaptcha, please try again";
    }
  }
?>
<!-- reCaptcha js API -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="container">
  <form method="POST">
  <label>Username</label>
  <input name="username" type="text" class="form-control"
  onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, username_feedback)">
  <div id='username_feedback'></div>
  <br>
  <label>Password</label>
  <input name="password" type="password" class="form-control"
  onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, pass1_feedback)">
  <div id='pass1_feedback'></div>
  <br>
  <label>Confirm Password</label>
  <input name="password1" type="password" class="form-control"
  onkeyup="validate('<?= JS_VALIDATOR_PATH ?>', this, pass2_feedback)">
  <div id='pass2_feedback'></div>
  <br><br>
  <div class="g-recaptcha" data-sitekey="6LensJkUAAAAAC4J-YDRNBLKx85-h_kJ09P_fnki"></div>
  <br><br>
  <button type="submit" class="btn btn-default">Register</button>
  <p class="text-danger"><?= $err_msg ?></p>
  </form>
</div>
<?php endblock() ?>
