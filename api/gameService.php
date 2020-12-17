<?php

require_once '../db/GameAccessor.php';
require_once '../entity/Game.php';
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
    if (filter_has_var(INPUT_GET, 'Cplt')) {
        try {
            $g = new GameAccessor();
            $results = $g->getCpltGames();
            //ChromePhp::log($results);
            $results = json_encode($results);
            echo $results;
        } catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    }
    else if (filter_has_var(INPUT_GET, 'Avail')) {
        try {
            $g = new GameAccessor();
            $results = $g->getAvailGames();
            //ChromePhp::log($results);
            $results = json_encode($results);
            echo $results;
        } catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    } else if (!filter_has_var(INPUT_GET, 'gameID')) {
        try {
            $g = new GameAccessor();
            $results = $g->getGames();
            //ChromePhp::log($results);
            $results = json_encode($results);
            echo $results;
        } catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    } else if (filter_has_var(INPUT_GET, 'gameByID')){
        $gameID = filter_input(INPUT_GET, 'gameByID');
        try { 
            ChromePhp::log($gameID . " inside");
            $t = new GameAccessor();
            $results = $t->getGameByGameID($gameID);
            
            $results = json_encode($results,JSON_NUMERIC_CHECK);
            ChromePhp::log($results);
            echo $results;
        } catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    }   else {
        ChromePhp::log("You are requesting the game " . filter_input(INPUT_GET, 'gameID'));
    }
}

function doDelete() {
    if (!filter_has_var(INPUT_GET, 'gameID')) {
        ChromePhp::log("You can not delete more than one game at a time.");
    } else {
        $gameID = filter_input(INPUT_GET, "gameID");

        $gameObj = new Game($gameID, 0, 0, "dummy", 0, 0);

        $g = new GameAccessor();
        $success = $g->deleteGame($gameObj);
        echo $success;
    }
}

function doPost() {
    $body = file_get_contents('php://input');
    $contents = json_decode($body, true);

    $gameObj = new Game($contents['gameID'], $contents['matchID'], $contents['gameNumber'], $contents['gameStateID'], $contents['score'], $contents['balls']);

    $g = new GameAccessor();
    $success = $g->addGame($gameObj);
    echo $success;
}

function doPut() {
    $body = file_get_contents('php://input');
    $contents = json_decode($body, true);

    $gameObj = new Game($contents['gameID'], $contents['matchID'], $contents['gameNumber'], $contents['gameStateID'], $contents['score'], strval($contents['balls']));

    $g = new GameAccessor();
    $success = $g->updateGame($gameObj);
    echo $success;
}
