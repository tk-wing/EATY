<?php
    //SESSIONの有効化
    session_start();
    require('dbconnect.php');
    require('functions.php');

    $lesson_id = $_GET['lesson_id'];
    $user_type = '';

    if (isset($_SESSION['EATY'])) {
        $user_id = $_SESSION['EATY']['id'];
        $user_type = $_SESSION['EATY']['user_type'];
    }

    // レッスン情報を取得
    $lesson_sql='SELECT * FROM `lessons_t` WHERE `id`=?';
    $lesson_stmt = $dbh->prepare($lesson_sql);
    $lesson_sql_data = [$lesson_id];
    $lesson_stmt->execute($lesson_sql_data);
    $lesson = $lesson_stmt->fetch(PDO::FETCH_ASSOC);

    // 講師のユーザー・プロフィール情報を取得
    $sql='SELECT `u`.`first_name`, `u`.`last_name`, `p`.* FROM `users` AS `u` INNER JOIN `profiles_t` AS `p` ON `u`.`id` = `p`.`user_id` WHERE `u`.`id`=?';
    $stmt = $dbh->prepare($sql);
    $data = [$lesson['user_id']];
    $stmt->execute($data);
    $teacher = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($teacher['nickname'] == '') {
        $name = $teacher['last_name'].'　'.$teacher['first_name'];
    }else{
        $name = $teacher['nickname'];
    }

    // 予約数を確認する
    $number_reservation_sql='SELECT count(*) AS `number_reservation` FROM `reservations` WHERE `lesson_id`=? AND `status`=?';
    $number_reservation_stmt = $dbh->prepare($number_reservation_sql);
    $number_reservation_sql_data = [$lesson_id, '1'];
    $number_reservation_stmt->execute($number_reservation_sql_data);

    $number_reservation = $number_reservation_stmt->fetch(PDO::FETCH_ASSOC);


    if ($number_reservation['number_reservation'] == $lesson['capacity']) {
        $lesson['status'] = '満席';
    }else{
        $lesson['count'] = $lesson['capacity'] - $number_reservation['number_reservation'];
    }


    if($user_type == '2'){
    // 生徒がレッスンを予約済みかを確認する。
    $reservation_sql='SELECT * FROM `reservations` WHERE `user_id`=? AND `lesson_id`=?';
    $reservation_stmt = $dbh->prepare($reservation_sql);
    $reservation_sql_data = [$user_id,$lesson_id];
    $reservation_stmt->execute($reservation_sql_data);
    $reservation = $reservation_stmt->fetch(PDO::FETCH_ASSOC);

    // 生徒がお気入りへ登録済みかを確認
    $favorite_flag_sql = "SELECT * FROM `like_lessons` WHERE `user_id` = ? AND `lesson_id` = ?";
    $favorite_flag_data = [$user_id, $lesson_id];
    $favorite_flag_stmt = $dbh->prepare($favorite_flag_sql);
    $favorite_flag_stmt->execute($favorite_flag_data);
    $is_favorite = $favorite_flag_stmt->fetch(PDO::FETCH_ASSOC);
  }



?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>レッスン詳細</title>
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
      <a href='#' data-toggle="modal" data-target="#demoNormalModal"><img src="img/eatylogo.png" width="100"></a>
    </div>
  </header>

  <div class="row">
    <div class="col-8">
      <div class="lesson_content text-center">
        <div class="blog-inner-prof text-center">
          <h3><?php echo $lesson['lesson_name'] ?></h3>
          <?php if (isset($lesson['count'])): ?>
            <p style="color: blue;">予約可(残り<?php echo $lesson['count'] ?>席)</p>
          <?php else: ?>
            <p style="color: red;">予約不可(このレッスンは満席です。)</p>
          <?php endif ?>

          <?php if ($lesson['img_1']): ?>
            <img class="lesson_img" src="users_lesson_img/<?php echo $lesson['img_1'] ?>" style="width:300px;height:200px;">
          <?php endif ?>

          <?php if ($lesson['img_2']): ?>
            <img class="lesson_img" src="users_lesson_img/<?php echo $lesson['img_2'] ?>" style="width:300px;height:200px;"><br>
          <?php endif ?>

          <?php if ($lesson['img_3']): ?>
            <img class="lesson_img" src="users_lesson_img/<?php echo $lesson['img_3'] ?>" style="width:300px;height:200px;">
          <?php endif ?>

          <?php if ($lesson['img_4']): ?>
            <img class="lesson_img" src="users_lesson_img/<?php echo $lesson['img_4'] ?>" style="width:300px;height:200px;">
          <?php endif ?>


          <div class="row contents">
              <div class="col-md-4">
                <span><i class="far fa-calendar-alt fa-2x icon"></i>日時</span><br>
                <span><?php echo date('m月d日',  strtotime($lesson['day'])) ?></span><br>
                <span><?php echo date('H時i分', strtotime($lesson['daytime'])) ?></span>
                <span></span>
              </div>
              <div class="col-md-4">
                <span><i class="fas fa-train fa-2x icon"></i>最寄り駅</span><br>
                <span><?php echo $lesson['station'] ?></span>
              </div>
              <div class="col-md-4">
                <span><i class="fas fa-yen-sign fa-2x icon"></i>料金</span><br>
                <span><?php echo $lesson['fee'] ?>円</span>
              </div>
          </div>

          <div class="row content_border">
            <div class="col-md-6" style="border-right: 1px solid #ccc;">
              <span>メニュー数</span>
              <span>&emsp;</span>
              <span><?php echo $lesson['menu'] ?></span>
            </div>
            <div class="col-md-6">
              <span>所要時間</span>
              <span>&emsp;</span>
              <span><?php echo $lesson['requiretime'] ?></span>
            </div>
          </div>

          <div>
            <ul>
              <li>メニュー内容</li>
              <li>メニュー内容</li>
              <li>メニュー内容</li>
              <li>メニュー内容</li>
              <li>メニュー内容</li>
              <li>メニュー内容</li>
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
                  <p><?php echo $lesson['bring'] ?></p>
                </div>
              </li>
              <li class="lesson-list-item">
                <h3>注意事項</h3>
                <span>+</span>
                <div class="inner">
                  <p><?php echo $lesson['precaution'] ?></p>
                </div>
              </li>
            </ul>

            <div>
              <?php if ($user_type == '1'): ?>
                <a href="bkg_edit_t.php?lesson_id=<?php echo $lesson_id ?>"><button type="button" class="btn btn-primary">編集する</button></a><br>
              <?php endif ?>
              <?php if ($user_type == '2'): ?>
                <?php if ($reservation == FALSE): ?>
                  <a href="bkg.php?lesson_id=<?php echo $lesson_id ?>"><button type="button" class="btn btn-primary">予約する</button></a><br>
                  <?php elseif ($reservation['status'] == '2'): ?>
                    <p style="color: red">キャンセル済みのレッスンです！</p>
                      <?php if (isset($lesson['count'])): ?>
                        <a href="bkg.php?lesson_id=<?php echo $lesson_id ?>"><button type="button" class="btn btn-primary">再予約する</button></a><br>
                      <?php endif ?>
                <?php else: ?>
                  <p style="color: red">予約済みのレッスンです！</p>
                <?php endif ?>
                <!-- <button type="button" class="btn btn-secondary"><i class="fas fa-heart" style="color: #F76AC0"></i></button> -->
                <span hidden id="user_id"><?php echo $user_id ?></span>
                <span hidden id="lesson_id"><?php echo $lesson_id  ?></span>
                <?php if ($is_favorite == FALSE): ?>
                  <button type="button" id="favorite" class="btn btn-secondary"><i class="fas fa-star"></i></button>
                <?php else: ?>
                  <button type="button" id="unfavorite" class="btn btn-warning"><i class="fas fa-star"></i></button>
                <?php endif ?>
              <?php endif ?>
            </div>

        </div>
      </div>
    </div>

  <div class="col-4">
    <div class="tercher_info blog-inner-prof text-center">
      <?php if ($teacher['img_name'] == ''): ?>
        <img class="img-responsive rounded-circle" src="img/profile_img_defult.png" alt="Blog" style="width:140px;height:140px;"><br>
      <?php else: ?>
        <img class="img-responsive rounded-circle" src="user_profile_img/<?php echo $teacher['img_name'] ?>" alt="Blog" style="width:140px;height:140px;">
      <?php endif ?>
      <p>講師名：<?php echo $name ?></p>
      <?php if ($user_type == '2'): ?>
        <a href="profile_t.php?teacher_id=<?php echo $teacher['user_id'] ?>"><button type="button" class="btn btn-primary">この講師のページへ行く</button></a><br>
      <?php endif ?>
    </div>
  </div>

  <!-- メニュー -->
  <div class="modal fade" id="demoNormalModal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-body text-center">
                  <p>メニュー</p>
              </div>
              <div class="modal-footer text-center" style="display: inline-block;">
                  <?php if ($user_type == '1'): ?>
                    <a href="top_t.php"><button type="button" class="btn btn-primary">マイページへ</button></a>
                  <?php elseif ($user_type == '2'): ?>
                    <a href="top_s.php"><button type="button" class="btn btn-primary">マイページへ</button></a>
                    <a href="serch_s.php"><button type="button" class="btn btn-primary">レッスン検索</button></a>
                  <?php endif ?>
                  <a href="signout.php"><button type="button" class="btn btn-danger">ログアウト</button></a>
              </div>
          </div>
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

  <script src="js/app.js"></script>
</body>

  </html>