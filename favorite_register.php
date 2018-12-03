<?php
    session_start();
    require('dbconnect.php');
    require('functions.php');

    $user_id = $_POST["user_id"];
    $lesson_id = $_POST["lesson_id"];

    if (isset($_POST['is_favorited'])) {
        $sql = "INSERT INTO `like_lessons` (`user_id`, `lesson_id`) VALUES (?, ?);";
    }else{
        $sql = "DELETE FROM `like_lessons` WHERE `user_id`=? AND `lesson_id`=?";
    }

    $data = [$user_id, $lesson_id];
    $stmt = $dbh->prepare($sql);
    $res = $stmt->execute($data);

    echo json_encode($res);



 ?>