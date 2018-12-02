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
  $(document).on('click', '#favorite', function() {
      var user_id = $('#user_id').text();
      var lesson_id = $('#lesson_id').text();
      var favorite_btn = $(this);

      $.ajax({
          url:'favorite_register.php',
          type:'POST',
          datatype: 'json',
          data:{
            'user_id':user_id,
            'lesson_id':lesson_id,
            'is_favorited':true
          }
      })
      .done(function(data){
          if (data == 'true') {
              favorite_btn.attr('id', 'unfavorite');
              favorite_btn.removeClass('btn-secondary');
              favorite_btn.addClass('btn-warning');
          }
        console.log(data);
      })
      .fail(function(err){
        // 目的の処理が失敗したときの処理
        console.log('error');
      })

  });

  $(document).on('click', '#unfavorite', function() {
      var user_id = $('#user_id').text();
      var lesson_id = $('#lesson_id').text();
      var favorite_btn = $(this);

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
              favorite_btn.attr('id', 'favorite');
              favorite_btn.removeClass('btn-warning');
              favorite_btn.addClass('btn-secondary');
          }
        console.log(data);
      })
      .fail(function(err){
        // 目的の処理が失敗したときの処理
        console.log('error');
      })

  });

  // 講師いいね機能
  $(document).on('click', '#like', function() {
      var user_id = $('#user_id').text();
      var teacher_id = $('#teacher_id').text();
      var like_btn = $(this);
      var like_count = $('#like_count').text();

      $.ajax({
          url:'like_register.php',
          type:'POST',
          datatype: 'json',
          data:{
            'user_id':user_id,
            'teacher_id':teacher_id,
            'is_liked':true
          }
      })
      .done(function(data){
          if (data == 'true') {
              like_count ++;
              $('#like_count').text(like_count);
              like_btn.attr('id', 'unlike');
              like_btn.removeClass('btn-secondary');
              like_btn.addClass('btn-danger');
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
      var teacher_id = $('#teacher_id').text();
      var like_btn = $(this);
      var like_count = $('#like_count').text();

      $.ajax({
          url:'like_register.php',
          type:'POST',
          datatype: 'json',
          data:{
            'user_id':user_id,
            'teacher_id':teacher_id,
          }
      })
      .done(function(data){
          if (data == 'true') {
              like_count --;
              $('#like_count').text(like_count);
              like_btn.attr('id', 'like');
              like_btn.removeClass('btn-danger');
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