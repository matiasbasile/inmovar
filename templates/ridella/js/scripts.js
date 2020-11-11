
 // swiper slider script
  var swipermw = $('.swiper-container.mousewheel').length ? true : false;
  var swiperkb = $('.swiper-container.keyboard').length ? true : false;
  var swipercentered = $('.swiper-container.center').length ? true : false;
  var swiperautoplay = $('.swiper-container').data('autoplay');
  var swiperinterval = $('.swiper-container').data('interval'),
  swiperinterval = swiperinterval ? swiperinterval : 7000;
  swiperautoplay = swiperautoplay ? swiperinterval : false;

  // swiper fadeslides script
  var autoplay = 5000;
  var swiper = new Swiper('.fadeslides', {
    autoplayDisableOnInteraction: false,
    effect: 'fade',
    speed: 800,
    loop: true,
    paginationClickable: true,
    watchSlidesProgress: true,
    autoplay: autoplay,
    simulateTouch: false,
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
    pagination: '.swiper-pagination',
    mousewheelControl: swipermw,
    keyboardControl: swiperkb,
  });
  

$( ".flip-vertical a.btn" ).click(function() {
  $( ".flip-vertical .back" ).addClass( "show" )
    });

$( ".flip-vertical a.btn" ).click(function() {
  $(this).addClass( "none" )
    });

$( ".flip-vertical a.btn" ).click(function() {
  $( ".contact-section" ).addClass( "increase" )
    });


  //BACK TO TOP SCRIPT
jQuery(".back-top").hide();
jQuery(function () {
  jQuery(window).scroll(function () {
      if (jQuery(this).scrollTop() > 150) {
          jQuery('.back-top').fadeIn();
      } else {
          jQuery('.back-top').fadeOut();
      }
  });
  jQuery('.back-top a').click(function () {
      jQuery('body,html').animate({
          scrollTop: 0
      }, 2500);
      return false;
  });
  });


  


// Loader Script
  $(window).load(function() {
    $('#loading').fadeOut(500);
  });


   //Parallax Script
      $('.parallax').jarallax ({
        speed: 0.6,
      });

//Search Box Script
 



// Select all links with hashes
$('a[href*="#"]')
  // Remove links that don't actually link to anything
  .not('[href="#"]')
  .not('[href="#0"]')
  .click(function(event) {
    // On-page links
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
      && 
      location.hostname == this.hostname
    ) {
      // Figure out element to scroll to
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
  });


  $('a.search').click(function() {
    $('.search-box').fadeToggle(300).addClass('open');
  });