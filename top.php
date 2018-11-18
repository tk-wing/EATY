<!DOCTYPE html>
<html lang="ja">
<head>
  <title>ex chef</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="css/stylesheet_top.css">
  <!-- BootstrapのCSS読み込み -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- BootstrapのJS読み込み -->
  <script src="js/bootstrap.min.js"></script>
  <!-- FontAwesome読み込み -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
  <!-- Theme style  -->
  <link rel="stylesheet" href="css/style.css">
  <!-- Modernizr JS -->
  <script src="js/modernizr-2.6.2.min.js"></script>
  <!-- viewport meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>

  <!-- ヘッダー -->
  <header>
    <button type="button" class="btn btn-light my-btn">TOP</button>
    <div class="sns">
      <a href="" class="btn-facebook sns-btn"><i class="fab fa-facebook fa-2x"></i></a>
      <a href="" class="btn-twitter sns-btn"><i class="fab fa-twitter fa-2x"></i></a>
      <a href="" class="btn-instagram sns-btn"><i class="fab fa-instagram fa-2x"></i></a>
    </div>
  </header>

  <!-- TOP上部・３つのボタン・コンセプト -->
  <div class="top wrapper">
    <!-- TOP上部 -->
    <div class="container-flued" style="background-image: url(img/top2.jpg); height: 800px; background-size:cover;">
      <img class="mx-auto d-block"src="img/logo2.png" width="300">

      <a href="signup.php"><button type="button" class="mx-auto d-block btn btn-outline-dark my-btn-signup">新規登録</button></a>
    

    <!-- 3つのボタン -->
    <div class="row top-content">
      <div class="col text-center area aboutus">
        <a href="#aboutus"><button type="button" class="btn btn-outline-dark">about us</button></a>
      </div>
      <div class="col text-center area signin">
        <a href="signin.php"><button type="button" class="btn btn-outline-dark">ログイン</button></a>
      </div>
      <div class="col text-center area serch">
      <button type="button" class="btn btn-outline-dark">レッスン検索</button>
      </div>
    </div>
    </div>
    <!-- コンセプト -->
    <div class="concept" id="aboutus">
      <div class="text-center title">about us</div>
      <div class="container">
        <div class="text-center">
          <a class="circle">教えたいexchef</a>
          <a class="text-center maltiply">×</a>
          <a class="circle">習いたいYOU</a>
        </div>
      </div>
    </div>

  </div>


  <!-- レッスン紹介 -->
  <div class="middle wrapper">
    <div class="text-center title">レッスン紹介</div>
    <div class="row middle-content">
      <div class="col-md-4 text-center">
        <div class="row">
          <div class="col-md-6">
            <span>2018/12/31</span>
          </div>
          <div class="col-md-6">
            <span>東京都品川区</span>
          </div>
        </div>
        <div class="blog-inner">
          <img class="img-responsive" src="http://placehold.jp/350x200.png" alt="Blog">
          <div class="desc">
            <h3><a href="#">レッスン名</a></h3>
            <p>¥5000/1人</p>
            <p><a href="#" class="btn btn-primary btn-outline with-arrow">レッスン詳細を見る<i class="icon-arrow-right"></i></a></p>
          </div>
        </div>
      </div>
      <div class="col-md-4 text-center">
        <div class="row">
          <div class="col-md-6">
            <span>2018/12/31</span>
          </div>
          <div class="col-md-6">
            <span>東京都品川区</span>
          </div>
        </div>
        <div class="blog-inner">
          <img class="img-responsive" src="http://placehold.jp/350x200.png" alt="Blog">
          <div class="desc">
            <h3><a href="#">レッスン名</a></h3>
            <p>¥5000/1人</p>
            <p><a href="#" class="btn btn-primary btn-outline with-arrow">レッスン詳細を見る<i class="icon-arrow-right"></i></a></p>
          </div>
        </div>
      </div>
      <div class="col-md-4 text-center">
        <div class="row">
          <div class="col-md-6">
            <span>2018/12/31</span>
          </div>
          <div class="col-md-6">
            <span>東京都品川区</span>
          </div>
        </div>
        <div class="blog-inner">
          <img class="img-responsive" src="http://placehold.jp/350x200.png" alt="Blog">
          <div class="desc">
            <h3><a href="#">レッスン名</a></h3>
            <p>¥5000/1人</p>
            <p><a href="#" class="btn btn-primary btn-outline with-arrow">レッスン詳細を見る<i class="icon-arrow-right"></i></a></p>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center"><button type="button" class="btn btn-secondary">more</button></div>
  </div>


  <!-- つくれぽ -->
  <div class="low wrapper">
    <div class="text-center title">つくれぽ</div>
    <div class="row low-content">
      <div class="col-md-3 text-center">
        <span>2018/12/31</span>
        <div class="blog-inner">
          <img class="img-responsive" src="http://placehold.jp/250x150.png" alt="Blog">
          <div class="desc">
            <div class="row">
              <div class="col-md-3">
                <img src="https://placehold.jp/80x80.png" style="width:80px;height:80px;border-radius: 50%;">
              </div>
              <div class="col-md-9">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
              </div>
            </div>
            <p><a href="#" class="btn btn-primary btn-outline with-arrow">このレッスンの講師プロフィールへ<i class="icon-arrow-right"></i></a></p>
          </div>
        </div>
      </div>
      <div class="col-md-3 text-center">
        <span>2018/12/31</span>
        <div class="blog-inner">
          <img class="img-responsive" src="http://placehold.jp/250x150.png" alt="Blog">
          <div class="desc">
            <div class="row">
              <div class="col-md-3">
                <img src="https://placehold.jp/80x80.png" style="width:80px;height:80px;border-radius: 50%;">
              </div>
              <div class="col-md-9">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
              </div>
            </div>
            <p><a href="#" class="btn btn-primary btn-outline with-arrow">このレッスンの講師プロフィールへ<i class="icon-arrow-right"></i></a></p>
          </div>
        </div>
      </div>
      <div class="col-md-3 text-center">
        <span>2018/12/31</span>
        <div class="blog-inner">
          <img class="img-responsive" src="http://placehold.jp/250x150.png" alt="Blog">
          <div class="desc">
            <div class="row">
              <div class="col-md-3">
                <img src="https://placehold.jp/80x80.png" style="width:80px;height:80px;border-radius: 50%;">
              </div>
              <div class="col-md-9">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
              </div>
            </div>
            <p><a href="#" class="btn btn-sm btn-primary btn-outline with-arrow">このレッスンの講師プロフィールへ<i class="icon-arrow-right"></i></a></p>
          </div>
        </div>
      </div>
      <div class="col-md-3 text-center">
        <span>2018/12/31</span>
        <div class="blog-inner">
          <img class="img-responsive" src="http://placehold.jp/250x150.png" alt="Blog">
          <div class="desc">
            <div class="row">
              <div class="col-md-3">
                <img src="https://placehold.jp/80x80.png" style="width:80px;height:80px;border-radius: 50%;">
              </div>
              <div class="col-md-9">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
              </div>
            </div>
            <p><a href="#" class="btn btn-primary btn-outline with-arrow" >このレッスンの講師プロフィールへ<i class="icon-arrow-right"></i></a></p>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center"><a href="signup.php"><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#demoNormalModal1">会員登録してみる<br>(無料)</button></a></div>
  </div>

  <footer>
  </footer>

</body>
</html>