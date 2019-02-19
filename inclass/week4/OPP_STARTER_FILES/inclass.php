<?php

  // require_once("Validator.class.php"); // no need cuz of __autoload function


   // called automically by PHP
  function __autoload($class_name) {
    require_once "$class_name.class.php";
  }

  // static class calls
  // pretend the values we're validating come from a form or sth
  echo "<h2>Static Function Usage</h2>";
  $number = 23456;
  $yes_no = Validator::numeric($number) ? "is" : "is NOT";
  echo "<p>$number $yes_no a number</p>";

  $number = "23456";
  $yes_no = Validator::numeric($number) ? "is" : "is NOT";
  echo "<p>$number $yes_no a number</p>";

  $number = "one";
  $yes_no = Validator::numeric($number) ? "is" : "is NOT";
  echo "<p>$number $yes_no a number</p>";


  // regular class calls
  echo "<h2>Regular Class Usage</h2>";
  $bob = new Person("Smith", "Bob");
  $jones = new Person("Jones");
  $person = new Person();

  echo
    "<p>Bob: " . $bob->sayHello() . "</p>
    <p>Mr. Jones: "  . $jones->sayHello() . "</p>
    <p>TBD Person: " . $person->sayHello() . "</p>
    <p>TBD Person's last name: " . $person->getLastName() . "</p>";

  echo "<h2>Sub Class Usage</h2>";

  $tom = new BusinessMajor("Golisano", "Tom");
  echo "<p>Tom: " . $tom->sayHello() . "</p>";
  echo "<p>Fashion Sense: " . $tom->fashion() . "</p>";

  echo "<br>";

  $steve = new ComputerMajor("Wozniak", "Steve");
  echo "<p>Steve: " . $steve->sayHello() . "</p>";
  echo "<p>Fashion Sense: " . $steve->fashion() . "</p>";
?>
