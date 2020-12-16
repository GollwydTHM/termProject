<?php

require_once '../db/PlayerAccessor.php';
require_once '../entity/Player.php';
require_once '../utils/ChromePhp.php';

$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
if ($method === "GET") {
    doGet();
} else if ($method === "POST") {
    doPost();
} else if ($method === "DELETE") {
    doDelete();
} else if ($method === "PUT") {
    doPut();
}

function doGet() {
    if (filter_has_var(INPUT_GET, 'teamID')) {
        $teamID = filter_input(INPUT_GET, 'teamID');

        try {
            $t = new PlayerAccessor();
            $results = $t->getPlayersCountByTeam($teamID);
            $results = json_encode($results, JSON_NUMERIC_CHECK);
            echo $results;
        } catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    } else if (filter_has_var(INPUT_GET, 'playersByTeamID')) {
        $teamID = filter_input(INPUT_GET, 'playersByTeamID');

        try {
            $t = new PlayerAccessor();
            $results = $t->getPlayersByTeam($teamID);
            $results = json_encode($results, JSON_NUMERIC_CHECK);
            echo $results;
        } catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    } else if (!filter_has_var(INPUT_GET, 'playerID')) {
        try {
            $t = new PlayerAccessor();
            $results = $t->getPlayers();
            $results = json_encode($results, JSON_NUMERIC_CHECK);
            echo $results;
        } catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    } else {
        ChromePhp::log("You are requesting the player " . filter_input(INPUT_GET, 'playerID'));
    }
}

function doDelete() {
    if (!filter_has_var(INPUT_GET, 'playerID')) {
        ChromePhp::log("You can not delete more than one team at a time.");
    } else {
        $playerID = filter_input(INPUT_GET, "playerID");

        $playerObj = new Player($playerID, 0, "dummy", "dummy", "dummy", "dm");

        $t = new PlayerAccessor();
        $success = $t->deletePlayer($playerObj);
        echo $success;
    }
}

function doPost() {
    $body = file_get_contents('php://input');
    $contents = json_decode($body, true);

    $playerObj = new Player($contents['playerID'], $contents['teamID'], $contents['firstName'], $contents['lastName'], $contents['hometown'], $contents['provinceCode']);
    ChromePhp::log($playerObj);
    $t = new PlayerAccessor();
    $success = $t->addPlayer($playerObj);
    echo $success;
}

function doPut() {
    $body = file_get_contents('php://input');
    $contents = json_decode($body, true);

    $playerObj = new Player($contents['playerID'], $contents['teamID'], $contents['firstName'], $contents['lastName'], $contents['hometown'], $contents['provinceCode']);

    $t = new PlayerAccessor();
    $success = $t->updatePlayer($playerObj);
    echo $success;
}
