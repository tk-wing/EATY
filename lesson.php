<!DOCTYPE html>
<html lang="ja">
<head>
  <title>レッスン詳細</title>
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

  <div class="lesson_content text-center">
    <div class="blog-inner-prof text-center">
      <h3>レッスン名</h3>
      <img class="lesson_img" src="https://placehold.jp/300x200.png" style="width:300px;height:200px;">
      <img class="lesson_img" src="https://placehold.jp/300x200.png" style="width:300px;height:200px;"><br>
      <img class="lesson_img" src="https://placehold.jp/300x200.png" style="width:300px;height:200px;">
      <img class="lesson_img" src="https://placehold.jp/300x200.png" style="width:300px;height:200px;">

      <div class="row contents">
          <div class="col-md-4">
            <span><i class="far fa-calendar-alt fa-2x icon"></i>日時</span>
          </div>
          <div class="col-md-4">
            <span><i class="fas fa-train fa-2x icon"></i>最寄り駅</span>
          </div>
          <div class="col-md-4">
            <span><i class="fas fa-yen-sign fa-2x icon"></i>料金</span>
          </div>
      </div>

      <div class="row content_border">
        <div class="col-md-6" style="border-right: 1px solid #ccc;">
          <span>メニュー数</span>
        </div>
        <div class="col-md-6">
          <span>所要時間</span>
        </div>
      </div>

      <div>
        <ul>
          <li>メニュー内容</li>
          <li>メニュー内容</li>
          <li>メニュー内容</li>
          <li>メニュー内容</li>
          <li>メニュー内容</li>
          <li>メニュー内容</li>
        </ul>
      </div>

      <div class="contents">
        <h4>レッスン詳細</h4>
      </div>

      <ul class="contents" id="lesson-list">
          <li class="lesson-list-item">
            <h3>持ち物</h3>
            <span>+</span>
            <div class="inner">
              <p>持ち物を表示</p>
            </div>
          </li>
          <li class="lesson-list-item">
            <h3>注意事項</h3>
            <span>+</span>
            <div class="inner">
              <p>注意事項を表示</p>
            </div>
          </li>
        </ul>

        <form method="POST" action="">
          <a href="#"><button type="button" class="btn btn-primary">予約する</button></a><br>
          <button type="button" class="btn btn-secondary"><i class="fas fa-heart" style="color: #F76AC0"></i></button>
          <button type="button" class="btn btn-secondary"><i class="fas fa-star text-warning"></i></button>
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

  <script src="js/app.js"></script>
</body>

  </html>