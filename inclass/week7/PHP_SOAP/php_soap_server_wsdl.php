<?php
  // creating and using WSDL
  // from: github.com/jk/php-wsdl-creator
  require "php-wsdl/class.phpwsdl.php";
  // set params on php-wsdl/cache to 770 (explination in notes)

  $soap = PhpWsdl::CreateInstance(
            null, // namespace
            null, // endpoint url
            "./php-wsdl/cache", // WSDL cache  location (must be writable by Apache)
            array( // list class files you want to expose
              "AreaService.php"
            ),
            null, // name of class that serves the web service
            null, // API demo file
            null, // complex types demo file
            false, // dont automatically send WSDL
            false // dont start SOAP server right now (wait for runServer())
          );

    // disable caching for dev and testing purposes
    ini_set("soap.wsdl_cache_enabled", 0); // for PHP
    ini_set("soap.wsdl_cache_ttl", 0);
    PhpWsdl::$CacheTime = 0; // for PhpWsdl

    // WSDL requested by a client?
    if ($soap->IsWsdlRequested()) {
      // optimize removes line breaks and tabs
      $soap->Optimize = false;
    }

    // start the soap server
    $soap->RunServer();
?>
