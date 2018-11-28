<?php 
      //作成時のチェックPHP


       //SESSIONの有効化
    session_start();

    //データベースとの接続
    require('dbconnect.php');
    require('functions.php');

    //パーミッション
    $lesson_id = $_GET['lesson_id'];
    $user_type = '';
    //$_SESSIONの中にeatyが定義されてなければsing
    if (!isset($_SESSION['EATY'])) {
      header('Location: create_lesson.php');
      }

   

      // カテゴリー情報を取得
      $categories_sql='SELECT * FROM `categories`';
      $categories_stmt = $dbh->prepare($categories_sql);
      $categories_sql_data = [];
      $categories_stmt->execute($categories_sql_data);
      
    


    v($_POST,'$_POST');
    v($_SESSION,'$SESSION');

    //$SESSIONで持ってきた値を変数に変える
    if (!empty($_SESSION)) {
      //DBへの入力

    $user_id = $_SESSION['EATY']['user_id'];

    $day = $_SESSION['EATY']['day'];
    $daytime = $_SESSION['EATY']['daytime'];
    $station = $_SESSION['EATY']['station'];
    $fee = $_SESSION['EATY']['fee'];
    $requiretime = $_SESSION['EATY']['requiretime'];
    $category_id = $_SESSION['EATY']['category_id'];
    $menu = $_SESSION['EATY']['menu'];
    $capacity = $_SESSION['EATY']['capacity'];
    $basic = $_SESSION['EATY']['basic'];
    $lesson_name = $_SESSION['EATY']['lesson_name'];
    $menudetail =  $_SESSION['EATY']['menudetail'];
    $bring = $_SESSION['EATY']['bring'];
    $precaution = $_SESSION['EATY']['precaution'];
    //画像
    $img_1 = $_SESSION['EATY']['img_1'];
    $img_2 = $_SESSION['EATY']['img_2'];
    $img_3 = $_SESSION['EATY']['img_3'];
    $img_4 = $_SESSION['EATY']['img_4'];

        //完了ボタンを押した時に再読み込み
        if (!empty($_POST)) {
          //DBへの入力
          $sql = 'INSERT INTO `lessons_t` SET `user_id`=?,`img_1`=?,`img_2`=?,`img_3`=?,`img_4`=?,`day`=?,`daytime`=?,`station`=?,`fee`=?,`requiretime`=?,`category_id`=?,`menu`=?,`capacity`=?,`basic`=?,`lesson_name`=?,`menudetail`=?,`bring`=?,`precaution`=?,`created`= NOW()';
          $stmt = $dbh->prepare($sql);
          $data =array($user_id['id'],$img_1,$img_2,$img_3,$img_4,$day,$daytime,$station,$fee,$requiretime,$category_id,$menu,$capacity,$basic,$lesson_name,$menudetail,$bring,$precaution);

          $stmt->execute($data);

          // unset($_SESSION['EATY']);//一度空に
          header('Location: bkg_t.php');
          exit();
        }
        
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

<body>

  <header>
    <div class="text-center">
      <a href="#"><img src="img/eatylogo.png" width="100"></a>
    </div>
  </header>

<form method="POST" action="" enctype="multipart/form-data">
  <div class="create_check_content text-center">
    <div class="blog-inner-prof text-center">
      <h3>レッスン名:<?= h($lesson_name);?></h3>
      <img class="lesson_img" src="users_lesson_img/<?= h($img_1);?>" style="width:300px;height:200px;">
      <img class="lesson_img" src="users_lesson_img/<?= h($img_2);?>" style="width:300px;height:200px;"><br>
      <img class="lesson_img" src="users_lesson_img/<?= h($img_3);?>" style="width:300px;height:200px;">
      <img class="lesson_img" src="users_lesson_img/<?= h($img_4);?>" style="width:300px;height:200px;">

      <div class="row contents">
          <div class="col-md-4">
            <span><i class="far fa-calendar-alt fa-2x icon"></i>日時:<?= h($day);?></span>
          </div>
          <div class="col-md-4">
            <span><i class="fas fa-train fa-2x icon"></i>最寄り駅:<?= h($station);?></span>
          </div>
          <div class="col-md-4">
            <span><i class="fas fa-yen-sign fa-2x icon"></i>料金:<?= h($fee);?></span>
          </div>
      </div>

      <div class="row content_border">
        <div class="col-md-6" style="border-right: 1px solid #ccc;">
          <span>メニュー数:<?= h($menu);?></span>
        </div>
        <div class="col-md-6">
          <span>所要時間:<?= h($requiretime);?></span>
        </div>
      </div>

      <div>
        <ul>
          <li>メニュー内容</li>
          <li><?= h($menudetail);?></li>
          <li>カテゴリー:<?= h($category_id);?></li>
          
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
              <p><?= h($bring);?></p>
            </div>
          </li>
          <li class="lesson-list-item">
            <h3>注意事項</h3>
            <span>+</span>
            <div class="inner">
              <p><?= h($precaution);?></p>
            </div>
          </li>
          <input type="hidden" name="str_1" value="str2"/>
          <!-- １回目来た時にPOSTに値が入っていない為 -->
          <input type="hidden" name="user_id" value="user_id">


            <input type="submit" class="btn btn-primary" value="完了">
            <a href="javascript:history.back(create_lesson.php)"><button type="button" class="btn btn-secondary" >編集</button></a>



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