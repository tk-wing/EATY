
<div class="blog-inner-prof">
    <div class="row">
      <div class="col-md-2 text-center">
        <p><?php echo $lessons_each["day"]; ?></p>
        <p><?php echo $lessons_each["daytime"]; ?></p>
      </div>

      <div class="col-md-2 text-center">
        <p><?php echo $lessons_each["lesson_name"]; ?></p>
      </div>

      <div class="col-md-2 text-center">
        <p><?php echo $lessons_each["station"]; ?></p>
      </div>

      <div class="col-md-2 text-center">
        <p><?php echo $lessons_each["basic"]; ?></p>
        <!-- ここはデータベース上変わってく、何人の生徒が予約したか -->
        <p>/<?php echo $lessons_each["capacity"]; ?></p>
      </div>

      <div class="col-md-2 text-center">
        <p>受付中</p>
      </div>

      <div class="col-md-2 text-center">
          <!-- 詳細はbkg_check_t.phpへ -->

          <form action="bkg_check_t.php" method="GET">
          <a href="bkg_check_t.php"><button type="" class="btn btn-primary">レッスン詳細</button></a>
          </form>
          <form action="bkg_edit_t.php" method="GET">

        <!-- 編集はcreate_lessonへ -->
          <input type="button" src class="btn btn-primary" value="レッスン編集" onclick="history.back()">
          </form>
      </div>

    </div>
</div>