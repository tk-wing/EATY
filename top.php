<?php
    session_start();
    require('dbconnect.php');
    require('functions.php');

    $lessons = [];

    // レッスン情報を取得
    $lesson_sql='SELECT * FROM `lessons_t` ORDER BY `created` DESC LIMIT 0,3';
    $lesson_stmt = $dbh->prepare($lesson_sql);
    $lesson_data = [];
    $lesson_stmt->execute($lesson_data);


    while(1){
      $lesson = $lesson_stmt->fetch(PDO::FETCH_ASSOC);
      if ($lesson == FALSE) {
          break;
      }
      $lessons[] = $lesson;
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>ex chef</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="css/stylesheet_top.css">
  <!-- BootstrapのCSS読み込み -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- BootstrapのJS読み込み -->
  <script src="js/bootstrap.min.js"></script>
  <!-- FontAwesome読み込み -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
  <!-- Theme style  -->
  <link rel="stylesheet" href="css/style.css">
  <!-- Modernizr JS -->
  <script src="js/modernizr-2.6.2.min.js"></script>
  <!-- viewport meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>

  <!-- ヘッダー -->
<!--   <header>
    <div class="text-center">
      <a href="#"><img src="img/eatylogo.png" width="100"></a>
    </div>
  </header> -->

  <!-- TOP上部・３つのボタン・コンセプト -->
  <div class="top wrapper">
    <!-- TOP上部 -->
    <div class="container-flued" style="background-image: url(img/top2.jpg); height: 800px; background-size:cover;">
      <img class="mx-auto d-block"src="img/logo2.png" width="300">

      <a href="signup.php"><button type="button" class="mx-auto d-block btn-box my-btn-signup">新規登録</button></a>
    

    <!-- 3つのボタン -->
    <!-- <div class="row top-content"> <div class="container">
<a href="#" class="btn-box">PUSH ME</a>
</div>-->
      <div class="col text-center area aboutus">
        <a href="#aboutus"><button type="button" class="btn-box">about us</button></a>
      </div>
      <div class="col text-center area signin">
        <a href="signin.php"><button type="button" class="btn-box">ログイン</button></a>
      </div>
      <div class="col text-center area serch">
      <button class="btn-box">レッスン検索</button>
      </div>
    <!-- </div> -->
    </div>
    <!-- コンセプト -->
    <div class="concept" id="aboutus">
      <div class="text-center title">about us</div>
      <div class="container">
        <div class="text-center">
          <a class="circle">教えたいexchef</a>
          <a class="maltiply">×</a>
          <a class="circle">習いたいYOU</a>
          <div class="text-center description">Our web service is “ex chef” for connecting those who would like to work with professional skill of cooking and baking with those who would like to learn how to cook and bake.<br>“ex chef”とは、料理とベーキングの専門的なスキルを身につけた人と、料理とベーキングの方法を学びたい人とをつなぐためのサービスです。</div>
        </div>
      </div>
    </div>

  </div>


  <!-- レッスン紹介 -->
  <div class="middle wrapper">
    <div class="text-center title">レッスン紹介</div>
    <div class="row middle-content">
      <?php foreach ($lessons as $lesson): ?>
        
      <div class="col-md-4 text-center">
        <div class="row">
          <div class="col-md-6">
            <span><?php echo date('m月d日', strtotime($lesson['day'])) ?></span>
          </div>
          <div class="col-md-6">
            <span><?php echo $lesson['station'] ?></span>
          </div>
        </div>
        <div class="blog-inner">
          <img class="img-responsive" src="users_lesson_img/<?php echo $lesson['img_1'] ?>" alt="Blog" width="100%" style="height: 250px;">
          <div class="desc">
            <h3><a href="lesson.php?lesson_id=<?php echo $lesson['id']?>"><?php echo $lesson['lesson_name'] ?></a></h3>
            <p>¥<?php echo $lesson['fee'] ?>/1人</p>
            <p><a href="lesson.php?lesson_id=<?php echo $lesson['id']?>" class="btn btn-default with-arrow">レッスン詳細を見る<i class="icon-arrow-right"></i></a></p>
          </div>
        </div>
      </div>
      <?php endforeach ?>

    </div>
    <div class="text-center"><button type="button" class="btn btn-default">more</button></div>
  </div>


  <!-- つくれぽ -->
  <div class="low wrapper">
    <div class="text-center title">つくれぽ</div>
    <div class="row low-content">
      <div class="col-md-3 text-center">
        <span>2018/12/31</span>
        <div class="blog-inner">
          <img class="img-responsive" src="http://placehold.jp/250x150.png" alt="Blog">
          <div class="desc">
            <div class="row">
              <div class="col-md-3">
                <img src="https://placehold.jp/80x80.png" style="width:80px;height:80px;border-radius: 50%;">
              </div>
              <div class="col-md-9">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
              </div>
            </div>
            <p><a href="#" class="btn btn-default with-arrow">このレッスンの講師プロフィールへ<i class="icon-arrow-right"></i></a></p>
          </div>
        </div>
      </div>
      <div class="col-md-3 text-center">
        <span>2018/12/31</span>
        <div class="blog-inner">
          <img class="img-responsive" src="http://placehold.jp/250x150.png" alt="Blog">
          <div class="desc">
            <div class="row">
              <div class="col-md-3">
                <img src="https://placehold.jp/80x80.png" style="width:80px;height:80px;border-radius: 50%;">
              </div>
              <div class="col-md-9">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
              </div>
            </div>
            <p><a href="#" class="btn btn-default with-arrow">このレッスンの講師プロフィールへ<i class="icon-arrow-right"></i></a></p>
          </div>
        </div>
      </div>
      <div class="col-md-3 text-center">
        <span>2018/12/31</span>
        <div class="blog-inner">
          <img class="img-responsive" src="http://placehold.jp/250x150.png" alt="Blog">
          <div class="desc">
            <div class="row">
              <div class="col-md-3">
                <img src="https://placehold.jp/80x80.png" style="width:80px;height:80px;border-radius: 50%;">
              </div>
              <div class="col-md-9">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
              </div>
            </div>
            <p><a href="#" class="btn btn-default with-arrow">このレッスンの講師プロフィールへ<i class="icon-arrow-right"></i></a></p>
          </div>
        </div>
      </div>
      <div class="col-md-3 text-center">
        <span>2018/12/31</span>
        <div class="blog-inner">
          <img class="img-responsive" src="http://placehold.jp/250x150.png" alt="Blog">
          <div class="desc">
            <div class="row">
              <div class="col-md-3">
                <img src="https://placehold.jp/80x80.png" style="width:80px;height:80px;border-radius: 50%;">
              </div>
              <div class="col-md-9">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
              </div>
            </div>
            <p><a href="#" class="btn btn-default with-arrow" >このレッスンの講師プロフィールへ<i class="icon-arrow-right"></i></a></p>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center"><a href="signup.php"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#demoNormalModal1">会員登録してみる<br>(無料)</button></a></div>
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