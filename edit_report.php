<?php
    require('dbconnect.php');
    require('functions.php');

    $report_each = $_GET["report_each"];

    $sql = "SELECT `reports`.*,`profiles_s`.`nickname`,`profiles_s`.`img_name` AS `profile_img` FROM `reports` LEFT JOIN `profiles_s` ON `reports`.`user_id`=`profiles_s`.`id` WHERE `reports`.`id`=$report_each";
    $data = array($report_each);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);


    //更新処理（更新ボタンが押されたときの処理）
    if (!empty($_POST)) {
        $update_sql = "UPDATE `reports` SET `feed` = ? WHERE `reports`.`id`=?";
        $data = array($_POST["feed"],$_POST["report_id"]);
        //sql文の実行
        $stmt = $dbh->prepare($update_sql);
        $stmt->execute($data);

        //つくれぽ一覧へ遷移
        header("Location: report.php");
        exit();
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
          $("#img2").attr("src", e.target.result);
          $("#img2").attr("title", file.name);
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
        <form method="POST" action="">
          <div class="row">
            <div class="col-md-12">
              <?php if ($signin_user['profile_img'] == ''): ?>
                <img id="img1" src="img/profile_img_defult.png" style="width:160px;height:160px;border-radius: 50%;">
              <?php else: ?>
                <img src="user_profile_img/<?php echo $signin_user['profile_img']; ?>" style="width:100px;height:100px;border-radius: 50%;">
              <?php endif ?>
              <p><?php echo $signin_user['nickname']; ?></p>
              <!-- <div class="form-group">
              </div> -->
               <label class="filelabel_create">
                <img id="img2" src="user_report_img/<?php echo $signin_user["img_name"]; ?>" style="width:130px;height:100px;">
                <input type="file" class="filesend" id="filesend_1" name="report_img_name" accept="image/*">
              </label>
              <div class="text-center">
                <textarea class="form-control col-md-3" id="textarea" name="feed" placeholder="一言コメント" style="height: 90px; display: inline-block;"><?php echo $signin_user["feed"]; ?></textarea>
                <!--箱があるかないか確認するisset先生-->
                <?php if(isset($validations['feed']) && $validations['feed'] == 'etsuko'): ?>
                  <br>
                  コメントを入力してください
                <?php endif; ?>
              </div>
                <div class="text-center"><input type="hidden" name="report_id" value="<?php echo $signin_user["id"]; ?>"><input type="submit" value="更新する" class="btn btn-warning mt-3" style="width:200px;"></div>
            </div>
          </div>
        </form>
    
      </div>
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