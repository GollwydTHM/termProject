<?php

require_once '../db/TeamAccessor.php';
require_once '../entity/Team.php';
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
    if (!filter_has_var(INPUT_GET, 'teamID')) {
        try {
            $t = new TeamAccessor();
            $results = $t->getTeams();
            $results = json_encode($results, JSON_NUMERIC_CHECK);
            echo $results;
        }
        catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    }
    else {
        $teamID = filter_input(INPUT_GET, 'teamID');
        try {
            $t = new TeamAccessor();
            $results = $t->getTeamByTeamID($teamID);
            $results = json_encode($results, JSON_NUMERIC_CHECK);
            echo $results;
        }
        catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    }
}

function doDelete() {
    if (!filter_has_var(INPUT_GET, 'teamID')) {
        ChromePhp::log("You can not delete more than one team at a time.");
    }
    else {
        $teamID = filter_input(INPUT_GET, "teamID");

        $teamObj = new Team($teamID, "dummyTeamName", 0);

        $t = new TeamAccessor();
        $success = $t->deleteTeam($teamObj);
        echo $success;
    }
}

function doPost() {
    $body = file_get_contents('php://input');
    $contents = json_decode($body, true);

    $teamObj = new Team($contents['teamID'], $contents['teamName'], $contents['earnings']);

    $t = new TeamAccessor();
    $success = $t->addTeam($teamObj);
    echo $success;
}

function doPut() {
    $body = file_get_contents('php://input');
    $contents = json_decode($body, true);

    $teamObj = new Team($contents['teamID'], $contents['teamName'], $contents['earnings']);

    $t = new TeamAccessor();
    $success = $t->updateTeam($teamObj);
    echo $success;
}