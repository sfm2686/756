<?php

  require_once("hw4_1.php");

  class BritishPerson extends Person {

    const CM_TO_INCHES = 2.54;
    const KG_TO_LBS = 2.20462;

    // (height in cm, weight in kg)
    function calculate_bmi() {
      // if (!$this->height || !$this->weight) { // check weight and height are set and height is not zero
      //   return 0;
      // }

      // $in_height = $this->height / self::CM_TO_INCHES;
      // $lb_weight = $this->weight / self::KG_TO_LBS;
      $currentHeight = parent::getHeight();
      $currentweight = parent::getWeight();

      parent::setHeight($currentHeight / self::CM_TO_INCHES);
      parent::setWeight($currentweight * self::KG_TO_LBS);

      return parent::calculate_bmi();
    }
  }

?>
