<?php

require_once '../db/StatsAccessor.php';
require_once '../entity/Stats.php';
require_once '../entity/Pay.php';

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
      
    if (filter_has_var(INPUT_GET, 'all')) {
        try { 
            $t = new StatsAccessor();  
            $results = $t->getMatchup();
            $results = json_encode($results, JSON_NUMERIC_CHECK);
            echo $results; 

        }
        catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    } 
    else if (filter_has_var(INPUT_GET, 'ranks')) {
        try { 
            $t = new StatsAccessor(); 
            $results = $t->getTopRank(); 
            $results = json_encode($results, JSON_NUMERIC_CHECK);
            echo $results; 

        }
        catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    } 
    else if (filter_has_var(INPUT_GET, 'games')){
        $teamID = filter_input(INPUT_GET, 'games');
        try { 
            ChromePhp::log($teamID . "inside");
            $t = new StatsAccessor();
            $results = $t->getGamesByTeamID($teamID);
            $results = json_encode($results,JSON_NUMERIC_CHECK);
            echo $results;
        } catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    }
}
function doPut() {
    $body = file_get_contents('php://input');
    $contents = json_decode($body, true);

    $payObj = new Pay($contents['teamID']);
     
    $t = new StatsAccessor();
    $success = $t->updatePay($payObj);
    echo $success;
}


