<?php include "includes/init.php" ?>
<?php $page_active = "contacto" ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include "includes/head.php" ?>
</head>
<body>
  <?php include "includes/header.php" ?>

  <section class="subheader">
    <div class="container">
      <h1>Contacto</h1>
      <div class="breadcrumb right"><a  href="<?php echo mklink ("/") ?>" >Inicio </a><i class="fa fa-angle-right"></i> <a class="current">Contacto</a></div>
      <div class="clear"></div>
    </div>
  </section>

  <?php if ($empresa->latitud != 0 && $empresa->longitud != 0) { ?>
    <section>
      <div style="height: 450px; width: 100%;" id="mapid"></div>
    </section>
  <?php } ?>

  <section class="module contact-details">
    <div class="container">

      <div class="row">
        <?php if (!empty($empresa->horario)) { ?>
          <div class="col-lg-3 col-md-3">
            <div class="contact-item">
              <i class="fa fa-clock-o"></i>
              <h4>Horarios</h4>
              <p><?php echo $empresa->horario ?></p>
            </div>
          </div>
        <?php } ?>
        <?php if (!empty($empresa->telefono)) {  ?>
          <div class="col-lg-3 col-md-3">
            <div class="contact-item">
              <i class="fa fa-phone"></i>
              <h4>Teléfonos</h4>
              <p><?php echo $empresa->telefono ?></p>
              <p><?php echo $empresa->telefono_2 ?></p>
            </div>
          </div>
        <?php } ?>
        <?php if (!empty($empresa->direccion)) {  ?>
          <div class="col-lg-3 col-md-3">
            <div class="contact-item">
              <i class="fa fa-map-marker"></i>
              <h4>Visitanos</h4>
              <p><?php echo ($empresa->direccion) ?><br/>CP <?php echo $empresa->codigo_postal.". ".$empresa->ciudad  ?></p>
            </div>
          </div>
        <?php } ?>
        <div class="col-lg-3 col-md-3">
          <div class="contact-item">
            <i class="fa fa-share-alt"></i>
            <h4>Redes Sociales</h4>
            <ul class="social-icons">
              <?php if (!empty($empresa->facebook)) { ?><li><a target="_blank" href="<?php echo $empresa->facebook ?>"><i class="fa fa-facebook"></i></a></li><?php } ?>
              <?php if (!empty($empresa->twitter)) { ?><li><a target="_blank" href="<?php echo $empresa->twitter ?>"><i class="fa fa-twitter"></i></a></li><?php } ?>
              <?php if (!empty($empresa->youtube)) {  ?><li><a target="_blank" href="<?php echo $empresa->youtube ?>"><i class="fa fa-youtube"></i></a></li><?php } ?>
              <?php if (!empty($empresa->instagram)) {  ?><li><a target="_blank" href="<?php echo $empresa->instagram ?>"><i class="fa fa-instagram"></i></a></li><?php } ?>
            </ul>
          </div>
        </div>
      </div><!-- end row -->

    </div>
  </section>


  <section class="module">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8">
          <div class="widget property-single-item property-location comment-form">
            <h4><span>Contacto</span><hr class="divisorline"> </h4>
            <?php $t = $web_model->get_text("contacto","<b>Dejanos tu mensaje</b> y te responderemos a la brevedad.")?> 
            <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></p>
            <form onsubmit="return enviar_contacto()">
              <div class="form-block">
                <label>
                  Nombre Completo *
                </label>
                <input class="requiredField" type="text" placeholder="Nombre Completo" id="contacto_nombre"  value="" />
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6">
                  <div class="form-block">
                    <label>
                      Email *
                    </label>
                    <input class="email requiredField" type="text" placeholder="Tu email" id="contacto_email" name="email" value="" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="form-block">
                    <label>Whatsapp *</label>
                    <input type="text" placeholder="Número sin 0 ni 15" name="phone" id="contacto_telefono" value="" />
                  </div>
                </div>
              </div>
              <div class="form-block">
                <label>Asunto</label>
                <select id="contacto_asunto">
                 <?php $asuntos = explode(";;;",$empresa->asuntos_contacto);
                  foreach($asuntos as $a) { ?>
                    <option><?php echo $a ?></option>
                 <?php } ?>
                </select>
               </div>
              <div class="form-block">
                <label>
                  Mensaje *
                </label>
                <textarea class="requiredField" placeholder="Tu mensaje..." id="contacto_mensaje" name="message"></textarea>
              </div>
              <div class="form-block">
                <input type="submit" value="Enviar" id="contacto_submit" />
              </div>
            </form>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 sidebar">
          <div class="widget widget-sidebar recent-properties">
            <h4><span>Links Rápidos</span><hr class="divisorline"> </h4>
            <div class="widget-content box">
              <ul class="bullet-list">
                <li><a href="<?php echo mklink ("/") ?>">Inicio</a></li>
                <li><a href="<?php echo mklink ("propiedades/alquileres/") ?>">Alquileres</a></li>
                <li><a href="<?php echo mklink ("propiedades/ventas/") ?>">Ventas</a></li>
                <?php /*
                <li><a href="<?php echo mklink ("propiedades/emprendimientos/") ?>">Emprendimientos</a></li>
                */ ?>
                <?php $cats = $entrada_model->get_subcategorias() ?>
                <?php foreach($cats as $c) { ?>
                  <?php $entradas = $entrada_model->get_list(array("id_categoria"=>$c->id)); ?>
                  <?php if (sizeof($entradas)>0) { ?>
                    <?php 
                    // Si tenemos exactamente una entrada, no ponemos submenu sino que lo hacemos en el mismo menu general
                    if (sizeof($entradas) == 1) { 
                      $r = $entradas[0]; ?>
                      <li class="<?php echo ($page_active == $c->link)?'current-menu-item' :'' ?>">
                        <a href="<?php echo mklink ($r->link) ?>"><?php echo $r->titulo ?></a>
                      </li>
                    <?php } else { ?>
                      <li class="menu-item-has-children <?php echo ($page_active == $c->link)?'current-menu-item' :'' ?>">
                        <a href="<?php echo mklink ("/") ?>"><?php echo ($c->nombre) ?></a>
                        <ul class="sub-menu">
                          <?php foreach ($entradas as $r) {  ?>
                            <li><a href="<?php echo mklink ($r->link) ?>"><?php echo $r->titulo ?></a></li>
                          <?php } ?>
                        </ul>
                      </li>
                    <?php } ?>
                  <?php } ?>
                <?php } ?>                
              </ul>
            </div><!-- end widget content -->
          </div><!-- end widget -->
        </div>
      </div><!-- end row -->
    </div><!-- end container -->
  </section>
<?php include "includes/footer.php" ?>
<?php include "includes/scripts.php" ?>

<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
  <?php if (!empty($empresa->posiciones) && !empty($empresa->latitud && !empty($empresa->longitud))) { ?>

    var mymap = L.map('mapid').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 16);

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
</script>

<script type="text/javascript">
function enviar_contacto() {
  
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var mensaje = $("#contacto_mensaje").val();
  var telefono = $("#contacto_telefono").val();
  var asunto = $("#contacto_asunto").val();

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
  if (!isTelephone(telefono)) {
    alert("Por favor controle el numero de telefono. Debe ingresarlo completo con la caracteristica sin 0 ni 15.");
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
    "telefono":telefono,
    "email":email,
    "mensaje":mensaje,
    "asunto":"asunto",
    "id_empresa":ID_EMPRESA,
  }
  $.ajax({
    "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
        location.reload();
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $("#contacto_submit").removeAttr('disabled');
      }
    }
  });
  return false;
}
</script>
</body>
</html>