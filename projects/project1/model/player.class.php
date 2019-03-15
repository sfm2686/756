<?php
class Player {

  private $firstname;
  private $lastname;
  private $dob;
  private $number;
  private $team;

  public function __construct($firstname, $lastname, $dob, $number, $team) {
    $this->firstname = $firstname;
    $this->lastname = $lastname;
    $this->dob = $dob;
    $this->number = $number;
    $this->team = $team;
  }


    /**
     * Get the value of Firstname
     *
     * @return mixed
     */
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * Set the value of Firstname
     *
     * @param mixed firstname
     *
     * @return self
     */
    public function setFirstname($firstname) {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of Lastname
     *
     * @return mixed
     */
    public function getLastname() {
        return $this->lastname;
    }

    /**
     * Set the value of Lastname
     *
     * @param mixed lastname
     *
     * @return self
     */
    public function setLastname($lastname) {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of Dob
     *
     * @return mixed
     */
    public function getDob() {
        return $this->dob;
    }

    /**
     * Set the value of Dob
     *
     * @param mixed dob
     *
     * @return self
     */
    public function setDob($dob) {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get the value of Number
     *
     * @return mixed
     */
    public function getNumber() {
        return $this->number;
    }

    /**
     * Set the value of Number
     *
     * @param mixed number
     *
     * @return self
     */
    public function setNumber($number) {
        $this->number = $number;

        return $this;
    }

    /**
     * Get the value of Team
     *
     * @return mixed
     */
    public function getTeam() {
        return $this->team;
    }

    /**
     * Set the value of Team
     *
     * @param mixed team
     *
     * @return self
     */
    public function setTeam($team) {
        $this->team = $team;

        return $this;
    }
}
?>
