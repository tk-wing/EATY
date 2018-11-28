<?ph<?php
    session_start();

    require('dbconnect.php');
    require('functions.php');

    v($_SESSION,'$_SESSION');
    v($_GET,'$_GET');
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

    // pロフィール情報をを取得(生徒)
    $profile_t_sql='SELECT * FROM `profiles_s` WHERE `user_id`=?';
    $profile_t_stmt = $dbh->prepare($profile_t_sql);
    $profile_t_sql_data = [$signin_user['id']];
    $profile_t_stmt->execute($profile_t_sql_data);
    $profile_t = $profile_t_stmt->fetch(PDO::FETCH_ASSOC);

    // カテゴリー情報を取得
    $categories_sql='SELECT * FROM `categories`';
    $categories_stmt = $dbh->prepare($categories_sql);
    $categories_sql_data = [];
    $categories_stmt->execute($categories_sql_data);
    
    // 都道府県情報の取得
    $areas_sql='SELECT * FROM `areas`';
    $areas_stmt = $dbh->prepare($areas_sql);
    $areas_sql_data = [];
    $areas_stmt->execute($areas_sql_data);

    $validations=[];

    

    //検索ボタンを押した時
    if (isset($_GET['day'])) {
        //同じ値の情報をDBから持ってくる。
        //１つでも値に入ってたら検索する。
        $lessons_sql='SELECT * FROM `lessons_t` WHERE `day`=?';
        $day=$_GET['day'];
        // $category_id=$_GET['category_id'];
        //$areas=$_GET['area'];//テーブルに都道府県がない為引っ張って来れない
        //$keyword = $_GET['keyword'];
        // $search_word = "%".$_GET['keyword']."%";

        $lessons_data = [$day];



        }else{
        //検査結果を表示。（同じ値だったものすべて）
            // $lessons_sql ='SELECT * FROM `lessons_t` WHERE 1';
            $lessons_sql ='SELECT `lessons_t`.*,`profiles_t`.`nickname`,`profiles_t`.`img_name`FROM `lessons_t` INNER JOIN `profiles_t` ON `lessons_t`.`user_id`=`profiles_t`.`user_id`';
            $lessons_data =[];
        } 

        $lessons_stmt = $dbh->prepare($lessons_sql);
        $lessons_stmt->execute($lessons_data);
        $lessons = [];

        while (true) {
          $lesson = $lessons_stmt->fetch(PDO::FETCH_ASSOC);//データ一個分

          if ($lesson == false) {
            //所得データは全て所得できているので、繰り返しを中断する
            break;
          }
         $lessons[]= $lesson;

        }







?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <title>検索結果</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <link rel="stylesheet" href="css/stylesheet_serch.css">
  <link rel="stylesheet" href="css/stylesheet_serch_s.css">

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
  <header>
    <div class="text-center" >
      <a href="#"><img src="img/eatylogo.png" width="100"></a>
    </div>
  </header>

 <a class="right" href="http://localhost/batch46/EATY/serch_s.php">検査条件をクリア</a>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <form method="GET" action="" enctype="multipart/form-data">
    <!-- GET送信　　画像が送れるように -->

<!------ Include the above in your HEAD tag ---------->
    <div class="container text-center">
      <nav class="navbar navbar-expand-lg navbar-dark">
                <ul>
                  <li>
                    <p>日付</p>
                  </li>
                  <li>
                    <input id="name" name="day" type="date" placeholder="" class="form-control input-md">
                  </li>
                  <li>

                    <p>開催場所</p>
                  </li>
                    <li>
                      <select id="area" name="area" class="form-control">
                                  <option value="">選択してください。</option>
                                  <?php while(1): ?>
                                    <?php  $areas = $areas_stmt->fetch(PDO::FETCH_ASSOC); ?>
                                    <?php if ($areas == false): ?>
                                      <?php break; ?>
                                    <?php endif ?>
                                      <?php if ($area_id == $areas['id']): ?>
                                        <option value="<?php echo $areas['id']?>" selected><?php echo $areas['name'] ?></option>
                                      <?php else: ?>
                                        <option value="<?php echo $areas['id']?>"><?php echo $areas['name'] ?></option>
                                      <?php endif ?>
                                  <?php endwhile ?>
                                </select>
                    </li>
                    <li>
                      <p>カテゴリー</p>
                    </li>
                    <li class="">
                      <select id="category" name="category_id[]" class="form-control">
                        <option value="">選択してください。</option>
                        <?php while(1): ?>
                          <?php  $category_id = $categories_stmt->fetch(PDO::FETCH_ASSOC); ?>
                          <?php if ($category_id == false): ?>
                            <?php break; ?>
                            <?php else: ?>
                            <option value="<?php echo $category_id['id'];?>"><?php echo $category_id['category_name'] ?></option>
                          <?php endif ?>
                        <?php endwhile; ?>
                      </select>
                    </li>
                    <li>
                      <p>キーワード</p>
                    </li>
                    <li class="">
                        <input id="name" name="keyword" type="text" placeholder="その他" class="form-control input-md">
                    </li>
                        <!-- <input type="submit" class="btn btn-primary" value="レッスン検索"> -->
                </ul>
                  </nav>
                <input type="submit"  class="btn btn-primary" value="レッスン検索">
    </form>

  <!-- レッスン検査結果表示 POST送信した時に表示 -->

  <?php foreach ($lessons as $lessons_each) {
    include("serch_s_row.php");

  } ?>

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