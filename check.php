<?php

    //SESSIONの有効化
    session_start();

    //SESSIONデータの受け取り
    $first_name = htmlspecialchars($_SESSION['EATY']['first_name']);
    $last_name = htmlspecialchars($_SESSION['EATY']['last_name']);
    $email = htmlspecialchars($_SESSION['EATY']['email']);
    $password = htmlspecialchars($_SESSION['EATY']['password']);
    $user_type = $_SESSION['EATY']['user_type'];

    $modal_display_style = 'display:none;';
    $modal_display_class = 'fade';

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

        if ($user_type==1) {
          $modal_display_style_t = 'display:block;';
          $modal_display_class_t = 'show';
        } elseif ($user_type ==2) {
          $modal_display_style_s = 'display:block;';
          $modal_display_class_s = 'show';
        }

        // 保持データの消去
        unset($_SESSION['EATY']);
        // exit();
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
      <p class="check_content"><?=$first_name . ' ' . $last_name ?></p>
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
        <input type="submit" value="登録" class="check_btn btn btn-primary" id="js-post" style="width:100px;">
      </div>

      <!-- 講師モーダル -->
      <div class="modal <?php echo $modal_display_class_t; ?>" id="demoNormalModal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true" style="<?php echo $modal_display_style_t?>">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-body">
                      <p>ご登録ありがとうございました！</p>
                      <p>次はプロフィール作成です。</p>
                  </div>
                  <div class="modal-footer" style="display: inline-block;">
                      <a href="edit_prof_t.php"><button type="button" class="btn btn-primary">講師プロフィール作成へ</button></a>
                  </div>
              </div>
          </div>
      </div>

      <!-- 生徒モーダル -->
      <div class="modal <?php echo $modal_display_class_s; ?>" id="demoNormalModal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true" style="<?php echo $modal_display_style_s?>">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-body">
                      <p>ご登録ありがとうございました！</p>
                  </div>
                  <div class="modal-footer" style="display: inline-block;">
                      <a href="card.html"><button type="button" class="btn btn-primary">マイページへ</button></a>
                      <a href="card.html"><button type="button" class="btn btn-primary">レッスン検索</button></a>
                  </div>
              </div>
          </div>
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


  <!-- jQuery、Popper.js、Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- <script src="assets/js/app.js"></script> -->


</body>
</html>