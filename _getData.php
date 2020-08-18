<?php

include "gitHubRepo.php";
include "dbHandler.php";

$api = new gitHubRepo();
if(!$api->getReposData()) {
    die("getReposData failed");
}

// if we are here, we received repo data
$pdo = new dbHandler();
//echo $pdo->getDbh()->query("SELECT 'abcde'")->fetchColumn() . "\n";

// save  the data, inject the db handler
$api->saveData($pdo->getDbh());

// retrieve the data and return in json encoded array
echo json_encode(array('data' => $api->getData($pdo->getDbh())));

die(); // make sure we end...
