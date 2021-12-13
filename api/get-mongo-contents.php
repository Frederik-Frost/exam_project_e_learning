<?php
// session_start();
// require_once(__DIR__.'/../globals.php');
// $client = _mongo_connect();
require_once __DIR__ .'/../vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->e_learning->activities;
// echo $_POST['id'];
$result = $collection->find(
    ['activity_id' => $_POST['id']]
);
foreach($result as $res){
    echo json_encode($res);
}