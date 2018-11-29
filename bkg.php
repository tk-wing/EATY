<?php
    session_start();
    require('dbconnect.php');
    require('functions.php');
    $lesson_id = $_GET['lesson_id'];
    $user_type = '';
    // $sql = 'SELECT * FROM `profiles_s` WHERE `user_id`=?';
    // $data = array($_SESSION['EATY']['id']);

    // var_dump($_SESSION['EATY']['id']);

    // $stmt = $dbh->prepare($sql);
    // $stmt->execute($data);
    // $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = 'SELECT * FROM `users` WHERE `id`=?';
    $data = array($_SESSION['EATY']['id']);

    var_dump($_SESSION['EATY']['id']);

    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = 'SELECT * FROM `lessons_t` WHERE `id`=?';
    $data = array($_SESSION['EATY']['id']);

    var_dump($_SESSION['EATY']['id']);

    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $id = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = 'SELECT * FROM `profiles_t` WHERE `user_id`=?';
    $data = array($_SESSION['EATY']['id']);

    var_dump($_SESSION['EATY']['id']);

    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $user_id = $stmt->fetch(PDO::FETCH_ASSOC);
 ?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <title>レッスン予約</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="css/stylesheet_s.css">
  <!-- BootstrapのCSS読み込み -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- BootstrapのJS読み込み -->
  <script src="js/bootstrap.min.js"></script>
  <!-- FontAwesome読み込み -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">

  <!-- Theme style  -->
  <link rel="stylesheet" href="css/style.css">

  <!-- Modernizr JS -->
  <script src="js/modernizr-2.6.2.min.js"></script>
  <!-- viewport meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

</head>

<body>
  <header>
    <div class="text-center">
      <a href="#"><img src="img/eatylogo.png" width="100"></a>
    </div>
  </header>

  <div class="bkg_content">

    <div class="blog-inner-prof text-center">
        <div>
          <h4 class="title_1"><?php echo $id['lesson_name']; ?></h4>
          <p class="title_1">日時: <?php echo date('Y/m/d', strtotime($id['day'])); ?><br><?php echo $id['daytime']; ?>～</p>
          <p class="title_1">料金: ¥<?php echo $id['fee']; ?>/一人</p>
          <p class="title_1">注意事項: <?php echo $id['precaution']; ?></p>
        </div>

        <div class="title_2">
          <div class="row">
            <div class="col-5 text-right">
              <span>お名前</span><br>
              <span><?php echo $signin_user['first_name']; ?><?php echo $signin_user['last_name']; ?></span>
            </div>
            <div class="col-2"></div>
            <div class="col-5 text-left">
              <span>メールアドレス</span>
              <p><?php echo $signin_user['email']; ?></p>
            </div>
          </div>
        </div>

        <form method="POST" action="">
          <div class="form-group title_1">
              <p><?php echo $user_id['nickname']; ?>さん(講師)へのメッセージ</p>
              <textarea class="form-control col-md-8" name="attention" style="height: 100px; display: inline-block;"></textarea>
          </div>

          <div class="form-group">
            <p>お支払い方法</p>
            <select id="pref" name="pref" class="form-control col-md-4" style="display: inline-block;">
              <option value="1">クレジットカード</option>
            </select>
          </div>

          <input type="submit" class="btn btn-primary mt-5" value="完了">
        </form>

        <div class="mt-5">
          <p>お支払いが確定したら、詳細の情報（講師の連絡先、会場の住所、地図等）をお送りします。</p>
       </div>

    </div>

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