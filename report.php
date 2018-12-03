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

    $sql = 'SELECT * FROM `reports` WHERE `user_id`=? ORDER BY `created` DESC LIMIT 5 OFFSET 0';

    $data = array($signin_user['user_id']);

    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $reports = [];

      while (true) {
      $report = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($report==false) {
        break;
      }
      $reports[]=$report;
    }
    v($reports,'reports');



?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <title>つくれぽ一覧</title>
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
      <a href="#"><img src="img/logo.jpg" width="90"></a>
    </div>
  </header>

  <div class="wrapper">
    <div class="top-content text-center">
       <img src="user_profile_img/<?php echo $signin_user['img_name']; ?>" style="width:120px;height:120px;border-radius: 50%;">
       <p><?php echo $signin_user['nickname']; ?>さんのつくれぽ</p>
    </div>

    <div class="row text-center" style="border: 4px solid #2C373B;border-radius: 240px 15px 185px 15px / 15px 200px 15px 185px;margin: 2em 0;padding: 2em;">
      <?php if (empty($reports)): ?>
        <div class="col-md-12 text-center">まだつくれぽ投稿がありません。</div>
        <?php else: ?>

      <?php foreach($reports as $report_each):?>

      <div class="col-md-3 text-center">
        <span><?php echo date('Y/m/d', strtotime($report_each['created'])); ?></span>
        <div class="blog-inner" style="border:solid 1px; ">
          <img class="img-responsive" src="user_report_img/<?php echo $report_each['img_name']; ?>" alt="Blog" style="margin: 5px">
          <p style="text-align: left; padding: 3px 3px"><?php echo $report_each['feed']; ?></p>
          <div class="desc">

            <form method="POST" action="">
              <div class="row">
                <div class="col" style="padding: 0px">
                  <a onclick="return confirm('削除してよろしいですか？')" href="delete_report.php?report_each=<?php echo $report_each['id']; ?>"class="btn btn-warning" style="font-size: 13px">投稿削除</a>
                <!-- </div>
                <div class="col"> -->
                  <a href="edit_report.php?report_each=<?php echo $report_each['id']; ?>" class="btn btn-success" style="font-size: 13px">投稿内容編集</a>

                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    <?php endforeach; ?>

<!--       <div class="col-md-3 text-center">
        <span>2018/12/31</span>
        <div class="blog-inner">
          <img class="img-responsive" src="http://placehold.jp/250x150.png" alt="Blog">
          <div class="desc">

            <form method="POST" action="">
              <div class="row">
                <div class="col">
                  <a href="#"><button type="button" class="btn btn-danger">投稿削除</button></a>
                </div>
                <div class="col">
                  <a href="#"><button type="button" class="btn btn-primary">投稿内容編集</button></a>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>

      <div class="col-md-3 text-center">
        <span>2018/12/31</span>
        <div class="blog-inner">
          <img class="img-responsive" src="http://placehold.jp/250x150.png" alt="Blog">
          <div class="desc">

            <form method="POST" action="">
              <div class="row">
                <div class="col">
                  <a href="#"><button type="button" class="btn btn-danger">投稿削除</button></a>
                </div>
                <div class="col">
                  <a href="#"><button type="button" class="btn btn-primary">投稿内容編集</button></a>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>

      <div class="col-md-3 text-center">
        <span>2018/12/31</span>
        <div class="blog-inner">
          <img class="img-responsive" src="http://placehold.jp/250x150.png" alt="Blog">
          <div class="desc">

            <form method="POST" action="">
              <div class="row">
                <div class="col">
                  <a href="#"><button type="button" class="btn btn-danger">投稿削除</button></a>
                </div>
                <div class="col">
                  <a href="#"><button type="button" class="btn btn-primary">投稿内容編集</button></a>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>

      <div class="col-md-3 text-center">
        <span>2018/12/31</span>
        <div class="blog-inner">
          <img class="img-responsive" src="http://placehold.jp/250x150.png" alt="Blog">
          <div class="desc">

            <form method="POST" action="">
              <div class="row">
                <div class="col">
                  <a href="#"><button type="button" class="btn btn-danger">投稿削除</button></a>
                </div>
                <div class="col">
                  <a href="#"><button type="button" class="btn btn-primary">投稿内容編集</button></a>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
 -->    
      <?php endif; ?>
    </div>

  </div>


  <div id="report_modal">
    <div class="report_modal">
      <div class="blog-inner">
        <div class="close-modal">
          <i class="fa fa-2x fa-times"></i>
        </div>
        <span>2018/12/31</span><br>
        <img class="img-responsive" src="http://placehold.jp/250x150.png" alt="Blog">
        <div class="desc">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
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

</body>