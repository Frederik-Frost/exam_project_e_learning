<?php
session_start();
require_once(__DIR__.'/../globals.php');
$db = _db_connect();

try{
        $q = $db->prepare('SELECT topics.next_step FROM topics WHERE topics.topic_id = :id');
        $q->bindValue(':id', $_POST['id']);   
        $q->execute();
        $row = $q->fetch();
        if(!$row){_res(400, ['info' => 'Could not find topic', 'error' =>__LINE__]);}
        else{
            $step = $row['next_step'];
            $query = $db->prepare(
                'INSERT INTO user_topics (user_id, topic_id)
                SELECT users.user_id AS user_id,
                       topics.topic_id AS topic_id
                       
                FROM topics INNER JOIN users
                WHERE users.user_id = :user_id AND topics.step = :step'
            );
            $query->bindValue(':user_id', $_SESSION['user_id']);
            $query->bindValue(':step', $step);
            $query->execute();
            // $data = $query->fetchAll();
            // _res('200', $data);
            echo "unlocked new topic";
        }

    
} catch(PDOException $ex){
    _res('500', ['info' => 'System under maintainance', 'error' => __LINE__]);
}