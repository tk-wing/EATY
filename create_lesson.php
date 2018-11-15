<!DOCTYPE html>
<html lang="ja">
<head>
  <title>レッスン作成</title>
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
    $('#filesend_1').change(function(e){
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

  $(function(){
    $('#filesend_2').change(function(e){
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
          $("#img2").attr("src", e.target.result);
          $("#img2").attr("title", file.name);
        };
      })(file);
      reader.readAsDataURL(file);
   
    });
  });

  $(function(){
    $('#filesend_3').change(function(e){
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
          $("#img3").attr("src", e.target.result);
          $("#img3").attr("title", file.name);
        };
      })(file);
      reader.readAsDataURL(file);
   
    });
  });

  $(function(){
    $('#filesend_4').change(function(e){
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
          $("#img4").attr("src", e.target.result);
          $("#img4").attr("title", file.name);
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

  <div class="wrapper">

    <div class="blog-inner-prof text-center">
        <div class="row">
          <div class="col-md-4 text-center">
            <div class="row">
              <div class="col text-right">
                <label class="filelabel_create">
                <img id="img1" src="https://placehold.jp/130x100.png" style="width:130px;height:100px;">
                <input type="file" class="filesend" id="filesend_1" name="img_name">
                </label>
              </div>

              <div class="col text-left">
                <label class="filelabel_create">
                <img id="img2" src="https://placehold.jp/130x100.png" style="width:130px;height:100px;">
                <input type="file" class="filesend" id="filesend_2" name="img_name">
                </label>
              </div>
            </div>

            <div class="row">
              <div class="col text-right">
                <label class="filelabel_create">
                <img id="img3" src="https://placehold.jp/130x100.png" style="width:130px;height:100px;">
                <input type="file" class="filesend" id="filesend_3" name="img_name">
                </label>
              </div>

              <div class="col text-left">
                <label class="filelabel_create">
                <img id="img4" src="https://placehold.jp/130x100.png" style="width:130px;height:100px;">
                <input type="file" class="filesend" id="filesend_4" name="img_name">
                </label>
              </div>
            </div>
          </div>

          <div class="col-md-4 text-center">
            <div class="row">
              <div class="col-md-3">
                <span style="line-height: 40px;">開催日</span>
              </div>
              <div class=col-md-9>
                <div class="form-group">
                  <div class="col-md-9">
                  <input id="name" name="name" type="date" placeholder="" class="form-control input-md">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <span style="line-height: 40px;">開催時間</span>
              </div>
              <div class=col-md-9>
                <div class="form-group">
                  <div class="col-md-9">
                  <input id="name" name="name" type="time" placeholder="" class="form-control input-md">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <span style="line-height: 40px;">開催場所</span>
              </div>
              <div class=col-md-9>
                <div class="form-group">
                  <div class="col-md-9">
                  <input id="name" name="name" type="text" placeholder="" class="form-control input-md">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <span style="line-height: 40px;">料金</span>
              </div>
              <div class=col-md-9>
                <div class="form-group">
                  <div class="col-md-9">
                  <input id="name" name="name" type="text" placeholder="" class="form-control input-md">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <span style="line-height: 40px;">所要時間</span>
              </div>
              <div class=col-md-9>
                <div class="form-group">
                  <div class="col-md-9">
                  <input id="name" name="name" type="text" placeholder="" class="form-control input-md">
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="col-md-4 text-center">
            <div class="row">
              <div class="col-md-3">
                <span style="line-height: 40px;">カテゴリ</span>
              </div>
              <div class=col-md-9>
                <div class="form-group">
                  <div class="col-md-9">
                  <input id="name" name="name" type="text" placeholder="" class="form-control input-md">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3" style="font-size: 15px;">
                <span style="line-height: 40px;">メニュー数</span>
              </div>
              <div class=col-md-9>
                <div class="form-group">
                  <div class="col-md-9">
                  <input id="name" name="name" type="text" placeholder="" class="form-control input-md">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <span style="line-height: 40px;">定員</span>
              </div>
              <div class=col-md-9>
                <div class="form-group">
                  <div class="col-md-9">
                  <input id="name" name="name" type="text" placeholder="" class="form-control input-md">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3" style="font-size: 12px;">
                <span style="line-height: 40px;">最小催行人数</span>
              </div>
              <div class=col-md-9>
                <div class="form-group">
                  <div class="col-md-9">
                  <input id="name" name="name" type="text" placeholder="" class="form-control input-md">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4 text-center">
            <div class="form-group">
              <label class="col-md-4 control-label" for="career"></label>
              <div class="col-md-14">
                <textarea class="form-control" name="lesson_name" style="height: 100px;">レッスン名</textarea>
              </div>
            </div>
          </div>
          <div class="col-md-8 text-center">
            <div class="form-group">
              <label class="col-md-4 control-label" for="career"></label>
              <div class="col-md-14">
                <textarea class="form-control" name="menu" style="height: 100px;">メニュー概要</textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 text-center">
            <div class="form-group">
              <label class="col-md-4 control-label" for="career"></label>
              <div class="col-md-14">
                <textarea class="form-control" name="require_item" style="height: 100px;">持ち物</textarea>
              </div>
            </div>
          </div>
          <div class="col-md-6 text-center">
            <div class="form-group">
              <label class="col-md-4 control-label" for="career"></label>
              <div class="col-md-14">
                <textarea class="form-control" name="attention" style="height: 100px;">注意事項</textarea>
              </div>
            </div>
          </div>
        </div>

        <input type="submit" class="btn btn-primary" value="レッスン登録">

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