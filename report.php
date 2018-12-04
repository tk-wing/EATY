<?php
    session_start();
    require('dbconnect.php');
    require('functions.php');

    // ユーザー情報を取得
    $sql='SELECT `users`.*, `profiles_s`.`nickname`, `profiles_s`.`img_name` FROM `users` LEFT JOIN `profiles_s` ON `users`.`id` = `profiles_s`.`user_id` WHERE `users`.`id`=?';
    $stmt = $dbh->prepare($sql);
    $data = array($_SESSION['EATY']['id']);
    $stmt->execute($data);
    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

    //ニックネームが登録されていない場合
    if (empty($signin_user['nickname'])) {
        $name = $signin_user['last_name'] . '　' . $signin_user['first_name'];
    } else {
        $name = $signin_user['nickname'];
    }


    $sql = 'SELECT * FROM `reports` WHERE `user_id`=? ORDER BY `created` DESC LIMIT 5 OFFSET 0';
    $data = array($signin_user['id']);
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
      <a href='#' data-toggle="modal" data-target="#demoNormalModal"><img src="img/eatylogo.png" width="100"></a>
    </div>
  </header>

  <div class="wrapper">
    <div class="top-content text-center">
      <?php if ($signin_user['img_name'] == ""): ?>
        <img id="img1" src="img/profile_img_defult.png" style="width:160px;height:160px;border-radius: 50%;">
      <?php else: ?>
        <img src="user_profile_img/<?php echo $signin_user['img_name']; ?>" style="width:120px;height:120px;border-radius: 50%;">
      <?php endif ?>
       <p><?php echo $name; ?>さんのつくれぽ</p>
    </div>

    <div class="row text-center" style="border: 4px solid #2C373B;border-radius: 240px 15px 185px 15px / 15px 200px 15px 185px;margin: 2em 0;padding: 2em;">
      <?php if (empty($reports)): ?>
        <div class="col-md-12 text-center">まだつくれぽ投稿がありません。</div>
        <?php else: ?>

      <?php foreach($reports as $report_each):?>

      <div class="col-md-3 text-center">
        <span><?php echo date('Y/m/d', strtotime($report_each['created'])); ?></span>
        <div class="blog-inner" style="border:solid 1px; ">
          <img class="img-responsive" src="user_report_img/<?php echo $report_each['img_name']; ?>" alt="Blog" style="margin: 5px; height: 150px;">
          <p style="text-align: center; padding: 3px 3px"><?php echo $report_each['feed']; ?></p>
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