<?php
    session_start();
    require('dbconnect.php');
    require('functions.php');

    $lesson_id = $_GET['lesson_id'];

    // ユーザー情報を取得
    $sql='SELECT * FROM `users` WHERE `id`=?';
    $stmt = $dbh->prepare($sql);
    $data = array($_SESSION['EATY']['id']);
    $stmt->execute($data);

    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

    // キャンセルしたレッスンのステータスカラムにキャンセルと入れる。
    $cancel_sql='UPDATE `reservations` SET `status`=? WHERE `user_id`=? AND `lesson_id`=?';
    $cancel_stmt = $dbh->prepare($cancel_sql);
    $cancel_data = ['2', $signin_user['id'], $lesson_id];
    $cancel_stmt->execute($cancel_data);

    header('Location: top_s.php');
    exit();


 ?>