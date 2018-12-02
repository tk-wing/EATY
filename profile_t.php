<?php
    //SESSIONの有効化
    session_start();
    require('dbconnect.php');
    require('functions.php');

    $teacher_id = $_GET['teacher_id'];
    $user_type = '';

    if (isset($_SESSION['EATY'])) {
        $user_id = $_SESSION['EATY']['id'];
        $user_type = $_SESSION['EATY']['user_type'];
    }


    // プロフィール情報をを取得
    $profile_t_sql='SELECT `profiles_t`.*, `users`.`first_name`, `users`.`last_name` FROM `profiles_t` INNER JOIN `users` ON `profiles_t`.`user_id` = `users`.`id` WHERE `profiles_t`.`user_id`=?';
    $profile_t_stmt = $dbh->prepare($profile_t_sql);
    $profile_t_sql_data = [$teacher_id];
    $profile_t_stmt->execute($profile_t_sql_data);
    $profile_t = $profile_t_stmt->fetch(PDO::FETCH_ASSOC);

    // いいねカウント
    $like_sql = "SELECT COUNT(*) AS `like_count` FROM likes WHERE `instructor_id`=?";
    $like_data = [$teacher_id];
    $like_stmt = $dbh->prepare($like_sql);
    $like_stmt->execute($like_data);
    $like_count_data = $like_stmt->fetch(PDO::FETCH_ASSOC);
    $profile_t['like_count'] = $like_count_data['like_count'];

    $lessons_t = [];

    // レッスン情報をを取得
    $lessons_t_sql='SELECT * FROM `lessons_t` WHERE `user_id`=? LIMIT 0,3';
    $lessons_t_stmt = $dbh->prepare($lessons_t_sql);
    $lessons_t_sql_data = [$teacher_id];
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
    $user_categories_sql_data = [$teacher_id];
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
        $name = $profile_t['last_name'] . '　' . $profile_t['first_name'];
    } else {
        $name = $profile_t['nickname'];
    }

    // 以下登録任意項目
    $img_name = $profile_t['img_name'];
    $profile = $profile_t['profile'];

      if($user_type == '2'){
      // 生徒がいいね済みかを確認
      $like_flag_sql = "SELECT * FROM `likes` WHERE `instructor_id` = ? AND `student_id` = ?";
      $like_flag_data = [$teacher_id, $user_id];
      $like_flag_stmt = $dbh->prepare($like_flag_sql);
      $like_flag_stmt->execute($like_flag_data);
      $is_liked = $like_flag_stmt->fetch(PDO::FETCH_ASSOC);
    }

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
              <?php if ($user_type == '2'): ?>
                <span hidden id="user_id"><?php echo $user_id ?></span>
                <span hidden id="teacher_id"><?php echo $profile_t['user_id'] ?></span>
                <button type="button" class="btn btn-secondary"><i class="far fa-envelope"></i></button>
                <?php if ($is_liked == FALSE): ?>
                  <button id="like" type="button" class="btn btn-secondary"><i class="far fa-heart"></i>&nbsp;<span id='like_count'><?php echo $profile_t['like_count'] ?></span></button>
                <?php else: ?>
                  <button id='unlike' type="button" class="btn btn-danger"><i class="far fa-heart"></i>&nbsp;<span id="like_count"><?php echo $profile_t['like_count'] ?></span></button>
                <?php endif ?>
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
    </div>
  </div>

  <!-- レッスン一覧 -->
  <div class="middle wrapper">
    <div class="text-center title">直近のレッスン</div>
    <div class="row middle-content">

      <?php if (empty($lessons_t)): ?>
        <div class="col-md-12 mb-5 text-center">直近のレッスンはありません。</div>
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
                <img class="img-responsive" src="users_lesson_img/<?php echo $lesson_t['img_1'] ?>" alt="Blog" width="100%" style="height: 250px;">
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
          </div>
        </div>
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
                    <a href="top_s.php"><button type="button" class="btn btn-primary">マイページへ</button></a>
                    <a href="serch_s.php"><button type="button" class="btn btn-primary">レッスン検索</button></a>
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