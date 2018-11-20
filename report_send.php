<?php 

    session_start();
    require('dbconnect.php');
    require('functions.php');
    $sql = 'SELECT * FROM `profiles_s` WHERE `user_id`=?';
    $data = array($_SESSION['EATY']['id']);

    var_dump($_SESSION['EATY']['id']);

    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

    v($signin_user,'signin_user');

    $validations = [];

    if (!empty($_POST)) {
      $post_time = $_POST['post_time'];

      if($post_time == ''){
        $validations['post_time'] = 'etsuko';

      }
    }

    if (!empty($_POST)) {
      $feed = $_POST['feed'];
      if($feed == ''){
        $validations['feed'] = 'etsuko';
      }
    }

    $report_img_name = $_POST['report_img_name'];
    $feed = $_POST['feed'];

    if (!empty($_POST)) {
      $sql = 'INSERT INTO `reports` SET `user_id`=?, `img_name`=?, `feed`=?,
      `created`=NOW(), `updated`=NOW()';
      $data = array($signin_user['id'],$report_img_name,$feed,);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
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
      <a href="#"><img src="img/logo.jpg" width="90"></a>
    </div>
  </header>

    <div class="container text-center">
      <div class="text-center">
        <form method="POST" action="">
          <div class="row">
            <div class="col-md-12">
              <img src="user_profile_img/<?php echo $signin_user['img_name']; ?>" style="width:100px;height:100px;border-radius: 50%;">
              <p><?php echo $signin_user['nickname']; ?></p>
              <div class="form-group">
                <input id="textinput" name="post_time" type="text" placeholder="投稿日" class="form-control input-md col-md-5" style="display: inline-block;">
                <!--箱があるかないか確認するisset先生-->
                <?php if(isset($validations['post_time']) && $validations['post_time'] == 'etsuko'): ?>
                  <br>
                  投稿日を入力してください
                <?php endif; ?>
              </div>
               <label class="filelabel_create">
                <img id="img2" src="https://placehold.jp/130x100.png" style="width:130px;height:100px;">
                <input type="file" class="filesend" id="filesend_1" name="report_img_name" accept="image/*">
              </label>
              <div class="text-center">
                <textarea class="form-control col-md-5" id="textarea" name="feed" placeholder="一言コメント" style="height: 90px; display: inline-block;"></textarea>
                <?php if(isset($validations['feed']) && $validations['feed'] == 'etsuko'): ?>
                  <br>
                  コメントを入力してください
                <?php endif; ?>
              </div>
                <div class="text-center"><input type="submit" value="この内容で投稿" class="btn btn-primary mt-3" style="width:200px;"></div>
            </div>
          </div>
        </form>
    
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