<!DOCTYPE html>
<html lang="ja">
<head>
  <title>レッスン予約</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

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

</head>

<body>
  <header>
    <div class="text-center">
      <a href="#"><img src="img/eatylogo.png" width="100"></a>
    </div>
  </header>

  <div class="bkg_content">

    <div class="blog-inner-prof text-center">
        <div>
          <h4 class="title_1">レッスン名</h4>
          <p class="title_1">日時: 2018/11/30 14：00～</p>
          <p class="title_1">料金: ¥5000/一人</p>
          <p class="title_1">注意事項: レッスンは男性限定です！</p>
        </div>

        <div class="title_2">
          <div class="row">
            <div class="col-5 text-right">
              <span>お名前</span><br>
              <span>○○○○</span>
            </div>
            <div class="col-2"></div>
            <div class="col-5 text-left">
              <span>メールアドレス</span>
              <p>●●●●＠gmail.com</p>
            </div>
          </div>
        </div>

        <form method="POST" action="">
          <div class="form-group title_1">
              <p>○○○○さん(講師)へのメッセージ</p>
              <textarea class="form-control col-md-8" name="attention" style="height: 100px; display: inline-block;"></textarea>
          </div>

          <div class="form-group">
            <p>お支払い方法</p>
            <select id="pref" name="pref" class="form-control col-md-4" style="display: inline-block;">
              <option value="1">クレジットカード</option>
            </select>
          </div>

          <input type="submit" class="btn btn-primary mt-5" value="完了">
        </form>

        <div class="mt-5">
          <p>お支払いが確定したら、詳細の情報（講師の連絡先、会場の住所、地図等）をお送りします。</p>
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

  </body>

</html>