<?php

require_once 'dbconnect.php';
require '../entity/Matchup.php';
require_once '../utils/ChromePhp.php';

class StatsAccessor {

    private $getByMatchIDStmtStr = "SELECT * "
            . "FROM matchup "
            . "WHERE teamID = :teamID";
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

        $this->getByMatchIDStmt = $this->conn->prepare($this->getByMatchIDStmtStr);
        if (is_null($this->getByMatchIDStmt)) {
            throw new Exception("bad statement: '" . $this->getAllStmtStr . "'");
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
                $matchID = $res['matchID'];
                $roundID = $res['roundID'];
                $matchgroup = $res['matchgroup'];
                $teamID = $res['teamID'];
                $score = $res['score'];
                $ranking = $res['ranking'];
                $obj = new Matchup(
                        $matchID,
                        $roundID,
                        $matchgroup,
                        $teamID,
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

    public function getMatchup($teamID) {
        return $this->getMatchupByQuery("SELECT * FROM matchup WHERE teamID = $teamID");
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
