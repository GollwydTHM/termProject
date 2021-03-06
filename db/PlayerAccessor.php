<?php

require_once 'dbconnect.php';
require '../entity/Player.php';
require_once '../utils/ChromePhp.php';

class PlayerAccessor {

    private $getByPlayerIDStmtStr = "SELECT * "
            . "FROM player "
            . "WHERE playerID = :playerID "
            . "ORDER BY teamID, playerID";
    private $getPlayersByTeamIDStmtStr = "SELECT * "
            . "FROM player "
            . "WHERE teamID = :teamID "
            . "ORDER BY teamID, PlayerID";
    private $getByPlayerCountByTeamIDStmtStr = "SELECT COUNT(*) "
            . "FROM player "
            . "WHERE teamID = :teamID";
    private $deleteStmtStr = "DELETE FROM player "
            . "WHERE playerID = :playerID";
    private $insertStmtStr = "INSERT INTO player "
            . "VALUES(:playerID, :teamID, :firstName, :lastName, :hometown, :provinceCode )";
    private $updateStmtStr = "UPDATE player SET "
            . "teamID = :teamID, firstName = :firstName, lastName = :lastName, hometown = :hometown, provinceCode = :provinceCode "
            . "WHERE playerID = :playerID";
    private $conn = null;
    private $getByPlayerIDStmt = null;
    private $getPlayersByTeamIDStmt = null;
    private $getPlayerCountByTeamIDStmt = null;
    private $deleteStmt = null;
    private $insertStmt = null;
    private $updateStmt = null;

    public function __construct() {
        $dbConn = new DBConnect();

        $this->conn = $dbConn->connect_db();
        if (is_null($this->conn)) {
            throw new Exception("no connection");
        }

        $this->getByPlayerIDStmt = $this->conn->prepare($this->getByPlayerIDStmtStr);
        if (is_null($this->getByPlayerIDStmt)) {
            throw new Exception("bad statement: '" . $this->getAllStmtStr . "'");
        }

        $this->getPlayersByTeamIDStmt = $this->conn->prepare($this->getPlayersByTeamIDStmtStr);
        if (is_null($this->getPlayersByTeamIDStmt)) {
            throw new Exception("bad statement: '" . $this->getAllStmtStr . "'");
        }

        $this->getPlayerCountByTeamIDStmt = $this->conn->prepare($this->getByPlayerCountByTeamIDStmtStr);
        if (is_null($this->getPlayerCountByTeamIDStmt)) {
            throw new Exception("bad statement: '" . $this->getByPlayerCountByTeamIDStmtStr . "'");
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

    public function getPlayersByQuery($query) {
        try {
            $result = [];
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $res) {
                $playerID = $res['playerID'];
                $teamID = $res['teamID'];
                $firstName = $res['firstName'];
                $lastName = $res['lastName'];
                $hometown = $res['hometown'];
                $provinceCode = $res['provinceCode'];
                $obj = new Player(
                        $playerID,
                        $teamID,
                        $firstName,
                        $lastName,
                        $hometown,
                        $provinceCode);
                array_push($result, $obj);
            }
        } catch (Exception $e) {
            $result = [];
        } finally {
            if (!is_null($stmt)) {
                $stmt->closeCursor();
            }
            return $result;
        }
    }

    public function getPlayers() {
        return $this->getPlayersByQuery("SELECT * FROM player ORDER BY teamID, playerID");
    }

    public function getPlayerByPlayerID($playerID) {
        $result = NULL;

        try {
            $this->getByPlayerIDStmt->bindParam(":playerID", $playerID);
            $this->getByPlayerIDStmt->execute();
            $res = $this->getByPlayerIDStmt->fetch(PDO::FETCH_ASSOC); //not fetchAll

            if ($res) {
                $playerID = $res['playerID'];
                $teamID = $res['teamID'];
                $firstName = $res['firstName'];
                $lastName = $res['lastName'];
                $hometown = $res['hometown'];
                $provinceCode = $res['provinceCode'];
                $result = new Player(
                        $playerID,
                        $teamID,
                        $firstName,
                        $lastName,
                        $hometown,
                        $provinceCode);
            }
        } catch (Exception $e) {
            $result = NULL;
        } finally {
            if (!is_null($this->getByPlayerIDStmt)) {
                $this->getByPlayerIDStmt->closeCursor();
            }
        }

        return $result;
    }

    public function getPlayersByTeam($teamID) {
        try {
            $result = [];
            $this->getPlayersByTeamIDStmt->bindParam(":teamID", $teamID);
            $this->getPlayersByTeamIDStmt->execute();
            $results = $this->getPlayersByTeamIDStmt->fetchAll(PDO::FETCH_ASSOC); //not fetchAll

            foreach ($results as $res) {
                $playerID = $res['playerID'];
                $teamID = $res['teamID'];
                $firstName = $res['firstName'];
                $lastName = $res['lastName'];
                $hometown = $res['hometown'];
                $provinceCode = $res['provinceCode'];
                $obj = new Player(
                        $playerID,
                        $teamID,
                        $firstName,
                        $lastName,
                        $hometown,
                        $provinceCode);
                array_push($result, $obj);
            }
        } catch (PDOException $e) {
            $result = null;
            ChromePhp::log($e);
        } finally {
            if (!is_null($this->getPlayersByTeamIDStmt)) {
                $this->getPlayersByTeamIDStmt->closeCursor();
            }
            return $result;
        }
    }

    public function getPlayersCountByTeam($teamID) {
        try {
            $this->getPlayerCountByTeamIDStmt->bindParam(":teamID", $teamID);
            $this->getPlayerCountByTeamIDStmt->execute();
            $row = $this->getPlayerCountByTeamIDStmt->fetch(PDO::FETCH_ASSOC);
            $result = $row['COUNT(*)'];
        } catch (PDOException $e) {
            $result = null;
            ChromePhp::log($e);
        } finally {
            if (!is_null($this->getPlayerCountByTeamIDStmt)) {
                $this->getPlayerCountByTeamIDStmt->closeCursor();
            }
            return $result;
        }
    }

    public function deletePlayer($player) {
        $success = false;
        $playerID = $player->getPlayerID();
        try {
            $this->deleteStmt->bindParam(":playerID", $playerID);
            $success = $this->deleteStmt->execute();
        } catch (PDOException $e) {
            $success = false;
        } finally {
            if (!is_null($this->deleteStmt)) {
                $this->deleteStmt->closeCursor();
            }
            return $success;
        }
    }

    public function addPlayer($player) {
        $success = false;

        $playerID = $player->getPlayerID();
        $teamID = $player->getTeamID();
        $firstName = $player->getFirstName();
        $lastName = $player->getLastName();
        $hometown = $player->getHometown();
        $provinceCode = $player->getProvinceCode();

        try {
            $this->insertStmt->bindParam(":playerID", $playerID);
            $this->insertStmt->bindParam(":teamID", $teamID);
            $this->insertStmt->bindParam(":firstName", $firstName);
            $this->insertStmt->bindParam(":lastName", $lastName);
            $this->insertStmt->bindParam(":hometown", $hometown);
            $this->insertStmt->bindParam(":provinceCode", $provinceCode);
            $success = $this->insertStmt->execute();
        } catch (PDOException $e) {
            $success = false;
        } finally {
            if (!is_null($this->insertStmt)) {
                $this->insertStmt->closeCursor();
            }
            return $success;
        }
    }

    public function updatePlayer($player) {
        $success = false;

        $playerID = $player->getPlayerID();
        $teamID = $player->getTeamID();
        $firstName = $player->getFirstName();
        $lastName = $player->getLastName();
        $hometown = $player->getHometown();
        $provinceCode = $player->getProvinceCode();

        try {
            $this->updateStmt->bindParam(":playerID", $playerID);
            $this->updateStmt->bindParam(":teamID", $teamID);
            $this->updateStmt->bindParam(":firstName", $firstName);
            $this->updateStmt->bindParam(":lastName", $lastName);
            $this->updateStmt->bindParam(":hometown", $hometown);
            $this->updateStmt->bindParam(":provinceCode", $provinceCode);
            $success = $this->updateStmt->execute();
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

//end class PlayerAccessor

