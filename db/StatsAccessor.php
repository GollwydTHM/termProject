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
    private $updateScoreByCompleteGameState = "";
    private $conn = null;
    private $getByMatchIDStmt = null;
    private $updateStmt = null;

    public function __construct() {
        $dbConn = new DBConnect();

        $this->conn = $dbConn->connect_db();
        if (is_null($this->conn)) {
            throw new Exception("no connection");
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

public function getMatchup() {
    return $this->getMatchupByQuery("SELECT t.teamID, t.teamName, m.score, m.ranking FROM team t, matchup m
        WHERE t.teamID = m.teamID");
}

public function getTopRank(){
    return $this->getMatchupByQuery("SELECT t.teamID, t.teamName, m.score, m.ranking FROM team t, matchup m
        WHERE t.teamID = m.teamID AND ranking <= 16
        ORDER BY ranking;");
}
public function updateScore($match) {
        $success = false;

        $matchID = $match->getMatchID();
        $roundID = $match->getRoundID();
        $matchgroup = $match->getMatchgroup();
        $teamID = $match->getTeamID();
        $score = $match->getScore(); 
        $ranking = $match->getRanking();
        
        try {
            $this->updateStmt->bindParam(":matchID", $matchID); 
            $success = $this->updateStmt->execute(); //not what you think
        } catch (PDOException $e) {
            $success = false;
        } finally {
            if (!is_null($this->updateStmt)) {
                $this->updateStmt->closeCursor();
            }
            return $success;
        }
    }

   

}

//end class MatchupAccessor
