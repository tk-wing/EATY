<?php

    session_start();
    require('dbconnect.php');
    require('functions.php');

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

    if($profile_s != FALSE){
        if (empty($profile_s['nickname'])) {
            $name = $signin_user['last_name'] . '　' . $signin_user['first_name'];
        } else {
            $name = $profile_s['nickname'];
        }

        if (!empty($profile_s['img_name'])) {
            $img_name = $profile_s['img_name'];
        } else {
            $img_name = '';
        }
    }else{
        $name = $signin_user['last_name'] . '　' . $signin_user['first_name'];
        $img_name = '';
    }

    // お気に入りレッスン情報をを取得
    $favorite_sql='SELECT `l`.*, `f`.`id` AS `favorite_id` FROM `lessons_t` AS `l` INNER JOIN `like_lessons` AS `f` ON `l`.`id` = `f`.`lesson_id` WHERE `f`.`user_id`=? ORDER BY `l`.`day` DESC';
    $favorite_stmt = $dbh->prepare($favorite_sql);
    $favorite_sql_data = [$signin_user['id']];
    $favorite_stmt->execute($favorite_sql_data);

    $favorites = [];

    while(1){
        $favorite = $favorite_stmt->fetch(PDO::FETCH_ASSOC);
        if ($favorite == FALSE) {
            break;
        }
        $favorites[] = $favorite;
    }




?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <title>お気に入りレッスン一覧</title>
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

  <div class="wrapper">
    <div class="top-content text-center">
        <?php if ($img_name == ''): ?>
          <img class="rounded-circle" src="img/profile_img_defult.png" style="width:120px;height:120px;">
        <?php else: ?>
          <img class="rounded-circle" src="user_profile_img/<?php echo $img_name ?>" style="width:120px;height:120px;">
        <?php endif ?>
       <p><?php echo $name ?>さんのお気入りレッスン</p>
    </div>

    <div class="row text-center" style="border: 4px solid #2C373B;border-radius: 240px 15px 185px 15px / 15px 200px 15px 185px;margin: 2em 0;padding: 2em;">

      <?php if (empty($favorites)): ?>
        <div class="col-md-12 text-center">お気に入りレッスンはまだありません。</div>
      <?php else: ?>
        <?php foreach ($favorites as $favorite): ?>
          <div class="col-md-3 text-center">
            <span>レッスン日：<?php echo date('m月d日', strtotime($favorite['day'])); ?></span>
            <div class="blog-inner" style="border:solid 1px; ">
              <img class="img-responsive" src="users_lesson_img/<?php echo $favorite['img_1']; ?>" alt="Blog"  width="100%" style="height: 200px;">
              <p><?php echo $favorite['lesson_name'] ?></p>

                  <form method="POST" action="">
                    <div class="row">
                      <div class="col" style="padding: 0px">
                        <a href="delete_favorite.php?favorite_id=<?php echo $favorite['favorite_id'] ?>"><button type="button" class="btn btn-warning" style="font-size: 13px">お気に入りから削除</button></a>
                      </div>
                      <div class="col">
                        <a href="lesson.php?lesson_id=<?php echo $favorite['id'] ?>"><button type="button" class="btn btn-primary" style="font-size: 13px">レッスン詳細ページへ</button></a>
                      </div>
                    </div>
                  </form>

              </div>
            </div>
        <?php endforeach ?>
      <?php endif ?>



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

  <!-- jQuery、Popper.js、Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- <script src="assets/js/app.js"></script> -->

</body>