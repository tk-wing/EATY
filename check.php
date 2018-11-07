<!DOCTYPE html>
<html lang="ja">
<head>
  <title>登録内容確認</title>
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
      <a href="#"><img src="img/eatylogo.png" width="100"></a>
    </div>
  </header>

  <div class="text-center container">

    <p class="title font-weight-bold">新規登録内容確認</p>


    <div class="check">
      <h3 class="text-success">登録タイプ</h3>
      <p class="check_content">名前</p>
      <p class="check_content">メールアドレス</p>
      <p class="check_content">パスワード</p>
    </div>

    <form class="signup_form" method="POST" action="">

      <!-- Button -->
      <div class="form-group">
        <input type="button" value="戻る" class="check_btn btn btn-primary" style="width:100px;">
        <input type="submit" value="登録" class="check_btn btn btn-primary" style="width:100px;">
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
</html>