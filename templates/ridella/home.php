<?php include "includes/init.php" ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
  <?php include "includes/head.php" ?>
</head>
<body>

<div class="home">
<?php include "includes/header.php" ?>

<!-- Swiper Slider -->
<div class="swiper-container fadeslides keyboard" data-autoplay="true">
  <div class="swiper-wrapper">
    <?php $slides = $web_model->get_slider(array()) ?>
    <?php foreach ($slides as $s) {  ?>
      <div class="swiper-slide parallax" style="background:url(<?php echo $s->path ?>) no-repeat 50% 50%; background-size:cover;">
        <div class="heading-wrap">
          <div class="table-container">
            <div class="align-container">
              <div class="container">
                <h1><?php echo (!empty($s->linea_1)) ? $s->linea_1 : "" ?></h1>
                <p><?php echo (!empty($s->linea_2)) ? $s->linea_2 : "" ?><br> <?php echo (!empty($s->linea_3))?$s->linea_3:"" ?></p>
              </div>
            </div>
          </div>
          <a class="slide-to-bottom" href="<?php echo mklink ("/") ?>#bottom"><img src="images/slider-bottom.png"></a>
        </div>
      </div>
    <?php } ?>
  </div>
  <div class="swiper-pagination"></div>
</div>

<div id="form_home_container" class="container">
  <div id="form_home">
    <input id="form_home_filter" class="form-control" type="text" name="filter" placeholder="Buscar por ciudad, calle, tipo de propiedad y/o código" />
    <div class="row">
      <div class="col-md-4">
        <select id="form_home_tipo_operacion" class="form-control">
          <option selected="" value="ventas">Venta</option>
          <option value="alquileres">Alquiler</option>
        </select>
      </div>
      <div class="col-md-4">
        <select id="form_home_localidad" class="form-control">
          <option selected="" value="todos">Localidad</option>
          <?php 
          $link_localidad = "";
          $localidades = $propiedad_model->get_localidades(array(
            "id_departamento"=>(isset($vc_id_departamento) ? $vc_id_departamento : 0),
          ));
          foreach ($localidades as $l) {  ?>
            <option <?php echo (isset($link_localidad) && $link_localidad == $l->link)?"selected":"" ?> value="<?php echo $l->link ?>"><?php echo $l->nombre ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-4">
        <select id="form_home_tipo_propiedad" name="tp" class="form-control">
          <option selected="" value="0">Tipo de Propiedad</option>
          <?php 
          $tipos_propiedades = $propiedad_model->get_tipos_propiedades();
          foreach ($tipos_propiedades as $tipos) { ?>
            <option <?php echo (isset($id_tipo_inmueble) && $id_tipo_inmueble == $tipos->id)?"selected":"" ?>  value="<?php echo $tipos->id ?>"><?php echo $tipos->nombre ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="tac">
      <a class="form_home_submit btn btn-red" href="javascript:void(0)" onclick="enviar_form_home()">BUSCAR PROPIEDADES</a>
    </div>
  </div>
</div>

<!-- Our Services -->
<div class="our-services" id="bottom">
  <div class="container">
    <div class="section-title">nuestros servicios</div>
    <div class="row">
      <div class="col-md-4">
        <div class="service-list">
          <div class="service-icon"></div>
          <h3><a href="<?php echo mklink("propiedades/ventas/")?>">ventas</a></h3>
          <?php $t = $web_model->get_text("ventasTxt","Lorem Ipsum is simply dummy text of the printing and typesetting")?>
          <p class="editable" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>">
            <?php echo $t->plain_text ?>
          </p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="service-list">
          <div class="service-icon icon2"></div>
          <h3><a href="<?php echo mklink("propiedades/alquileres/")?>">alquileres</a></h3>
          <?php $t = $web_model->get_text("alquileresTxt","Lorem Ipsum is simply dummy text of the printing and typesetting")?>
          <p class="editable" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>">
            <?php echo $t->plain_text ?>
          </p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="service-list">
          <div class="service-icon icon3"></div>
          <h3><a href="<?php echo mklink("entrada/tasaciones-1700/"); ?>">tasaciones</a></h3>
          <?php $t = $web_model->get_text("TasacionesTxt","Lorem Ipsum is simply dummy text of the printing and typesetting")?>
          <p class="editable" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>">
            <?php echo $t->plain_text ?>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Featured Properties -->
<div class="featured-properties">
  <div class="container">
    <div class="section-title">propiedades destacadas</div>
    <div class="properties-listing">
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#venta">venta</a></li>
        <li><a data-toggle="tab" href="#alquiler">alquiler</a></li>
        <li><a data-toggle="tab" href="#lotes">lotes</a></li>
      </ul>
      <div class="tab-content">
        <div id="venta" class="tab-pane fade in active">
          <div class="row">
          <?php $ventas = $propiedad_model->get_list(array("id_tipo_operacion"=>1,"offset"=>6,"solo_propias"=>1))?>
            <?php foreach ($ventas as $p) {  ?>            
              <div class="col-md-4">
                <div class="property-list">
                  <div class="image-block">
                    <?php if (!empty($p->path)) { ?>
                      <img src="/admin/<?php echo $p->path ?>" alt="<?php echo ($p->nombre);?>">
                    <?php } else if (!empty($empresa->no_imagen)) { ?>
                      <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($p->nombre);?>">
                    <?php } else { ?>
                      <img src="images/no-imagen.png" alt="<?php echo ($p->nombre);?>">
                    <?php } ?>
                    <div class="overlay">
                      <div class="table-container">
                        <div class="align-container">
                          <div class="user-action">
                            <a href="<?php echo $p->link_propiedad ?>"><i class="fas fa-plus"></i></a>
                            <a href="javascript:void(0)"><i class="fas fa-heart"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="property-description">
                    <h4><?php echo $p->nombre ?></h4>
                    <h5><?php echo (!empty($p->precio_final)) ? $p->moneda." ".number_format($p->precio_final,0,",",".") : "CONSULTAR" ?></h5>
                    <p><?php echo ($p->localidad).". ".$p->direccion_completa ?></p>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div id="alquiler" class="tab-pane fade">
          <div class="row">
          <?php $alquileres = $propiedad_model->get_list(array("id_tipo_operacion"=>2,"offset"=>6,"solo_propias"=>1))?>
            <?php foreach ($alquileres as $p) {  ?>            
              <div class="col-md-4">
                <div class="property-list">
                  <div class="image-block">
                    <?php if (!empty($p->path)) { ?>
                    <img src="/admin/<?php echo $p->path ?>" alt="<?php echo ($p->nombre);?>">
                    <?php } else if (!empty($empresa->no_imagen)) { ?>
                      <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($p->nombre);?>">
                    <?php } else { ?>
                      <img src="images/no-imagen.png" alt="<?php echo ($p->nombre);?>">
                    <?php } ?>
                    <div class="overlay">
                      <div class="table-container">
                        <div class="align-container">
                          <div class="user-action">
                            <a href="<?php echo $p->link_propiedad ?>"><i class="fas fa-plus"></i></a>
                            <a href="javascript:void(0)"><i class="fas fa-heart"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="property-description">
                    <h4><?php echo $p->nombre ?></h4>
                    <h5><?php echo (!empty($p->precio_final)) ? $p->moneda." ".number_format($p->precio_final,0,",",".") : "CONSULTAR" ?></h5>
                    <p><?php echo ($p->localidad).". ".$p->direccion_completa ?></p>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div id="lotes" class="tab-pane fade">
          <div class="row">
          <?php $lotes = $propiedad_model->get_list(array("id_tipo_inmueble"=>7,"offset"=>6,"solo_propias"=>1)); ?>
            <?php foreach ($lotes as $p) {  ?>            
              <div class="col-md-4">
                <div class="property-list">
                  <div class="image-block">
                    <?php if (!empty($p->path)) { ?>
                    <img src="/admin/<?php echo $p->path ?>" alt="<?php echo ($p->nombre);?>">
                    <?php } else if (!empty($empresa->no_imagen)) { ?>
                      <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($p->nombre);?>">
                    <?php } else { ?>
                      <img src="images/no-imagen.png" alt="<?php echo ($p->nombre);?>">
                    <?php } ?>
                    <div class="overlay">
                      <div class="table-container">
                        <div class="align-container">
                          <div class="user-action">
                            <a href="<?php echo $p->link_propiedad ?>"><i class="fas fa-plus"></i></a>
                            <a href="javascript:void(0)"><i class="fas fa-heart"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="property-description">
                    <h4><?php echo $p->nombre ?></h4>
                    <h5><?php echo (!empty($p->precio_final)) ? $p->moneda." ".number_format($p->precio_final,0,",",".") : "CONSULTAR" ?></h5>
                    <p><?php echo ($p->localidad).". ".$p->direccion_completa ?></p>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Contact Section -->
<div class="contact-section">
  <div class="container">
    <div class="table-container">
      <div class="align-container">
        <h6>Contacto</h6>
        <h2>dudas o consultas?<br> Comunicate con nosotros</h2>
        <div id="flip-this" class="flip-vertical"> 
          <div class="front"> 
            <div class="btn-block">
              <a class="btn btn-red" href="javascript:void(0);">enviar mensaje</a>
            </div>
          </div> 
          <div class="back">
            <form style="backface-visibility: hidden;" onsubmit="return enviar_contacto()">
              <div class="row">
                <div class="col-md-6">
                  <input class="form-control" id="contacto_nombre" type="text" name="Nombre" placeholder="Nombre">
                </div>
                <div class="col-md-6">
                  <input class="form-control" id="contacto_telefono" type="tel" name="Teléfono" placeholder="Teléfono">
                </div>
                <div class="col-md-6">
                  <input class="form-control" id="contacto_email" type="email" name="Email" placeholder="Email">
                </div>
                <div class="col-md-6">
                  <select id="contacto_asunto">
                    <option value="Asunto sin especificar">Asunto</option>
                    <option value="Ventas">Ventas</option>
                    <option value="Alquileres">Alquileres</option>
                    <option value="Tasaciones">Tasaciones</option>
                  </select>
                </div>
                <div class="col-md-12">
                  <textarea class="form-control" id="contacto_mensaje" placeholder="Mensaje"></textarea>
                </div>
                <div class="col-md-12">
                  <input class="btn btn-red" id="contacto_submit" type="submit" value="enviar mensaje">
                </div>
              </div>
            </form>
          </div> 
      </div>
    </div>
  </div>
 </div>
</div>

<!-- Footer -->
<?php include "includes/footer.php" ?>
</div>
<script type="text/javascript"> 
function enviar_form_home() {
  var url = "<?php echo mklink("propiedades/") ?>";
  url += $("#form_home_tipo_operacion").val()+"/";
  url += $("#form_home_localidad").val()+"/";
  url += "?filter="+$("#form_home_filter").val();
  url += "&tp="+$("#form_home_tipo_propiedad").val();
  window.location.href = url;
}
function enviar_contacto() {
    
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var telefono = $("#contacto_telefono").val();
  var mensaje = $("#contacto_mensaje").val();
  var asunto = $("#contacto_asunto").val();
  var id_origen = <?php echo (isset($id_origen) ? $id_origen : 0) ?>;
  
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
    "id_origen": ((id_origen != 0) ? id_origen : "Contacto"),
  }
  $.ajax({
    "url":"/admin/consultas/function/enviar/",
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