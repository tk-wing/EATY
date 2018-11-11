<!DOCTYPE html>
<html lang="ja">
<head>
  <title>レッスン検索ページ</title>
  <meta charset="utf-8">
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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
  <!-- Theme style  -->
  <link rel="stylesheet" href="css/style.css">

  <!-- Modernizr JS -->
  <!-- <script src="js/modernizr-2.6.2.min.js"></script> -->
  <!-- viewport meta -->
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
</head>
<body>
   
   <header>
    <div class="text-center" >
      <a href="#"><img src="img/eatylogo.png" width="100"></a>
    </div>
  </header>

  <div class="text-center container">
    <p class="title font-weight-bold">レッスン検索</p>
    <form class="signup_form" method="POST" action=""></form>

   
    <div class="title font-weight-bold">
      日付<select id="genre" name="genre" class="form-control">
        <option value="1">Option one</option>
        <option value="2">Option two</option>
      </select>
    </div>
    <div class="title font-weight-bold">
      開催場所<select id="genre" name="genre" class="form-control">
        <option value="1">Option one</option>
        <option value="2">Option two</option>
      </select>
    </div>
    <div class="title font-weight-bold">
      ジャンル<select id="genre" name="genre" class="form-control">
        <option value="1">Option one</option>
        <option value="2">Option two</option>
      </select>
    </div>
    <div class="title font-weight-bold">
      キーワード<select id="genre" name="genre" class="form-control">
        <option value="1">Option one</option>
        <option value="2">Option two</option>
      </select>
    </div>


  </div>


  <input type="submit" class="btn btn-primary" value="レッスン検索">



  
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