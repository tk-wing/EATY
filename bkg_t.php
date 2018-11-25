<?php
    session_start();

    require('dbconnect.php');
    require('functions.php');

    v($_SESSION,'$_SESSION');

    v($_POST,'$_POST');
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

    // if($profile_t == FALSE){
    //     header('Location: edit_prof_t.php');
    //     exit();
    // }
    if (empty($_SESSION['id'])) {
        // $lessons_sql = 'SELECT * FROM `lessons_t` WHERE`day`=?';
        // $stmt = $dbh->prepare($sql);
        // $data =array($signin_user['id']);
        // $stmt->execute($data);

        $lessons_sql ='SELECT `lessons_t`.*,`users`.`first_name` FROM `lessons_t` INNER JOIN `users` ON `lessons_t`.`user_id`=`users`.`id`';


        $lessons_data =[];
        $lessons_stmt = $dbh->prepare($lessons_sql);
        $lessons_stmt->execute($lessons_data);

    }
        // $lessons_stmt = $dbh->prepare($lessons_sql);
        // $lessons_stmt->execute($lessons_data);
        


        $lessons = []; 
        while (true) {
          $lesson = $lessons_stmt->fetch(PDO::FETCH_ASSOC);//データ一個分

          if ($lesson == false) {
            //所得データは全て所得できているので、繰り返しを中断する
            break;
          }
         $lessons[]= $lesson;

        }


      // $sql = 'SELECT * FROM `reservtions` WHERE `status` = ?';
      // $data = array($status);
      // $stmt = $dbh->prepare($sql);
      // $stmt->execute($data);
      // $user = $stmt->fetch(PDO::FETCH_ASSOC);
      // if ($status == '1') {
      //     $status_msg = '受付中';
      // }else{
      //     $status_msg = '満席';
      // }
  





?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>レッスン管理一覧</title>
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

  <div class="wrapper">
    <div class="top-content text-center">
      <img src="https://placehold.jp/120x120.png" style="width:120px;height:120px;border-radius: 50%;">
    </div>

    <div class="blog-inner-prof">
        <div class="row">
          <div class="col-md-2 text-center">
            <p>日程</p>
          </div>

          <div class="col-md-2 text-center">
            <p>レッスン名</p>
          </div>

          <div class="col-md-2 text-center">
            <p>開催場所</p>
          </div>

          <div class="col-md-2 text-center">
            <p>予約数/定員</p>
          </div>

          <div class="col-md-2 text-center">
            <p>状況</p>
          </div>

        </div>
    </div>
<!--     
    <div class="blog-inner-prof">
        <div class="row">
          <div class="col-md-2 text-center">
            <p><?php echo $lesson_data['day']; ?></p>
            <p>13:00~</p>
          </div>

          <div class="col-md-2 text-center">
            <p>クリスマスケーキ</p>
          </div>

          <div class="col-md-2 text-center">
            <p>東京都 渋谷区</p>
          </div>

          <div class="col-md-2 text-center">
            <p>6/15</p>
          </div>

          <div class="col-md-2 text-center">
            <p>受付</p>
          </div>

          <div class="col-md-2 text-center">
            <a href="#"><button type="button" class="btn btn-primary">レッスン詳細</button></a>
            <a href="#"><button type="button" class="btn btn-primary">レッスン編集</button></a>
          </div>

        </div>
    </div> -->
    <?php foreach ($lessons as $lessons_each) {
      include("bkg_t_row.php");

    } ?>

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
<!DOCTYPE html>
<html lang="ja">
<head>
  <title>レッスン管理一覧</title>
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

  <div class="wrapper">
    <div class="top-content text-center">
      <img src="https://placehold.jp/120x120.png" style="width:120px;height:120px;border-radius: 50%;">
    </div>

    <div class="blog-inner-prof">
        <div class="row">
          <div class="col-md-2 text-center">
            <p>日程</p>
          </div>

          <div class="col-md-2 text-center">
            <p>レッスン名</p>
          </div>

          <div class="col-md-2 text-center">
            <p>開催場所</p>
          </div>

          <div class="col-md-2 text-center">
            <p>予約数/定員</p>
          </div>

          <div class="col-md-2 text-center">
            <p>状況</p>
          </div>

        </div>
    </div>

    <div class="blog-inner-prof">
        <div class="row">
          <div class="col-md-2 text-center">
            <p>12/24</p>
            <p>13:00~</p>
          </div>

          <div class="col-md-2 text-center">
            <p>クリスマスケーキ</p>
          </div>

          <div class="col-md-2 text-center">
            <p>東京都 渋谷区</p>
          </div>

          <div class="col-md-2 text-center">
            <p>6/15</p>
          </div>

          <div class="col-md-2 text-center">
            <p>受付</p>
          </div>

          <div class="col-md-2 text-center">
            <a href="#"><button type="button" class="btn btn-primary">レッスン詳細</button></a>
            <a href="#"><button type="button" class="btn btn-primary">レッスン編集</button></a>
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