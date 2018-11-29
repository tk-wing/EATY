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

  // お気入りレッスン登録
  $(document).on('click', '#like', function() {
      var user_id = $('#user_id').text();
      var lesson_id = $('#lesson_id').text();
      var like_btn = $(this);

      $.ajax({
          url:'favorite_register.php',
          type:'POST',
          datatype: 'json',
          data:{
            'user_id':user_id,
            'lesson_id':lesson_id,
            'is_liked':true
          }
      })
      .done(function(data){
          if (data == 'true') {
              like_btn.attr('id', 'unlike');
              like_btn.removeClass('btn-secondary');
              like_btn.addClass('btn-warning');
          }
        console.log(data);
      })
      .fail(function(err){
        // 目的の処理が失敗したときの処理
        console.log('error');
      })

  });

  $(document).on('click', '#unlike', function() {
      var user_id = $('#user_id').text();
      var lesson_id = $('#lesson_id').text();
      var like_btn = $(this);

      $.ajax({
          url:'favorite_register.php',
          type:'POST',
          datatype: 'json',
          data:{
            'user_id':user_id,
            'lesson_id':lesson_id,
          }
      })
      .done(function(data){
          if (data == 'true') {
              like_btn.attr('id', 'like');
              like_btn.removeClass('btn-warning');
              like_btn.addClass('btn-secondary');
          }
        console.log(data);
      })
      .fail(function(err){
        // 目的の処理が失敗したときの処理
        console.log('error');
      })

  });

});