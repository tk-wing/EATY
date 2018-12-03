<?php
    session_start();
    require('dbconnect.php');
    require('functions.php');

    $favorite_id = $_GET['favorite_id'];

    $sql ='DELETE FROM `like_lessons` WHERE `id`=?';
    $stmt = $dbh->prepare($sql);
    $data = [$favorite_id];
    $stmt->execute($data);

    header('Location: favorites.php');
    exit();


?>