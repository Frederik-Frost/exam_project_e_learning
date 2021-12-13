<?php
session_start();
require_once(__DIR__.'/../globals.php');
$db = _db_connect();

try{
    $query = $db->prepare(
        'SELECT topics.*
        FROM topics
        INNER JOIN user_topics
        ON topics.topic_id = user_topics.topic_id
        WHERE user_topics.user_id = :id'
    );
    $query->bindValue(':id', $_SESSION['user_id']);
    $query->execute();
    $data = $query->fetchAll();
    _res('200', $data);
} catch(PDOException $ex){
    _res('500', ['info' => 'System under maintainance', 'error' => __LINE__]);
}