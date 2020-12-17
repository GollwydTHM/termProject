<?php

require_once 'dbconnect.php';
require '../entity/Matchup.php';
require_once '../utils/ChromePhp.php';

class MatchupAccessor {

    private $getByMatchIDStmtStr = "SELECT * "
            . "FROM matchup "
            . "WHERE matchID = :matchID";
     private $getTournamentQualTankStmtStr = "SELECT  m.ranking, t.teamName "
            . "FROM  matchup m, team t "
            . "WHERE m.teamID = t.teamID and m.roundID = 'QUAL' ORDER BY m.ranking";
    private $deleteStmtStr = "DELETE FROM matchup "
            . "WHERE matchID = :matchID";
    private $insertStmtStr = "INSERT INTO matchup "
            . "VALUES(:matchID, :roundID, :matchgroup, :teamID, :score, :ranking)";
    private $updateStmtStr = "UPDATE matchup SET "
            . "roundID = :roundID, matchgroup = :matchgroup, teamID = :teamID, score = :score, ranking = :ranking "
            . "WHERE matchID = :matchID";
    private $updateScoreByMatchIdStmtStr = "UPDATE matchup "
            . "SET score = (SELECT SUM(g.score) from game g "
            . "WHERE g.matchID = :matchID AND g.gameStateID = 'COMPLETE') "
            . "WHERE matchID = :matchID";
    private $updateTeamIDByMatchStr = "UPDATE matchup "
            . "SET teamID = :teamID "
            . "WHERE matchID = :matchID";
    private $conn = null;
    private $getByMatchIDStmt = null;
    private $deleteStmt = null;
    private $insertStmt = null;
    private $updateStmt = null;
    private $updateScoreByMatchIdStmt = null;
    private $updateTeamIDByMatchStmt = null;
    private $getTournamentQualTankStmt = null;

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

        $this->deleteStmt = $this->conn->prepare($this->deleteStmtStr);
        if (is_null($this->deleteStmt)) {
            throw new Exception("bad statement: '" . $this->deleteStmtStr . "'");
        }

        $this->insertStmt = $this->conn->prepare($this->insertStmtStr);
        if (is_null($this->insertStmt)) {
            throw new Exception("bad statement: '" . $this->getAllStmtStr . "'");
        }

        $this->updateStmt = $this->conn->prepare($this->updateStmtStr);
        if (is_null($this->updateStmt)) {
            throw new Exception("bad statement: '" . $this->updateStmtStr . "'");
        }

        $this->updateScoreByMatchIdStmt = $this->conn->prepare($this->updateScoreByMatchIdStmtStr);
        if (is_null($this->updateScoreByMatchIdStmt)) {
            throw new Exception("bad statement: '" . $this->updateScoreByMatchIdStmtStr . "'");
        }
        $this->updateTeamIDByMatchStmt = $this->conn->prepare($this->updateTeamIDByMatchStr);
        if (is_null($this->updateTeamIDByMatchStmt)) {
            throw new Exception("bad statement: '" . $this->updateTeamIDByMatchStr . "'");
        }
        
         $this->getTournamentQualTankStmt = $this->conn->prepare($this->getTournamentQualTankStmtStr);
        if (is_null($this->getTournamentQualTankStmt)) {
            throw new Exception("bad statement: '" . $this->getTournamentQualTankStmtStr . "'");
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
    
    public function getTournamentQual() {
        $result = [];

        try {
            $this->getTournamentQualTankStmt->execute();
            $results = $this->getTournamentQualTankStmt->fetchAll(PDO::FETCH_ASSOC);
            ChromePhp::log($results);
            foreach ($results as $res) {
                $rank = $res['ranking'];
                $teamName = $res['teamName'];
                $obj = new stdClass();
                $obj->rank = $rank;
                $obj->teamName = $teamName;
                //ChromePhp::log($obj);

                array_push($result, $obj);
            }
        } catch (Exception $e) {
            $result = [];
        } finally {
            if (!is_null($this)) {
                $this->getTournamentQualTankStmt->closeCursor();
            }
        }
        //ChromePhp::log($result);

        return $result;
    }

    public function getMatchup() {
        return $this->getMatchupByQuery("SELECT * FROM matchup");
    }

    public function getMatchupByRoundID($roundID) {
        return $this->getMatchupByQuery("SELECT * FROM matchup WHERE roundID ='" . $roundID . "'");
    }

    public function getMatchupByRoundIDAndMatchGroup($roundID, $matchRound) {

        return $this->getMatchupByQuery("SELECT * FROM matchup WHERE roundID ='" . $roundID . "' AND matchgroup ='" . $matchRound . "'");
    }

    public function getMatchByMatchID($matchID) {
        $result = NULL;

        try {
            $this->getByMatchIDStmt->bindParam(":matchID", $matchID);
            $this->getByMatchIDStmt->execute();
            $res = $this->getByMatchIDStmt->fetch(PDO::FETCH_ASSOC); //not fetchAll

            if ($res) {
                $matchID = $res['matchID'];
                $roundID = $res['roundID'];
                $matchgroup = $res['matchgroup'];
                $teamID = $res['teamID'];
                $score = $res['score'];
                $ranking = $res['ranking'];
                $result = new Matchup(
                        $matchID,
                        $roundID,
                        $matchgroup,
                        $teamID,
                        $score,
                        $ranking);
            }
        } catch (Exception $e) {
            $result = NULL;
        } finally {
            if (!is_null($this->getByMatchIDStmt)) {
                $this->getByMatchIDStmt->closeCursor();
            }
        }

        return $result;
    }

    public function deleteMatch($match) {
        $success = false;
        $matchID = $match->getMatchID();
        try {
            $this->deleteStmt->bindParam(":matchID", $matchID);
            $success = $this->deleteStmt->execute();
            $rc = $this->deleteStmt->rowCount();
        } catch (PDOException $e) {
            $success = false;
        } finally {
            if (!is_null($this->deleteStmt)) {
                $this->deleteStmt->closeCursor();
            }
            return $success;
        }
    }

    public function addMatch($match) {
        $success = false;

        $matchID = $match->getMatchID();
        $roundID = $match->getRoundID();
        $matchgroup = $match->getMatchgroup();
        $teamID = $match->getTeamID();
        $score = $match->getScore();
        $ranking = $match->getRanking();


        try {
            $this->insertStmt->bindParam(":matchID", $matchID);
            $this->insertStmt->bindParam(":roundID", $roundID);
            $this->insertStmt->bindParam(":matchgroup", $matchgroup);
            $this->insertStmt->bindParam(":teamID", $teamID);
            $this->insertStmt->bindParam(":score", $score);
            $this->insertStmt->bindParam(":ranking", $ranking);
            $success = $this->insertStmt->execute(); //not what you think
        } catch (PDOException $e) {
            $success = false;
        } finally {
            if (!is_null($this->insertStmt)) {
                $this->insertStmt->closeCursor();
            }
            return $success;
        }
    }

    public function updateMatch($match) {
        $success = false;

        $matchID = $match->getMatchID();
        $roundID = $match->getRoundID();
        $matchgroup = $match->getMatchgroup();
        $teamID = $match->getTeamID();
        $score = $match->getScore();
        $ranking = $match->getRanking();

        try {
            $this->updateStmt->bindParam(":matchID", $matchID);
            $this->updateStmt->bindParam(":roundID", $roundID);
            $this->updateStmt->bindParam(":matchgroup", $matchgroup);
            $this->updateStmt->bindParam(":teamID", $teamID);
            $this->updateStmt->bindParam(":score", $score);
            $this->updateStmt->bindParam(":ranking", $ranking);
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

    public function updateScore($matchID) {
        $success = false;

        try {
            $this->updateScoreByMatchIdStmt->bindParam(":matchID", $matchID);
            $success = $this->updateScoreByMatchIdStmt->execute(); //not what you think
        } catch (PDOException $e) {
            ChromePhp::log("catahccatahccatahccatahccatahccatahc");

            $success = false;
        } finally {
            if (!is_null($this->updateScoreByMatchIdStmt)) {
                $this->updateScoreByMatchIdStmt->closeCursor();
            }
            return $success;
        }
    }

    public function updateTeam($match) {
        $success = false;
        try {
            $matchID = $match->getMatchID();
            $teamID = $match->getTeamID();

            $this->updateTeamIDByMatchStmt->bindParam(":matchID", $matchID);
            $this->updateTeamIDByMatchStmt->bindParam(":teamID", $teamID);
            $success = $this->updateScoreByMatchIdStmt->execute(); //not what you think
        } catch (PDOException $e) {
            $success = false;
        } finally {
            if (!is_null($this->updateScoreByMatchIdStmt)) {
                $this->updateScoreByMatchIdStmt->closeCursor();
            }
            return $success;
        }
    }

}

//end class MatchupAccessor
