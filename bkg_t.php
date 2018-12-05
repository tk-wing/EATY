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

    //pロフィール情報をを取得
    $profile_t_sql='SELECT * FROM `profiles_t` WHERE `user_id`=? ';
    $profile_t_stmt = $dbh->prepare($profile_t_sql);
    $profile_t_sql_data = [$signin_user['id']];
    $profile_t_stmt->execute($profile_t_sql_data);
    $profile_t = $profile_t_stmt->fetch(PDO::FETCH_ASSOC);


    $img_name =$profile_t['img_name'];
    // if($signin_user == FALSE){
    //     header('Location: signup.php');
    //     exit();
    // }
    if (empty($_SESSION['id'])) {

        $lessons_sql ='SELECT * FROM `lessons_t` WHERE `user_id`=?';
        // $lessons_sql ='SELECT * FROM `lessons_t` WHERE `day`=?,`daytime`=?,`lesson_name`=?,`station`=?,`basic`=?,`capacity`=?';
        $lessons_data =[$signin_user['id']];
        $lessons_stmt = $dbh->prepare($lessons_sql);
        $lessons_stmt->execute($lessons_data);

        }


        //自分のレッスンを繰り返し表示
        $lessons = []; 
        while (1) {//一回の繰り返し
          $lesson = $lessons_stmt->fetch(PDO::FETCH_ASSOC);//データ一個分

          if ($lesson == false) {
            //所得データは全て所得できているので、繰り返しを中断する
            break;
          }
          //１つのテーブルに対してカウントし、予約状況を表示させる為、繰り返しの中に書く
            //レッスン受付状態のの確認
            $number_reservation_sql='SELECT count(*) AS `number_reservation` FROM `reservations` WHERE `lesson_id`=? AND `status`=?';
            $number_reservation_stmt = $dbh->prepare($number_reservation_sql);
            $number_reservation_sql_data = [$lesson['id'],'1'];//$lessonはreservationsテーブルのlesson_idと同じ値
            $number_reservation_stmt->execute($number_reservation_sql_data);
            $number_reservation = $number_reservation_stmt->fetch(PDO::FETCH_ASSOC);

            $today = date("Y-m-d");
            $targetTime = strtotime($lesson['day']);

            if ($today == date('Y-m-d', strtotime('-1 day', $targetTime))) {
                $lesson['status'] = '受付終了';
            }elseif (strtotime($today) > $targetTime) {
                $lesson['status'] = '開催済み';
            }
            //reservationsテーブルのlesson_idとstatusを数える
            elseif ($number_reservation['number_reservation'] == $lesson['capacity']) {
                $lesson['status'] = '満席';//数えた数がcapacityと一緒だったら満席をステータスに入れる
            }else{
                //capacity-数えた数をカウント関数にしてる。

                $lesson['count'] = 0 + $number_reservation['number_reservation'];
                $lesson['status'] = 'NULL';
            }

            $lessons[]= $lesson;
        }

          // v($lessons,'$lessons');

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
      <a data-toggle="modal" data-target="#demoNormalModal"><img src="img/eatylogo.png" width="100"></a>
    </div>
  </header>

  <div class="wrapper">
    <div class="top-content text-center">
      <?php if ($img_name == ''): ?>
        <img class="img-responsive" src="img/profile_img_defult.png" alt="Blog" style="width:140px;height:140px;border-radius: 50%;">
      <?php else: ?>
        <img src="user_profile_img/<?php echo $img_name ?>" style="width:120px;height:120px;border-radius: 50%;">
      <?php endif ?>
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

    <?php foreach ($lessons as $lessons_each) {
      include("bkg_t_row.php");

    } ?>

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