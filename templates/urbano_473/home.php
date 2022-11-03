<?php include 'includes/init.php' ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include 'includes/head.php' ?>
</head>
<?php $slider = $web_model->get_slider(); ?>  
<body>
  <section>
    <?php $banner = $entrada_model->get(44831) ?>
    <div class="banner-contacto" style="<?php echo "/admin/" . $banner->path ?>">
    <div class="banner-contacto">
      <?php $t = $web_model->get_text("arriba-titulo","Urbano 473"); ?>
      <h1 data-id="<?php echo $t->id?>" data-clave="<?php echo $t->clave ?>" class="editable"><?php echo $t->plain_text ?></h1>

      <?php $t = $web_model->get_text("arriba-subtitulo","473 E/30 y 31, City Bell"); ?>
      <h4 data-id="<?php echo $t->id?>" data-clave="<?php echo $t->clave ?>" class="editable"><?php echo $t->plain_text ?></h4>

      <?php $t = $web_model->get_text("arriba-desc","Pensado para familias que buscan seguridad, <br> priorizando la cercanía de la ciudad."); ?>
      <p data-id="<?php echo $t->id?>" data-clave="<?php echo $t->clave ?>" class="editable"><?php echo $t->plain_text ?></p>

      <a href="<?php echo mklink('/')?>#sobre_nosotros_section" class="mouse-icon">
        <div class="mouse-wheel"></div>
      </a>
    </div>
    <div class="form-contacto" id="lanzamiento_preventa">
      <div class="">
        <h4 class="text-center">Lanzamiento preventa</h4>
        <hr class="divider">
        <p class="text-center">¡Solicitá asesoramiento ahora!</p>
        <div class="row">
          <div class="col-md-6 mb-3">
            <input type="text" class="form-control" id="contacto_nombre" placeholder="Nombre completo">
          </div>
          <div class="col-md-6 mb-3">
            <input type="number" class="form-control" id="contacto_telefono" placeholder="Whatsapp (sin 0 ni 15)">
          </div>
          <div class="col-md-12 mb-3">
            <input type="email" class="form-control" id="contacto_email" placeholder="Email">
          </div>
          <div class="col-md-12 mb-3">
            <textarea class="form-control" id="contacto_mensaje" placeholder="Mensaje"></textarea>
          </div>
          <div class="col-md-12 mb-3">
            <button onclick="enviar_contacto()" class="btn btn-primary btn-block btn-lg text-uppercase boton-consulta" id="contacto_submit"><i class="fa-brands fa-whatsapp wsp-icon"></i>Enviar consulta</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="mt-5 sobre-nosotros" id="sobre_nosotros_section">
    <div class="container">
      <div class="sobre-nosotros-titulo">
        <h4>OBRA U CANTILO</h4>
        <hr class="divider">
        <?php $t = $web_model->get_text("sobre-desc","Pensado para familias que buscan seguridad, <br> priorizando la cercanía de la ciudad."); ?>
        <p data-id="<?php echo $t->id?>" data-clave="<?php echo $t->clave ?>" class="editable"><?php echo $t->plain_text ?></p>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <?php 
          $t = $web_model->get_text("caracteristica-1-imagen","assets/img/foto1.png");
          $t1 = $web_model->get_text("caracteristica-1-1","9 lotes exclusivos");
          $t2 = $web_model->get_text("caracteristica-1-2","Cuenta con 9 lotes de 400m2 en propiedad horizontal");
          ?>
          <div class="carta">
            <a class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" data-fancybox="gallery" data-src="<?php echo $t->plain_text ?>" data-caption="<?php echo $t1->plain_text ?>&lt;br /&gt;<?php echo $t2->plain_text ?>">
              <div class="carta-img-cont">
                <img src="<?php echo $t->plain_text ?>" class="img-rounded">
              </div>
            </a>
            <div>
              <h4 class="text-center text-uppercase editable" data-id="<?php echo $t1->id ?>" data-clave="<?php echo $t1->clave ?>"><?php echo $t1->plain_text ?></h4>
              <p class="text-center editable" data-id="<?php echo $t2->id ?>" data-clave="<?php echo $t2->clave ?>"><?php echo $t2->plain_text ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-3">
          <?php 
          $t = $web_model->get_text("caracteristica-2-imagen","assets/img/imagen2.jpg");
          $t1 = $web_model->get_text("caracteristica-2-1","9 lotes exclusivos");
          $t2 = $web_model->get_text("caracteristica-2-2","Cuenta con 9 lotes de 400m2 en propiedad horizontal");
          ?>          
          <div class="carta">
            <a class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" data-fancybox="gallery" data-src="<?php echo $t->plain_text ?>" data-caption="<?php echo $t1->plain_text ?>&lt;br /&gt;<?php echo $t2->plain_text ?>">
              <div class="carta-img-cont">
                <img src="<?php echo $t->plain_text ?>" class="img-rounded">
              </div>
            </a>
            <div>
              <h4 class="text-center text-uppercase editable" data-id="<?php echo $t1->id ?>" data-clave="<?php echo $t1->clave ?>"><?php echo $t1->plain_text ?></h4>
              <p class="text-center editable" data-id="<?php echo $t2->id ?>" data-clave="<?php echo $t2->clave ?>"><?php echo $t2->plain_text ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-3">
          <?php 
          $t = $web_model->get_text("caracteristica-3-imagen","assets/img/imagen2.jpg");
          $t1 = $web_model->get_text("caracteristica-3-1","9 lotes exclusivos");
          $t2 = $web_model->get_text("caracteristica-3-2","Cuenta con 9 lotes de 400m2 en propiedad horizontal");
          ?>                    
          <div class="carta">
            <a class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" data-fancybox="gallery" data-src="<?php echo $t->plain_text ?>" data-caption="<?php echo $t1->plain_text ?>&lt;br /&gt;<?php echo $t2->plain_text ?>">
              <div class="carta-img-cont">
                <img src="<?php echo $t->plain_text ?>" class="img-rounded">
              </div>
            </a>
            <div>
              <h4 class="text-center text-uppercase editable" data-id="<?php echo $t1->id ?>" data-clave="<?php echo $t1->clave ?>"><?php echo $t1->plain_text ?></h4>
              <p class="text-center editable" data-id="<?php echo $t2->id ?>" data-clave="<?php echo $t2->clave ?>"><?php echo $t2->plain_text ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-3">
          <?php 
          $t = $web_model->get_text("caracteristica-4-imagen","assets/img/imagen4.jpg");
          $t1 = $web_model->get_text("caracteristica-4-1","Barrio cerrado boutique");
          $t2 = $web_model->get_text("caracteristica-4-2","Es un barrio cerrado dentro de un concepto de baja escala");
          ?>                    
          <div class="carta">
            <a class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" data-fancybox="gallery" data-src="<?php echo $t->plain_text ?>" data-caption="<?php echo $t1->plain_text ?>&lt;br /&gt;<?php echo $t2->plain_text ?>">
              <div class="carta-img-cont">
                <img src="<?php echo $t->plain_text ?>" class="img-rounded">
              </div>
            </a>
            <div>
              <h4 class="text-center text-uppercase editable" data-id="<?php echo $t1->id ?>" data-clave="<?php echo $t1->clave ?>"><?php echo $t1->plain_text ?></h4>
              <p class="text-center editable" data-id="<?php echo $t2->id ?>" data-clave="<?php echo $t2->clave ?>"><?php echo $t2->plain_text ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section style="background-color: #ededed">
    <div class="">
      <div class="owl-carousel owl-theme owl-carousel3 slider-section">
        <div class="item">
          <div class="carta-slider">
            <div class="carta-fondo">
              <?php $t = $web_model->get_text("car-1-imagen","assets/img/asfalto.png"); ?>
              <img src="<?php echo $t->plain_text ?>" class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
            </div>
            <?php $t2 = $web_model->get_text("car-1-texto","Asfalto"); ?>
            <p class="text-center editable" data-id="<?php echo $t2->id ?>" data-clave="<?php echo $t2->clave ?>"><?php echo $t2->plain_text ?></p>
          </div>
        </div>
        <div class="item">
          <div class="carta-slider">
            <div class="carta-fondo">
              <?php $t = $web_model->get_text("car-2-imagen","assets/img/luz.png"); ?>
              <img id="img2" src="<?php echo $t->plain_text ?>" class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
            </div>
            <?php $t2 = $web_model->get_text("car-2-texto","Luz eléctrica"); ?>
            <p class="text-center editable" data-id="<?php echo $t2->id ?>" data-clave="<?php echo $t2->clave ?>"><?php echo $t2->plain_text ?></p>
          </div>
        </div>
        <div class="item">
          <div class="carta-slider">
            <div class="carta-fondo">
              <?php $t = $web_model->get_text("car-3-imagen","assets/img/agua.png"); ?>
              <img id="img3" src="<?php echo $t->plain_text ?>" class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
            </div>
            <?php $t2 = $web_model->get_text("car-3-texto","Agua corriente"); ?>
            <p class="text-center editable" data-id="<?php echo $t2->id ?>" data-clave="<?php echo $t2->clave ?>"><?php echo $t2->plain_text ?></p>
          </div>
        </div>
        <div class="item">
          <div class="carta-slider">
            <div class="carta-fondo">
              <?php $t = $web_model->get_text("car-4-imagen","assets/img/cam-seguridad.png"); ?>
              <img id="img4" src="<?php echo $t->plain_text ?>" class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
            </div>
            <?php $t2 = $web_model->get_text("car-4-texto","Cámaras de seguridad"); ?>
            <p class="text-center editable" data-id="<?php echo $t2->id ?>" data-clave="<?php echo $t2->clave ?>"><?php echo $t2->plain_text ?></p>
          </div>
        </div>
        <div class="item">
          <div class="carta-slider">
            <div class="carta-fondo">
              <?php $t = $web_model->get_text("car-5-imagen","assets/img/asfalto.png"); ?>
              <img src="<?php echo $t->plain_text ?>" class="editable editable-img" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
            </div>
            <?php $t2 = $web_model->get_text("car-5-texto","Asfalto"); ?>
            <p class="text-center editable" data-id="<?php echo $t2->id ?>" data-clave="<?php echo $t2->clave ?>"><?php echo $t2->plain_text ?></p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="ubicacion">
    <div class="">
      <h4>Ubicación</h4>
      <hr class="divider">
      <?php $t = $web_model->get_text("ubicacion-desc","Se encuentra en 473 e/30 y 31, City Bell. Se destaca por su cercanía al centro de la ciudad <br>y estar ubicado en un lugar en plena expanción y desarrollo."); ?>
      <p data-id="<?php echo $t->id?>" data-clave="<?php echo $t->clave ?>" class="editable"><?php echo $t->plain_text ?></p>
      <div class="row">
        <div class="col-md-6">
          <div id="map_canvas"></div>
        </div>
        <div class="col-md-6">
          <div class="owl-carousel owl-theme owl-carousel1">
            <?php foreach ($slider as $s) { ?>
              <div class="item">
                <img src="<?php echo $s->path; ?>">
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="lanzamiento">
    <div class="">
      <div class="stroke-text">
        <h1 id="lanzamiento">Lanzamiento</h1>
      </div>
      <h1>Pre-venta</h1>
      <?php $t = $web_model->get_text("lanzamiento-desc","Obtené la carpeta del proyecto con precio y formas de pago"); ?>
      <p data-id="<?php echo $t->id?>" data-clave="<?php echo $t->clave ?>" class="editable"><?php echo $t->plain_text ?></p>
      <div class="text-center">
        <a class="boton-lanzamiento" href="<?php echo mklink('/') ?>#lanzamiento_preventa">¡DESCARGAR CARPETA DEL PROYECTO!</a>
      </div>
    </div>
  </section>

  <footer>
    <div class="text-center">
      <p class="d-inline-block">Desarrolla y Comercializa GRUPO URBANO</p>
      <a href="https://www.grupo-urbano.com.ar" target="_blank">
        <img class="d-inline-block" src="assets/img/imagen-footer.png">
      </a>
    </div>
  </footer>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/fancybox.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<?php include_once("templates/comun/mapa_js.php"); ?>

<script>

$(document).ready(function(){

  <?php if (!empty($empresa->latitud && !empty($empresa->longitud))) { ?>

    var mymap = L.map('map_canvas').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 16);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
    }).addTo(mymap);

    <?php
    $posiciones = explode("/",$empresa->posiciones);
    for($i=0;$i<sizeof($posiciones);$i++) { 
      $pos = explode(";",$posiciones[$i]); ?>
      L.marker([<?php echo $pos[0] ?>,<?php echo $pos[1] ?>]).addTo(mymap);
    <?php } ?>

  <?php } ?>
});


function enviar_contacto() {
    
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var telefono = $("#contacto_telefono").val();
  var mensaje = $("#contacto_mensaje").val();
  var asunto = "Contacto desde Web - Grupo 473";
  
  if (isEmpty(nombre) || nombre == "Nombre") {
    alert("Por favor ingrese un nombre");
    $("#contacto_nombre").focus();
    return false;          
  }
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido");
    $("#contacto_email").focus();
    return false;          
  }
  if (isEmpty(telefono) || telefono == "Telefono") {
    alert("Por favor ingrese un telefono");
    $("#contacto_telefono").focus();
    return false;          
  }
  if (isEmpty(mensaje) || mensaje == "Mensaje") {
    alert("Por favor ingrese un mensaje");
    $("#contacto_mensaje").focus();
    return false;              
  }    
  
  $("#contacto_submit").attr('disabled', 'disabled');
  var datos = {
    "para":"<?php echo $empresa->email ?>",
    "nombre":nombre,
    "email":email,
    "mensaje":mensaje,
    "telefono":telefono,
    "asunto":asunto,
    "id_empresa":ID_EMPRESA,
  }
  $.ajax({
    "url":"/admin/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        var url = "https://wa.me/"+"<?php echo $empresa->telefono_f; ?>";
        url+= "?text="+encodeURIComponent(mensaje);
        var open = window.open(url,"_blank");
        if (open == null || typeof(open)=='undefined') {
          location.href = url;
        }
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $("#contacto_submit").removeAttr('disabled');
      }
    }
  });
  return false;
}  


$('.owl-carousel1').owlCarousel({
  loop: true,
  margin: 10,
  nav: false,
  dots: false,
  autoplay:true,
  autoplayTimeout:2000,
  autoplayHoverPause:true,
  items: 1,
})

$( ".carta-slider" ).mouseover(function(e) {
  var img = $(e.currentTarget).find('.asfalto-img');
  img.attr("src","assets/img/asfalto-hover.png");
});

$( ".carta-slider" ).mouseout(function(e) {
  var img = $(e.currentTarget).find('.asfalto-img');
  img.attr("src","assets/img/asfalto.png");
});

$( ".carta-slider" ).mouseover(function(e) {
  var img = $(e.currentTarget).find('#img2');
  img.attr("src","assets/img/luz-hover.png");
});

$( ".carta-slider" ).mouseout(function(e) {
  var img = $(e.currentTarget).find('#img2');
  img.attr("src","assets/img/luz.png");
});

$( ".carta-slider" ).mouseover(function(e) {
  var img = $(e.currentTarget).find('#img3');
  img.attr("src","assets/img/agua-hover.png");
});

$( ".carta-slider" ).mouseout(function(e) {
  var img = $(e.currentTarget).find('#img3');
  img.attr("src","assets/img/agua.png");
});

$( ".carta-slider" ).mouseover(function(e) {
  var img = $(e.currentTarget).find('#img4');
  img.attr("src","assets/img/cam-seguridad-hover.png");
});

$( ".carta-slider" ).mouseout(function(e) {
  var img = $(e.currentTarget).find('#img4');
  img.attr("src","assets/img/cam-seguridad.png");
});

$( ".carta-slider" ).mouseover(function(e) {
  var img = $(e.currentTarget).find('.asfalto-img');
  img.attr("src","assets/img/asfalto-hover.png");
});

$( ".carta-slider" ).mouseout(function(e) {
  var img = $(e.currentTarget).find('.asfalto-img');
  img.attr("src","assets/img/asfalto.png");
});

$('.owl-carousel3').owlCarousel({
  loop:true,
  margin:15,
  nav: true,
  navText: ["<div class='nav-button owl-prev izquierda'><i class='fa-solid fa-chevron-left'></i></div>", "<div class='nav-button owl-next derecha'><i class='fa-solid fa-chevron-right'></i></div>"],
  responsiveClass:true,
  responsive:{
    0:{
      items:1,
      nav: false
    },
    600:{
      items:1,
      nav:false
    },
    1000:{
      items:4,
      nav:true,
      loop:false
    }
  }
})

</script>

</body>

</html>