<?php
class Person {

  const BMI_CONSTANT = 705;

	private $first_name,$last_name, $weight, $height;

  // class constructor
  function __construct($first_name="Sam", $last_name="Spade") {
    $this->first_name = $first_name;
    $this->last_name = $last_name;
  }

  // (height in inches, weight in lbs)
  function calculate_bmi() {
    if (!$this->height || !$this->weight) { // check weight and height are set and height is not zero
      return 0;
    }

    return round((self::BMI_CONSTANT * $this->weight) / pow($this->height, 2), 2);
  }

  /* accessors and mutators */

  // first name
  function getFirstName() {
    return $this->first_name;
  }

  function setFirstName($first_name) {
    $this->first_name = $first_name;
  }

  // last name
  function getLastName() {
    return $this->last_name;
  }

  function setLastName($last_name) {
    $this->last_name = $last_name;
  }

  // height
  function getHeight() {
    return $this->height;
  }

  function setHeight($height) {
    $this->height = $height;
  }

  // weight
  function getWeight() {
    return $this->weight;
  }

  function setWeight($weight) {
    $this->weight = $weight;
  }
}

?>
