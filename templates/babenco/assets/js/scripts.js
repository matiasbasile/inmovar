$(document).ready(function() {

 //Owl Carouel Slider Script
 $('.owl-carousel').each(function() {
  var $carousel = $(this);
  var $items = ($carousel.data('items') !== undefined) ? $carousel.data('items') : 1;
  var $items_tablet = ($carousel.data('items-tablet') !== undefined) ? $carousel.data('items-tablet') : 1;
  var $items_mobile_landscape = ($carousel.data('items-mobile-landscape') !== undefined) ? $carousel.data('items-mobile-landscape') : 1;
  var $items_mobile_portrait = ($carousel.data('items-mobile-portrait') !== undefined) ? $carousel.data('items-mobile-portrait') : 1;
  $carousel.owlCarousel ({
    loop : ($carousel.data('loop') !== undefined) ? $carousel.data('loop') : true,
    items : $carousel.data('items'),
    margin : ($carousel.data('margin') !== undefined) ? $carousel.data('margin') : 0,
    dots : ($carousel.data('dots') !== undefined) ? $carousel.data('dots') : true,
    nav : ($carousel.data('nav') !== undefined) ? $carousel.data('nav') : true,
    navText : [""],
    autoplay : ($carousel.data('autoplay') !== undefined) ? $carousel.data('autoplay') : false,
    autoplayTimeout : ($carousel.data('autoplay-timeout') !== undefined) ? $carousel.data('autoplay-timeout') : 3000,
    animateIn : ($carousel.data('animatein') !== undefined) ? $carousel.data('animatein') : false,
    animateOut : ($carousel.data('animateout') !== undefined) ? $carousel.data('animateout') : false,
    mouseDrag : ($carousel.data('mouse-drag') !== undefined) ? $carousel.data('mouse-drag') : true,
    autoWidth : ($carousel.data('auto-width') !== undefined) ? $carousel.data('auto-width') : false,
    autoHeight : ($carousel.data('auto-height') !== undefined) ? $carousel.data('auto-height') : false,
    center : ($carousel.data('center') !== undefined) ? $carousel.data('center') : false,
    responsiveClass: true,
    dotsEachNumber: true,
    smartSpeed: 600,
    autoplayHoverPause: true,
    responsive : {
      0 : {
        items : $items_mobile_portrait,
      },
      768 : {
        items : $items_mobile_landscape,
      },
      992 : {
        items : $items_tablet,
      },
      1200 : {
        items : $items,
      }
    }
  });
  var totLength = $('.owl-dot', $carousel).length;
  $('.total-no', $carousel).html(totLength);
  $('.current-no', $carousel).html(totLength);
  $carousel.owlCarousel();
  $('.current-no', $carousel).html(1);
  $carousel.on('changed.owl.carousel', function(event) {
    var total_items = event.page.count;
    var currentNum = event.page.index +1;
    $('.total-no', $carousel ).html(total_items);
    $('.current-no', $carousel).html(currentNum);
  });
});

});

$(function () {
  $('input')
    .on('change', function (event) {
      var $element = $(event.target);
      var $container = $element.closest('.example');

      if (!$element.data('tagsinput')) return;

      var val = $element.val();
      if (val === null) val = 'null';
      var items = $element.tagsinput('items');

      $('code', $('pre.val', $container)).html(
        $.isArray(val)
          ? JSON.stringify(val)
          : '"' + val.replace('"', '\\"') + '"'
      );
      $('code', $('pre.items', $container)).html(
        JSON.stringify($element.tagsinput('items'))
      );
    })
    .trigger('change');
});

$(".check-desk a").click(function(){
  $(".check-desk-list").slideToggle();
});

$(".check-mob a").click(function(){
  $(".checkbox-list-top").slideToggle();
});

$(".filter-mob").click(function(){
  $(".check-desk-list").slideToggle();
});


var btn = $('#button');

$(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});

btn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});

