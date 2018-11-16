<!DOCTYPE html>
<html>
<head>
  <title>つくれぽ投稿</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="css/stylesheet.css">
  
  <!-- BootstrapのCSS読み込み -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- BootstrapのJS読み込み -->
  <script src="js/bootstrap.min.js"></script>
  <!-- FontAwesome読み込み -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
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
              <img id="img1" src="https://placehold.jp/100x100.png" style="width:100px;height:100px;border-radius: 50%;">
              <p>○○○さんのつくれぽ</p>
              <div class="form-group">
                <input id="textinput" name="textinput" type="text" placeholder="投稿日" class="form-control input-md col-md-5" style="display: inline-block;">
              </div>
                <div>
                <img id="img1" src="https://placehold.jp/160x130.png" style="width:160px;height:100px;">
                </div>
              <div class="text-center">
                <textarea class="form-control col-md-5" id="textarea" name="textarea" style="height: 90px; display: inline-block;">一言コメント</textarea>
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