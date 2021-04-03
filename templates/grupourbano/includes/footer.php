<?php
if ($nombre_pagina != "mapa") { ?>
<?php $marcas = $articulo_model->get_marcas(array("grupo"=>2)) ?>
<section class="bg-marcas piquito">
  <div class="container">
    <div class="row">
      <div class="owl-carouselmarcas">
        <?php foreach ($marcas as $m) {  ?>
          <div class="item text-center">
            <img class="footer-marcas" src="<?php echo $m->path?>">
          </div>
        <?php }   ?>
      </div>
    </div>
  </div>
</section>
<?php } ?>

<!-- STATUS INFO -->
<section class="status-info">
  <!-- <div class="col-md-6">
    <div class="project-status"><span>proyectos y direcci&oacute;n</span> <small>Punt <img src="images/circle1.png" alt="Cricle" /> dos</small> <big><img src="images/circle2.png" alt="Circle" />2</big></div>
  </div> -->
  <div class="col-md-12 investors">
    <div class="container">
      <div class="row text-center">
        <div class="col-md-10 col-xs-12">
          <h4><a target="_blank" href="manual.pdf">Manual del inversor</a></h4>
          <div class="investor-info">
            <p>Preguntas frecuentes acerca del funcionamiento, comercializaci&oacute;n y construcci&oacute;n de viviendas.</p>
          </div>
          <div class="investor-status" style="width: 100%;">
            <a target="_blank" href="/templates/grupourbano/manual.pdf" class="btn btn-black"><img src="images/pdf-icon.png" alt="PDF" /> descargar pdf</a>
          </div>
        </div>
        <div class="col-md-2 col-xs-12">
          <img class="mt20 w100p" src="/admin/uploads/45/marcas/cdu.jpg" alt="Camara Empresaria de Desarrolladores Urbanos">
        </div>
      </div>
    </div>
  </div>
</section>

<footer>
  <div class="container">
    <div class="col-md-4">
      <div class="contact-info">
        <div class="brand"><img src="images/logo-footer.png" alt="Grupo Urbano" width="286"  /></div>
        <div class="brand"><img src="images/logo-small.png" alt="Grupo Urbano" width="286"  /></div>
        <?php /*
        <div class="brand"><img src="images/brand2.png" alt="Grupo Urbano" width="286"  /></div>
        */ ?>
        <div class="block">
            <a href="<?php echo mklink ("/") ?>">grupo urbano</a>
            <a href="<?php echo mklink ("/") ?>">brokers inmobiliarios</a>
        </div>
        <div class="hidden-xs">OFICINA</div>
        <hr class="mt10 mb10 hidden-xs">
        <p class="latolight"><?php echo ($empresa->direccion); ?>
            <?php if (!empty($empresa->codigo_postal)) { echo "CP: ".($empresa->codigo_postal); } ?>
            <br/><?php echo ($empresa->ciudad); ?>
        </p>
      </div>
    </div>
    <div class="col-md-4 quick-links">
      <div class="row m0">
        <div>
          <h6 class="titulo">VENTAS Y ALQUILERES</h6>
          <div class="pt8 latolight">
        		<?php $t = $web_model->get_text("tel1","0221 427 1544 / 45") ?>
            <span class="word">T:</span><span class="editable" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>"><?php echo $t->plain_text ?></span>
            <br>
        		<?php $t = $web_model->get_text("tel2","+54 (221) 525 1821 / 601 0023 / 5578357") ?>
            <span class="pb5 pt5 editable" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>">
            	<?php echo $t->plain_text ?>
          	</span>
          	<br>
        		<?php $t = $web_model->get_text("mail1","info@grupo-urbano.com.ar") ?>
            <span class="word">E:</span><span class="editable" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>"><?php echo $t->plain_text ?></span>
          </div>  
        </div>
        <div class="pt20">
          <h6 class="titulo">ADMINISTRACIÓN DE PROPIEDADES</h6>
          <div class="pt8 latolight">
        		<?php $t = $web_model->get_text("tel3","+ 54 9 (0221) 463-7615") ?>
            <span class="word">T:</span><span class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?> </span><br>
        		<?php $t = $web_model->get_text("mail2","administracion@grupo-urbano.com.ar") ?>
            <span class="word">E:</span><span class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?> </span>
          </div>  
        </div>
        <div class="pt20">
          <h6 class="titulo">ADMINISTRACIÓN DE CONSORCIOS</h6>
          <div class="pt8 latolight">
        		<?php $t = $web_model->get_text("teEl4","+54 9 (221) 437-6487 (Urgencias)") ?>
            <span class="word">T:</span><span class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></span><br>
        		<?php $t = $web_model->get_text("mail3","consorcios@grupo-urbano.com.ar") ?>
            <span class="word">E:</span><span class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?> </span>
          </div>  
        </div>
        <div class="pt20">
          <h6 class="titulo">PROYECTOS Y DESARROLLOS </h6>
          <div class="pt8 latolight">
        		<?php $t = $web_model->get_text("tel5","+54 9 (221) 637 2369") ?>
            <span class="word">T:</span><span class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></span><br>
        		<?php $t = $web_model->get_text("mail4","pablog@grupo-urbano.com.ar") ?>
            <span class="word">E:</span><span class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></span>
          </div>  
        </div>
        
      </div>
    </div>
    <div class="col-md-4 newsletter">
      <h5>newsletter</h5>
      <form onsubmit="return enviar_newsletter()">
        <input type="email" id="newsletter_email" placeholder="Escribe tu email..." />
        <button id="newsletter_submit" class="btn btn-bluue">suscribir</button>
      </form>
      <div class="social">
        <h5>seguinos</h5>
        <div class="block">
          <?php if (!empty($empresa->twitter)) { ?>
            <a target="_blank" href="<?php echo $empresa->twitter ?>"><img src="images/twitter.png" alt="Twitter" /></a>
          <?php } ?>
          <?php if (!empty($empresa->facebook)) { ?>
            <a target="_blank" href="<?php echo $empresa->facebook ?>"><img src="images/facebook.png" alt="Facebook" /></a>
          <?php } ?>
          <?php if (!empty($empresa->youtube)) { ?>
            <a target="_blank" href="<?php echo $empresa->youtube ?>"><img src="images/youtube.png" alt="Youtube" /></a>
          <?php } ?>
          <?php if (!empty($empresa->instagram)) { ?>
            <a target="_blank" href="<?php echo $empresa->instagram ?>"><img src="images/instagram-icon.png" alt="Instagram" /></a>
          <?php } ?>            
          <?php if (!empty($empresa->google_plus)) { ?>
            <a target="_blank" href="<?php echo $empresa->google_plus ?>"><img src="images/google-plus.png" alt="Google Plus" /></a>
          <?php } ?>
        </div>
      </div>
        <!-- <div class="contact-info" style="padding-top: 20px;">       
          <p>
              <?php if (!empty($empresa->telefono)) { ?>
                  Tel&eacute;fonos: <?php echo ($empresa->telefono); ?>
                  <?php if (!empty($empresa->telefono_2)) { ?>
                      <span>|</span> <?php echo ($empresa->telefono_2); ?>
                  <?php } ?>
              <?php } ?>
              <?php if (!empty($empresa->email)) { ?>
                  <br/>Email: <?php echo $empresa->email; ?>
              <?php } ?>
          </p>
        </div> -->

    </div>
  </div>
</footer>

<!-- COPYRIGHT -->
<section class="copyright">
  <div class="container">
    <div class="row">
      <div class="go-top"><a href="javascript:void(0);"></a></div>
      <div class="col-md-6">&copy; Grupo-Urbano Brokers Inmobiliarios - Todos Los Derechos Reservados</div>
      <div class="col-md-6">
        <div class="site-by"><a href="https://www.misticastudio.com/" target="_blank">Diseño Web Inmobiliarias <img src="/admin/resources/images/misticastudio.png" alt="Mistica Studio" /></a></div>
      </div>
    </div>
  </div>
</section>

<!-- SCRIPT'S --> 
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/owl.carousel.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
  $('.tabs .tab-buttons a').click(function(e){
    e.preventDefault();
    var content = $(e.currentTarget)[0].hash;
    $(".tab-content").hide();
    $(content).fadeIn(700);
    $('.tabs .tab-buttons a').removeClass("active");
    $(e.currentTarget).addClass("active");
  });
  var encontro = false;
  $(".search-box .tab-content").each(function(i,e){
    if ($(e).is(":visible")) { encontro = true; return; }
  });
  if (!encontro) {
    $(".search-box .tab-content").first().show();
    $('.tabs .tab-buttons a').first().addClass("active");
  }
});

//SIDEBAR NAV SCRIPT
( function( $ ) {
  $( document ).ready(function() {
    $(".sidebar-nav li.dropdown > a").on("click", function(){
		var element = $(this).parent("li");
		if (element.hasClass("open")) {
			element.removeClass("open");
			element.find("li").removeClass("open");
			element.find("ul").slideUp();
		}
		else {
			element.addClass("open");
			element.children("ul").slideDown();
			element.siblings("li").children("ul").slideUp();
			element.siblings("li").removeClass('open');
			element.siblings("li").find("li").removeClass('open');
			element.siblings("li").find("ul").slideUp();
		}
	});
});
} )( jQuery );

//OWL CAROUSEL(1) SCRIPT
jQuery(document).ready(function ($) {
"use strict";
$(".owl-carousel").owlCarousel({
      items : 3,
      itemsDesktop : [1279,2],
      itemsDesktopSmall : [979,2],
      itemsMobile : [767,1],
    });

$(".owl-carousel-clients").owlCarousel({
      items : 5,
      itemsDesktop : [1279,4],
      itemsDesktopSmall : [979,3],
      itemsMobile : [767,2],
    });

});

//GO TOP SCRIPT
jQuery(".go-top").hide();
jQuery(function () {
  jQuery(window).scroll(function () {
      if (jQuery(this).scrollTop() > 150) {
          jQuery('.go-top').fadeIn();
      } else {
          jQuery('.go-top');
      }
  });
  jQuery('.go-top').click(function () {
      jQuery('body,html').animate({
          scrollTop: 0
      }, 1500);
      return false;
  });
});
</script>
<script type="text/javascript">
function filtrar(form) {
  var submit_form = false;
  if (form == undefined) {
    submit_form = true;
    form = $(".filter_form").first();
  }
  if ($("#show-in-map").is(":checked")) {
    var url = "<?php echo mklink ("/") ?>mapa/";
  } else {
    var url = "<?php echo mklink ("/") ?>propiedades/";
  }
  var order = $("#sort-by").val();
  $("#filter_order").val(order);
  var offset = $("#show").val();
  $("#filter_offset").val(offset);
  var view = ($(".list-view").hasClass("active")) ? 0 : 1;
  $("#filter_view").val(view);
  
  var tipo_operacion = $(form).find(".filter_tipo_operacion").val();
  if (!isEmpty(tipo_operacion)) {
    url+=tipo_operacion+"/";
  }
  
  var localidad = $(form).find(".filter_localidad").val();
  if (!isEmpty(localidad)) {
    url+=localidad+"/";
  }
  
  if ($("#precio_minimo").length > 0) {
    var minimo = $("#precio_minimo").val().replace(".","");
    $("#precio_minimo_oculto").val(minimo);
    var maximo = $("#precio_maximo").val().replace(".","");
    $("#precio_maximo_oculto").val(maximo);  
  }

  $(form).attr("action",url);
  if (submit_form) $(form).submit();
  else return true;  
}
/*
$(document).ready(function(){
  $(".pagination a").click(function(e){
    e.preventDefault();
    var url = $(e.currentTarget).attr("href");
    
    var f = document.createElement("form");
    f.setAttribute('method',"post");
    f.setAttribute('action',url);
    $(f).css("display","none");
    
    var i = document.createElement("input");
    i.setAttribute('type',"hidden");
    i.setAttribute('name',"id_tipo_inmueble");
    i.setAttribute('value',$(".filter_tipo_propiedad").first().val());
    f.appendChild(i);
    
    var i = document.createElement("input");
    i.setAttribute('type',"hidden");
    i.setAttribute('name',"banios");
    i.setAttribute('value',$(".filter_banios").first().val());
    f.appendChild(i);  
    
    var i = document.createElement("input");
    i.setAttribute('type',"hidden");
    i.setAttribute('name',"dormitorios");
    i.setAttribute('value',$(".filter_dormitorios").first().val());
    f.appendChild(i);
    document.body.appendChild(f);
    f.submit();    
  });
});
*/

$(document).ready(function(){
  $("#show-in-list").click(function(){
    var v = $("#show-in-list").prop("checked");
    $("#show-in-map").prop("checked",!v);
  });
  $("#show-in-map").click(function(){
    var v = $("#show-in-map").prop("checked");
    $("#show-in-list").prop("checked",!v);
  });
});

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
      "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
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

<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script>
$(document).ready(function(){
  if ($("#precio_minimo").length > 0) {
    new AutoNumeric('#precio_minimo', { 
      'decimalPlaces':0,
      'decimalCharacter':',',
      'digitGroupSeparator':'.',
    });
  }
  if ($("#precio_maximo").length > 0) {
    new AutoNumeric('#precio_maximo', { 
      'decimalPlaces':0,
      'decimalCharacter':',',
      'digitGroupSeparator':'.',
    });
  }
})
</script>

<?php include("templates/comun/clienapp.php") ?>