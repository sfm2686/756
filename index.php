<?php
  // include navbar
  include 'nav.html';
  $name_err = $email_err = $message_err = $confirmation = "";
  $name = $email = $message = "";

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if there is a name and it only contains letters
    if (empty($_POST["name"]) || !preg_match('/^[\p{L} ]+$/u', $_POST["name"])) {
      $name_err = "<div class=\"alert alert-danger\" role=\"alert\">Please enter a valid name, a valid name contains only letters</div>";
    } else {
      $name = $_POST["name"];
    }
    // check if there is an email and if it is a valid format
    if (empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
      $email_err = "<div class=\"alert alert-danger\" role=\"alert\">Please enter a valid email</div>";
    } else {
      $email = $_POST["email"];
    }
    // check if there is a message
    if (empty($_POST["message"])) {
      $message_err = "<div class=\"alert alert-danger\" role=\"alert\">Please enter a messagee</div>";
    } else {
      $message = $_POST["message"];
    }
  }

  // if the varialbes are not empty send email
  if ($name && $email && $message) {
    $to = "sfm2686@rit.edu";
    $subject = "A Message From $name";
    // message should be sanitized??
    $message_to_send = $message;
    $headers[] = "Content-type: text/html; charset=iso-8859-1";
    $headers[] = "Cc: $email";
    // send email and show confirmation message
    mail($to, $subject, $message, implode("\r\n", $headers));
    $confirmation = "<div class=\"alert alert-success\" role=\"alert\">The message
    has been sent successfuly. I will try to get back to you as soon as I can!</div>";
  }
?>

<!doctype html>
<html lang="en-us">

<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sultan Mira's Homepage</title>
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <!-- JUMBOTRON -->
  <div class="jumbotron text-center">
    <div class="container-fluid">
      <h2>About</h2>
      <img src="images/profilepic.jpg" width="300" height="300" title="Profile Pic"/>
    </div>
  </div>
  <div class="container-fluid">
   <h1>Personal Information</h1>
   <p>My name is Sultan Mira, I am an international student originally from Jeddah
   Saudi Arabia. I am a 5th year BS/MS Software Engineering student, I am set
   to graduate at the end of the summer of 2019. I have been in the United States
   since June 2013. I lived in many different places in the United States, including
   Boston MA, and Silicon Valley CA. An interesting fact about myself is that I drove
   to Silicon Valley CA and back twice from Rochester NY for co-ops. Once was in the
   summer of 2017 and then again in the summer of 2018.</p>

   <hr>

   <h1>Contact Information</h1>
   <p>Phone Number: 585 [dash] 500 [dash] 1730</p>
   <p>Email: sfm2686 [at] rit [dot] edu</p>

   <hr>

   <h1>Contact Me</h1>
   <small>You can fill the following fields to send me an email and cc yourself!</small>
   <br>
   <br>
   <form class="form-group" method="post">
     <label>Name</label>
     <?= $name_err ?>
     <input class="form-control" placeholder="Add your name here" name="name"
     value="<?= $name ?>">
     <br>
     <?= $email_err ?>
     <label>Email</label>
     <input class="form-control" placeholder="Add your email here" name="email"
     value="<?= $email ?>">
     <br>
     <?= $message_err ?>
     <label>Message</label>
     <textarea class="form-control" placeholder="Add your message here" name="message"
     ><?= $message ?></textarea>
     <br>
     <?= $confirmation ?>
     <input type="submit" class="btn btn-default" value="Submit">
   </form>
 </div>
 <div style="height:100px"></div>
</body>
</html>
