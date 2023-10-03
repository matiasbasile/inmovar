
$(".toggle-menu").click(function(){
  $("html").toggleClass("open");
  });
  
$(".modal-hdn").click(function(){
  $("html").addClass("open-m");
});

// Video
$(".modal").on('hidden.bs.modal', function (e) {
  $(".modal iframe").attr("src", $(".modal iframe").attr("src"));
});

  	// Owl Carousel Slider
    jQuery('.owl-carousel').each(function() {

      var $carousel = jQuery(this);
      var $items = ($carousel.data('items') !== undefined) ? $carousel.data('items') : 1;
      var $items_xl = ($carousel.data('items-xl') !== undefined) ? $carousel.data('items-xl') : 1;
      var $items_lg = ($carousel.data('items-lg') !== undefined) ? $carousel.data('items-lg') : 1;
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
      smartSpeed: 1100,
      autoplayHoverPause: false,
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
          },
          1921 : {
          items : $items_xl,
          }
      }
      });
      var totLength = jQuery('.owl-dot', $carousel).length;
      jQuery('.total-no', $carousel).html(totLength);
      jQuery('.current-no', $carousel).html(totLength);
      $carousel.owlCarousel();
      jQuery('.current-no', $carousel).html(1);
      $carousel.on('changed.owl.carousel', function(event) {
      var total_items = event.page.count;
      var currentNum = event.page.index + 1;
      jQuery('.total-no', $carousel ).html(total_items);
      jQuery('.current-no', $carousel).html(currentNum);
      });
  });

    // Fancybox
    Fancybox.bind('[data-fancybox="gallery"]', {
      //
    }); 