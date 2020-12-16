<?php

require_once 'dbconnect.php';
require '../entity/Game.php';
require_once '../utils/ChromePhp.php';

class GameAccessor {

    private $getByGameIDStmtStr = "SELECT * "
            . "FROM game "
            . "WHERE gameID = :gameID";
    private $deleteStmtStr = "DELETE FROM game "
            . "WHERE gameID = :gameID";
    private $insertStmtStr = "INSERT INTO game "
            . "VALUES(:gameID, :matchID, :gameNumber, :gameStateID, :score, :balls)";
    private $updateStmtStr = "UPDATE game SET "
            . "matchID = :matchID, gameNumber = :gameNumber, gameStateID = :gameStateID, score = :score, balls = :balls "
            . "WHERE gameID = :gameID";
    private $conn = null;
    private $getByGameIDStmt = null;
    private $deleteStmt = null;
    private $insertStmt = null;
    private $updateStmt = null;

    public function __construct() {
        $dbConn = new DBConnect();

        $this->conn = $dbConn->connect_db();
        if (is_null($this->conn)) {
            throw new Exception("no connection");
        }

        $this->getByGameIDStmt = $this->conn->prepare($this->getByGameIDStmtStr);
        if (is_null($this->getByGameIDStmt)) {
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

    public function getGamesByQuery($query) {
        try {
            $result = [];
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $res) {
                $gameID = $res['gameID'];
                $matchID = $res['matchID'];
                $gameNumber = $res['gameNumber'];
                $gameStateID = $res['gameStateID'];
                $score = $res['score'];
                $balls = $res['balls'];
                $obj = new Game(
                        $gameID,
                        $matchID,
                        $gameNumber,
                        $gameStateID,
                        $score,
                        $balls);
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

    public function getAvailGames() {
        return $this->getGamesByQuery("SELECT * FROM game WHERE gameStateID = 'AVAILABLE' OR gameStateID = 'INPROGRESS'");
    }

    public function getCpltGames() {
        return $this->getGamesByQuery("SELECT * FROM game WHERE gameStateID = 'COMPLETE'");
    }

    public function getGameByGameID($gameID) {
        $result = NULL;

        try {
            $this->getByGameIDStmt->bindParam(":gameID", $gameID);
            $this->getByGameIDStmt->execute();
            $res = $this->getByGameIDStmt->fetch(PDO::FETCH_ASSOC); //not fetchAll

            if ($res) {
                $gameID = $res['gameID'];
                $matchID = $res['matchID'];
                $gameNumber = $res['gameNumber'];
                $gameStateID = $res['gameStateID'];
                $score = $res['score'];
                $balls = $res['balls'];
                $result = new Game(
                        $gameID,
                        $matchID,
                        $gameNumber,
                        $gameStateID,
                        $score,
                        $balls);
            }
        } catch (Exception $e) {
            $result = NULL;
        } finally {
            if (!is_null($this->getByGameIDStmt)) {
                $this->getByGameIDStmt->closeCursor();
            }
        }

        return $result;
    }

    public function deleteGame($game) {
        $success = false;
        $gameID = $game->getGameID();
        try {
            $this->deleteStmt->bindParam(":gameID", $gameID);
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

    public function addGame($game) {
        $success = false;

        $gameID = $game->getGameID();
        $matchID = $game->getMatchID();
        $gameNumber = $game->getGameNumber();
        $gameStateID = $game->getGameStateID();
        $score = $game->getScore();
        $balls = $game->getBalls();

        try {
            $this->insertStmt->bindParam(":gameID", $gameID);
            $this->insertStmt->bindParam(":matchID", $matchID);
            $this->insertStmt->bindParam(":gameNumber", $gameNumber);
            $this->insertStmt->bindParam(":gameStateID", $gameStateID);
            $this->insertStmt->bindParam(":score", $score);
            $this->insertStmt->bindParam(":balls", $balls);
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

    public function updateGame($game) {
        $success = false;

        $gameID = $game->getGameID();
        $matchID = $game->getMatchID();
        $gameNumber = $game->getGameNumber();
        $gameStateID = $game->getGameStateID();
        $score = $game->getScore();
        $balls = $game->getBalls();


        try {
            $this->updateStmt->bindParam(":gameID", $gameID);
            $this->updateStmt->bindParam(":matchID", $matchID);
            $this->updateStmt->bindParam(":gameNumber", $gameNumber);
            $this->updateStmt->bindParam(":gameStateID", $gameStateID);
            $this->updateStmt->bindParam(":score", $score);
            $this->updateStmt->bindParam(":balls", $balls);
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

//end class GameAccessor

