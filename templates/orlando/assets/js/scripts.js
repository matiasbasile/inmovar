jQuery(document).ready(function() {
  "use strict";
  
  //Owl Carousel Slider Script
  $('.owl-carousel').each( function() {
    var $carousel = $(this);
    var $items = ($carousel.data('items') !== undefined) ? $carousel.data('items') : 4;
    var $items_lg = ($carousel.data('items-lg') !== undefined) ? $carousel.data('items-lg') : 2;
    var $items_md = ($carousel.data('items-md') !== undefined) ? $carousel.data('items-md') : 1;
    var $items_sm = ($carousel.data('items-sm') !== undefined) ? $carousel.data('items-sm') : 1;
    var $items_ssm = ($carousel.data('items-ssm') !== undefined) ? $carousel.data('items-ssm') : 1;
    $carousel.owlCarousel ({
      loop : ($carousel.data('loop') !== undefined) ? $carousel.data('loop') : true,
      items : $carousel.data('items'),
      margin : ($carousel.data('margin') !== undefined) ? $carousel.data('margin') : 0,
      dots : ($carousel.data('dots') !== undefined) ? $carousel.data('dots') : true,
      nav : ($carousel.data('nav') !== undefined) ? $carousel.data('nav') : false,
      navText : ["<div class='slider-no-current'><span class='current-no'></span><span class='total-no'></span></div><span class='current-monials'></span>", "<div class='slider-no-next'></div><span class='next-monials'></span>"],
      autoplay : ($carousel.data('autoplay') !== undefined) ? $carousel.data('autoplay') : true,
      autoplayTimeout : ($carousel.data('autoplay-timeout') !== undefined) ? $carousel.data('autoplay-timeout') : 5000,
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
          items : $items_ssm,
        },
        480 : {
          items : $items_sm,
        },
        768 : {
          items : $items_md,
        },
        992 : {
          items : $items_lg,
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
      var currentNum = event.page.index + 1;
      $('.total-no', $carousel ).html(total_items);
      $('.current-no', $carousel).html(currentNum);
    });
  });

  var btn = jQuery('.back-to-top');
  jQuery(window).scroll(function() {
    if (jQuery(window).scrollTop() > 150) {
    btn.addClass('active');
    } else {
      btn.removeClass('active');
    }
  });
    btn.on('click', function(e) {
      e.preventDefault();
    jQuery('html, body').animate({scrollTop:0}, '150');
  });

//UI SLIDER SCRIPT
$('.slider-snap').noUiSlider({
  start: [ 30, 70 ],
  snap: true,
  connect: true,
  range: {
    'min': 0,
    '5%': 5,
    '10%': 10,
    '15%': 15,
    '20%': 20,
    '25%': 25,
    '30%': 30,
    '35%': 35,
    '40%': 40,
    '45%': 45,    
    '50%': 50,    
    '55%': 55,    
    '60%': 60,
    '65%': 65,
    '70%': 70,
    '75%': 75,
    '80%': 80,
    '85%': 85,
    '90%': 90,
    '95%': 95,
    'max': 100
  }
});
$('.slider-snap').Link('lower').to($('.slider-snap-value-lower'));
$('.slider-snap').Link('upper').to($('.slider-snap-value-upper'));


});