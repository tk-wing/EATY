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
      <a href="#"><img src="img/eatylogo.png" width="100"></a>
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
              <button type="button" class="btn btn-secondary"><i class="far fa-envelope"></i></button>
              <button type="button" class="btn btn-secondary"><i class="far fa-heart"></i></button>
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
      <a href="edit_prof_t.php"><button type="button" class="btn btn-secondary">プロフィール編集</button></a>
      </div>
    </div>
  </div>

  <!-- レッスン一覧 -->
  <div class="middle wrapper">
    <div class="text-center title">レッスン紹介</div>
    <div class="row middle-content">
      <div class="col-md-4 text-center">
          <div class="row">
            <div class="col-md-6">
              <span>2018/12/31</span>
            </div>
            <div class="col-md-6">
              <span>東京都品川区</span>
            </div>
          </div>
        <div class="blog-inner">
          <img class="img-responsive" src="http://placehold.jp/350x200.png" alt="Blog">
          <div class="desc">
            <h3><a href="#">レッスン名</a></h3>
            <span>¥5000/1人</span>
            <span>残り１席</span>
            <p><a href="#" class="btn btn-primary btn-outline with-arrow">レッスン詳細を見る<i class="icon-arrow-right"></i></a></p>
          </div>
        </div>
      </div>
      <div class="col-md-4 text-center">
        <div class="row">
          <div class="col-md-6">
            <span>2018/12/31</span>
          </div>
          <div class="col-md-6">
            <span>東京都品川区</span>
          </div>
        </div>
        <div class="blog-inner">
          <img class="img-responsive" src="http://placehold.jp/350x200.png" alt="Blog">
          <div class="desc">
            <h3><a href="#">レッスン名</a></h3>
            <span>¥5000/1人</span>
            <span>残り１席</span>
            <p><a href="#" class="btn btn-primary btn-outline with-arrow">レッスン詳細を見る<i class="icon-arrow-right"></i></a></p>
          </div>
        </div>
      </div>
      <div class="col-md-4 text-center">
        <div class="row">
          <div class="col-md-6">
            <span>2018/12/31</span>
          </div>
          <div class="col-md-6">
            <span>東京都品川区</span>
          </div>
        </div>
        <div class="blog-inner">
          <img class="img-responsive" src="http://placehold.jp/350x200.png" alt="Blog">
          <div class="desc">
            <h3><a href="#">レッスン名</a></h3>
            <span>¥5000/1人</span>
            <span>残り１席</span>
            <p><a href="#" class="btn btn-primary btn-outline with-arrow">レッスン詳細を見る<i class="icon-arrow-right"></i></a></p>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center">
      <a href="#"><button type="button" class="btn btn-secondary">レッスン追加</button></a>
      <a href="bkg_t.php"><button type="button" class="btn btn-secondary">レッスン管理一覧</button></a>
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