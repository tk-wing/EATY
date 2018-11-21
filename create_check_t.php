<?php 
       //SESSIONの有効化
    session_start();

    //データベースとの接続
    require('dbconnect.php');
    require('functions.php');

    //$_SESSIONの中にeatyが定義されてなければsing
    if (!isset($_SESSION['eaty'])) {
      header('Location: create_lesson.php');
    }




    v($_POST,'$_POST');
    v($_SESSION,'$SESSION');

    $day = $_SESSION['eaty']['day'];
    $daytime = $_SESSION['eaty']['daytime'];
    $station = $_SESSION['eaty']['station'];
    $fee = $_SESSION['eaty']['fee'];
    $requiretime = $_SESSION['eaty']['requiretime'];
    $category_id = $_SESSION['eaty']['category_id'];
    $menu = $_SESSION['eaty']['menu'];
    $capacity = $_SESSION['eaty']['capacity'];
    $basic = $_SESSION['eaty']['basic'];
    $lesson_name = $_SESSION['eaty']['lesson_name'];
    $menudetail =  $_SESSION['eaty']['menudetail'];
    $bring = $_SESSION['eaty']['bring'];
    $precaution = $_SESSION['eaty']['precaution'];
    //画像
    $img_1 = $_SESSION['eaty']['img_1'];
    $img_2 = $_SESSION['eaty']['img_2'];
    $img_3 = $_SESSION['eaty']['img_3'];
    $img_4 = $_SESSION['eaty']['img_4'];

      if (!empty($_POST)) {
        //DBへの入力
        $sql = 'INSERT INTO `lessons_t` SET `img_1`=?,`img_2`=?,`img_3`=?,`img_4`=?,`day`=?,`daytime`=?,`station`=?,`fee`=?,`requiretime`=?,`category_id`=?,`menu`=?,`capacity`=?,`basic`=?,`lesson_name`=?,`menudetail`=?,`bring`=?,`precaution`=?,`created`= NOW()';//`user_id`=?,
        $data =array($img_1,$img_2,$img_3,$img_4,$day,$daytime,$station,$fee,$requiretime,$category_id,$menu,$capacity,$basic,$lesson_name,$menudetail,$bring,$precaution);//$_SESSION['id']
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        unset($_SESSION['eaty']);//一度空に

        // header('Location: bkg.php');
        // exit();
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

  <!-- <form method="POST" action="" enctype="multipart/form-data"> -->
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
        </ul>
          <form method="POST" action="" enctype="multipart/form-data">
            <input type="submit" class="btn btn-primary" value="完了">
            <a href="create_lesson.php"><button type="button" class="btn btn-secondary">編集</button></a>
          </form>

    </div>
  </div>
  <!-- </form> -->
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