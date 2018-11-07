<?php

    //SESSIONの有効化
    session_start();

    // POST送信があった場合
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $given_name=htmlspecialchars($_POST['given_name']);
        $family_name=htmlspecialchars($_POST['family_name']);
        $email=htmlspecialchars($_POST['email']);
        $pw=htmlspecialchars($_POST['pw']);
        $pw_check=htmlspecialchars($_POST['pw_check']);
        $type=$_POST['type'];

        //性が未入力の場合
        if ($given_name == '') {
            $given_name_msg = '性を入力して下さい';
            $validations['given_name'] = '未入力';
        }

        //名が未入力の場合
        if ($family_name == '') {
            $family_name_msg = '名を入力して下さい';
            $validations['family_name'] = '未入力';
        }

        //メールアドレスが未入力の場合
        if ($email == '') {
            $email_msg = 'メールアドレスを入力して下さい';
            $validations['email'] = '未入力';
        }

        //パスワードが未入力の場合
        if ($pw == '') {
            $pw_msg = 'パスワードを入力して下さい';
            $validations['pw'] = '未入力';
        }

        //確認用パスワードが未入力の場合
        if ($pw_check == '') {
            $pw_check_msg = 'パスワードを入力して下さい';
            $validations['pw_check'] = '未入力';
        }

        // パスワードと確認用パスワードが一致しない場合またはパスワードが4~8文字の英数字でない場合
        $pw_length = strlen($pw);
        $pw_int = preg_match('/[0-9]/', $pw);
        $pw_alpha = preg_match('/[a-zA-Z]/', $pw);
        $pw_int_alpha = preg_match('/[^0-9a-zA-Z]/', $pw);
        if ($pw != '' && $pw_check != '') {


            //パスワードと確認用パスワードが一致しない場合
            if ($pw !== $pw_check) {
                $unmatch_msg = 'パスワードが一致しません';
                $validations['unmatch'] = '不一致';

            //パスワードが4~8文字の英数字でない場合
            } elseif ($pw_length < 4 || $pw_length > 8 || $pw_int == FALSE || $pw_alpha == FALSE || $pw_int_alpha == TRUE) {
                $unqualified_msg = 'パスワードは4~8文字の英数字で入力して下さい';
                $validations['unqualified'] = '文字数';
            }
        }

        //新規登録情報が適切に入力された場合
        if (empty($validations)) {
            $_SESSION['EATY']['given_name']  = $given_name;
            $_SESSION['EATY']['family_name']  = $family_name;
            $_SESSION['EATY']['email']  = $email;
            $_SESSION['EATY']['pw']  = $pw;
            $_SESSION['EATY']['type']  = $type;
            header('Location: check.php');
            exit();
        }

        if ($type == '生徒') {
            $radio_t = '';
            $radio_s = 'checked';
        } else {
            $radio_t = 'checked';
            $radio_s = '';
        }

    //初期値の設定
    } else {
        $given_name = '';
        $family_name = '';
        $email = '';
        $pw = '';
        $pw_check = '';
        $radio_t = 'checked';
        $radio_s = '';
    }

?>

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
        <input name="given_name" type="text" placeholder="姓" class="form-control" style="width:200px; display: inline-block;" value="<?=$given_name ?>">
        <?php if(isset($validations['given_name'])): ?>
          <span style="color:red;"><?=$given_name_msg ?></span>
        <?php endif; ?>
      </div>

      <!-- Text input-->
      <div class="form-group">
        <input name="family_name" type="text" placeholder="名" class="form-control" style="width:200px; display: inline-block;" value="<?=$family_name ?>" >
        <?php if(isset($validations['family_name'])): ?>
          <span style="color:red;"><?=$family_name_msg ?></span>
        <?php endif; ?>
      </div>

      <!-- Text input-->
      <div class="form-group">
        <input name="email" type="text" placeholder="メールアドレス" class="form-control" style="width:200px; display: inline-block;" value="<?=$email ?>">
        <?php if(isset($validations['email'])): ?>
          <span style="color:red;"><?=$email_msg ?></span>
        <?php endif; ?>
      </div>

      <!-- Password input-->
      <div class="form-group">
        <input name="pw" type="password" placeholder="パスワード" class="form-control" style="width:200px; display: inline-block;">
        <?php if(isset($validations['pw'])): ?>
          <span style="color:red;"><?=$pw_msg ?></span>
        <?php endif; ?>
        <?php if(isset($validations['unmatch'])): ?>
          <span style="color:red;"><?=$unmatch_msg ?></span>
        <?php endif; ?>
        <?php if(isset($validations['unqualified'])): ?>
          <span style="color:red;"><?=$unqualified_msg ?></span>
        <?php endif; ?>
      </div>

      <!-- Password input-->
      <div class="form-group">
        <input name="pw_check" type="password" placeholder="パスワード再入力" class="form-control" style="width:200px; display: inline-block;">
        <?php if(isset($validations['pw_check'])): ?>
          <span style="color:red;"><?=$pw_check_msg ?></span>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <input type="radio" name="type" id="type-0" value="講師" <?=$radio_t   ?>>
        講師
        <input type="radio" name="type" id="type-1" value="生徒" <?=$radio_s ?>>
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