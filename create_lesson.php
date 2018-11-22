<?php
       //SESSIONの有効化
    session_start();

    //データベースとの接続
    require('dbconnect.php');
    require('functions.php');

    $validations = [];

    v($_FILES,'$_FILES');

    v($_POST,'$_POST');

    // ユーザー情報を取得
    $sql='SELECT * FROM `users` WHERE `id`=?';
    $stmt = $dbh->prepare($sql);
    $data = array($_SESSION['EATY']['id']);
    $stmt->execute($data);

    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

    // カテゴリー情報を取得
    $categories_sql='SELECT * FROM `categories`';
    $categories_stmt = $dbh->prepare($categories_sql);
    $categories_sql_data = [];
    $categories_stmt->execute($categories_sql_data);

 



  //バリデーションの設定と変数定義
if (!empty($_POST)) {
    $day = $_POST['day'];
    $daytime = $_POST['daytime'];
    $station = $_POST['station'];
    $fee = $_POST['fee'];
    $requiretime = $_POST['requiretime'];
    $category_id = $_POST['category_id'];
    $menu = $_POST['menu'];
    $capacity = $_POST['capacity'];
    $basic = $_POST['basic'];
    $lesson_name = $_POST['lesson_name'];
    $menudetail = $_POST['menudetail'];
    $bring = $_POST['bring'];
    $precaution = $_POST['precaution'];

    //バリデーション
      if ($day == '') {
        $validations['day'] = 'blank';
    }
      if ($daytime == '') {
        $validations['daytime'] = 'blank';
    }
     if ($station == '') {
        $validations['station'] = 'blank';
    }
     if ($fee == '') {
        $validations['fee'] = 'blank';
    }
     if ($requiretime == '') {
        $validations['requiretime'] = 'blank';
    }
     if ($category_id == '') {
        $validations['category_id'] = 'blank';
    }
     if ($menu == '') {
        $validations['menu'] = 'blank';
    }
     if ($capacity == '') {
        $validations['capacity'] = 'blank';
    }
     if ($basic == '') {
        $validations['basic'] = 'blank';
    }
    //下の項目
    if ($lesson_name =='') {
        $validations['lesson_name'] = 'blank';
    }
    if ($menudetail == '') {
        $validations['menudetail']='blank';
    }

    if ($bring == '') {
        $validations['bring']='blank';
    }

    if ($precaution == '') {
        $validations['precaution']='blank';
    }

    //画像のバリデーション
    $img_1 = $_FILES['img_1']['name'];
    $img_2 = $_FILES['img_2']['name'];
    $img_3 = $_FILES['img_3']['name'];
    $img_4 = $_FILES['img_4']['name'];

    if ($img_1 =='' & $img_2 =='' & $img_3 =='' & $img_4 =='') {
        $validations['img_1']='blank';
        //ファイルの空チェク
        $validations['img_2']='blank';
        $validations['img_3']='blank';
        $validations['img_4']='blank';
    }
    //     //レッスン作成が適切に入力されていた場合
        if ($_FILES['img_1']['name']) {
          $file_name1 = date('YmdHis') .$_FILES['img_1']['name'];
            $tmp_file = $_FILES['img_1']['tmp_name'];
            $destination = 'users_lesson_img/'.$file_name1;
            move_uploaded_file($tmp_file, $destination);
        }
         if ($_FILES['img_2']['name']) {
          $file_name2 = date('YmdHis') .$_FILES['img_2']['name'];
            $tmp_file = $_FILES['img_2']['tmp_name'];
            $destination = 'users_lesson_img/'.$file_name2;
            move_uploaded_file($tmp_file, $destination);
        }
         if ($_FILES['img_3']['name']) {
          $file_name3 = date('YmdHis') .$_FILES['img_3']['name'];
            $tmp_file = $_FILES['img_3']['tmp_name'];
            $destination = 'users_lesson_img/'.$file_name3;
            move_uploaded_file($tmp_file, $destination);
        }
         if ($_FILES['img_4']['name']) {
          $file_name4 = date('YmdHis') .$_FILES['img_4']['name'];
            $tmp_file = $_FILES['img_4']['tmp_name'];
            $destination = 'users_lesson_img/'.$file_name4;
            move_uploaded_file($tmp_file, $destination);
        }

        // if ($_FILES['img_name']['name'] != '') {
        //     $file_name = date('YmdHis') .$_FILES['img_name']['name'];
        //     $tmp_file = $_FILES['img_name']['tmp_name'];
        //     $destination = 'user_profile_img/'.$file_name;
        //     move_uploaded_file($tmp_file, $destination);
        if (empty($validations)) {
         //格項目
         $_SESSION['EATY']['day']  = $day;
         $_SESSION['EATY']['daytime']  = $daytime;
         $_SESSION['EATY']['station']  = $station;
         $_SESSION['EATY']['fee']  = $fee;
         $_SESSION['EATY']['requiretime']  = $requiretime;
         $_SESSION['EATY']['category_id']  = $capacity;
         $_SESSION['EATY']['menu']  = $menu;
         $_SESSION['EATY']['capacity']  = $capacity;
         $_SESSION['EATY']['basic']  = $basic;
         $_SESSION['EATY']['lesson_name']  = $lesson_name;
         $_SESSION['EATY']['menudetail']  = $menudetail;
         $_SESSION['EATY']['bring']  = $bring;
         $_SESSION['EATY']['precaution']  = $precaution;
         //画像
         $_SESSION['EATY']['img_1']  = $file_name1;
         $_SESSION['EATY']['img_2']  = $file_name2;
         $_SESSION['EATY']['img_3']  = $file_name3;
         $_SESSION['EATY']['img_4']  = $$file_name4;

         header('Location: create_check_t.php');
         exit();
        }
        
}
    
    

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>レッスン作成</title>
  <meta charset="utf-8">
   <!-- エラーメッセージカラー -->
   <style>
    .error_msg{
      color: red;
      font-size: 12px;
    }
  </style>
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
    $('#filesend_1').change(function(e){
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

  $(function(){
    $('#filesend_2').change(function(e){
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
          $("#img2").attr("src", e.target.result);
          $("#img2").attr("title", file.name);
        };
      })(file);
      reader.readAsDataURL(file);
   
    });
  });

  $(function(){
    $('#filesend_3').change(function(e){
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
          $("#img3").attr("src", e.target.result);
          $("#img3").attr("title", file.name);
        };
      })(file);
      reader.readAsDataURL(file);
   
    });
  });

  $(function(){
    $('#filesend_4').change(function(e){
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
          $("#img4").attr("src", e.target.result);
          $("#img4").attr("title", file.name);
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

  <form class="signup_form" method="POST" action="" enctype="multipart/form-data">
    <!-- enctype=multipart/form-dataを加えた。何からのファイルを表示、また＄_FILEを使う為 -->

  <div class="wrapper">

    <div class="blog-inner-prof text-center">
        <div class="row">
          <div class="col-md-4 text-center">
            <div class="row">
              <div class="col text-right">
                <label class="filelabel_create">
                <img id="img1" src="https://placehold.jp/130x100.png" style="width:130px;height:100px;">
                <input type="file" class="filesend" id="filesend_1" name="img_1" accept="image/*">
                </label>
              </div>

              <div class="col text-left">
                <label class="filelabel_create">
                <img id="img2" src="https://placehold.jp/130x100.png" style="width:130px;height:100px;">
                <input type="file" class="filesend" id="filesend_2" name="img_2" accept="image/*">
                </label>
              </div>
            </div>

            <div class="row">
              <div class="col text-right">
                <label class="filelabel_create">
                <img id="img3" src="https://placehold.jp/130x100.png" style="width:130px;height:100px;">
                <input type="file" class="filesend" id="filesend_3" name="img_3" accept="image/*">
                </label>
              </div>

              <div class="col text-left">
                <label class="filelabel_create">
                <img id="img4" src="https://placehold.jp/130x100.png" style="width:130px;height:100px;">
                <input type="file" class="filesend" id="filesend_4" name="img_4" accept="image/*">
                </label>
              </div>
            </div>
            <!-- *で画像しか選択できません -->
            <?php if(isset($validations['img_1']) && $validations['img_1'] == 'blank'): ?>
              <span class="error_msg">１つは画像を入れてください</span>
            <?php endif?>
          </div>


          <div class="col-md-4 text-center">
            <div class="row">
              <div class="col-md-3">
                <span style="line-height: 40px;">開催日</span>
              </div>
              <div class=col-md-9>
                <div class="form-group">
                  <div class="col-md-9">
                  <input id="name" name="day" type="date" placeholder="" class="form-control input-md">
                  <?php if(isset($validations['day'])&& $validations['day']=='blank'): ?>
                  <span class="error_msg">開催日を指定してください</span>
                  <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <span style="line-height: 40px;">開催時間</span>
              </div>
              <div class=col-md-9>
                <div class="form-group">
                  <div class="col-md-9">
                  <input id="name" name="daytime" type="time" placeholder="" class="form-control input-md">
                  <?php if(isset($validations['daytime'])&& $validations['daytime']=='blank'): ?>
                  <span class="error_msg">開催時間を指定してください</span>
                  <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <span style="line-height: 40px;">最寄駅</span>
              </div>
              <div class=col-md-9>
                <div class="form-group">
                  <div class="col-md-9">
                  <input id="name" name="station" type="text" placeholder="" class="form-control input-md">
                  <?php if(isset($validations['station'])&& $validations['station']=='blank'): ?>
                  <span class="error_msg">最寄駅を指定してください</span>
                  <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <span style="line-height: 40px;">料金</span>
              </div>
              <div class=col-md-9>
                <div class="form-group">
                  <div class="col-md-9">
                  <input id="name" name="fee" type="text" placeholder="" class="form-control input-md">
                  <?php if(isset($validations['fee'])&& $validations['fee']=='blank'): ?>
                  <span class="error_msg">料金を指定してください</span>
                  <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <span style="line-height: 40px;">所要時間</span>
              </div>
              <div class=col-md-9>
                <div class="form-group">
                  <div class="col-md-9">
                  <input id="name" name="requiretime" type="time" placeholder="" class="form-control input-md">
                  <?php if(isset($validations['requiretime'])&& $validations['requiretime']=='blank'): ?>
                  <span class="error_msg">所要時間を指定してください</span>
                  <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="col-md-4 text-center">
            <div class="row">
              <div class="col-md-3">
                <span style="line-height: 40px;">カテゴリ</span>

              </div>
              <div class=col-md-9>
                <div class="form-group">
                  <div class="col-md-9">
                  <!-- <input id="name" name="category_id" type="text" placeholder="" class="form-control input-md"> -->
                  <select id="category" name="category_id" class="form-control">
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

                  <?php if(isset($validations['category_id'])&& $validations['category_id']=='blank'): ?>
                  <span class="error_msg">カテゴリーを指定してください</span>
                  <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3" style="font-size: 15px;">
                <span style="line-height: 40px;">メニュー数</span>
              </div>
              <div class=col-md-9>
                <div class="form-group">
                  <div class="col-md-9">
                  <input id="name" name="menu" type="text" placeholder="" class="form-control input-md">
                  <?php if(isset($validations['menu'])&& $validations['menu']=='blank'): ?>
                  <span class="error_msg">メニュー数を指定してください</span>
                  <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <span style="line-height: 40px;">定員</span>
              </div>
              <div class=col-md-9>
                <div class="form-group">
                  <div class="col-md-9">
                  <input id="name" name="capacity" type="text" placeholder="" class="form-control input-md">
                  <?php if(isset($validations['capacity'])&& $validations['capacity']=='blank'): ?>
                  <span class="error_msg">定員を指定してください</span>
                  <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3" style="font-size: 12px;">
                <span style="line-height: 40px;">最小催行人数</span>
              </div>
              <div class=col-md-9>
                <div class="form-group">
                  <div class="col-md-9">
                  <input id="name" name="basic" type="text" placeholder="" class="form-control input-md">
                  <?php if(isset($validations['basic'])&& $validations['basic']=='blank'): ?>
                  <span class="error_msg">最小遂行人数を指定してください</span>
                  <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4 text-center">
            <div class="form-group">
              <label class="col-md-4 control-label" for="career"></label>
              <div class="col-md-14">
                <textarea class="form-control" name="lesson_name" placeholder="レッスン名" style="height: 100px;"></textarea>
                <?php if(isset($validations['lesson_name'])&& $validations['lesson_name']=='blank'): ?>
                  <span class="error_msg">レッスン名を入力してください</span>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="col-md-8 text-center">
            <div class="form-group">
              <label class="col-md-4 control-label" for="career"></label>
              <div class="col-md-14">
                <textarea class="form-control" name="menudetail" placeholder="メニュー概要" style="height: 100px;"></textarea>
                <?php if(isset($validations['menudetail'])&& $validations['menudetail']=='blank'): ?>
                  <span class="error_msg">メニュー概要を入力してください</span>
                <?php endif; ?>

              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 text-center">
            <div class="form-group">
              <label class="col-md-4 control-label" for="career"></label>
              <div class="col-md-14">
                <textarea class="form-control" name="bring" placeholder="持ち物" style="height: 100px;"></textarea>
                <?php if(isset($validations['bring'])&& $validations['bring']=='blank'): ?>
                  <span class="error_msg">持ち物を記入してください</span>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="col-md-6 text-center">
            <div class="form-group">
              <label class="col-md-4 control-label" for="career"></label>
              <div class="col-md-14">
                <textarea class="form-control" name="precaution" placeholder="注意事項" style="height: 100px;"></textarea>
                <?php if(isset($validations['precaution'])&& $validations['precaution']=='blank'): ?>
                  <span class="error_msg">注意事項を入力してください</span>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <input type="submit" class="btn btn-primary" value="レッスン登録">

    </div>

   </div>
</form>
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