<?php
    //SESSIONの有効化
    session_start();
    require('dbconnect.php');
    require('functions.php');

    if (!isset($_SESSION['EATY'])) {
        header('Location: signin.php');
        exit();
    }

    $validations = [];

    // ユーザー情報を取得
    $sql='SELECT * FROM `users` WHERE `id`=?';
    $stmt = $dbh->prepare($sql);
    $data = array($_SESSION['EATY']['id']);
    $stmt->execute($data);

    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

    // 必須項目
    $last_name = $signin_user['last_name'];
    $first_name = $signin_user['first_name'];

    // pロフィール情報をを取得
    $profile_t_sql='SELECT `p`.*, `uc`.`category_id` FROM `profiles_t` AS `p` LEFT JOIN `user_categories` AS `uc` ON `p`.`user_id` = `uc`.`user_id` WHERE `p`.`user_id`=?';
    $profile_t_stmt = $dbh->prepare($profile_t_sql);
    $profile_t_sql_data = [$signin_user['id']];
    $profile_t_stmt->execute($profile_t_sql_data);
    $profile_t = $profile_t_stmt->fetch(PDO::FETCH_ASSOC);

    // カテゴリー情報を取得
    $categories_sql='SELECT * FROM `categories`';
    $categories_stmt = $dbh->prepare($categories_sql);
    $categories_sql_data = [];
    $categories_stmt->execute($categories_sql_data);


    // pロフィール情報をを取得
    $profile_t_sql='SELECT `p`.*, `uc`.`category_id` FROM `profiles_t` AS `p` LEFT JOIN `user_categories` AS `uc` ON `p`.`user_id` = `uc`.`user_id` WHERE `p`.`user_id`=?';
    $profile_t_stmt = $dbh->prepare($profile_t_sql);
    $profile_t_sql_data = [$signin_user['id']];
    $profile_t_stmt->execute($profile_t_sql_data);
    $profile_t = $profile_t_stmt->fetch(PDO::FETCH_ASSOC);

    // カテゴリー情報を取得
    $categories_sql='SELECT * FROM `categories`';
    $categories_stmt = $dbh->prepare($categories_sql);
    $categories_sql_data = [];
    $categories_stmt->execute($categories_sql_data);

    





?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>生徒 プロフィール編集</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="css/stylesheet_t.css">
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

  <script>
  $(function(){
    $('#filesend').change(function(e){
      //ファイルオブジェクトを取得する
      var file = e.target.files[0];
      var reader = new FileReader();

      //画像でない場合は処理終了
      if(file.type.indexOf("image") < 0){
        alert("画像ファイルを指定してください。");
        return false;
      }

      //アップロードした画像を設定する
      reader.onload = (function(file){
        return function(e){
          $("#img1").attr("src", e.target.result);
          $("#img1").attr("title", file.name);
        };
      })(file);
      reader.readAsDataURL(file);

    });
  });
  </script>
</head>

<body>
  <header>
    <div class="text-center">
      <a href="#"><img src="img/eatylogo.png" width="100"></a>
    </div>
  </header>

  <div class="edit_content_s text-center">
    <form method="POST" action="">
      <div class="row">
        <div class="col-md-4 text-center">
          <img id="img1" src="https://placehold.jp/160x160.png" style="width:160px;height:160px;border-radius: 50%;">
          <label>
            <span class="filelabel" title="ファイルを選択">
              <i class="fas fa-camera-retro"></i>
              選択
            </span>
            <input type="file" class="filesend" id="filesend" name="img_name">
          </label>
        </div>

        <div class="col-md-8">
          <!-- Text input-->
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <input id="last_name" name="last_name" type="text" placeholder="姓" value="<?php echo $signin_user['last_name'] ?>" class="form-control input-md">
              </div>
              <div class="col-md-4">
                <input id="first_name" name="first_name" type="text" placeholder="名" value="<?php echo $signin_user['first_name'] ?>" class="form-control input-md">
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-9">
               <input id="nickname" name="nickname" type="text" placeholder="ニックネーム(任意)"" class="form-control input-md">
              </div>
            </div>
          </div>

          <div class="row">
            <p class="col-md-8 check_content"><?php echo $signin_user['email'] ?></p>
          </div>

          <!-- ジャンル -->
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <ul id="category">
                  <li class="category-item">
                    <p class="ml-1">ジャンル</p><br>
                    <span class="category-button">+</span>
                    <div class="inner">
                       <div class="checkbox">
                         <?php while(1): ?>
                            <?php $categories = $categories_stmt->fetch(PDO::FETCH_ASSOC) ?>
                            <?php if ($categories == FALSE): ?>
                              <?php break ?>
                            <?php endif ?>
                            <?php if ($category_id == $categories['id']): ?>
                              <label>
                                <input type="checkbox" name="categories"  value="<?php echo $categories['id'] ?>" checked>
                                <?php echo $categories['category_name'] ?>
                              </label><br>
                              <?php else: ?>
                                <label>
                                  <input type="checkbox" name="categories"  value="<?php echo $categories['id'] ?>">
                                  <?php echo $categories['category_name'] ?>
                                </label><br>
                            <?php endif ?>
                          <?php endwhile ?>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>

              <!-- その他ジャンル -->
              <div class="col-md-6">
                <input id="category_other" name="category_other" type="text" placeholder="その他ジャンル" class="form-control input-md" value="<?php echo $category_other ?>">
              </div>
            </div>
              <input type="submit" class="btn btn-primary" value="完了">
          </div>

        </div>
      </div>
    </form>
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