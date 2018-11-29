<?php

    //SESSIONの有効化
    session_start();
    require('dbconnect.php');

    //ログイン情報を受け取った場合
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $user_type = $_POST['user_type'];

        //メールアドレスまたはパスワードが入力されていない場合
        if ($email == '' || $password == '') {
            $failed_msg = '入力または選択した情報が正しくありません';
            $validations['signin'] = '失敗';

        //メールアドレスとパスワードが入力されている場合
        } elseif($email != '' && $password != '') {

            //データベースのデータの読み込み
            $sql = 'SELECT * FROM `users` WHERE `email` = ?';
            $data = array($email);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            //データベースのメールアドレスと一致しない場合
            if ($user==false) {
                $failed_msg = '入力または選択した情報が正しくありません';
                $validations['signin'] = '失敗';

            //データベースのメールアドレスと一致する場合
            } else {

                //データベースのuser_typeとパスワードと一致する場合
                $verify = password_verify($password, $user['password']);

                if ($verify==true && $user_type == $user['user_type']) {
                    $_SESSION['EATY']['id'] = $user['id'];
                    $_SESSION['EATY']['user_type'] = $user['user_type'];

                    //講師と生徒のリンク先の条件分岐
                    if ($user_type == 1) {
                        header('Location: top_t.php');
                        exit();
                    } elseif($user_type == 2) {
                        header('Location: top_s.php');
                        exit();
                    }

                //データベースのパスワードと一致しない場合
                } else {
                    $failed_msg = '入力または選択した情報が正しくありません';
                    $validations['signin'] = '失敗';
                }
            }
        }

    //初期値の設定
    } else {
        $email = '';
        $password = '';
    }

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <title>サインイン</title>
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
    <p class="title font-weight-bold">ログイン</p>


    <form class="signup_form" method="POST" action="">

    <!-- エラーメッセージの表示 -->
    <?php if(isset($validations['signin'])): ?>
      <p style="color:red;"><?=$failed_msg ?></p>
    <?php endif; ?>

      <!-- Text input-->
      <div class="form-group">
        <input name="email" type="text" placeholder="メールアドレス" class="form-control" style="width:200px; display: inline-block;">
      </div>

      <!-- Password input-->
      <div class="form-group">
        <input name="password" type="password" placeholder="パスワード" class="form-control" style="width:200px; display: inline-block;">
      </div>

      <div class="form-group">
        <input type="radio" name="user_type" id="type-0" value=1 checked="checked">
        講師
        <input type="radio" name="user_type" id="type-1" value=2>
        生徒
      </div>

      <!-- Button -->
      <div class="form-group">
        <input type="submit" value="ログインする" class="signin_btn btn btn-primary" style="width: 180px;"><br>
        <a href="#"><button type="button" class="signin_btn btn btn-primary" style="width: 180px;">パスワードお忘れの方</button></a><br>
        <a href="signup.php"><button type="button" class="signin_btn btn btn-primary">アカウントをお持ちでない方は新規登録</button></a>
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