$(document).ready(function() {
  "use strict";
  //Toggle Class Script
  $('.toggle').on('click', function () {
    $(this).toggleClass('active');
    $('.nav').toggleClass('open');
  });

  //Insert After Script
  $(window).resize(function() {
    if (screen.width <= 991) {
      $('.contact-items-wrap').insertAfter('.nav > .container > ul');
      $('.topbar').insertAfter('.nav > .container > ul');
    };
  });
  $(window).trigger('resize');

  //Outside Click Remove Class Script
  $(document).on('click', function(e) {
    if ($(e.target).is('.toggle, .toggle *, .nav, .nav *') == false) {
      $('.toggle').removeClass('active');
      $('.nav').removeClass('open');
    }
  });

$(document).ready(function() {

  $('.form-toggle').click(function(){
    if ($('.form-responsive').is(":visible")) {
      $('.form-responsive').slideUp();  
    } else {
      $('.form-responsive').slideDown();  
    }
  });

$(window).scroll(function() {

   var st = $(this).scrollTop(); 
   if( st > 50 ) {
   $(".header").addClass("active"); 
   } else {
   $(".header").removeClass("active"); 
   }
  }); 
 }); 

  //Owl Carousel Slider Script
  $('.owl-carousel').each( function() {
    var $carousel = $(this);
    var $items = ($carousel.data('items') !== undefined) ? $carousel.data('items') : 1;
    var $items_lg = ($carousel.data('items-lg') !== undefined) ? $carousel.data('items-lg') : 3;
    var $items_md = ($carousel.data('items-md') !== undefined) ? $carousel.data('items-md') : 2;
    var $items_sm = ($carousel.data('items-sm') !== undefined) ? $carousel.data('items-sm') : 2;
    var $items_ssm = ($carousel.data('items-ssm') !== undefined) ? $carousel.data('items-ssm') : 1;
    $carousel.owlCarousel ({
      loop : ($carousel.data('loop') !== undefined) ? $carousel.data('loop') : true,
      items : $carousel.data('items'),
      margin : ($carousel.data('margin') !== undefined) ? $carousel.data('margin') : 0,
      dots : ($carousel.data('dots') !== undefined) ? $carousel.data('dots') : true,
      nav : ($carousel.data('nav') !== undefined) ? $carousel.data('nav') : false,
      navText : ["<div class='slider-no-current'><span class='current-no'></span><span class='total-no'></span></div><span class='current-monials'></span>", "<div class='slider-no-next'></div><span class='next-monials'></span>"],
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
      autoplay: 600,
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

   $('.carousel').carousel({
      interval: 2500
  });


// ===== Scroll to Top ==== 
$(window).scroll(function() {
    if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
        $('#return-to-top').fadeIn(200);    // Fade in the arrow
    } else {
        $('#return-to-top').fadeOut(200);   // Else fade out the arrow
    }
});
$('#return-to-top').click(function() {      // When arrow is clicked
    $('body,html').animate({
        scrollTop : 0                       // Scroll to top of body
    }, 500);
});


});

 //flexslider script
 /*
  $(window).load(function() {
    $('.main-slider').flexslider ({
      animation: 'slide',
      controlNav: false,
      animationLoop: false,
      slideshow: false,
      sync: '.thumb-slider',
      start: function() {
        $('body').removeClass('loading');
      }
    });
    $('.thumb-slider').flexslider ({
      animation: "slide",
      controlNav: false,
      animationLoop: false,
      slideshow: false,
      itemWidth: 205,
      itemMargin: 10,
      asNavFor: '.main-slider'
    });
  });
  */

  function repoducir_audio(){
    $(".audio").play;
  }