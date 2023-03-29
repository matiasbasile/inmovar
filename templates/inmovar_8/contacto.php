<?php include "includes/init.php" ?>
<?php $titulo_pagina = "contacto" ?>
<!doctype html>
<html lang="en">
<head>
  <?php include "includes/head.php" ?>
</head>
<body>
<!-- header part start here -->
  <?php include "includes/header.php" ?>
<!-- header part end here --> 
  <!-- Contact Us Page Start here -->
  <div class="contact_page">
    <div class="page_top_bar">
      <div class="container">
        <h3>Contacto</h3>
      </div>
    </div>
    <div class="container">
      <div class="contact_wraper pg_spc">
        <div class="address_map">
        <div id="mapid"></div>
        
        </div>
        <div class="contact_box">
          <div class="row">
            <?php if (!empty($empresa->direccion)) {  ?>
              <div class="col-lg-4 col-md-4">
                <div class="ct_box_wrap ct_home">
                  <h5>Dirección</h5>
                  <ul>
                    <li><?php echo utf8_encode($empresa->direccion) ?><br><?php echo $empresa->codigo_postal." ".$empresa->ciudad ?>
                    </li>
                  </ul>
                </div>
              </div>
            <?php } ?>
            <?php if (!empty($empresa->horario)) {  ?>
              <div class="col-lg-4 col-md-4">
                <div class="ct_box_wrap ct_clock">
                  <h5>horarios</h5>
                  <ul>
                    <li><?php echo nl2br(utf8_encode($empresa->horario)) ?>
                    </li>
                  </ul>
                </div>
              </div>
            <?php } ?>
            <div class="col-lg-4 col-md-4">
              <div class="ct_box_wrap ct_call">
                <h5>telefóno e Email</h5>
                <ul>
                 <?php if (!empty($empresa->telefono)) {  ?> <li> <span>T:</span> <?php echo $empresa->telefono ?>
                  </li><?php } ?>
                   <li> <span>E:</span> <?php echo $empresa->email ?>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="contact_form custom_select_arrow">
          <h4>Enviar Consulta</h4>
          <form id="contact" onsubmit="return enviar_contacto()">
            <div class="form-row">
              <div class="form-group col-md-6">
                <input id="contacto_nombre" type="text" class="form-control" name="Nombre" placeholder="Nombre*" required />
              </div>
              <div class="form-group col-md-6">
                <input id="contacto_telefono" type="text" class="form-control" name="Teléfono" placeholder="Teléfono*" required />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <input id="contacto_email" type="email" class="form-control" name="email" placeholder="Email*" required />
              </div>
              <div class="form-group col-md-6">
                <select id="contacto_asunto" name="consultasgenerales" class="form-control custom_selct" required />
                 <?php $asuntos = explode(";;;",$empresa->asuntos_contacto);
                  foreach($asuntos as $a) { ?>
                    <option <?php echo (isset($get_params["s"]) && mb_strtolower($get_params["s"]) == mb_strtolower($a)) ? "selected":"" ?>><?php echo $a ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                <textarea id="contacto_mensaje" name="message" class="form-textarea" placeholder="Escribe tu consulta*" required /></textarea>
              </div>
            </div>
            <div class="form-row ">
              <div class="form-group col-md-12">
                <button id="contacto_submit" name="submit" type="submit" class="full_width_btn">Enviar</button>
              </div></div>
            </form>
          </div>
        </div>
      </div>
    </div>


    <!-- Contact Us Page End here -->

<!-- Footer Part Start here -->
<?php include "includes/footer.php" ?>

<!-- Footer Part End here --> 


<!-- JavaScript
  ================================================== -->
  <script type="text/javascript" src="/admin/resources/js/jquery.min.js"></script> 

  <!-- <script src="js/jquery-3.2.1.slim.min.js"></script>  -->
  <script src="js/bootstrap.js"></script> 
  <script src="js/popper.min.js"></script> 
  <script src="js/owl.carousel.js"></script>
  
  
 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>

<script type="text/javascript">
  function enviar_contacto() {
    
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var mensaje = $("#contacto_mensaje").val();
  var asunto = $("#contacto_asunto").val();
  var telefono = $("#contacto_telefono").val();
  var para = "<?php echo $empresa->email ?>";
  asunto = asunto.toUpperCase();
  
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
  if (isEmpty(mensaje) || mensaje == "Mensaje") {
      alert("Por favor ingrese un mensaje");
      $("#contacto_mensaje").focus();
      return false;              
  }    
  
  $("#contacto_submit").attr('disabled', 'disabled');
  var datos = {
    "para":para,
    "nombre":nombre,
    "email":email,
    "mensaje":mensaje,
    "asunto":"CONTACTO POR: "+asunto,
    "telefono":telefono,
    "id_empresa":ID_EMPRESA,
  }
  $.ajax({
    "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        window.location.href ='<?php echo mklink ("web/gracias/") ?>';
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $("#contacto_submit").removeAttr('disabled');
      }
    }
  });
  return false;
}
</script>
<script type="text/javascript">
  $(document).ready(function(){

  <?php if (!empty($empresa->latitud && !empty($empresa->longitud))) { ?>
    var mymap = L.map('mapid').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], <?php echo $empresa->zoom ?>);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: '<?php echo (defined("MAPBOX_KEY") ? MAPBOX_KEY : "") ?>',
    }).addTo(mymap);


    var icono = L.icon({
      iconUrl: "images/map-marker.png",
      iconSize:     [44,50], // size of the icon
      iconAnchor:   [22,50], // point of the icon which will correspond to marker's location
    });

    L.marker([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>],{
      icon: icono
    }).addTo(mymap);

  <?php } ?>

  })
</script>

 


 <script type="text/javascript">
$('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
  if (!$(this).next().hasClass('show')) {
    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
  }
  var $subMenu = $(this).next(".dropdown-menu");
  $subMenu.toggleClass('show');


  $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
    $('.dropdown-submenu .show').removeClass("show");
  });


  return false;
});

$(document).ready(function(){
    $('.sub-menu-ul .dropdown-toggle').on('click',function(){
          if($(this).hasClass('menu_show')){
            $(this).removeClass('menu_show');
          }else{
            $(this).addClass('menu_show');
          }
       });
});


</script>

  
</body>
</html>
