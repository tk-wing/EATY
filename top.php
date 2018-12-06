<?php
    session_start();
    require('dbconnect.php');
    require('functions.php');

    $lessons = [];

    // レッスン情報を取得
    $lesson_sql='SELECT * FROM `lessons_t` LIMIT 0,3';
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

    $reports = [];
    // つくれぽを取得
    $report_sql='SELECT * FROM `reports` ORDER BY `created` DESC LIMIT 0,4';
    $report_stmt = $dbh->prepare($report_sql);
    $report_sql_data = [];
    $report_stmt->execute($report_sql_data);

    while(1){
        $report = $report_stmt->fetch(PDO::FETCH_ASSOC);
        if ($report == FALSE) {
            break;
        }

        $student_sql='SELECT `u`.`id` AS `teacher_id`, `u`.`first_name`, `u`.`last_name`, `p`.`nickname`, `p`.`img_name` FROM `users` AS `u` LEFT JOIN `profiles_s` AS `p` ON `u`.`id` = `p`.`user_id` WHERE `u`.`id`=?';
        $student_stmt = $dbh->prepare($student_sql);
        $student_sql_data = [$report['user_id']];
        $student_stmt->execute($student_sql_data);
        $student = $student_stmt->fetch(PDO::FETCH_ASSOC);

        if ($student['nickname'] == '') {
            $report['name'] = $student['last_name'] . '　' . $student['first_name'];
        }else{
            $report['name'] = $student['nickname'];
        }

        $report['profile_img'] = $student['img_name'];

        $reports[] = $report;
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
      <img class="mx-auto d-block" src="img/logo2.png" width="300" style="padding: 15px;">
      <div class="col text-center area signup">
      <a href="signup.php"><button type="button" class="btn-box">新規登録</button></a>
      </div>
    

    <!-- 3つのボタン -->
      <div class="col text-center area aboutus">
        <a href="#aboutus"><button type="button" class="btn-box">about us</button></a>
      </div>
      <div class="col text-center area signin">
        <a href="signin.php"><button type="button" class="btn-box">ログイン</button></a>
      </div>
      <div class="col text-center area serch">
      <a href="serch_s.php"><button type="button" class="btn-box">レッスン検索</button></a>
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
    <div class="text-center"><a href="serch_s.php"><button type="button" class="btn btn-default">more</button></a></div>
  </div>


  <!-- つくれぽ -->
  <div class="low wrapper">
    <div class="text-center title">つくれぽ</div>
    <div class="row low-content">
      <?php foreach ($reports as $report): ?>
        <div class="col-md-3 text-center">
          <span><?php echo date('Y年m月d日',  strtotime($report['created'])) ?></span>
          <div class="blog-inner">
            <img class="img-responsive" src="user_report_img/<?php echo $report['img_name'] ?>" alt="Blog" style="height: 150px;">
            <div class="desc">
              <div class="row">
                <div class="col-md-4">
                  <?php if ($report['profile_img'] == ''): ?>
                    <img src="img/profile_img_defult.png" style="width:80px;height:80px;border-radius: 50%;">
                  <?php else: ?>
                    <img src="user_profile_img/<?php echo $report['profile_img'] ?>" style="width:80px;height:80px;border-radius: 50%;">
                  <?php endif ?>
                  <p style="font-size: 15px;"><?php echo $report['name'] ?></p>
                </div>
                <div class="col-md-8 text-left">
                  <?php echo $report['feed'] ?>
                </div>
              </div>
              <p><a href="profile_t.php?teacher_id=<?php echo $report['tag_teacher'] ?>" class="btn btn-default with-arrow">このレッスンの講師プロフィールへ<i class="icon-arrow-right"></i></a></p>
            </div>
          </div>
        </div>
      <?php endforeach ?>


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