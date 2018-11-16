<?php
    session_start();
    require('dbconnect.php');
    require('functions.php');

    v($_SESSION, '$_SESSION');

    $validations = [];

    // ユーザー情報を取得
    $sql='SELECT * FROM `users` WHERE `id`=?';
    $stmt = $dbh->prepare($sql);
    $data = array($_SESSION['EATY']['id']);
    $stmt->execute($data);

    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

    v($signin_user, '$signin_user');

    // 必須項目
    $last_name = $signin_user['last_name'];
    $first_name = $signin_user['first_name'];
    $area_id = '';
    $city = '';
    $station = '';
    $category_id = '';
    $past = '';
    // 任意項目
    $nickname = '';
    $category_other = '';
    $profile = '';
    $file_name = '';

    V($_FILES, '$_FILES');
    // V($_POST, '$_POST');

    // 都道府県情報の取得
    $areas_sql='SELECT * FROM `areas`';
    $areas_stmt = $dbh->prepare($areas_sql);
    $areas_sql_data = [];
    $areas_stmt->execute($areas_sql_data);

    // カテゴリー情報を取得
    $categories_sql='SELECT * FROM `categories`';
    $categories_stmt = $dbh->prepare($categories_sql);
    $categories_sql_data = [];
    $categories_stmt->execute($categories_sql_data);



    if(!empty($_POST)){
        //必須項目
        $last_name = $_POST['last_name'];
        $first_name = $_POST['first_name'];
        $area_id = $_POST['area'];
        $city = $_POST['city'];
        $station = $_POST['station'];
        $category_id = $_POST['category'];
        $past = $_POST['past'];
        // 任意項目
        $nickname = $_POST['nickname'];
        $category_other = $_POST['category_other'];
        $profile = $_POST['profile'];

        // 必須項目のバリデーション
        $user_prof_infos = ['last_name'=>$last_name, 'first_name'=>$first_name, 'area_id'=>$area_id, 'city'=>$city, 'station'=>$station, 'category_id'=>$category_id, 'past'=>$past];

        foreach ($user_prof_infos as $index => $user_prof_info) {
            if ($user_prof_info == '') {
                $validations[$index] = 'blank';
            }
        }

        // 画像ネーム取得
        $file_name = $_FILES['img_name']['name'];

        // 必須項目入力済みの場合の処理
        if(empty($validations)) {

            if ($_FILES['img_name']['name'] != '') {
                $file_name = date('YmdHis') .$_FILES['img_name']['name'];
                $tmp_file = $_FILES['img_name']['tmp_name'];
                $destination = 'user_profile_img/'.$file_name;
                move_uploaded_file($tmp_file, $destination);
            }else{
                $file_name = '';
            }

            // profile_tへデータ登録
            $sql='INSERT INTO `profiles_t` SET `user_id`=?, `nickname`=?, `img_name`=?, `area_id`=?, `city`=?, `station`=?, `past`=?, `profile`=?, `created`=NOW()';
            $stmt = $dbh->prepare($sql);
            $data = array($signin_user['id'],$nickname, $file_name, $area_id, $city, $station, $past, $profile);
            $stmt->execute($data);

            // user_categoriesへデータ登録
            $user_categories_sql='INSERT INTO `user_categories` SET `user_id`=?, `category_id`=?, `created`=NOW()';
            $user_categories_stmt = $dbh->prepare($user_categories_sql);
            $user_categories_data = array($signin_user['id'], $category_id);
            $user_categories_stmt->execute($user_categories_data);


            header('Location: top_t.php');
            exit();
        }


    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>講師 プロフィール編集</title>
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

  <div class="text-center">
      <span class="error_msg"><?php echo result($validations,'first_name','姓') ?></span><br>
      <span class="error_msg"><?php echo result($validations,'last_name','名') ?></span><br>
      <span class="error_msg"><?php echo result($validations,'city','市区町村') ?></span><br>
      <span class="error_msg"><?php echo result($validations,'station','最寄り駅') ?></span><br>
      <span class="error_msg"><?php echo result($validations,'past','※経歴／資格') ?></span><br>
      <span class="error_msg"><?php echo select_result($validations,'area_id','都道府県') ?></span><br>
      <span class="error_msg"><?php echo select_result($validations,'category_id','料理ジャンル') ?></span>
  </div>

  <div class="edit_content text-center">
    <form method="POST" action="" enctype="multipart/form-data">
      <div class="row">
        <!-- プロフィール画像（任意） -->
        <div class="col-md-4">
          <?php if ($file_name == ''): ?>
            <img id="img1" src="img/profile_img_defult.png" style="width:160px;height:160px;border-radius: 50%;">
          <?php else: ?>
            <img id="img1" src="user_profile_img/<?php echo $first_name ?>" style="width:160px;height:160px;border-radius: 50%;">
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
          <!-- 名前-->
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <input id="last_name" name="last_name" type="text" placeholder="姓" class="form-control input-md" value="<?php echo $first_name ?>">
              </div>
              <div class="col-md-4">
                <input id="first_name" name="first_name" type="text" placeholder="名" class="form-control input-md" value="<?php echo $last_name ?>">
              </div>
            </div>
          </div>

          <!-- ニックネーム -->
          <div class="form-group">
            <div class="row">
              <div class="col-md-9">
               <input id="nickname" name="nickname" type="text" placeholder="ニックネーム(任意)"" class="form-control input-md" value="<?php echo $nickname ?>">
              </div>
            </div>
          </div>

          <!-- メールアドレスを表示（ここでは変更不可） -->
          <div class="row">
            <p class="col-md-8 check_content"><?php echo $signin_user['email'] ?></p>
          </div>

          <!-- 都道府県選択 -->
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <select id="area" name="area" class="form-control">
                  <option value="">選択してください。</option>
                  <?php while(1): ?>
                    <?php  $areas = $areas_stmt->fetch(PDO::FETCH_ASSOC); ?>
                    <?php if ($areas == false): ?>
                      <?php break; ?>
                      <?php else: ?>
                        <option value="<?php echo $areas['id']?>"><?php echo $areas['name'] ?></option>
                    <?php endif ?>
                  <?php endwhile ?>
                </select>
              </div>
              <!-- 市町村入力 -->
              <div class="col-md-4">
                <input id="city" name="city" type="text" placeholder="市区町村" class="form-control input-md" value="<?php echo $city ?>">
              </div>
              <!-- 最寄り駅 -->
              <div class="col-md-4">
                <input id="station" name="station" type="text" placeholder="最寄り駅" class="form-control input-md" value="<?php echo $station ?>">
              </div>
            </div>
          </div>
          <!-- ジャンル -->
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <select id="category" name="category" class="form-control">
                  <option value="">選択してください。</option>
                  <?php while(1): ?>
                    <?php  $categories = $categories_stmt->fetch(PDO::FETCH_ASSOC); ?>
                    <?php if ($categories == false): ?>
                      <?php break; ?>
                      <?php else: ?>
                      <option value="<?php echo $categories['id'];?>"><?php echo $categories['category_name'] ?></option>
                    <?php endif ?>
                  <?php endwhile; ?>
                </select>
              </div>
              <!-- その他ジャンル -->
              <div class="col-md-6">
                <input id="category_other" name="category_other" type="text" placeholder="その他ジャンル" class="form-control input-md" value="<?php echo $category_other ?>">
              </div>
            </div>
          </div>

          <!-- 経歴・資格入力 -->
          <div class="form-group">
            <label class="col-md-4 control-label" for="career"></label>
            <div class="col-md-14">
              <textarea class="form-control" id="past" name="past" placeholder="※経歴／資格" style="height: 100px;"><?php echo $past;?></textarea>
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

</body>