<?php
    session_start();//SESSIONスタートしてないと、エラーが出る

    //データベースとの接続
    require('dbconnect.php');
    require('functions.php');
    

    v($_POST,'$_POST');
    v($_SESSION,'$_SESSION');

    //$_SESSIONの中にEATYが定義されてなければcreate_lesson.phpへ
    if (!isset($_SESSION['EATY'])) {
      header('Location: create_lesson.php');
    }
        
        $day = $_SESSION['EATY']['day'];
        $daytime = $_SESSION['EATY']['daytime'];
        $place = $_SESSION['EATY']['place'];
        $fee = $_SESSION['EATY']['fee'];
        $requiretime = $_SESSION['EATY']['requiretime'];
        $category_id = $_SESSION['EATY']['category_id'];
        $menu = $_SESSION['EATY']['menu'];
        $capacity = $_SESSION['EATY']['capacity'];
        $basic = $_SESSION['EATY']['basic'];
        $lesson_name = $_SESSION['EATY']['lesson_name'];
        $menudetail = $_SESSION['EATY']['menudetail'];
        $bring = $_SESSION['EATY']['bring'];
        $precaution = $_SESSION['EATY']['precaution'];
        //画像
        $img_1 = $_SESSION['EATY']['img_1'];
        $img_2 = $_SESSION['EATY']['img_2'];
        $img_3 = $_SESSION['EATY']['img_3'];
        $img_4 = $_SESSION['EATY']['img_4'];

        if (!empty($_POST)) {
        $sql = 'INSERT INTO `lessons_t` SET `img_1`=?,`img_2`=?,`img_3`=?,`img_4`=?,`day`=?,`daytime`=?,`place`=?,`fee`=?,`requiretime`=?,`category_id`=?,`menu`=?,`capacity`=?,`basic`=?,`lesson_name`=?,`menudetail`=?,`bring`=?,`precaution`=?,`user_id`=?,`created`= NOW()';
        $data =array($img_1,$img_2,$img_3,$img_4,$day,$daytime,$place,$fee,$requiretime,$category_id,$menu,$capacity,$basic,$lesson_name,$menudetail,$bring,$precaution);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        unset($_SESSION['eaty']);

        header('Location: bkg_t.php');
        // exit();
        // }
        }
?>




<!DOCTYPE html>
<html lang="ja">
<head>
  <title>レッスン作成内容確認</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="css/stylesheet_t.css">
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
  <form class="signup_form" method="POST" action="" enctype="multipart/form-data">
    <!-- enctype=multipart/form-dataを加えた。何からのファイルを表示、また＄_FILEを使う為 -->

<body>

  <header>
    <div class="text-center">
      <a href="#"><img src="img/eatylogo.png" width="100"></a>
    </div>
  </header>

  <div class="create_check_content text-center">
    <div class="blog-inner-prof text-center">
      <h3>レッスン名:<?=h($lesson_name);?></h3>
      <img class="lesson_img" src="users_lesson_img/<?= h($img_1); ?>" style="width:300px;height:200px;">
      <img class="lesson_img" src="users_lesson_img/<?= h($img_2); ?>" style="width:300px;height:200px;"><br>
      <img class="lesson_img" src="users_lesson_img/<?= h($img_3); ?>" style="width:300px;height:200px;">
      <img class="lesson_img" src="users_lesson_img/<?= h($img_4); ?>" style="width:300px;height:200px;">

      <div class="row contents">
          <div class="col-md-4">
            <span><i class="far fa-calendar-alt fa-2x icon"></i>日付:<?=h($day);?>日時:<?=h($daytime);?></span>
          </div>
          <div class="col-md-4">
            <span><i class="fas fa-train fa-2x icon"></i>開催場所:<?=h($place);?></span>
          </div>
          <div class="col-md-4">
            <span><i class="fas fa-yen-sign fa-2x icon"></i>料金:<?=h($fee);?></span>
          </div>
      </div>

      <div class="row content_border">
        <div class="col-md-6" style="border-right: 1px solid #ccc;">
          <span>メニュー数:<?=h($menu);?></span>
        </div>
        <div class="col-md-6">
          <span>所要時間:<?=h($requiretime);?></span>
        </div>
      </div>

      <div>
        <ul>
          <li>メニュー内容</li>
          <li>カテゴリー:<?=h($category_id);?></li>
          <li>定員:<?=h($capacity);?></li>
          <li>最小遂行人数:<?=h($basic);?></li>
          <li>メニュー概要:<?=h($menudetail);?></li>
        </ul>
      </div>

      <div class="contents">
        <h4>レッスン詳細</h4>
      </div>

      <ul class="contents" id="lesson-list">
          <li class="lesson-list-item">
            <h3>持ち物</h3>
            <span>+</span>
            <div class="inner">
              <p><?=h($bring);?></p>
            </div>
          </li>
          <li class="lesson-list-item">
            <h3>注意事項</h3>
            <span>+</span>
            <div class="inner">
              <p><?=h($precaution);?></p>
            </div>
          </li>
        </ul>

        <form method="POST" action="">
          <input type="submit" class="btn btn-primary" value="完了">
          <a href="#"><button type="button" class="btn btn-secondary">編集</button></a>
        </form>

    </div>
  </div>
</form>
  <footer>
    <div class="sns text-center">
      <a href="" class="btn-facebook sns-btn"><i class="fab fa-facebook fa-2x"></i></a>
      <a href="" class="btn-twitter sns-btn"><i class="fab fa-twitter fa-2x"></i></a>
      <a href="" class="btn-instagram sns-btn"><i class="fab fa-instagram fa-2x"></i></a>
      <p>©ex chef</p>
    </div>
  </footer>

  <script src="js/app.js"></script>
</body>

  </html>