<?php

class Stats implements JsonSerializable {

    
    private $teamID;
    private $teamName;
    private $score;
    private $ranking;

    function __construct($teamID, $teamName, $score, $ranking) {
        $this->teamID = $teamID;
        $this->teamName = $teamName;
        $this->score = $score;
        $this->ranking = $ranking;
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

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}
