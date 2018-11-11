<?php

    $dsn = 'mysql:dbname=eaty;host=localhost';
    $user = 'root';
    $password_db = '';
    $dbh = new PDO($dsn, $user, $password_db);
    $dbh->query('SET NAMES utf8');

    //確認が完了した場合

    //パスワードの暗号化
    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    //データベースへのデータ登録
    $sql = 'INSERT INTO `users` SET `user_type` = ?, `first_name` = ?, `last_name` = ?, `email` = ?, `password` = ?, `created` = NOW()';
    $stmt = $dbh->prepare($sql);
    $data = array($user_type, $first_name, $last_name, $email, $hash_password);
    $stmt->execute($data);



    //保持データの消去
    unset($_SESSION['EATY']);
    exit();


?>