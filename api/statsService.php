<?php

require_once '../db/StatsAccessor.php';
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
     
    
    if (filter_has_var(INPUT_GET, 'teamID')) {
        try {
             
            $teamID = filter_input(INPUT_GET, "teamID");
            $t = new StatsAccessor();
             
            $results = $t->getMatchup($teamID);
            $results = json_encode($results, JSON_NUMERIC_CHECK);
            echo $results;
        }
        catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    }
    else {
        ChromePhp::log("You are requesting the match " . filter_input(INPUT_GET, 'teamID'));
    }
}


