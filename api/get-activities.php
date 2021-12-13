<?php
session_start();
require_once(__DIR__.'/../globals.php');
$db = _db_connect();

try{
    $query = $db->prepare(
        'SELECT *
        FROM activities
        WHERE topic_id= :id'
    );
    $query->bindValue(':id', $_POST['id']);
    $query->execute();
    $data = $query->fetchAll();
    _res('200', $data);
} catch(PDOException $ex){
    _res('500', ['info' => 'System under maintainance', 'error' => __LINE__]);
}