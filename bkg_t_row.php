
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
        <form action="create_check_t.php" method="POST">
          <input type="hidden" name="day" value="<?=$lessons_each['day'];?>" >
          <input type="hidden" name="daytime" value="<?=$lessons_each['daytime'];?>" >
          <a href="#"><button type="hidden" class="btn btn-primary">レッスン詳細</button></a>
          <!-- 詳細はcreate_checkへ -->
        </form>
        <a href="create_lesson.php"><button type="button" class="btn btn-primary">レッスン編集</button></a>
        <!-- 編集はcreate_lessonへ -->
      </div>

    </div>
</div>