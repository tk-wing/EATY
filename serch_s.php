<?php
    session_start();

    require('dbconnect.php');
    require('functions.php');

    v($_SESSION,'$_SESSION');

       // ユーザー情報を取得
    $sql='SELECT * FROM `users` WHERE `id`=?';
    $stmt = $dbh->prepare($sql);
    $data = array($_SESSION['EATY']['id']);
    $stmt->execute($data);

    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

    // pロフィール情報をを取得(生徒)
    $profile_t_sql='SELECT * FROM `profiles_s` WHERE `user_id`=?';
    $profile_t_stmt = $dbh->prepare($profile_t_sql);
    $profile_t_sql_data = [$signin_user['id']];
    $profile_t_stmt->execute($profile_t_sql_data);
    $profile_t = $profile_t_stmt->fetch(PDO::FETCH_ASSOC);

    // カテゴリー情報を取得
    $categories_sql='SELECT * FROM `categories`';
    $categories_stmt = $dbh->prepare($categories_sql);
    $categories_sql_data = [];
    $categories_stmt->execute($categories_sql_data);
    
    // 都道府県情報の取得
    $areas_sql='SELECT * FROM `areas`';
    $areas_stmt = $dbh->prepare($areas_sql);
    $areas_sql_data = [];
    $areas_stmt->execute($areas_sql_data);

    $validations=[];


    //検索ボタンを押した時
    if (!empty($_POST)) {
      $day=$_POST['day'];

      //バリデーション
      if ($day == '' ) {
        $validations['day']= 'blank';
        
      }else{
        //検査結果を表示。（同じ値だったものすべて）
        $lessons_sql ='SELECT * FROM `lessons_t` WHERE `id`=?';
        $lessons_data =[$signin_user['id']];//POSTしたきの値
        $lessons_stmt = $dbh->prepare($lessons_sql);
        $lessons_stmt->execute($lessons_data);
      }
    
    }


        $lessons = []; 
        // while (true) {
        //   $lesson = $lessons_stmt->fetch(PDO::FETCH_ASSOC);//データ一個分

        //   if ($lesson == false) {
        //     //所得データは全て所得できているので、繰り返しを中断する
        //     break;
        //   }
         // $lessons[]= $lesson;

        // }

?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <title>検索結果</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <link rel="stylesheet" href="css/stylesheet_serch.css">
  <link rel="stylesheet" href="css/stylesheet_serch_s.css">

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
  <header>
    <div class="text-center" >
      <a href="#"><img src="img/eatylogo.png" width="100"></a>
    </div>
  </header>

 <a class="right" href="http://localhost/batch46/EATY/serch_s.php">検査条件をクリア</a>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<div class="container text-center">
    <nav class="navbar navbar-expand-lg navbar-dark">
                <ul>
                  <li>
                    <p>日付</p>
                  </li>
                  <li>
                    <input id="name" name="day" type="date" placeholder="" class="form-control input-md">
                  </li>
                  <li>

                    <p>開催場所</p>
                  </li>
                    <li>
                       <select id="genre" name="genre" class="form-control">
                         <option value="1">Option one</option>
                         <option value="2">Option two</option>
                       </select>
                    </li>
                    <li>
                      <p>ジャンル</p>
                    </li>
                    <li class="">
                      <select id="category" name="category_id[]" class="form-control">
                        <option value="">選択してください。</option>
                        <?php while(1): ?>
                          <?php  $category_id = $categories_stmt->fetch(PDO::FETCH_ASSOC); ?>
                          <?php if ($category_id == false): ?>
                            <?php break; ?>
                            <?php else: ?>
                            <option value="<?php echo $category_id['id'];?>"><?php echo $category_id['category_name'] ?></option>
                          <?php endif ?>
                        <?php endwhile; ?>
                      </select>
                    </li>
                    <li>
                      <p>キーワード</p>
                    </li>
                    <li class="">
                        <input id="name" name="keyword" type="text" placeholder="その他" class="form-control input-md">
                    </li>
                        <!-- <input type="submit" class="btn btn-primary" value="レッスン検索"> -->
                </ul>
                  </nav>
                <input type="submit"  class="btn btn-primary" value="レッスン検索">

  <!-- レッスン検査結果表示 POST送信した時に表示 -->
  <div class="container">
      <div id="products" class="row view-group">

                <div class="item col-xs-4 col-lg-4">

                    <div class="thumbnail card">
                      <!-- 全体の白い枠 -->
                      <h4 class="group card-title inner list-group-item-heading">簡単オムライス</h4>
                        <div class="blog-inner">
                          <img class="img-responsive" src="http://placehold.jp/350x200.png" alt="Blog">
                        </div>
                        <div class="caption card-body">
                          <!-- 下の白い枠 -->
                          <table>
                            <tr>
                              <td colspan="2">ざっくり場所</td>
                              <td >¥3000/1人</td>
                            </tr>
                            <tr>
                              <td><img src="https://placehold.jp/120x120.png" style="width:120px;height:120px;border-radius: 50%;"></td>
                              <td>講師名</td>
                              <td><input type="submit" class="btn btn-primary"  value="レッスン詳細"></td>
                            </tr>

                          </table>
                             
                        </div>
                    </div>
                </div>
                <div class="item col-xs-4 col-lg-4">

                    <div class="thumbnail card">
                      <!-- 全体の白い枠 -->
                      <h4 class="group card-title inner list-group-item-heading">簡単オムライス</h4>
                        <div class="blog-inner">
                          <img class="img-responsive" src="http://placehold.jp/350x200.png" alt="Blog">
                        </div>
                        <div class="caption card-body">
                          <!-- 下の白い枠 -->
                          <table>
                            <tr>
                              <td colspan="2">ざっくり場所</td>
                              <td >¥3000/1人</td>
                            </tr>
                            <tr>
                              <td><img src="https://placehold.jp/120x120.png" style="width:120px;height:120px;border-radius: 50%;"></td>
                              <td>講師名</td>
                              <td><input type="submit" value="レッスン詳細"></td>
                            </tr>

                          </table>
                             
                        </div>
                    </div>
                </div>
                <div class="item col-xs-4 col-lg-4">

                    <div class="thumbnail card">
                      <!-- 全体の白い枠 -->
                      <h4 class="group card-title inner list-group-item-heading">簡単オムライス</h4>
                        <div class="blog-inner">
                          <img class="img-responsive" src="http://placehold.jp/350x200.png" alt="Blog">
                        </div>
                        <div class="caption card-body">
                          <!-- 下の白い枠 -->
                          <table>
                            <tr>
                              <td colspan="2">ざっくり場所</td>
                              <td >¥3000/1人</td>
                            </tr>
                            <tr>
                              <td><img src="https://placehold.jp/120x120.png" style="width:120px;height:120px;border-radius: 50%;"></td>
                              <td>講師名</td>
                              <td><input type="submit" value="レッスン詳細"></td>
                            </tr>

                          </table>
                             
                        </div>
                    </div>
                </div>
                <div class="item col-xs-4 col-lg-4">

                    <div class="thumbnail card">
                      <!-- 全体の白い枠 -->
                      <h4 class="group card-title inner list-group-item-heading">簡単オムライス</h4>
                        <div class="blog-inner">
                          <img class="img-responsive" src="http://placehold.jp/350x200.png" alt="Blog">
                        </div>
                        <div class="caption card-body">
                          <!-- 下の白い枠 -->
                          <table>
                            <tr>
                              <td colspan="2">ざっくり場所</td>
                              <td >¥3000/1人</td>
                            </tr>
                            <tr>
                              <td><img src="https://placehold.jp/120x120.png" style="width:120px;height:120px;border-radius: 50%;"></td>
                              <td>講師名</td>
                              <td><input type="submit" value="レッスン詳細"></td>
                            </tr>

                          </table>
                             
                        </div>
                    </div>
                </div>
                <div class="item col-xs-4 col-lg-4">

                    <div class="thumbnail card">
                      <!-- 全体の白い枠 -->
                      <h4 class="group card-title inner list-group-item-heading">簡単オムライス</h4>
                        <div class="blog-inner">
                          <img class="img-responsive" src="http://placehold.jp/350x200.png" alt="Blog">
                        </div>
                        <div class="caption card-body">
                          <!-- 下の白い枠 -->
                          <table>
                            <tr>
                              <td colspan="2">ざっくり場所</td>
                              <td >¥3000/1人</td>
                            </tr>
                            <tr>
                              <td><img src="https://placehold.jp/120x120.png" style="width:120px;height:120px;border-radius: 50%;"></td>
                              <td>講師名</td>
                              <td><input type="submit" value="レッスン詳細"></td>
                            </tr>

                          </table>
                             
                        </div>
                    </div>
                </div>
                <div class="item col-xs-4 col-lg-4">

                    <div class="thumbnail card">
                      <!-- 全体の白い枠 -->
                      <h4 class="group card-title inner list-group-item-heading">簡単オムライス</h4>
                        <div class="blog-inner">
                          <img class="img-responsive" src="http://placehold.jp/350x200.png" alt="Blog">
                        </div>
                        <div class="caption card-body">
                          <!-- 下の白い枠 -->
                          <table>
                            <tr>
                              <td colspan="2">ざっくり場所</td>
                              <td >¥3000/1人</td>
                            </tr>
                            <tr>
                              <td><img src="https://placehold.jp/120x120.png" style="width:120px;height:120px;border-radius: 50%;"></td>
                              <td>講師名</td>
                              <td><input type="submit" value="レッスン詳細"></td>
                            </tr>

                          </table>
                             
                        </div>
                    </div>
                </div>
                <div class="item col-xs-4 col-lg-4">

                    <div class="thumbnail card">
                      <!-- 全体の白い枠 -->
                      <h4 class="group card-title inner list-group-item-heading">簡単オムライス</h4>
                        <div class="blog-inner">
                          <img class="img-responsive" src="http://placehold.jp/350x200.png" alt="Blog">
                        </div>
                        <div class="caption card-body">
                          <!-- 下の白い枠 -->
                          <table>
                            <tr>
                              <td colspan="2">ざっくり場所</td>
                              <td >¥3000/1人</td>
                            </tr>
                            <tr>
                              <td><img src="https://placehold.jp/120x120.png" style="width:120px;height:120px;border-radius: 50%;"></td>
                              <td>講師名</td>
                              <td><input type="submit" value="レッスン詳細"></td>
                            </tr>

                          </table>
                             
                        </div>
                    </div>
                </div>
                <div class="item col-xs-4 col-lg-4">

                    <div class="thumbnail card">
                      <!-- 全体の白い枠 -->
                      <h4 class="group card-title inner list-group-item-heading">簡単オムライス</h4>
                        <div class="blog-inner">
                          <img class="img-responsive" src="http://placehold.jp/350x200.png" alt="Blog">
                        </div>
                        <div class="caption card-body">
                          <!-- 下の白い枠 -->
                          <table>
                            <tr>
                              <td colspan="2">ざっくり場所</td>
                              <td >¥3000/1人</td>
                            </tr>
                            <tr>
                              <td><img src="https://placehold.jp/120x120.png" style="width:120px;height:120px;border-radius: 50%;"></td>
                              <td>講師名</td>
                              <td><input type="submit" value="レッスン詳細"></td>
                            </tr>

                          </table>
                             
                        </div>
                    </div>
                </div>
                <div class="item col-xs-4 col-lg-4">

                    <div class="thumbnail card">
                      <!-- 全体の白い枠 -->
                      <h4 class="group card-title inner list-group-item-heading">簡単オムライス</h4>
                        <div class="blog-inner">
                          <img class="img-responsive" src="http://placehold.jp/350x200.png" alt="Blog">
                        </div>
                        <div class="caption card-body">
                          <!-- 下の白い枠 -->
                          <table>
                            <tr>
                              <td colspan="2">ざっくり場所</td>
                              <td >¥3000/1人</td>
                            </tr>
                            <tr>
                              <td><img src="https://placehold.jp/120x120.png" style="width:120px;height:120px;border-radius: 50%;"></td>
                              <td>講師名</td>
                              <td><input type="submit" value="レッスン詳細"></td>
                            </tr>

                          </table>
                             
                        </div>
                    </div>
                </div>

                <input type="submit" class="btn btn-primary input" value="More" >
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