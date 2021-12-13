<?php
require_once __DIR__ .'/../vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->e_learning->comments;

$result = $collection->find(
    ['topic_id' => $_POST['id']]
);
$data = [];
foreach($result as $res){
    $data[] = $res;
}
echo json_encode($data);
