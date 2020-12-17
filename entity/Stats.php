<?php

class Stats implements JsonSerializable {

    
    private $teamID;
    private $teamName;
    private $score;
    private $ranking;
    private $earnings;
    function __construct($teamID, $teamName, $score, $ranking, $earnings) {
        $this->teamID = $teamID;
        $this->teamName = $teamName;
        $this->score = $score;
        $this->ranking = $ranking;
        $this->earnings = $earnings;
    }
 

    function getTeamID() {
        return $this->teamID;
    }
    function getTeamName() {
        return $this->teamName;
    }

    function getScore() {
        return $this->score;
    }

    function getRanking() {
        return $this->ranking;
    }
    function getEarnings() {
        return $this->earnings;
    }

        public function jsonSerialize() {
        return get_object_vars($this);
    }

}
