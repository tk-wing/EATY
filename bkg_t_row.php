
<div class="blog-inner-prof">
    <div class="row">
      <div class="col-md-2 text-center">
        <p><?php echo date('m月d日',  strtotime($lessons_each['day'])) ?></p>
        <p><?php echo date('H時i分から', strtotime($lessons_each['daytime'])) ?></p>
      </div>

      <div class="col-md-2 text-center">
        <p><?php echo $lessons_each["lesson_name"]; ?></p>
      </div>

      <div class="col-md-2 text-center">
        <p><?php echo $lessons_each["station"]; ?></p>
      </div>

      <div class="col-md-2 text-center">
        <!-- ここはデータベース上変わってく、何人の生徒が予約したか -->

          <?php if (isset($lessons_each['count'])): ?>
            <p>現在<?php echo $lessons_each['count'] ?>人</p>
          <?php else: ?>
            <p style="color: red;">0(定員に満たしました。)</p>
          <?php endif ?>
        <p>/<?php echo $lessons_each["capacity"]; ?>人</p>
      </div>

      <!-- もしカウントに値があったら受付中、そうじゃなかったらステータスの満席を入れる -->
      <div class="col-md-2 text-center">
        <?php if (isset($lessons_each['count'])): ?>
          <p style="color: green;">受付中</span>
        <?php else: ?>
          <p style="color: red;"><?php echo $lessons_each['status'] ?></p>
        <?php endif ?>

      </div>

      <div class="col-md-2 text-center">
          <!-- 詳細はbkg_check_t.phpへ -->

          <a href="lesson.php?lesson_id=<?php echo $lessons_each['id'] ?>"><button type="" class="btn btn-primary">レッスン詳細</button></a>

        <!-- 編集はcreate_lessonへ -->
          <a href="bkg_edit_t.php?lesson_id=<?php echo $lessons_each['id'] ?>"><button type="" src class="btn btn-primary">レッスン編集</button></a>

      </div>

    </div>
</div>