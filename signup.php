<!DOCTYPE html>
<html lang="ja">
<head>
  <title>新規登録</title>
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
    <p class="title font-weight-bold">新規登録</p>
    <form class="signup_form" method="POST" action="">

    <!-- Text input-->
    <div class="form-group" >
      <input name="given_name" type="text" placeholder="姓" class="form-control" style="width:200px; display: inline-block; ">
    </div>

      <!-- Text input-->
      <div class="form-group">
        <input name="family_name" type="text" placeholder="名" class="form-control" style="width:200px; display: inline-block;">
      </div>

      <!-- Text input-->
      <div class="form-group">
        <input name="email" type="text" placeholder="メールアドレス" class="form-control" style="width:200px; display: inline-block;">
      </div>

      <!-- Password input-->
      <div class="form-group">
        <input name="pw" type="password" placeholder="パスワード" class="form-control" style="width:200px; display: inline-block;">
      </div>

      <!-- Password input-->
      <div class="form-group">
        <input name="pw_check" type="password" placeholder="パスワード再入力" class="form-control" style="width:200px; display: inline-block;">
      </div>

      <div class="form-group">
        <input type="radio" name="type" id="type-0" value="講師" checked="checked">
        講師
        <input type="radio" name="type" id="type-1" value="生徒">
        生徒
      </div>

      <!-- Button -->
      <div class="form-group">
        <input type="submit" value="確認" class="btn btn-primary" style="width:100px;">
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