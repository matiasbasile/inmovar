 $(".toggle-icon" ).on( "click", function() {
    $('.toggle-menu').slideDown();
    $('html').addClass('has-nav');
});
  $( ".menu-close" ).on( "click", function() {
    $('.toggle-menu').slideUp();
    $('html').removeClass('has-nav');
});

$(window).scroll(function(){
    if ($(window).scrollTop() > 100){
        $('.francesconi-header').addClass( "sticky");
    }
    else {
      $('.francesconi-header').removeClass( "sticky");
    }
  });

//Dropdown Script
  $('.has-dropdown').hover (
    function() {
      $(this).addClass('open').find('ul').first().stop(false, false).slideDown();
    },
    function() {
      $(this).removeClass('open').find('ul').first().stop(false, false).slideUp();
    }
  );

//Hero Swiper Slider Script
  var singleSwiper = new Swiper('.hero-slider', {
    speed: 600,
    autoplay: {
      delay: 3000,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
});
   

//Nuestra Swiper Slider Script
  var swiper = new Swiper(".nuestra-slider", {
  slidesPerView: 5,
  autoplay: {
      delay: 3000,
    },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    1199: {
      slidesPerView: 5,
      spaceBetween: 20,
    },
    768: {
      slidesPerView: 3,
      spaceBetween: 20,
    },
    576: {
      slidesPerView: 2,
      spaceBetween: 30,
    },
    320: {
      slidesPerView: 2,
      spaceBetween: 30,
    },
  },
});

//Map slider Swiper Slider Script
var swiper = new Swiper(".map-slider", {
  slidesPerView: 3,
  spaceBetween: 30,
  navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    320: {
      slidesPerView: 1,
      spaceBetween: 0,
    },
    640: {
      slidesPerView: 2,
      spaceBetween: 0,
    },
    768: {
      slidesPerView: 3,
      spaceBetween: 0,
    },
    1199: {
      slidesPerView: 3,
      spaceBetween: 0,
    },
  },
});


$('.magnific-gallery').magnificPopup({
    delegate: 'a',
    type: 'image',
    tLoading: 'Loading image #%curr%...',
    mainClass: 'mfp-img-mobile',
    gallery: {
      enabled: true,
      navigateByImgClick: true,
    },
  });