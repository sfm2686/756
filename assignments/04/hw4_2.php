<?php

  require_once("hw4_1.php");

  // first person object
  $person = new Person();

  $person->setHeight(84); // 60 inches -> 7 ft
  $person->setWeight(180); // 180 lbs

  $full_name = $person->getFirstName() . " " . $person->getLastName();
  $bmi = $person->calculate_bmi();
  echo "<p>First person</p>";
  echo "<p>Person name: $full_name, BMI: $bmi</p>";

  echo "<hr>";

  // second person object
  $person = new Person("John", "Doe");

  $person->setHeight(60); // 60 inches -> 5 ft
  $person->setWeight(140); // 140 lbs

  $full_name = $person->getFirstName() . " " . $person->getLastName();
  $bmi = $person->calculate_bmi();
  echo "<p>Second person</p>";
  echo "<p>Person name: $full_name, BMI: $bmi</p>";

?>
