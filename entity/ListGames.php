<?php

class ListGame implements JsonSerializable{
    private $gameID;
    private $matchID;
    private $gameNumber; 
    private $teamID;
    private $gameStateID;
    private $score;
    private $balls;
    
    public function __construct($gameID, $matchID, $gameNumber,$gameStateID, $score, $balls, $teamID) {
        $this->gameID = $gameID;
        $this->matchID = $matchID;
        $this->gameNumber = $gameNumber; 
        $this->teamID = $teamID;
        $this->gameStateID = $gameStateID;
        $this->score = $score;
        $this->balls = $balls;
    } 
    function setGameID() {
        $this->gameID;
    }

    function setMatchID() {
        $this->matchID;
    }

    function setGameNumber() {
        $this->gameNumber;
    }
    function getTeamID() {
        return $this->teamID;
    } 
    public function jsonSerialize() {
        return get_object_vars($this);
    }
}