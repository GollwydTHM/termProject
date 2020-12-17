<?php

class Pay implements JsonSerializable {

    
    private $teamID; 

    function __construct($teamID) {
        $this->teamID = $teamID; 
    }
 

    function getTeamID() {
        return $this->teamID;
    }  
 
    public function jsonSerialize() {
        return get_object_vars($this);
    }

}
