<?php
    session_start();

    require('dbconnect.php');
    require('functions.php');

    $user_type = '';

    if (isset($_SESSION['EATY'])) {
        $user_id = $_SESSION['EATY']['id'];
        $user_type = $_SESSION['EATY']['user_type'];
    }

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


    // //検索ボタンを押した時
    // if (!empty($_GET['day'])|| !empty($_GET['area_id'])|| !empty($_GET['category_id'])|| !empty($_GET['keyword'])) {
    //     $day = $_GET['day'];
    //     $area = $_GET['area_id'];
    //     $category_id = $_GET['category_id'];
    //     $keyword = $_GET['keyword'];

    //     $lessons_sql ='SELECT `lessons_t`.*,`profiles_t`.`nickname`,`profiles_t`.`img_name`,`profiles_t`.`area_id`FROM `lessons_t` INNER JOIN `profiles_t` ON `lessons_t`.`user_id`=`profiles_t`.`user_id`';

    //     //１つでも値に入ってたら検索する。

    //     if (!empty($day)) {
    //         $lessons_data[] = $day;
    //         $lessons_sql.= 'AND `day`= ?';//AND絶対当てはまるようにしてる
    //     }
    //     if (!empty($area)) {
    //         $lessons_data[] = $area;
    //         $lessons_sql.= 'AND `area_id`= ?';
    //     }
    //     if (!empty($category_id)) {
    //         $lessons_data[] = $category_id;
    //         $lessons_sql.= 'AND `category_id`= ?';
    //     }
    //     if (!empty($keyword)) {
    //     // $lessons_sql.= 'AND `lesson_name`= ?';
    //     $lessons_sql.='AND`lessons_t`.`lesson_name` LIKE ?';//
    //     $search_word = "%".$_GET['keyword']."%";

    //     $lessons_data[] = $search_word;



    //     }
    // }else{
    //     //検査結果を表示。（同じ値だったものすべて）
    //         $lessons_sql ='SELECT `lessons_t`.*,`profiles_t`.`nickname`,`profiles_t`.`img_name`FROM `lessons_t` INNER JOIN `profiles_t` ON `lessons_t`.`user_id`=`profiles_t`.`user_id`';
    //         $lessons_data =[];

    // }
    //         $lessons_stmt = $dbh->prepare($lessons_sql);
    //         $lessons_stmt->execute($lessons_data);

    //     // $lessons_stmt = $dbh->prepare($lessons_sql);
    //     // $lessons_stmt->execute($lessons_data);
    //     $lessons_t = [];
    //     while (1) {
    //         $lesson_t = $lessons_stmt->fetch(PDO::FETCH_ASSOC);
    //         if ($lesson_t == FALSE) {
    //             break;
    //         }
    //         $lessons_t[] = $lesson_t;
    //     }

    // 検索ボタンが押されたら
    if (!empty($_GET)){

      $lessons_sql = "SELECT `lessons_t`.*,`profiles_t`.`nickname`,`profiles_t`.`img_name` AS `profile_img` FROM `lessons_t` INNER JOIN `profiles_t` ON `lessons_t`.`user_id`=`profiles_t`.`user_id` WHERE 1=1";

      $day = $_GET['day'];
      $area = $_GET['area_id'];
      $category_id = $_GET['category_id'];
      $keyword = $_GET['keyword'];

      $lessons_data = [];


      if(!empty($day)){
              $lessons_sql .= ' AND `lessons_t`.`day`=?';
              $lessons_data[] = $day;
          }

      if(!empty($area)){
              $lessons_sql .= ' AND `profiles_t`.`area_id`=?';
              $lessons_data[] = $area;
          }

      if(!empty($category_id)){
              $lessons_sql .= ' AND `lessons_t`.`category_id`=?';
              $lessons_data[] = $category_id;
          }

      if(!empty($keyword)){
              $lessons_sql .= ' AND CONCAT(`lessons_t`.`station`, `lessons_t`.`fee`, `lessons_t`.`lesson_name`, `lessons_t`.`menudetail`) LIKE ?';
              $lessons_data[] = '%'.$keyword.'%';
          }

      $lessons_sql .= ' ORDER BY `lessons_t`.`day`';


    }else{
        $lessons_sql = 'SELECT `lessons_t`.*,`profiles_t`.`nickname`,`profiles_t`.`img_name` AS `profile_img` FROM `lessons_t` INNER JOIN `profiles_t` ON `lessons_t`.`user_id`=`profiles_t`.`user_id` ORDER BY `lessons_t`.`day`';
        $lessons_data = [];
    }


    $lessons_stmt = $dbh->prepare($lessons_sql);
    $lessons_stmt->execute($lessons_data);

    $lessons_t = [];


    while (1) {
        $lesson_t = $lessons_stmt->fetch(PDO::FETCH_ASSOC);
        if ($lesson_t == FALSE) {
            break;
        }
        $lessons_t[] = $lesson_t;
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
      <?php if ($user_type == ''): ?>
        <a href='top.php'><img src="img/eatylogo.png" width="100"></a>
      <?php else: ?>
        <a href='#' data-toggle="modal" data-target="#demoNormalModal"><img src="img/eatylogo.png" width="100"></a>
      <?php endif ?>
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
                      <select id="area" name="area_id" class="form-control">
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
                      <select id="category" name="category_id" class="form-control">
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
     <div class="row middle-content">
      <!-- レッスン検査結果表示 -->
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
              <span>残り１席</span>
              <p><a href="lesson.php?lesson_id=<?php echo $lesson_t['id']?>" class="btn btn-primary btn-outline with-arrow">レッスン詳細を見る<i class="icon-arrow-right"></i></a></p>
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