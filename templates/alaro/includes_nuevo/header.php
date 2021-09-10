<div class="top-header">
  <div class="header-social">
    <ul>
      <?php if (!empty($empresa->facebook)) {  ?>
        <li><a href="<?php echo $empresa->facebook ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
      <?php } ?>
          <?php if (!empty($empresa->instagram)) {  ?>
        <li><a href="<?php echo $empresa->instagram ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
      <?php } ?>
          <?php if (!empty($empresa->youtube)) {  ?>
        <li><a href="<?php echo $empresa->youtube ?>" target="_blank"><i class="fa fa-play" aria-hidden="true"></i></a></li>
      <?php } ?>
    </ul>
  </div>
  <ul class="contact-info">
    <?php if (!empty($empresa->direccion)) {  ?><li><a href="javascript:void(0)"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $empresa->direccion." ".$empresa->ciudad ?></a></li><?php } ?>
    <?php if (!empty($empresa->telefono)) {  ?><li><a href="tel:<?php echo $empresa->telefono ?>"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $empresa->telefono ?></a></li><?php } ?>
  </ul>
</div>
<header>
  <div class="logo"><a href="<?php echo mklink ("/") ?>">
    <?php if ($nombre_pagina == "alquileres") {  ?>
      <img style="max-width: 200px" src="images/reyes.png" alt="Logo" class="reyes" />
    <?php } else { ?>
      <img src="assets_nuevo/images/logo1.png" alt="Logo" /></a>
    <?php } ?>
  </div>
  <a href="javascript:void(0);" onClick="$('.header-right').slideToggle();" class="dots-toggle"><span></span> <span></span> <span></span></a>
  <div class="header-right">
    <nav>
      <ul>
        <li>
          <a href="<?php echo mklink ("propiedades/proximos-proyectos/") ?>">Edificios en Desarrollo</a>
        </li>
        <li>
          <a href="<?php echo mklink ("propiedades/ventas/") ?>">Venta de Terminados</a>
        </li>
        <li>
          <a href="<?php echo mklink ("propiedades/alquileres/") ?>">Alquileres</a>
        </li>
        <li>
          <a href="<?php echo mklink ("propiedades/proyectos-finalizados/") ?>">Proyectos Finalizados</a>
        </li>
      </ul>
    </nav>
  </div>
  <a href="javascript:void(0);" class="toggle-menu"><span></span> <span></span> <span></span></a>
</header>

<div class="slide-popup">
  <a class="cloose" href="javascript:void(0)" onclick="$('html').removeClass('sidebar-open');"><i class="fa fa-close"></i></a>
  <h3>Sobre Nosotros</h3>
  <ul class="menu">
    <li>
      <?php $nos = $entrada_model->get(1695)?>
      <a href="<?php echo mklink ($nos->link) ?>">Quienes Somos</a>
    </li>
    <li>
      <a href="<?php echo mklink ("contacto/") ?>">Contacto</a>
    </li>
  </ul>
  <ul class="contact-info">
    <?php if (!empty($empresa->direccion)) {  ?><li><a href="javascript:void(0)"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $empresa->direccion." ".$empresa->ciudad ?></a></li><?php } ?>
    <?php if (!empty($empresa->telefono)) {  ?><li><a href="tel:<?php echo $empresa->telefono ?>"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $empresa->telefono ?></a></li><?php } ?>
  </ul>
  <div id="map_canvas"></div>
  <div class="form-wrap">
    <h3>Enviar Consulta</h3>
    <form onsubmit="return enviar_contacto_header()">
      <div class="row">
        <div class="col-md-6">
          <input type="text" id="contacto_nombre" placeholder="Nombre" />
        </div>
        <div class="col-md-6">
          <input type="text" id="contacto_apellido" placeholder="Apellido" />
        </div>
        <div class="col-md-6">
          <input type="tel" id="contacto_telefono" placeholder="WhasApp (sin 0 ni 15)" />
        </div>
        <div class="col-md-6">
          <input type="email" id="contacto_email" placeholder="Email" />
        </div>
        <div class="col-md-12">
          <textarea id="contacto_mensaje" placeholder="Escribir mensaje"></textarea>
        </div>
        <div class="col-md-12 text-center">
          <input class="btn btn-red" type="submit" id="contacto_submit" value="enviar consulta" />
        </div>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript">
          function enviar_contacto_header() {

            var nombre = jQuery("#contacto_nombre").val();
            var email = jQuery("#contacto_email").val();
            var mensaje = jQuery("#contacto_mensaje").val();
            var telefono = jQuery("#contacto_telefono").val();

            if (isEmpty(nombre) || nombre == "Nombre") {
              alert("Por favor ingrese un nombre");
              jQuery("#contacto_nombre").focus();
              return false;          
            }

            if (isEmpty(apellido) || apellido == "Apellido") {
              alert("Por favor ingrese un apellido");
              jQuery("#contacto_apellido").focus();
              return false;          
            }


            if (isEmpty(telefono) || telefono == "telefono") {
              alert("Por favor ingrese un telefono");
              jQuery("#contacto_telefono").focus();
              return false;          
            }

            if (!validateEmail(email)) {
              alert("Por favor ingrese un email valido");
              jQuery("#contacto_email").focus();
              return false;          
            }
            if (isEmpty(mensaje) || mensaje == "Mensaje") {
              alert("Por favor ingrese un mensaje");
              jQuery("#contacto_mensaje").focus();
              return false;              
            }    
            jQuery("#contacto_submit").attr('disabled', 'disabled');
            var datos = {
              "para":"<?php echo $empresa->email ?>",
              "nombre":nombre,
              "telefono":telefono,
              "email":email,
              "asunto":"Consulta desde web",
              "mensaje":mensaje,
              "id_empresa":ID_EMPRESA,
            }
            jQuery.ajax({
              "url":"/admin/consultas/function/enviar/",
              "type":"post",
              "dataType":"json",
              "data":datos,
              "success":function(r){
                if (r.error == 0) {
                  alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
                } else {
                  alert("Ocurrio un error al enviar su email. Disculpe las molestias");
                  jQuery("#contacto_submit").removeAttr('disabled');
                }
              }
            });
            return false;
          }
        </script>