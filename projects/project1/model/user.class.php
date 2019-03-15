<?php
class User {
  private $username;
  private $role;
  private $password;
  private $team;
  private $leauge;

  public function __construct($username, $role, $password, $team, $leauge) {
    $this->username = $username;
    $this->role = $role;
    $this->password = $password;
    $this->team = $team;
    $this->leauge = $leauge;
  }

    /**
     * Get the value of Username
     *
     * @return mixed
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set the value of Username
     *
     * @param mixed username
     *
     * @return self
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of Role
     *
     * @return mixed
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * Set the value of Role
     *
     * @param mixed role
     *
     * @return self
     */
    public function setRole($role) {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of Password
     *
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set the value of Password
     *
     * @param mixed password
     *
     * @return self
     */
    public function setPassword($password) {
        $this->password = $password;

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

    /**
     * Get the value of Leauge
     *
     * @return mixed
     */
    public function getLeauge() {
        return $this->leauge;
    }

    /**
     * Set the value of Leauge
     *
     * @param mixed leauge
     *
     * @return self
     */
    public function setLeauge($leauge) {
        $this->leauge = $leauge;

        return $this;
    }
}
?>
