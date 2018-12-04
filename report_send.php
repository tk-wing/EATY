<?php
    session_start();
    require('dbconnect.php');
    require('functions.php');

    // ユーザー情報を取得
    $sql='SELECT `users`.*, `profiles_s`.`nickname`, `profiles_s`.`img_name` FROM `users` LEFT JOIN `profiles_s` ON `users`.`id` = `profiles_s`.`user_id` WHERE `users`.`id`=?';
    $stmt = $dbh->prepare($sql);
    $data = array($_SESSION['EATY']['id']);
    $stmt->execute($data);
    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

    // 受講歴を取得
    $tag_sql = 'SELECT * FROM `reservations` WHERE `student_id`=?'
    $tag_stmt $dbh->prepare($tag_sql);
    $tag_data = [$signin_user['id']];
    $tag_stmt->execute($tag_data);

    while (1) {
        $tag = $tag_stmt->fetch(PDO::FETCH_ASSOC);
        if ($tag == FALSE) {
            break;
        }
        $sql='SELECT `users`.*, `profiles_s`.`nickname`, `profiles_s`.`img_name` FROM `users` LEFT JOIN `profiles_s` ON `users`.`id` = `profiles_s`.`user_id` WHERE `users`.`id`=?';
          $stmt = $dbh->prepare($sql);
          $data = array($_SESSION['EATY']['id']);
          $stmt->execute($data);
          $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

    }

    //ニックネームが登録されていない場合
    if (empty($signin_user['nickname'])) {
        $name = $signin_user['last_name'] . '　' . $signin_user['first_name'];
    } else {
        $name = $signin_user['nickname'];
    }
    // 以下登録任意項目
    $img_name = $signin_user['img_name'];

    $validations = [];


    if (!empty($_POST)) {
        $report_img_name = $_FILES['report_img_name']['name'];
        $feed = $_POST['feed'];

        if($feed == ''){
          $validations['feed'] = 'blank';
        }

        if ($report_img_name == '') {
            $validations['report_img_name'] = 'blank';
        }

        if (empty($validations)) {
            $report_img_name = date('YmdHis') .$report_img_name;
            $tmp_file = $_FILES['report_img_name']['tmp_name'];
            $destination = 'user_report_img/'.$report_img_name;
            move_uploaded_file($tmp_file, $destination);

            $sql = 'INSERT INTO `reports` SET `user_id`=?, `img_name`=?, `feed`=?,`created`=NOW()';
            $data = array($signin_user['id'],$report_img_name,$feed,);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);

            header('Location: report.php');
            exit();
        }

    }


 ?>

<!DOCTYPE html>
<html>
<head>
  <title>つくれぽ投稿</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!--stylesheetのCSS読み込み -->
  <link rel="stylesheet" href="css/stylesheet.css">
  <link rel="stylesheet" href="css/stylesheet_t.css">

  <!-- BootstrapのCSS読み込み -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- BootstrapのJS読み込み -->
  <script src="js/bootstrap.min.js"></script>
  <!-- FontAwesome読み込み -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">


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
</script>
</head>



<body>
  <header>
    <div class="text-center">
      <a href='#' data-toggle="modal" data-target="#demoNormalModal"><img src="img/eatylogo.png" width="100"></a>
    </div>
  </header>

    <div class="container text-center">
      <div class="text-center">
        <form method="POST" action="" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-12">
              <?php if ($signin_user['img_name'] == ''): ?>
                <img src="img/profile_img_defult.png" style="width:160px;height:160px;border-radius: 50%;">
              <?php else: ?>
                <img src="user_profile_img/<?php echo $signin_user['img_name']; ?>" style="width:100px;height:100px;border-radius: 50%;">
              <?php endif ?>
              <p><?php echo $name; ?></p>
              <!-- <div class="form-group">

              </div> -->
              <img id="img1" src="https://placehold.jp/130x100.png" style="width:130px;height:100px;"><br>
              <label class="filelabel_create">
                <input type="file" class="filesend" id="filesend_1" name="report_img_name" accept="image/*">
                <span class="filelabel" title="ファイルを選択">
                  <i class="fas fa-camera-retro"></i>
                  選択
                </span>
              </label>
              <div class="text-center">
                <textarea class="form-control col-md-3" id="textarea" name="feed" placeholder="一言コメント" style="height: 90px; display: inline-block;"></textarea>
                <!--箱があるかないか確認するisset先生-->
                <?php if(isset($validations['feed']) && $validations['feed'] == 'blank'): ?>
                  <br>
                  コメントを入力してください
                <?php endif; ?>
              </div>

                <div class="text-center">
                <label class="col-md-4 control-label" for="tag">講師をタグ付けする<br>(受講歴のある講師を選択できます)</label><br>
                  <select id="tag" name="tag" class="form-control col-md-3" style="display: inline-block;">
                    <option value="1">Option one</option>
                    <option value="2">Option two</option>
                  </select>
                </div>

              <div class="text-center"><input type="submit" value="この内容で投稿" class="btn btn-primary mt-3" style="width:200px;"></div>

            </div>
          </div>
        </form>

      </div>

      <!-- メニュー -->
      <div class="modal fade" id="demoNormalModal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-body text-center">
                      <p>メニュー</p>
                  </div>
                  <div class="modal-footer text-center" style="display: inline-block;">
                      <a href="top_s.php"><button type="button" class="btn btn-primary">マイページへ</button></a>
                      <a href="serch_s.php"><button type="button" class="btn btn-primary">レッスン検索</button></a>
                      <a href="signout.php"><button type="button" class="btn btn-danger">ログアウト</button></a>
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

  <!-- jQuery、Popper.js、Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- <script src="assets/js/app.js"></script> -->

</body>
</html>