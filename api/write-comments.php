<?php
session_start();
require_once __DIR__ .'/../vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->e_learning->comments;

$query = $collection->insertOne([
    'topic_id' => $_POST['id'],
    'user_name' =>  $_SESSION['user_name']." ".$_SESSION['user_last_name'],
    'comment' => $_POST['comment']
]);

