<?php
class Person {
	private $last,$first;

  // constructor here...
	function __construct($last = "TBD", $first = "TBD") {
		$this->last = $last;
		$this->first = $first;
	}

	function getFirstName() {
		return $this->first;
	}

	function getLastName() {
		return $this->last;
	}

	function sayHello() {
		return "Hi there! My first name is {$this->first} and my last name is ".
			$this->getLastName()."<br />";
	}

	function fashion() {
	  echo "jeans";
	}
}

?>
