<?php
    //SESSIONの有効化
    session_start();
    require('dbconnect.php');
    require('functions.php');

    // ユーザー情報を取得
    $sql='SELECT * FROM `users` WHERE `id`=?';
    $stmt = $dbh->prepare($sql);
    $data = array($_SESSION['EATY']['id']);
    $stmt->execute($data);

    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

    // pロフィール情報をを取得
    $profile_t_sql='SELECT * FROM `profiles_t` WHERE `user_id`=?';
    $profile_t_stmt = $dbh->prepare($profile_t_sql);
    $profile_t_sql_data = [$signin_user['id']];
    $profile_t_stmt->execute($profile_t_sql_data);
    $profile_t = $profile_t_stmt->fetch(PDO::FETCH_ASSOC);

    if($profile_t == FALSE){
        header('Location: edit_prof_t.php');
        exit();
    }

    // いいねされているか確認
    $like_flag_sql = "SELECT * FROM `likes` WHERE `instructor_id` = ?";
    $like_flag_data = [$signin_user['id']];
    $like_flag_stmt = $dbh->prepare($like_flag_sql);
    $like_flag_stmt->execute($like_flag_data);
    $profile_t['is_liked'] = $like_flag_stmt->fetch(PDO::FETCH_ASSOC);

    // いいねカウント
    $like_sql = "SELECT COUNT(*) AS `like_count` FROM likes WHERE `instructor_id`=?";
    $like_data = [$signin_user['id']];
    $like_stmt = $dbh->prepare($like_sql);
    $like_stmt->execute($like_data);
    $like_count_data = $like_stmt->fetch(PDO::FETCH_ASSOC);
    $profile_t['like_count'] = $like_count_data['like_count'];

    $lessons_t = [];

    // レッスン情報をを取得
    $lessons_t_sql='SELECT * FROM `lessons_t` WHERE `user_id`=? LIMIT 0,3';
    $lessons_t_stmt = $dbh->prepare($lessons_t_sql);
    $lessons_t_sql_data = [$signin_user['id']];
    $lessons_t_stmt->execute($lessons_t_sql_data);

    while (1) {
        $lesson_t = $lessons_t_stmt->fetch(PDO::FETCH_ASSOC);
        if ($lesson_t == FALSE) {
            break;
        }

        // 予約数を確認する
        $number_reservation_sql='SELECT count(*) AS `number_reservation` FROM `reservations` WHERE `lesson_id`=? AND `status`=?';
        $number_reservation_stmt = $dbh->prepare($number_reservation_sql);
        $number_reservation_sql_data = [$lesson_t['id'], '1'];
        $number_reservation_stmt->execute($number_reservation_sql_data);
        $number_reservation = $number_reservation_stmt->fetch(PDO::FETCH_ASSOC);

        if ($number_reservation['number_reservation'] == $lesson_t['capacity']) {
            $lesson_t['status'] = '満席';
        }else{
            $lesson_t['count'] = $lesson_t['capacity'] -$number_reservation['number_reservation'];
        }

        $lessons_t[] = $lesson_t;
    }

    $reports = [];

    // つくれぽを取得
    $report_sql='SELECT * FROM `reports` WHERE `tag_teacher`=? ORDER BY `created` DESC LIMIT 0,4';
    $report_stmt = $dbh->prepare($report_sql);
    $report_sql_data = [$signin_user['id']];
    $report_stmt->execute($report_sql_data);

    while(1){
        $report = $report_stmt->fetch(PDO::FETCH_ASSOC);
        if ($report == FALSE) {
            break;
        }

        $student_sql='SELECT `u`.`first_name`, `u`.`last_name`, `p`.`nickname`, `p`.`img_name` FROM `users` AS `u` LEFT JOIN `profiles_s` AS `p` ON `u`.`id` = `p`.`user_id` WHERE `u`.`id`=?';
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


    // 都道府県情報を取得
    $area_sql = 'SELECT * FROM `areas` WHERE `id` = ?';
    $area_data = array($profile_t['area_id']);
    $area_stmt = $dbh->prepare($area_sql);
    $area_stmt->execute($area_data);
    $area = $area_stmt->fetch(PDO::FETCH_ASSOC);

    // カテゴリー情報を取得
    $categories_sql='SELECT * FROM `categories`';
    $categories_stmt = $dbh->prepare($categories_sql);
    $categories_sql_data = [];
    $categories_stmt->execute($categories_sql_data);

    // ユーザーカテゴリー情報を取得
    $user_categories_sql='SELECT * FROM `user_categories` WHERE `user_id`=?';
    $user_categories_stmt = $dbh->prepare($user_categories_sql);
    $user_categories_sql_data = [$signin_user['id']];
    $user_categories_stmt->execute($user_categories_sql_data);

    while (1) {
        $user_categories = $user_categories_stmt->fetch(PDO::FETCH_ASSOC);
        if ($user_categories == FALSE) {
            break;
        }
        $user_categories_id[] = $user_categories['category_id'];
    }

    while (1) {
        $categories = $categories_stmt->fetch(PDO::FETCH_ASSOC);
        // v($categories, '$categories');
        if ($categories == FALSE) {
            break;
        }
        foreach ($user_categories_id as $user_category_id) {
            if ($user_category_id == $categories['id']) {
                $user_categories[] = $categories['category_name'];
            }
        }
    }

    // 登録必須項目(名前・ニックネーム以外)
    $city = $profile_t['city'];
    $station = $profile_t['station'];
    $past = $profile_t['past'];

    // $category_id = $profile_t['category'];
    $area = $area['name'];

    //ニックネームが登録されていない場合
    if (empty($profile_t['nickname'])) {
        $name = $signin_user['last_name'] . '　' . $signin_user['first_name'];
    } else {
        $name = $profile_t['nickname'];
    }

    // 以下登録任意項目
    $img_name = $profile_t['img_name'];
    $profile = $profile_t['profile'];

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>講師 TOP</title>
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
      <a data-toggle="modal" data-target="#demoNormalModal"><img src="img/eatylogo.png" width="100"></a>
    </div>
  </header>

  <!-- プロフィール -->
  <div class="top wrapper">
    <div class="text-center title">プロフィール</div>
    <div class="top-content">
      <div class="blog-inner-prof">
          <div class="row">
            <div class="col-md-3 text-center">
              <?php if($img_name==''): ?>
                <img class="img-responsive" src="img/profile_img_defult.png" alt="Blog" style="width:140px;height:140px;border-radius: 50%;">
              <?php else: ?>
                <img class="img-responsive" src="user_profile_img/<?php echo $img_name ?>" alt="Blog" style="width:140px;height:140px;border-radius: 50%;">
              <?php endif; ?>
              <p><?=$name ?></p>
              <p><?php echo $area.$city ?><br>
              <?php echo $station ?></p>
              <?php if ($profile_t['is_liked'] == FALSE): ?>
                <i class="far fa-heart"></i>&nbsp;<span><?php echo $profile_t['like_count'] ?></span>
              <?php else: ?>
                <i class="fas fa-heart" style="color: red;"></i>&nbsp;<span><?php echo $profile_t['like_count'] ?></span>
              <?php endif ?>
            </div>
            <div class="col-md-9">
              <div>
                ＜ジャンル＞<br>
                <?php for($i=0; $i<count($user_categories); $i++): ?>
                  <span><?php echo $user_categories[$i]; ?></span><span>&emsp;</span>
                <?php endfor ?>
                <span><?php echo $profile_t['category_other'] ?></span>
              </div><br>
              <div>
                ＜経歴・資格＞
                <p><?php echo $past ?></p>
              </div>
              <div>
                ＜自己紹介＆メッセージ＞
                <p><?php echo $profile ?></p>
              </div>
            </div>
          </div>
      </div>
      <div class="text-center">
      <a href="edit_prof_t.php"><button type="button" class="btn btn-primary">プロフィール編集</button></a>
      </div>
    </div>
  </div>

  <!-- レッスン一覧 -->
  <div class="middle wrapper">
    <div class="text-center title">直近のレッスン</div>
    <div class="row middle-content">

      <?php if (empty($lessons_t)): ?>
        <div class="col-md-12 mb-5 text-center">レッスンの登録がありません。</div>
        <?php else: ?>
          <?php foreach ($lessons_t as $lesson_t): ?>
            <div class="col-md-4 text-center">
                <div class="row">
                  <div class="col-md-6">
                    <span><?php echo date('m月d日',  strtotime($lesson_t['day'])) ?></span>
                  </div>
                  <div class="col-md-6">
                    <span>最寄り駅：<?php echo $lesson_t['station'] ?></span>
                  </div>
                </div>
              <div class="blog-inner">
                <?php for($i=1; $i<=4; $i++): ?>
                  <?php if ($lesson_t['img_'.$i]): ?>
                    <img class="img-responsive" src="users_lesson_img/<?php echo $lesson_t['img_'.$i] ?>" alt="Blog" width="100%" style="height: 250px;">
                    <?php break; ?>
                  <?php endif ?>
                <?php endfor ?>
                <div class="desc">
                  <h3><a href="lesson.php?lesson_id=<?php echo $lesson_t['id']?>"><?php echo $lesson_t['lesson_name'] ?></a></h3>
                  <span>料金:¥<?php echo $lesson_t['fee'] ?>/1人</span>
                  <?php if (isset($lesson_t['count'])): ?>
                    <span>残り<?php echo $lesson_t['count'] ?>席</span>
                  <?php else: ?>
                    <span style="color: red;"><?php echo $lesson_t['status'] ?></span>
                  <?php endif ?>
                  <p><a href="lesson.php?lesson_id=<?php echo $lesson_t['id']?>" class="btn btn-primary btn-outline with-arrow">レッスン詳細を見る<i class="icon-arrow-right"></i></a></p>
                </div>
              </div>
            </div>
          <?php endforeach ?>
      <?php endif ?>

    </div>
    <div class="text-center">
      <a href="create_lesson.php"><button type="button" class="btn btn-primary">レッスン追加</button></a>
      <a href="bkg_t.php"><button type="button" class="btn btn-primary">レッスン管理一覧</button></a>
    </div>

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
                <div class="col-md-4 text-center">
                  <?php if ($report['profile_img'] == ''): ?>
                    <img src="img/profile_img_defult.png" style="width:80px;height:80px;border-radius: 50%;">
                  <?php else: ?>
                    <img src="user_profile_img/<?php echo $report['profile_img'] ?>" style="width:80px;height:80px;border-radius: 50%;">
                  <?php endif ?>
                  <p style="font-size: 15px;"><?php echo $report['name'] ?></p>
                </div>
                <div class="col-md-8">
                  <?php echo $report['feed'] ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach ?>

    </div>

    <!-- メニュー -->
    <div class="modal fade" id="demoNormalModal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <p>メニュー</p>
                </div>
                <div class="modal-footer text-center" style="display: inline-block;">
                    <a href="top_t.php"><button type="button" class="btn btn-primary">マイページへ</button></a>
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

</body>