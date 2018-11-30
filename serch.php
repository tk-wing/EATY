<?php
    session_start();

    require('dbconnect.php');
    require('functions.php');

    // v($_SESSION,'$_SESSION');

       // ユーザー情報を取得
    $sql='SELECT * FROM `users` WHERE `id`=?';
    $stmt = $dbh->prepare($sql);
    $data = array($_SESSION['EATY']['id']);
    $stmt->execute($data);

    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

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


    if (!empty($_POST)) {
        $day = $_POST['day'];
      }


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>レッスン検索ページ</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="css/stylesheet_serch.css">
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

  <div class="text-center container">
    <p class="title font-weight-bold">レッスン検索</p>
    <form class="signup_form" method="POST" action=""></form>

   
    <div class="title font-weight-bold">
      日付
      <!-- <div style="float: right"> -->
<!--         <select id="genre" name="genre" class="form-control">
          <option value="1">Option one</option>
          <option value="2">Option two</option>
        </select> -->
          <input id="name" name="day" type="date" placeholder="" class="form-control input-md">

      </div>
    </div>
    <div class="title font-weight-bold">
      開催場所
      <!-- <div style="float: right"> -->
        <div class="col-md-4">
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
        </div>

      </div>
    </div>
    <div class="title font-weight-bold">
      カテゴリー
      <div style="float: right">
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

        <?php if(isset($validations['category_id'])&& $validations['category_id']=='blank'): ?>
        <span class="error_msg">カテゴリーを指定してください</span>
        <?php endif; ?>
      </div>
    </div>
    <div class="title font-weight-bold">
      キーワード
      <div style="float: right">
        <input id="name" name="keyword" type="text" placeholder="その他" class="form-control input-md">
       <!--  <?php if(isset($validations['fee'])&& $validations['fee']=='blank'): ?>
        <span class="error_msg">キーワードを指定してください</span>
        <?php endif; ?> -->
      </div>
    </div>

    <input type="submit" class="btn btn-primary" value="レッスン検索">

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