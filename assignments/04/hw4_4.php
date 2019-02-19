<?php

  require_once("hw4_3.php");

  // first person object
  $person = new BritishPerson("Stephen", "Hawking");

  $person->setHeight(180); // 180 cm
  $person->setWeight(70); // 70 kg

  $full_name = $person->getFirstName() . " " . $person->getLastName();
  $bmi = $person->calculate_bmi();
  echo "<p>First person</p>";
  echo "<p>Person name: $full_name, BMI: $bmi</p>";

  echo "<hr>";

  // second person object
  $person = new BritishPerson("Winston", "Churchill");

  $person->setHeight(164); // 164 cm
  $person->setWeight(66); // 66 kg

  $full_name = $person->getFirstName() . " " . $person->getLastName();
  $bmi = $person->calculate_bmi();
  echo "<p>Second person</p>";
  echo "<p>Person name: $full_name, BMI: $bmi</p>";

?>
