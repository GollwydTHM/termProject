<?php

class ListGame implements JsonSerializable{
    private $gameID;
    private $matchID;
    private $gameNumber; 
    private $teamID;

    public function __construct($gameID, $matchID, $gameNumber, $teamID) {
        $this->gameID = $gameID;
        $this->matchID = $matchID;
        $this->gameNumber = $gameNumber; 
        $this->teamID = $teamID;
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