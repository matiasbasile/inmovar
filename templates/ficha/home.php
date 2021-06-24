<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include("includes/head.php"); ?>
</head>
<body class="bgcolorA">
<div id="big_slides_container" style="display:none;">
	<div id="big_slides_close" onClick="close_enlarged()">X</div>
	<div id="big_slides_prev" onClick="prev_enlarged()"></div>
	<div id="big_slides_next" onClick="next_enlarged()"></div>
  <img id="big_img" onload="center()">
</div>
<div class="header">
  <img src="https://static.tokkobroker.com/logos/8274/Ridella.jpg" height="100" />
</div>
<div id="property_detail_wrapper" class="content_wrapper">
  <div id="property_detail_content">
    <div id="ficha">
      <div id="header_ficha">
        <div class="pre-title-header">
          <?= $propiedad->nombre ?>
        </div>
        <div class="titulo_header">
          <div class="titulo_address" style="">
            <?= $propiedad->calle ?> | <?= $propiedad->localidad ?>
          </div>
        </div>
      <div class="titulo_precio">
      </div>
    </div>
  </div>
  <div id="ficha_slider">
    <ul class="slides" onClick="enlarge()">
      <li data-thumb="https://static.tokkobroker.com/pictures/10310731172228030020173195667303805718351347376946130912451072671840420925279.jpg"> <img src="https://static.tokkobroker.com/pictures/10310731172228030020173195667303805718351347376946130912451072671840420925279.jpg"  class="zoomImg" alt="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 1" /></li>
      <li data-thumb="https://static.tokkobroker.com/pictures/63119213139912688178411842487794057619414033553825619873750376882171374745530.jpg"> <img src="https://static.tokkobroker.com/pictures/63119213139912688178411842487794057619414033553825619873750376882171374745530.jpg"  class="zoomImg" alt="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 2" /></li>
      <li data-thumb="https://static.tokkobroker.com/pictures/36252178531727002310253554524784809984628253327030271974943829284299199873427.jpg"> <img src="https://static.tokkobroker.com/pictures/36252178531727002310253554524784809984628253327030271974943829284299199873427.jpg"  class="zoomImg" alt="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 3" /></li>
      <li data-thumb="https://static.tokkobroker.com/pictures/49725233523305756678731128811332357345529160313026921124556410057806807696965.jpg"> <img src="https://static.tokkobroker.com/pictures/49725233523305756678731128811332357345529160313026921124556410057806807696965.jpg"  class="zoomImg" alt="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 4" /></li>
      <li data-thumb="https://static.tokkobroker.com/pictures/70395707087771075696208934104638630689039843454515665688141646514597072486814.jpg"> <img src="https://static.tokkobroker.com/pictures/70395707087771075696208934104638630689039843454515665688141646514597072486814.jpg"  class="zoomImg" alt="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 5" /></li>
      <li data-thumb="https://static.tokkobroker.com/pictures/75668594932886527279033846700064803167406528336496070379902704481860978222888.jpg"> <img src="https://static.tokkobroker.com/pictures/75668594932886527279033846700064803167406528336496070379902704481860978222888.jpg"  class="zoomImg" alt="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 6" /></li>
      <li data-thumb="https://static.tokkobroker.com/pictures/88461507502800074974332944632187119089746093043185308625897629226714179046885.jpg"> <img src="https://static.tokkobroker.com/pictures/88461507502800074974332944632187119089746093043185308625897629226714179046885.jpg"  class="zoomImg" alt="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 7" /></li>
    </ul>
  </div>
  <div class="tostick">
    <div id="ficha_detalle" class="card">
      <div id="ficha_detalle_head" class="bgcolorC" style="text-transform: uppercase;">Detalles de la propiedad</div>
        <div id="ficha_detalle_cuerpo">
          <div class="operations-box">
            <div class="op-venta">
              <div class="op-operation"><?= $propiedad->tipo_operacion ?></div>
              <div class="op-values"> 
                <div class="op-value"><?= $propiedad->precio ?></div>
              </div>
            </div>
          </div>
          <div class="ficha_detalle_item">
            <b>Direccion</b><br/><?= $propiedad->calle ?> | <?= $propiedad->localidad ?>
          </div>
          <div class="ficha_detalle_item">
            <b>Localidad/Partido</b><br/><?= $propiedad->localidad ?>
          </div>
          <div id="ficha_detalle_ref">(REF. EPH3702409)</div>
        </div>
        <div id="slider_thumbs" class="noprint">
          <a data-slide-index="0" href=""><img src="https://static.tokkobroker.com/thumbs/10310731172228030020173195667303805718351347376946130912451072671840420925279_thumb.jpg" data-big="https://static.tokkobroker.com/pictures/10310731172228030020173195667303805718351347376946130912451072671840420925279.jpg" class="slider-thumb" alt="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 1"></a>
          <a data-slide-index="1" href=""><img src="https://static.tokkobroker.com/thumbs/63119213139912688178411842487794057619414033553825619873750376882171374745530_thumb.jpg" data-big="https://static.tokkobroker.com/pictures/63119213139912688178411842487794057619414033553825619873750376882171374745530.jpg" class="slider-thumb" alt="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 2"></a>
          <a data-slide-index="2" href=""><img src="https://static.tokkobroker.com/thumbs/36252178531727002310253554524784809984628253327030271974943829284299199873427_thumb.jpg" data-big="https://static.tokkobroker.com/pictures/36252178531727002310253554524784809984628253327030271974943829284299199873427.jpg" class="slider-thumb" alt="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 3"></a>
          <a data-slide-index="3" href=""><img src="https://static.tokkobroker.com/thumbs/49725233523305756678731128811332357345529160313026921124556410057806807696965_thumb.jpg" data-big="https://static.tokkobroker.com/pictures/49725233523305756678731128811332357345529160313026921124556410057806807696965.jpg" class="slider-thumb" alt="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 4"></a>
          <a data-slide-index="4" href=""><img src="https://static.tokkobroker.com/thumbs/70395707087771075696208934104638630689039843454515665688141646514597072486814_thumb.jpg" data-big="https://static.tokkobroker.com/pictures/70395707087771075696208934104638630689039843454515665688141646514597072486814.jpg" class="slider-thumb" alt="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 5"></a>
          <a data-slide-index="5" href=""><img src="https://static.tokkobroker.com/thumbs/75668594932886527279033846700064803167406528336496070379902704481860978222888_thumb.jpg" data-big="https://static.tokkobroker.com/pictures/75668594932886527279033846700064803167406528336496070379902704481860978222888.jpg" class="slider-thumb" alt="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 6"></a>
          <a data-slide-index="6" href=""><img src="https://static.tokkobroker.com/thumbs/88461507502800074974332944632187119089746093043185308625897629226714179046885_thumb.jpg" data-big="https://static.tokkobroker.com/pictures/88461507502800074974332944632187119089746093043185308625897629226714179046885.jpg" class="slider-thumb" alt="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata" title="Foto thumbnail  en  en Argentina | G.B.A. Zona Sur | La Plata  20 y 32 | La Plata numero 7"></a>
        </div>
      </div>
      <div id="producer_container" class="card">
        <img src="https://static.tokkobroker.com/static/img/user.png"/>
        <div id="producer_info">
          <div id="producer_name">LAUTARO SESSA</div>
          <div class="producer-item">
            <a href="mailto:lautaro@ridellapropiedades.com">
              <img src="https://static.tokkobroker.com/static/img/mail.svg?20210623013909">
              <div>lautaro@ridellapropiedades.com</div>
            </a>
          </div>
          <div class="producer-item">
            <a href="tel: 5492216318721" >
              <img src="https://static.tokkobroker.com/static/img/cellphone.svg?20210623013909">
              <div> 5492216318721</div>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div id="ficha_desc">
      <section id="ficha_informacion_basica" class="card" style="color:  !important; width: 100%;">
        <div class="titulo2">Información básica.</div>
        <ul class="ficha_ul" id="lista_informacion_basica">
          <li><i class="fa fa-check detalleColorC"></i>Ambientes: <?= $propiedad->ambientes ?></li>
          <li><i class="fa fa-check detalleColorC"></i>Dormitorios: <?= $propiedad->dormitorios ?></li>
          <li><i class="fa fa-check detalleColorC"></i>Baños: <?= $propiedad->banios ?></li>
          <li><i class="fa fa-check detalleColorC"></i>Cocheras: <?= $propiedad->cocheras ?></li>
          <li><i class="fa fa-check detalleColorC"></i>Condición: no encontre</li>
          <li><i class="fa fa-check detalleColorC"></i>Antigüedad: no encontre</li>
          <li><i class="fa fa-check detalleColorC"></i>Situación: no encontre </li>
        </ul>
      </section> 
      <section id="ficha_superficies" class="card" style="color:  !important; width: 100%;">
        <div class="titulo2">Superficies</div>
     
        <ul class="ficha_ul" id="lista_superficies">
          <li><i class="fa fa-check detalleColorC"></i>Superficie del terreno: <?= $propiedad->superficie_total ?></li>
          <li><i class="fa fa-check detalleColorC"></i>Superficie cubierta: <?= $propiedad->superficie_cubierta ?></li>
          <li><i class="fa fa-check detalleColorC"></i>Total construido: que poner?</li>
        </ul>
      </section>
      <div class="card">
        <div class="titulo2">
          Descripción
        </div>
        <?= $propiedad->texto ?>
      </div>
    </div>
    <div id="ficha_contacto" style="color:  !important;" class="card noprint">
      <div class="titulo2" style="text-transform: uppercase;">Contacto</div>
        <div id="ficha_gracias" style="height:300px; display:none; color:  !important;">
          Gracias por tu consulta. <br>
          Te responderemos a la brevedad.
        </div>
        <div class="ficha_contacto_item"><label>Nombre</label> <input id="contact_name" type="text" />
        </div>
        <div class="ficha_contacto_item"><label>Teléfono</label> <input id="contact_phone" type="text" />
        </div>
        <div class="ficha_contacto_item"><label>E-mail</label> <input id="contact_email" type="text" />
        </div>
        <div class="ficha_contacto_item"><label>Tipo de operación</label>
            <select id="contact_operation">
            </select>
        </div>
        <div class="ficha_contacto_item">
          <label>
            Mensaje
          </label> 
          <textarea id="contact_text">
            Estoy interesado en esta propiedad.
          </textarea>
        </div>
        <div id="ficha_send" class="detalleColor" style="cursor:pointer;" onclick="send_webcontact()">
          ENVIAR
        </div>
      </div>
      <section id="ficha_mapa" style="color:  !important;" class="card noprint">
        <div class="titulo2">Ubicación</div>
        <div style="height: 500px;" id="mapid"></div>
      </section>



      <div id="network_portal" class="card">
        Nota importante: Toda la información y medidas provistas son aproximadas y deberán ratificarse con la documentación pertinente y no compromete contractualmente a nuestra empresa. Los gastos (expensas, ABL) expresados      refieren a la última información recabada y deberán confirmarse. Fotografias no vinculantes ni contractuales.
      
      </div>
    </div>
  </div>
  <div class="footer">
    <div class="powered">
      Powered by
    </div>
      <a href="https://www.tokkobroker.com" target="_blank"> 
        <img class="poweredimg" src="https://static.tokkobroker.com/static/img/logotokko_small_bw.svg?20210623013909" />
      </a>
  </div>

  <?php include('includes/footer.php'); ?>

</div>
</body>
</html>
