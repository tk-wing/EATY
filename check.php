<?php

    //SESSIONの有効化
    session_start();

    //SESSIONデータの受け取り
    $first_name = htmlspecialchars($_SESSION['EATY']['first_name']);
    $last_name = htmlspecialchars($_SESSION['EATY']['last_name']);
    $email = htmlspecialchars($_SESSION['EATY']['email']);
    $password = htmlspecialchars($_SESSION['EATY']['password']);
    $user_type = $_SESSION['EATY']['user_type'];

    //user_typeの変換(表示用)
    if ($user_type == 1) {
      $type = '講師';
    } else {
      $type = '生徒';
    }

    //直接URLを参照した場合は、Signupに遷移
    if(!isset($_SESSION['EATY'])) {
        header('Location: signup.php');
        exit();
    }

    //データベースとの接続
    $dsn = 'mysql:dbname=eaty;host=localhost';
    $user = 'root';
    $password_db = '';
    $dbh = new PDO($dsn, $user, $password_db);
    $dbh->query('SET NAMES utf8');

    //確認が完了した場合
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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
    }

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <title>登録内容確認</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="css/stylesheet.css">
  <!-- BootstrapのCSS読み込み -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- BootstrapのJS読み込み -->
  <script src="js/bootstrap.min.js"></script>
  <!-- FontAwesome読み込み -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
</head>
<body>

  <header>
    <div class="text-center">
      <a href="#"><img src="img/eatylogo.png" width="100"></a>
    </div>
  </header>

  <div class="text-center container">

    <p class="title font-weight-bold">新規登録内容確認</p>


    <div class="check">
      <h3 class="text-success"><?=$type ?></h3>
      <p class="check_content"><?=$last_name . ' ' . $first_name ?></p>
      <p class="check_content"><?=$email ?></p>
      <p class="check_content">●●●●●●●●</p>
    </div>

    <form class="signup_form" method="POST" action="">

      <!-- Button -->
      <div class="form-group">
        <input type="hidden" name="first_name" value="$first_name">
        <input type="hidden" name="last_name" value="$last_name">
        <input type="hidden" name="email" value="$email">
        <input type="hidden" name="password" value="$password">
        <input type="hidden" name="user_type" value="user_type">
        <input type="button" value="戻る" class="check_btn btn btn-primary" style="width:100px;" onClick="history.back()">
        <input type="submit" value="登録" class="check_btn btn btn-primary" style="width:100px;">
      </div>

    </form>


  </div>

  <footer>
    <div class="sns text-center">
      <a href="" class="btn-facebook sns-btn"><i class="fab fa-facebook fa-2x"></i></a>
      <a href="" class="btn-twitter sns-btn"><i class="fab fa-twitter fa-2x"></i></a>
      <a href="" class="btn-instagram sns-btn"><i class="fab fa-instagram fa-2x"></i></a>
      <p>©ex chef</p>
    </div>
  </footer>


</body>
</html>