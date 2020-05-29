$(function(){
  $(function(){

    $('.sidenav').sidenav({
      closeOnClick  : true,
      edge: 'right',
      draggable     : true
    });
    $('.parallax').parallax();
    $('.materialboxed').materialbox();
    $('.collapsible').collapsible();
    $('select').formSelect();

  }); // end of document ready
}); // end of jQuery name space
$(function() {
  var pagetop = $('#page_top');   
  pagetop.hide();
  $(window).scroll(function () {
      if ($(this).scrollTop() > 100) {  //100pxスクロールしたら表示
          pagetop.fadeIn();
      } else {
          pagetop.fadeOut();
      }
  });
  $('a[href^="#"]').click(function(){
    var time = 500;
    var target = $(href == "#" ? 'html' : href);
    var distance = target.offset().top;
    $("html, body").animate({scrollTop:distance}, time, "swing");
    return false;
  });
  $(function(){
    $("#account_name").change(function(){
      $("#account_form").submit();
    });
    $("#terms").change(function(){
      $("#account_form").submit();
    });
  });
});