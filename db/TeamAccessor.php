<?php

require_once 'dbconnect.php';
require '../entity/Team.php';
require_once '../utils/ChromePhp.php';

class TeamAccessor {

    private $getByTeamIDStmtStr = 
            "SELECT * "
            . "FROM team "
            . "WHERE teamID = :teamID";
    private $deleteStmtStr = 
            "DELETE FROM team "
            . "WHERE teamID = :teamID";
    private $insertStmtStr = 
            "INSERT INTO team "
            . "VALUES(:teamID, :teamName, :earnings)";
    private $updateStmtStr = 
            "UPDATE team SET "
            . "teamName = :teamName, earnings = :earnings "
            . "WHERE teamID = :teamID";
    private $conn = null;
    private $getByTeamIDStmt = null;
    private $deleteStmt = null;
    private $insertStmt = null;
    private $updateStmt = null;

    public function __construct() {
        $dbConn = new DBConnect();

        $this->conn = $dbConn->connect_db();
        if (is_null($this->conn)) {
            throw new Exception("no connection");
        }
        
        $this->getByTeamIDStmt = $this->conn->prepare($this->getByTeamIDStmtStr);
        if (is_null($this->getByTeamIDStmt)) {
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
    }

    public function getTeamsByQuery($query) {
        $result = [];

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $res) {
                $teamID = $res['teamID'];
                $teamName = $res['teamName'];
                $earnings = $res['earnings'];
                $obj = new Team(
                        $teamID,
                        $teamName,
                        $earnings);
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

    public function getTeams() {
        return $this->getTeamsByQuery("SELECT * FROM team");
    }

    public function getTeamByTeamID($teamID) {
        $result = NULL;

        try {
            $this->getByTeamIDStmt->bindParam(":teamID", $teamID);
            $this->getByTeamIDStmt->execute();
            $res = $this->getByTeamIDStmt->fetch(PDO::FETCH_ASSOC); //not fetchAll

            if ($res) {
                $teamID = $res['teamID'];
                $teamName = $res['teamName'];
                $earnings = $res['earnings'];
                $result = new Team(
                        $teamID,
                        $teamName,
                        $earnings);
            }
        } catch (Exception $e) {
            $result = NULL;
        } finally {
            if (!is_null($this->getByTeamIDStmt)) {
                $this->getByTeamIDStmt->closeCursor();
            }
        }

        return $result;
    }

    public function deleteTeam($team) {
        $success = false;
        $teamID = $team->getTeamID();
        try {
            $this->deleteStmt->bindParam(":teamID", $teamID);
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

    public function addTeam($team) {
        $success = false;

        $teamID = $team->getTeamID();
        $teamName = $team->getTeamName();
        $earnings = $team->getEarnings();

        try {
            $this->insertStmt->bindParam(":teamID", $teamID);
            $this->insertStmt->bindParam(":teamName", $teamName);
            $this->insertStmt->bindParam(":earnings", $earnings);
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

    public function updateTeam($team) {
        $success = false;

        $teamID = $team->getTeamID();
        $teamName = $team->getTeamName();
        $earnings = $team->getEarnings();
        
        try {
            $this->updateStmt->bindParam(":teamID", $teamID);
            $this->updateStmt->bindParam(":teamName", $teamName);
            $this->updateStmt->bindParam(":earnings", $earnings);
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

} //end class TeamAccessor