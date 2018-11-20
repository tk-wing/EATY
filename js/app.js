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

  $('.category-item').on('click', function(){
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

});