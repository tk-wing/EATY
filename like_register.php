<?php
    session_start();
    require('dbconnect.php');
    require('functions.php');

    $user_id = $_POST["user_id"];
    $teacher_id = $_POST["teacher_id"];

    if (isset($_POST['is_liked'])) {
        $sql = "INSERT INTO `likes` (`instructor_id`, `student_id`) VALUES (?, ?);";
    }else{
        $sql = "DELETE FROM `likes` WHERE `instructor_id`=? AND `student_id`=?";
    }

    $data = [$teacher_id, $user_id];
    $stmt = $dbh->prepare($sql);
    $res = $stmt->execute($data);

    echo json_encode($res);



 ?>