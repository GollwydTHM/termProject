<?php


include 'resetAccessor.php';
try {
//    $output = accessor::getData();
    
    $acc = new resetAccessor();
    $output = $acc->getQUALDatabaseStatement();
    $results = json_encode($output, JSON_NUMERIC_CHECK);
    echo $results;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}