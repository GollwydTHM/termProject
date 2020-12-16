<?php

require_once '../db/StatsAccessor.php';
require_once '../entity/Stats.php';
require_once '../utils/ChromePhp.php';

$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
if ($method === "GET") {
    ChromePhp::log("Get method");
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
     
                ChromePhp::log("inside do get");

    if (!filter_has_var(INPUT_GET, 'teamID')) {
        try {
            ChromePhp::log("inside try 1st line");
            $t = new StatsAccessor();
             
            $results = $t->getMatchup();
            $results = json_encode($results, JSON_NUMERIC_CHECK);
            echo $results;
                        ChromePhp::log("all done!");

        }
        catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    }
    else {
        ChromePhp::log("You are requesting the match " . filter_input(INPUT_GET, 'teamID'));
    }
}
//function doPut(){
//    $body = file_get_contents('php://input');
//    $contents = json_decode($body, true);
//
//    $statsObj = new Team($contents['matchID'], $contents['roundID'], $contents['matchgroup'], $contents['teamID'], $contents['score'], $contents['ranking']);
//
//    $t = new StatsAccessor();
//    $success = $t->updateScore($statsObj);
//    echo $success;
//}


