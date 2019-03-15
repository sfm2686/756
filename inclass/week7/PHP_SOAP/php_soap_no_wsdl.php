<?php
  // proxy for AreaeService
  // SERVER

  require_once("AreaService.php");

  $server = new SoapServer(null, array(
              "uri" => "http://serenity.ist.rit.edu/~sfm2686/756/inclass/week7/PHP_SOAP/php_soap_no_wsdl.php"
            ));

  $server->setClass("AreaService");
  $server->handle(); // handle requests that are coming in
?>
