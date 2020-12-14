<?php

class Matchup implements JsonSerializable {

    private $matchID;
    private $roundID;
    private $matchgroup;
    private $teamID;
    private $score;
    private $ranking;

    function __construct($matchID, $roundID, $matchgroup, $teamID, $score, $ranking) {
        $this->matchID = $matchID;
        $this->roundID = $roundID;
        $this->matchgroup = $matchgroup;
        $this->teamID = $teamID;
        $this->score = $score;
        $this->ranking = $ranking;
    }

    function getMatchID() {
        return $this->matchID;
    }

    function getRoundID() {
        return $this->roundID;
    }

    function getMatchgroup() {
        return $this->matchgroup;
    }

    function getTeamID() {
        return $this->teamID;
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
