<?php

require_once '../db/MatchupAccessor.php';
require_once '../entity/Matchup.php';
require_once '../utils/ChromePhp.php';

$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
if ($method === "GET") {
    doGet();
}
else if ($method === "POST") {
    doPost();
}
else if ($method === "DELETE") {
    doDelete();
}
else if ($method === "PUT") {
    doPut();
}

function doGet() {
    if (!filter_has_var(INPUT_GET, 'matchID')) {
        try {
            $t = new MatchupAccessor();
            $results = $t->getMatchup();
            $results = json_encode($results, JSON_NUMERIC_CHECK);
            echo $results;
        }
        catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    }
    else {
        ChromePhp::log("You are requesting the match " . filter_input(INPUT_GET, 'matchID'));
    }
}

function doDelete() {
    if (!filter_has_var(INPUT_GET, 'matchID')) {
        ChromePhp::log("You can not delete more than one match at a time.");
    }
    else {
        $matchID = filter_input(INPUT_GET, "matchID");

        $matchupObj = new Matchup($matchID, "Dummy", 0, 0, 0, 0);

        $t = new MatchupAccessor();
        $success = $t->deleteMatch($matchupObj);
        echo $success;
    }
}

function doPost() {
    $body = file_get_contents('php://input');
    $contents = json_decode($body, true);

    $matchupObj = new Matchup($contents['matchID'], $contents['roundID'], $contents['matchgroup'], $contents['teamID'], $contents['score'], $contents['ranking']);

    $t = new MatchupAccessor();
    $success = $t->addMatch($matchupObj);
    echo $success;
}

function doPut() {
    $body = file_get_contents('php://input');
    $contents = json_decode($body, true);

    $matchupObj = new Matchup($contents['matchID'], $contents['roundID'], $contents['matchgroup'], $contents['teamID'], $contents['score'], $contents['ranking']);

    $t = new MatchupAccessor();
    $success = $t->updateMatch($matchupObj);
    echo $success;
}
