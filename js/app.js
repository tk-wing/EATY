$(function(){

  $('.lesson-list-item').on('click', function(){
    var inner = $(this).find('.inner');
    if (inner.hasClass('open')) {
      inner.removeClass('open');
      inner.slideUp();
      $(this).find('span').text('+');
    }else{
      inner.addClass('open');
      inner.slideDown();
      $(this).find('span').text('-');
    }
  });

  $('.ml-1').on('click', function(){
    var inner = $(this).parent().find('.inner');
    if (inner.hasClass('open')) {
      inner.removeClass('open');
      inner.slideUp();
      $(this).find('span').text('+');
    }else{
      inner.addClass('open');
      inner.slideDown();
      $(this).find('span').text('-');
    }
  });

  // いいねカウント
  $(document).on('click', '#like', function() {
      var user_id = $('#user_id').text();
      var lesson_id = $('#lesson_id').text();
      var like_btn = $(this);

      console.log(user_id);
      console.log(lesson_id);

      $.ajax({
          url:'like.php',
          type:'POST',
          datatype: 'json',
          data:{
            'feed_id':feed_id,
            'user_id':user_id,
            'is_liked':true
          }
      })
      // .done(function(data){
      //     if (data == 'true') {
      //         like_count++;
      //         like_btn.siblings('.like_count').text(like_count);
      //         like_btn.removeClass('like');
      //         like_btn.addClass('unlike');
      //         like_btn.html('<i style="color: red;" class="fas fa-heart"></i>');
      //     }
      //   console.log(data);
      // })
      // .fail(function(err){
      //   // 目的の処理が失敗したときの処理
      //   console.log('error');
      // })

  });

});