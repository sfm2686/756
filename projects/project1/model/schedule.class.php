<?php

include_once 'model.class.php';

class Schedule extends Model {

  private $sport;
  private $league;
  private $season;
  private $hometeam;
  private $awayteam;
  private $homescore;
  private $awayscore;
  private $scheduled;
  private $completed;

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
     * Get the value of League
     *
     * @return mixed
     */
    public function getLeague() {
        return $this->league;
    }

    /**
     * Set the value of League
     *
     * @param mixed league
     *
     * @return self
     */
    public function setLeague($league) {
        $this->league = $league;

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
     * Get the value of Hometeam
     *
     * @return mixed
     */
    public function getHometeam() {
        return $this->hometeam;
    }

    /**
     * Set the value of Hometeam
     *
     * @param mixed hometeam
     *
     * @return self
     */
    public function setHometeam($hometeam) {
        $this->hometeam = $hometeam;

        return $this;
    }

    /**
     * Get the value of Awayteam
     *
     * @return mixed
     */
    public function getAwayteam() {
        return $this->awayteam;
    }

    /**
     * Set the value of Awayteam
     *
     * @param mixed awayteam
     *
     * @return self
     */
    public function setAwayteam($awayteam) {
        $this->awayteam = $awayteam;

        return $this;
    }

    /**
     * Get the value of Homescore
     *
     * @return mixed
     */
    public function getHomescore() {
        return $this->homescore;
    }

    /**
     * Set the value of Homescore
     *
     * @param mixed homescore
     *
     * @return self
     */
    public function setHomescore($homescore) {
        $this->homescore = $homescore;

        return $this;
    }

    /**
     * Get the value of Awayscore
     *
     * @return mixed
     */
    public function getAwayscore() {
        return $this->awayscore;
    }

    /**
     * Set the value of Awayscore
     *
     * @param mixed awayscore
     *
     * @return self
     */
    public function setAwayscore($awayscore) {
        $this->awayscore = $awayscore;

        return $this;
    }

    /**
     * Get the value of Scheduled
     *
     * @return mixed
     */
    public function getScheduled() {
        return $this->scheduled;
    }

    /**
     * Set the value of Scheduled
     *
     * @param mixed scheduled
     *
     * @return self
     */
    public function setScheduled($scheduled) {
        $this->scheduled = $scheduled;

        return $this;
    }

    /**
     * Get the value of Completed
     *
     * @return mixed
     */
    public function getCompleted() {
        return $this->completed;
    }

    /**
     * Set the value of Completed
     *
     * @param mixed completed
     *
     * @return self
     */
    public function setCompleted($completed) {
        $this->completed = $completed;

        return $this;
    }
}
?>
