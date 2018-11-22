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
    $profile_s_sql='SELECT * FROM `profiles_s` WHERE `user_id`=?';
    $profile_s_stmt = $dbh->prepare($profile_s_sql);
    $profile_s_sql_data = [$signin_user['id']];
    $profile_s_stmt->execute($profile_s_sql_data);
    $profile_s = $profile_s_stmt->fetch(PDO::FETCH_ASSOC);

    // ユーザーカテゴリー情報をを取得
    $user_categories_sql='SELECT * FROM `user_categories` WHERE `user_id`=?';
    $user_categories_stmt = $dbh->prepare($user_categories_sql);
    $user_categories_data = [$signin_user['id']];
    $user_categories_stmt->execute($user_categories_data);

    if($profile_s != FALSE){
        $nickname = h($profile_s['nickname']);
        $category_other = h($profile_s['category_other']);
        $profile = h($profile_s['profile']);
        $file_name = $profile_s['img_name'];

        while(1){
            $user_categories = $user_categories_stmt->fetch(PDO::FETCH_ASSOC);
            if ($user_categories == FALSE) {
                break;
            }
            $categories_id[] = $user_categories['category_id'];
        }

    }else{
        $nickname = '';
        $categories_id = '';
        $category_other = '';
        $profile = '';
        $file_name = '';

    }

    // カテゴリー情報を取得
    $categories_sql='SELECT * FROM `categories`';
    $categories_stmt = $dbh->prepare($categories_sql);
    $categories_sql_data = [];
    $categories_stmt->execute($categories_sql_data);


    if($profile_s == FALSE){
        if(!empty($_POST)){
            $last_name = h($_POST['last_name']);
            $first_name = h($_POST['first_name']);
            $nickname = h($_POST['nickname']);
            $categories_id = $_POST['categories'];
            $category_other = h($_POST['category_other']);
            $profile = h($_POST['profile']);


            // 必須項目のバリデーション
            $user_prof_infos = ['last_name'=>$last_name, 'first_name'=>$first_name,];

            foreach ($user_prof_infos as $index => $user_prof_info) {
                if ($user_prof_info == '') {
                    $validations[$index] = 'blank';
                }
            }

            $file_name = $_FILES['img_name']['name'];

            // 必須項目入力済みの場合の処理
            if(empty($validations)) {

                if (!empty($file_name)) {
                    $file_name = date('YmdHis') .$file_name;
                    $tmp_file = $_FILES['img_name']['tmp_name'];
                    $destination = 'user_profile_img/'.$file_name;
                    move_uploaded_file($tmp_file, $destination);
                }

                // もし名字・名前に変更があったら
                if($last_name != $signin_user['last_name'] || $first_name != $signin_user['first_name']){
                    $user_sql='UPDATE `users` SET `first_name`=?, `last_name`=? `updated`=NOW() WHERE `id`=?';
                    $user_stmt = $dbh->prepare($user_sql);
                    $user_data = [$first_name, $last_name, $signin_user['id']];
                    $user_stmt->execute($user_data);
                }

                // profile_sへデータ登録
                $sql='INSERT INTO `profiles_s` SET `user_id`=?, `nickname`=?, `img_name`=?, `category_other`=?, `profile`=?, `created`=NOW()';
                $stmt = $dbh->prepare($sql);
                $data = [$signin_user['id'],$nickname, $file_name, $category_other, $profile];
                $stmt->execute($data);

                // user_categoriesへデータ登録
                foreach ($categories_id as $category_id) {
                    $user_categories_sql='INSERT INTO `user_categories` SET `user_id`=?, `category_id`=?, `created`=NOW()';
                    $user_categories_stmt = $dbh->prepare($user_categories_sql);
                    $user_categories_data = array($signin_user['id'], $category_id);
                    $user_categories_stmt->execute($user_categories_data);
                }


                header('Location: top_s.php');
                exit();
            }
        }

    }else{
        if(!empty($_POST)){
            $last_name = h($_POST['last_name']);
            $first_name = h($_POST['first_name']);

            $nickname = h($_POST['nickname']);
            $categories_id = $_POST['categories'];
            $category_other = h($_POST['category_other']);
            $profile = h($_POST['profile']);

            // 必須項目のバリデーション
            $user_prof_infos = ['last_name'=>$last_name, 'first_name'=>$first_name,];

            foreach ($user_prof_infos as $index => $user_prof_info) {
                if ($user_prof_info == '') {
                    $validations[$index] = 'blank';
                }
            }

            $file_name = $_FILES['img_name']['name'];
            if(empty($file_name)){
                $file_name = $profile_s['img_name'];
            }

            // 必須項目入力済みの場合の処理
            if(empty($validations)) {

                if ($file_name != $profile_s['img_name']) {
                    $file_name = date('YmdHis') .$file_name;
                    $tmp_file = $_FILES['img_name']['tmp_name'];
                    $destination = 'user_profile_img/'.$file_name;
                    move_uploaded_file($tmp_file, $destination);
                }

                // もし名字・名前に変更があったら
                if($last_name != $signin_user['last_name'] || $first_name != $signin_user['first_name']){
                    $user_sql='UPDATE `users` SET `first_name`=?, `last_name`=?, `updated`=NOW() WHERE `id`=?';
                    $user_stmt = $dbh->prepare($user_sql);
                    $user_data = [$first_name, $last_name, $signin_user['id']];
                    $user_stmt->execute($user_data);
                }

                // profile_sへデータ更新
                $sql='UPDATE `profiles_s` SET `nickname`=?, `img_name`=?, `category_other`=?, `profile`=?, `updated`=NOW() WHERE `user_id`=?';
                $stmt = $dbh->prepare($sql);
                $data = [$nickname, $file_name, $category_other, $profile,$signin_user['id']];
                $stmt->execute($data);

                // user_categoriesへデータ削除
                $user_categories_sql='DELETE FROM `user_categories` WHERE `user_id`=?';
                $user_categories_stmt = $dbh->prepare($user_categories_sql);
                $user_categories_data = [$signin_user['id']];
                $user_categories_stmt->execute($user_categories_data);

                // user_categoriesへデータ登録
                foreach ($categories_id as $category_id) {
                    $user_categories_sql='INSERT INTO `user_categories` SET `user_id`=?, `category_id`=?, `created`=NOW()';
                    $user_categories_stmt = $dbh->prepare($user_categories_sql);
                    $user_categories_data = array($signin_user['id'], $category_id);
                    $user_categories_stmt->execute($user_categories_data);
                }


                header('Location: top_s.php');
                exit();
            }


        }



    }





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
    <form method="POST" action="" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-4 text-center">
          <?php if ($file_name == ''): ?>
            <img id="img1" src="img/profile_img_defult.png" style="width:160px;height:160px;border-radius: 50%;">
          <?php else: ?>
            <img id="img1" src="user_profile_img/<?php echo $file_name ?>" style="width:160px;height:160px;border-radius: 50%;">
          <?php endif ?>
          <label>
            <span class="filelabel" title="ファイルを選択">
              <i class="fas fa-camera-retro"></i>
              選択
            </span>
            <input type="file" class="filesend" id="filesend" name="img_name" accept="image/*">
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
               <input id="nickname" name="nickname" type="text" placeholder="ニックネーム(任意)" value="<?php echo $nickname ?>" class="form-control input-md">
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
                            <?php if (is_check_user_category($categories_id,$categories['id']) == $categories['id'] ): ?>
                              <label>
                                <input type="checkbox" name="categories[]"  value="<?php echo $categories['id'] ?>" checked>
                                <?php echo $categories['category_name'] ?>
                              </label><br>
                            <?php else: ?>
                              <label>
                                <input type="checkbox" name="categories[]"  value="<?php echo $categories['id'] ?>">
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

              <!-- 自己紹介・コメント（任意項目） -->
              <div class="form-group">
                <label class="col-md-4 control-label" for="comment"></label>
                <div class="col-md-14">
                  <textarea class="form-control" id="profile" name="profile" placeholder="自己紹介＆コメント" style="height: 100px;"><?php echo $profile ?></textarea>
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