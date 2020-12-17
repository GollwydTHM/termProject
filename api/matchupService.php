<?php

require_once '../db/MatchupAccessor.php';
require_once '../entity/Matchup.php';
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
    ChromePhp::log("enter doGet");
    if (filter_has_var(INPUT_GET, 'roundID') && filter_has_var(INPUT_GET, 'matchGroup')) {
        ChromePhp::log("if");
        try {
            $round = filter_input(INPUT_GET, "roundID");
            $match = filter_input(INPUT_GET, "matchGroup");
            ChromePhp::log($round);
            ChromePhp::log("Match group: " . $match);
            $t = new MatchupAccessor();
            $results = $t->getMatchupByRoundIDAndMatchGroup($round, $match);
            $results = json_encode($results, JSON_NUMERIC_CHECK);
            echo $results;
        } catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    } else if (filter_has_var(INPUT_GET, 'roundID')) {
        ChromePhp::log("if else 1");
        try {
            $round = filter_input(INPUT_GET, "roundID");
            $t = new MatchupAccessor();
            $results = $t->getMatchupByRoundID($round);
            $results = json_encode($results, JSON_NUMERIC_CHECK);
            //ChromePhp::log($results);

            echo $results;
        } catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    } else if (filter_has_var(INPUT_GET, 'qualTournament')) { //////////////////////////////////////////////////////////////////////////////////////////////////////
        try {
            $t = new MatchupAccessor();
            $results = $t->getTournamentQual();
            $results = json_encode($results, JSON_NUMERIC_CHECK);
            echo $results;
        } catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    } else if (filter_has_var(INPUT_GET, 'matchTree')) {
        try {
            $t = new MatchupAccessor();
            $results = $t->getTournamentTree();
            $results = json_encode($results, JSON_NUMERIC_CHECK);
            echo $results;
        } catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    } else if (!filter_has_var(INPUT_GET, 'matchID')) {
        ChromePhp::log("else if 2");
        try {
            $t = new MatchupAccessor();
            $results = $t->getMatchup();
            $results = json_encode($results, JSON_NUMERIC_CHECK);
            echo $results;
        } catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    } else {
        ChromePhp::log("You are requesting the match " . filter_input(INPUT_GET, 'matchID'));
    }
}

function doDelete() {
    if (!filter_has_var(INPUT_GET, 'matchID')) {
        ChromePhp::log("You can not delete more than one match at a time.");
    } else {
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
    ChromePhp::log("enter doPut");
    if (filter_has_var(INPUT_GET, 'Team')) {
        ChromePhp::log("entered team if ");

        $body = file_get_contents('php://input');
        $contents = json_decode($body, true);
        $matchupObj = new Matchup($contents['matchID'], "sda", 0, $contents['teamID'], 0, 0);

        $t = new MatchupAccessor();
        $success = $t->updateTeam($matchupObj);
        ChromePhp::log($success);

        echo $success;
    } else if (filter_has_var(INPUT_GET, 'ScoreMatchID')) {
        ChromePhp::log("entered else if ");
        $ScoreMatchID = filter_input(INPUT_GET, "ScoreMatchID");
        //ChromePhp::log($ScoreMatchID);

        $t = new MatchupAccessor();
        $success = $t->updateScore($ScoreMatchID);
        echo $success;
    } else if (filter_has_var(INPUT_GET, 'matchID')) {
        ChromePhp::log("entered else if2");
        $body = file_get_contents('php://input');
        $contents = json_decode($body, true);

        $matchupObj = new Matchup($contents['matchID'], $contents['roundID'], $contents['matchgroup'], $contents['teamID'], $contents['score'], $contents['ranking']);

        $t = new MatchupAccessor();
        $success = $t->updateMatch($matchupObj);
        echo $success;
    }
    else {
        $body = file_get_contents('php://input');
        $contents = json_decode($body, true);
        ChromePhp::log($contents);
        $matchupObj = new Matchup($contents['matchID'], "sda", 0, $contents['teamID'], 0, 0);
        ChromePhp::log($matchupObj);
        ChromePhp::log("entered2");

        $t = new MatchupAccessor();
        $success = $t->updateTeam($matchupObj);
        ChromePhp::log($success);

        echo $success;
    }
}
