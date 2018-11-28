<?php
    //SESSIONの有効化
    session_start();
    require('dbconnect.php');
    require('functions.php');

    if (!isset($_SESSION['EATY'])) {
        header('Location: signin.php');
        exit();
    }


    // ユーザー情報を取得
    $sql='SELECT * FROM `users` WHERE `id`=?';
    $stmt = $dbh->prepare($sql);
    $data = array($_SESSION['EATY']['id']);
    $stmt->execute($data);

    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);


    // プロフィール情報をを取得
    $profile_s_sql='SELECT * FROM `profiles_s` WHERE `user_id`=?';
    $profile_s_stmt = $dbh->prepare($profile_s_sql);
    $profile_s_sql_data = [$signin_user['id']];
    $profile_s_stmt->execute($profile_s_sql_data);
    $profile_s = $profile_s_stmt->fetch(PDO::FETCH_ASSOC);


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

    // 予約済みレッスン情報をを取得
    $lessons_s_sql='SELECT `r`.*, `l`.`day`, `l`.`daytime`, `l`.`station`, `l`.`lesson_name` FROM `reservations` AS `r` INNER JOIN `lessons_t` AS `l` ON `r`.`lesson_id` = `l`.`id` WHERE `r`.`user_id`=?';
    $lessons_s_stmt = $dbh->prepare($lessons_s_sql);
    $lessons_s_sql_data = [$signin_user['id']];
    $lessons_s_stmt->execute($lessons_s_sql_data);

    while (1) {
        $lesson_s = $lessons_s_stmt->fetch(PDO::FETCH_ASSOC);
        if ($lesson_s == FALSE) {
            break;
        }
        $lessons_s[] = $lesson_s;
    }


    while (1) {
        $user_categories = $user_categories_stmt->fetch(PDO::FETCH_ASSOC);
        if ($user_categories == FALSE) {
            break;
        }
        $user_categories_id[] = $user_categories['category_id'];
    }

    if (!empty($user_categories_id)) {
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
    }



    //ニックネームが登録されていない場合
    if (empty($profile_s['nickname'])) {
        $name = $signin_user['last_name'] . '　' . $signin_user['first_name'];
    } else {
        $name = $profile_s['nickname'];
    }

    // 以下登録任意項目
    $img_name = $profile_s['img_name'];
    $profile = $profile_s['profile'];

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>生徒 TOP</title>
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

  <!-- プロフィール -->
  <div class="row top_s">
    <div class="col wrapper_col">
      <div class="content">
        <div class="blog-inner-prof">
            <div class="row">
              <div class="col-md-5 text-center">
                <?php if ($img_name==''): ?>
                  <img class="img-responsive" src="img/profile_img_defult.png" alt="Blog" style="width:140px;height:140px;border-radius: 50%;"><br>
                <?php else: ?>
                  <img class="img-responsive" src="user_profile_img/<?php echo $img_name ?>" alt="Blog" style="width:140px;height:140px;border-radius: 50%;"><br>
                <?php endif ?>
                <p><?php echo $name ?></p>
                <button type="button" class="btn btn-secondary"><i class="far fa-envelope"></i></button>
              </div>
              <div class="col-md-7">
                <div>
                  ＜ジャンル＞<br>
                  <?php for($i=0; $i<count($user_categories); $i++): ?>
                    <span><?php echo $user_categories[$i]; ?></span><span>&emsp;</span>
                  <?php endfor ?>
                  <span><?php echo $profile_s['category_other'] ?></span>
                </div><br>
                <div>
                  ＜自己紹介＆メッセージ＞
                  <p><?php echo $profile ?></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col text-right">
                <a href="report.php"><button type="button" class="btn btn-secondary">つくれぽ一覧を見る</button></a><br>
                <a href="favorites.php"><button type="button" class="btn btn-secondary">お気に入りレッスン</button></a>
              </div>
              <div class="col text-left">
                <a href="report_send.php"><button type="button" class="btn btn-secondary">つくれぽを投稿する</button></a><br>
                <a href="edit_prof_s.php"><button type="button" class="btn btn-secondary" style="width: 170px;">プロフィール編集</button></a>
              </div>
            </div>
        </div>
      </div>
    </div>

    <!-- レッスン一覧 -->
    <div class="col wrapper_col">
      <div class="blog-inner-prof">
          <div class="row">
            <div class="col-2 text-center">
              <p>日程</p>
            </div>

            <div class="col-2 text-center">
              <p>レッスン名</p>
            </div>

            <div class="col-2 text-center">
              <p>開催場所</p>
            </div>

            <div class="col-2 text-center">
              <p>状況</p>
            </div>

          </div>
      </div>

      <div class="blog-inner-prof">
          <div class="row">
            <?php foreach ($lessons_s as $lesson): ?>
            <div class="col-md-2 text-center">
              <p><?php echo date('m月d日',  strtotime($lesson['day'])) ?></p>
              <p><?php echo date('H時i分', strtotime($lesson['daytime'])) ?>~</p>
            </div>

            <div class="col-md-2 text-center">
              <p><?php echo $lesson['lesson_name'] ?></p>
            </div>

            <div class="col-md-2 text-center">
              <span>最寄り駅</span><br>
              <span><?php echo $lesson['station'] ?></span>
            </div>

            <div class="col-md-2 text-center">
              <?php if ($lesson['status']=='1'): ?>
                <p style="color: blue">予約済み</p>
              <?php elseif($lesson['status']=='2'): ?>
                <p style="color: red;">キャンセル</p>
              <?php endif ?>
            </div>

            <div class="col-md-4 text-center">
              <a href="lesson.php?lesson_id=<?php echo $lesson['lesson_id']?>"><button type="button" class="btn btn-primary">レッスン詳細</button></a>
              <?php if ($lesson['status']=='1'): ?>
                <a onclick="return confirm('本当にキャンセルしますか？')" href="cancel_lesson_s.php?lesson_id=<?php echo $lesson['lesson_id']?>"><button type="button" class="btn btn-danger" style="width: 125px">キャンセル</button></a>
              <?php endif ?>
            </div>
            <?php endforeach ?>
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