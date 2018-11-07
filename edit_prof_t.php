<!DOCTYPE html>
<html lang="ja">
<head>
  <title>講師 プロフィール編集</title>
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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">

  <!-- Theme style  -->
  <link rel="stylesheet" href="css/style.css">

  <!-- Modernizr JS -->
  <script src="js/modernizr-2.6.2.min.js"></script>
  <!-- viewport meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <script>
  $(function(){
    $('#filesend').change(function(e){
      //ファイルオブジェクトを取得する
      var file = e.target.files[0];
      var reader = new FileReader();
   
      //画像でない場合は処理終了
      if(file.type.indexOf("image") < 0){
        alert("画像ファイルを指定してください。");
        return false;
      }
   
      //アップロードした画像を設定する
      reader.onload = (function(file){
        return function(e){
          $("#img1").attr("src", e.target.result);
          $("#img1").attr("title", file.name);
        };
      })(file);
      reader.readAsDataURL(file);
   
    });
  });
  </script>
</head>

<body>
  <header>
    <div class="text-center">
      <a href="#"><img src="img/eatylogo.png" width="100"></a>
    </div>
  </header>

  <div class="edit_content text-center">
    <form method="POST" action="">
      <div class="row">
        <div class="col-md-4">
          <img id="img1" src="https://placehold.jp/160x160.png" style="width:160px;height:160px;border-radius: 50%;">

          <label>
            <span class="filelabel" title="ファイルを選択">
              <i class="fas fa-camera-retro"></i>
              選択
            </span>
            <input type="file" id="filesend"z name="img_name">
          </label>
        </div>

        <div class="col-md-8">
          <!-- Text input-->
          <div class="form-group">
            <div class="col-md-9">
            <input id="name" name="name" type="text" placeholder="" class="form-control input-md">
            </div>
          </div>

          <!-- Password input-->
          <div>
            <p class="check_content">メールアドレス</p>
          </div>

          <!-- Select Basic -->
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <select id="pref" name="pref" class="form-control">
                  <option value="1">Option one</option>
                  <option value="2">Option two</option>
                </select>
              </div>
              <div class="col-md-4">
                <input id="city" name="city" type="text" placeholder="市区町村" class="form-control input-md">
              </div>
              <div class="col-md-4">
                <input id="textinput" name="textinput" type="text" placeholder="最寄り駅" class="form-control input-md">
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <select id="genre" name="genre" class="form-control">
                  <option value="1">Option one</option>
                  <option value="2">Option two</option>
                </select>
              </div>
              <div class="col-md-6">
                <input id="genre_other" name="genre_other" type="text" placeholder="その他ジャンル" class="form-control input-md">
              </div>
            </div>
          </div>

          <!-- Textarea -->
          <div class="form-group">
            <label class="col-md-4 control-label" for="career"></label>
            <div class="col-md-14">
              <textarea class="form-control" id="career" name="career" style="height: 100px;">※経歴／資格</textarea>
            </div>
          </div>

          <!-- Textarea -->
          <div class="form-group">
            <label class="col-md-4 control-label" for="comment"></label>
            <div class="col-md-14">
              <textarea class="form-control" id="comment" name="comment" style="height: 100px;">自己紹介＆コメント</textarea>
            </div>
          </div>

          <input type="submit" class="btn btn-primary" value="完了">
        </div>

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