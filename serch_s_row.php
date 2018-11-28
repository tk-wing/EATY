<div class="item col-xs-4 col-lg-4">

                    <div class="thumbnail card">
                      <!-- 全体の白い枠 -->
                      <!-- レッスンネーム -->
                      <h4 class="group card-title inner list-group-item-heading"><?php echo $lessons_each["lesson_name"]; ?></h4>
                      
                        <div class="blog-inner">
                          <!-- レッスンイメージ画像:img_1~4の中の画像をどれか選ぶ -->
                          <img class="lesson_img" src="users_lesson_img/<?= $lessons_each["img_1"];?>" alt="Blog">
                        </div>
                        <div class="caption card-body">
                          <!-- 下の白い枠 -->
                          <table>
                            <tr>
                              <td colspan="2"><?php echo $lessons_each["station"]; ?></td>
                              <td ><?php echo $lessons_each["fee"]; ?>/1人</td>
                            </tr>
                            <tr>
                              <!-- 講師画像 -->
                              <td><img class="img-responsive" src="user_profile_img/<?= $lessons_each["img_name"];?>" style="width:120px;height:120px;border-radius: 50%;"></td>
                              <!-- 講師ニックネーム -->
                              <!-- もしニックネームがなかったら本名 -->
                              <td><?= $lessons_each["nickname"];?></td>
                              <td><input type="submit" class="btn btn-primary"  value="レッスン詳細"></td>
                            </tr>

                          </table>
                             
                        </div>
                    </div>
                </div>