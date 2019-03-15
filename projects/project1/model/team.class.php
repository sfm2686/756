<?php
class Team {
  private $name;
  private $mascot;
  private $sport;
  private $leauge;
  private $season;
  private $picture;
  private $homecolor;
  private $awaycolor;
  private $maxplayers;

  public function __construct($name, $mascot, $sport, $leauge, $season, $picture, $homecolor, $awaycolor, $maxplayers) {
    $this->name = $name;
    $this->mascot = $mascot;
    $this->spoft = $sport;
    $this->league = $leauge;
    $this->season = $season;
    $this->picture = $picture;
    $this->homecolor = $homecolor;
    $this->awaycolor = $awaycolor;
    $this->maxplayers = $maxplayers;
  }

    /**
     * Get the value of Name
     *
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param mixed name
     *
     * @return self
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of Mascot
     *
     * @return mixed
     */
    public function getMascot() {
        return $this->mascot;
    }

    /**
     * Set the value of Mascot
     *
     * @param mixed mascot
     *
     * @return self
     */
    public function setMascot($mascot) {
        $this->mascot = $mascot;

        return $this;
    }

    /**
     * Get the value of Sport
     *
     * @return mixed
     */
    public function getSport() {
        return $this->sport;
    }

    /**
     * Set the value of Sport
     *
     * @param mixed sport
     *
     * @return self
     */
    public function setSport($sport) {
        $this->sport = $sport;

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

    /**
     * Get the value of Season
     *
     * @return mixed
     */
    public function getSeason() {
        return $this->season;
    }

    /**
     * Set the value of Season
     *
     * @param mixed season
     *
     * @return self
     */
    public function setSeason($season) {
        $this->season = $season;

        return $this;
    }

    /**
     * Get the value of Picture
     *
     * @return mixed
     */
    public function getPicture() {
        return $this->picture;
    }

    /**
     * Set the value of Picture
     *
     * @param mixed picture
     *
     * @return self
     */
    public function setPicture($picture) {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get the value of Homecolor
     *
     * @return mixed
     */
    public function getHomecolor() {
        return $this->homecolor;
    }

    /**
     * Set the value of Homecolor
     *
     * @param mixed homecolor
     *
     * @return self
     */
    public function setHomecolor($homecolor) {
        $this->homecolor = $homecolor;

        return $this;
    }

    /**
     * Get the value of Awaycolor
     *
     * @return mixed
     */
    public function getAwaycolor() {
        return $this->awaycolor;
    }

    /**
     * Set the value of Awaycolor
     *
     * @param mixed awaycolor
     *
     * @return self
     */
    public function setAwaycolor($awaycolor) {
        $this->awaycolor = $awaycolor;

        return $this;
    }

    /**
     * Get the value of Maxplayers
     *
     * @return mixed
     */
    public function getMaxplayers() {
        return $this->maxplayers;
    }

    /**
     * Set the value of Maxplayers
     *
     * @param mixed maxplayers
     *
     * @return self
     */
    public function setMaxplayers($maxplayers) {
        $this->maxplayers = $maxplayers;

        return $this;
    }
}
?>
