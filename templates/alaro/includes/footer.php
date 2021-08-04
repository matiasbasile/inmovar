<div class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-4 en-movil-center">
        <h5>Informaci&oacute;n de Contacto</h5>
        <div class="contact-info">
            <?php if (!empty($empresa->direccion)) {  ?>
              <div class="block">
                <a href="javascript:void(0)">
                <i class="fa fa-map-marker" aria-hidden="true"></i> 
                <?php echo $empresa->direccion ?>
                <br><span><?php echo $empresa->ciudad ?></span>
                 </a>
              </div>
            <?php } ?>
            <?php if (!empty($empresa->telefono)) {  ?><div class="block"><a href="tel:<?php echo $empresa->telefono ?>"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $empresa->telefono ?></a></div><?php } ?>
        </div>
      </div>
      <div class="col-md-4">
        <div class="next-investment">
          <h4>ESTAS BUSCANDO<br>
            TU PR&Oacute;XIMA INVERSI&Oacute;N?
          </h4>
          <a href="<?php echo mklink("contacto/"); ?>">COMUNICATE</a> 
          <div class="header-social">
            <ul>
              <?php if (!empty($empresa->facebook)) { ?>
                <li><a href="<?php echo $empresa->facebook ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
              <?php } ?>
              <?php if (!empty($empresa->youtube)) { ?>
                <li><a href="<?php echo $empresa->youtube ?>" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
              <?php } ?>
              <?php if (!empty($empresa->instagram)) { ?>
                <li><a href="<?php echo $empresa->instagram ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
              <?php } ?>
            </ul>
          </div>          
        </div>
      </div>
      <div class="col-md-4 en-movil-center">
        <h5>Suscribete al Newsletter</h5>
        <form onsubmit="return enviar_newsletter()" class="subscribe-info">
          <input id="newsletter_email" type="email" placeholder="Escribe su email" />
          <input id="newsletter_submit" class="btn btn-black" type="submit" value="enviar" />
          <p>Suscribete a nuestro newsletter para recibir <br>
            informaci&oacute;n sobre las &uacute;ltimas novedades. </p>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- COPYRIGHT -->
<div class="copyright">
  <div class="container">
    <p><span>Edificios Alaro.</span> Todos los Derechos Reservados.</p>
    <p class="pt20"><a href="https://www.misticastudio.com/" target="_blank"><img src="assets_nuevo/images/mistica-logo.png" alt="Mistica Logo" /></a></p>
    <div class="back-top"><a href="javascript:void(0);"><i class="fa fa-chevron-up" aria-hidden="true"></i></a></div>
  </div>
</div>
<script type="text/javascript" src="js/jquery.min.js"></script> 
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/flexslider.js"></script>  
<script type="text/javascript" src="js/owl.carousel.js"></script> 
<script type="text/javascript" src="js/swiper.js"></script> 
<script type="text/javascript">
$('.small-list').hover (
    function() {
      $(this).addClass('hover');
    },
    function() {
      $(this).removeClass('hover');
    }
  );

//ACCORDION SCRIPT
jQuery(document).ready(function() {
  function close_accordion_section() {
    jQuery('.accordion .accordion-title a').removeClass('active');
    jQuery('.accordion .accordion-content').slideUp(300).removeClass('open');
  }
  jQuery('.accordion-title a').click(function(e) {
    var currentAttrValue = jQuery(this).attr('href');
    if(jQuery(e.target).is('.active')) {
      close_accordion_section();
    }else {
      close_accordion_section();
      jQuery(this).addClass('active');
      jQuery('.accordion ' + currentAttrValue).slideDown(300).addClass('open'); 
    }
    e.preventDefault();
  });
});
  
/*OWL CAROUSEL SCRIPT*/
jQuery(document).ready(function ($) {
"use strict";
  $(".products").owlCarousel({
    autoplay: true,
    rewind: true,
    nav: false,
    dots: true,
    responsiveClass:true,
    responsive: {
      0: {
        items: 1,
      },
      979: {
        items: 3,
      },
      1199: {
        items: 5,
      }
    },
  });
});
    
jQuery(document).ready(function ($) {
"use strict";
  $(".on-going").owlCarousel({
    autoplay: true,
    rewind: true,
    nav: false,
    dots: true,
    responsiveClass:true,
    responsive: {
      0: {
        items: 1,
      },
      979: {
        items: 3,
      },
      1199: {
        items: 4,
      }
    },
  });
});
    
jQuery(document).ready(function ($) {
"use strict";
  $(".finish-project").owlCarousel({
    autoplay: true,
    rewind: true,
    nav: false,
    dots: true,
    items : 5,
    responsiveClass:true,
    responsive: {
      0: {
        items: 1,
      },
      979: {
        items: 3,
      },
      1199: {
        items: 5,
      }
    },
  });
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
      }, 350);
      return false;
  });
});  

//FLEXSLIDER SCRIPT
(function($){
  $(window).load(function(){
    $('.flexslider').flexslider({
      animation: "slide",
      animationLoop: true,
      start: function(slider){
      $('body').removeClass('loading');
      }
    });
  });
})(jQuery);

</script>
<script type="text/javascript">
function enviar_newsletter() {
  var email = $("#newsletter_email").val();
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido.");
    $("#newsletter_email").focus();
    return false;
  }
  $("#newsletter_submit").attr('disabled', 'disabled');
  var datos = {
    "email":email,
    "mensaje":"Registro a Newsletter",
    "asunto":"Registro a Newsletter",
    "para":"<?php echo $empresa->email ?>",
    "id_empresa":ID_EMPRESA,
    "id_origen":2,
  }
  $.ajax({
    "url":"/admin/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        alert("Muchas gracias por registrarse a nuestro newsletter!");
        location.reload();
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $("#newsletter_submit").removeAttr('disabled');
      }
    }
  });  
  return false;
}  
</script>
<?php include("templates/comun/clienapp.php") ?>