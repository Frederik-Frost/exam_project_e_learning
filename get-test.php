<?php
require_once __DIR__ .'/vendor/autoload.php';

// connect
$client = new MongoDB\Client("mongodb://localhost:27017");

//Select db
$collection = $client->e_learning->comments;

// $result = $collection->find();
// $result = $collection->find(array(), array('projection' => array('name' => 1, '_id' => 1)));

$result = $collection->find(
    ['topic_id' => '2']
);
foreach($result as $res){
    echo json_encode($res);
}
// echo json_encode($result) ;


// $res = json_encode($result, true);
// echo $res;

// foreach ($result as $res) {
//     echo $res["name"] . "\n";
//  }
// $query = $collection->insertOne([
//     'name' => 'test',
//     'comment' => 'Please work!',
//     'rating' => '5',
//     'description' => 'This is a test to see how it all works when you change the model in mongo.',
//     'topic_id' => '1'
// ]);

// $comment = $db->find();
// foreach ($comment as $c){
//     echo "<div>".$c['name']."</div>";
//     echo "<div>".$c['comment']."</div>";
// }
// echo $db;    
// phpinfo();