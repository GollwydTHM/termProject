<?php

require_once 'dbconnect.php';
require '../entity/Matchup.php';
require '../entity/Stats.php';

require_once '../utils/ChromePhp.php';

class StatsAccessor {

    private $getTeams = "SELECT t.teamID, t.teamName, m.score, m.ranking " 
            . "FROM team t, matchup m"
            . "WHERE t.teamID = m.teamID";
    private $getTopRankStmt = "SELECT t.teamID, t.teamName, m.score, m.ranking FROM team t, matchup m
            WHERE t.teamID = m.teamID AND ranking <= 16
            ORDER BY ranking;";
    private $getListOfGamesStmt = "SELECT g.gameID,  g.matchID,  g.gameNumber, m.teamID FROM game g, matchup m
            WHERE g.matchID = m.teamID AND m.teamID = :teamID";
    private $updateScoreByCompleteGameState = "";
    private $conn = null;
    private $getListOfGames = null;  

    public function __construct() {
        $dbConn = new DBConnect();

        $this->conn = $dbConn->connect_db();
        if (is_null($this->conn)) {
            throw new Exception("no connection");
        }
        $this->getListOfGames = $this->conn->prepare($this->getListOfGamesStmt);
        if (is_null($this->getListOfGames)) {
            throw new Exception("bad statement: '" . $this->getListOfGamesStmt . "'");
        }
        $this->getTopRankStmt = $this->conn->prepare($this->getTopRankStmt);
        if (is_null($this->getTopRankStmt)){
            throw new Exception("bad statement: '" . $this->getTopRankStmt . "'");
        }
        $this->getTeams = $this->conn->prepare($this->getTeams);
        if (is_null($this->getTeams)) {
            throw new Exception("bad statement: '" . $this->getTeams . "'");
        }
        $this->updateStmt = $this->conn->prepare($this->updateScoreByCompleteGameState);
        if (is_null($this->updateStmt)) {
            throw new Exception("bad statement: '" . $this->updateScoreByCompleteGameState . "'");
        }
    }

    public function getMatchupByQuery($query) {
        $result = [];

        try { 
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $res) { 
                $teamID = $res['teamID'];
                $teamName = $res['teamName'];
                $score = $res['score'];
                $ranking = $res['ranking'];
                $obj = new Stats( 
                        $teamID,
                        $teamName,
                        $score,
                        $ranking);
                array_push($result, $obj);
            }
        } catch (Exception $e) {
            $result = [];
        } finally {
            if (!is_null($stmt)) {
                $stmt->closeCursor();
            }
        }

        return $result;
    }
    public function getGamesByTeamID($teamID) {
        

        try {
            $result = [];
            $this->getListOfGames->bindParam(":teamID", $teamID);
            $this->getListOfGames->execute(); //not what you think
            $results =  $this->getListOfGames->fetchAll(PDO::FETCH_ASSOC);
            ChromePhp::log("Before foreach");
            foreach ($results as $res){
                $gameID = $res['gameID'];
                $matchID = $res['matchID'];
                $gameNumber = $res['gameNumber'];
                $teamID = $res['teamID'];  
                $obj = new ListGame(
                        $gameID,
                        $matchID,
                        $gameNumber,
                        $teamID);
                ChromePhp::log($obj);
                array_push($result, $obj);
            }
        } catch (PDOException $e) { 
            $result = null;
        } finally {
            if (!is_null($this->getListOfGames)) {
                $this->getListOfGames->closeCursor();
            }
            return $results;
        }
    }
 
public function getMatchup() {
    return $this->getMatchupByQuery("SELECT t.teamID, t.teamName, m.score, m.ranking FROM team t, matchup m
        WHERE t.teamID = m.teamID");
}

public function getTopRank(){
    return $this->getMatchupByQuery("SELECT t.teamID, t.teamName, m.score, m.ranking FROM team t, matchup m
        WHERE t.teamID = m.teamID AND ranking <= 16
        ORDER BY ranking;");
}


}

//end class MatchupAccessor
