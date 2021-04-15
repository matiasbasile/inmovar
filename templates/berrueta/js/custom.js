//BACK TO TOP SCRIPT
jQuery(".go-top").hide();
jQuery(function () {
  jQuery(window).scroll(function () {
      if (jQuery(this).scrollTop() > 150) {
          jQuery('.go-top').fadeIn();
      } else {
          jQuery('.go-top').fadeOut();
      }
  });
  jQuery('.go-top').click(function () {
      jQuery('body,html').animate({
          scrollTop: 0
      }, 350);
      return false;
  });
});

//USER DROPDOWN SCRIPT
jQuery('html').click(function() {
  jQuery('#profile-menu').hide();
})
  jQuery('#user-dropdown').click(function(e){
   e.stopPropagation();
});
  jQuery('#toggle-dropdown').click(function(e) {
   jQuery('#profile-menu').toggle();
});
