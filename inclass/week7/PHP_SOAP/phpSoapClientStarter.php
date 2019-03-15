<?php

  require "xmlpp.php"; // for pretty xml printing

  try {

  // // not using WSDL
  // $options = array(
  //   "location" => "http://serenity.ist.rit.edu/~sfm2686/756/inclass/week7/PHP_SOAP/php_soap_no_wsdl.php",
  //   "uri" => "http://serenity.ist.rit.edu/~sfm2686",
  //   "trace" => 1  // debug output
  // );
  // $client = new SoapClient(null, $options); // first param is for the WSDL

  // using WSDL
  $options = array(
    "trace" => 1  // debug output
  );

  // wsdl location
  $wsdl = "http://serenity.ist.rit.edu/~sfm2686/756/inclass/week7/PHP_SOAP/php_soap_server_wsdl.php?wsdl";

  $client = new SoapClient($wsdl, $options);

  $response = $client->helloWorld();
?>

<h1>Hello world</h1>
<?= var_dump($response) ?>
<p>Response: <?= $response ?></p>

<h3>Last Request</h3>
<pre><?= xmlpp($client->__getLastRequest(), true) ?></pre>
<h3>Last Response</h3>
<pre><?= xmlpp($client->__getLastResponse(), true) ?></pre>

<hr>

<?php
  $response = $client->calcRectangle(10, 20.4);
?>

<h1>Calc Rectangle</h1>
<?= var_dump($response) ?>
<p>Response: <?= $response ?></p>

<h3>Last Request</h3>
<pre><?= xmlpp($client->__getLastRequest(), true) ?></pre>
<h3>Last Response</h3>
<pre><?= xmlpp($client->__getLastResponse(), true) ?></pre>

<hr>

<?php
  $response = $client->calcCircle(3.14);
?>

<h1>Calc Circle</h1>
<?= var_dump($response) ?>
<p>Response: <?= $response ?></p>

<h3>Last Request</h3>
<pre><?= xmlpp($client->__getLastRequest(), true) ?></pre>
<h3>Last Response</h3>
<pre><?= xmlpp($client->__getLastResponse(), true) ?></pre>

<hr>

<?php
  $response = $client->countTo(37);
?>

<h1>Count To</h1>
<?= var_dump($response) ?>
<p>Response:
  <?php
    if ($response) {
      foreach($response as $value) {
        echo $value . "<br/>";
      }
    }
  ?>
</p>

<h3>Last Request</h3>
<pre><?= xmlpp($client->__getLastRequest(), true) ?></pre>
<h3>Last Response</h3>
<pre><?= xmlpp($client->__getLastResponse(), true) ?></pre>

<hr>

<?php
  } // end of try block
  catch(SoapFault $e) {
    echo "Soap Fault:";
    var_dump($e);
  }
?>
