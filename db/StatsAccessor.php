<?php

require_once 'dbconnect.php';
require '../entity/Matchup.php';
require_once '../utils/ChromePhp.php';

class StatsAccessor {

    private $getByMatchIDStmtStr = "SELECT * "
            . "FROM matchup "
            . "WHERE teamID = :teamID";
    
    private $conn = null;
    private $getByMatchIDStmt = null;

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

//    public function getMatchByTeamID($teamID) {
//        $result = NULL;
//         
//        try {
//            ChromePhp::log("start of the try");
//            $this->getByMatchIDStmt->bindParam(":teamID", $teamID);
//            $this->getByMatchIDStmt->execute();
//            $res = $this->getByMatchIDStmt->fetch(PDO::FETCH_ASSOC); //not fetchAll
//             
//            if ($res) {
//                $matchID = $res['matchID'];
//                $roundID = $res['roundID'];
//                $matchgroup = $res['matchgroup'];
//                $teamID = $res['teamID'];
//                $score = $res['score'];
//                $ranking = $res['ranking'];
//                $result = new Matchup(
//                        $matchID,
//                        $roundID,
//                        $matchgroup,
//                        $teamID,
//                        $score,
//                        $ranking);
//            }
//        } catch (Exception $e) {
//            $result = NULL;
//        } finally {
//            if (!is_null($this->getByMatchIDStmt)) {
//                $this->getByMatchIDStmt->closeCursor();
//            }
//        }
//
//        return $result;
//    }

   

}

//end class MatchupAccessor
