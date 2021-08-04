<?php 
include "includes/init.php";
$id_empresa = isset($get_params["em"]) ? $get_params["em"] : $empresa->id;
$propiedad = $propiedad_model->get($id,array(
  "id_empresa"=>$id_empresa,
  "id_empresa_original"=>$empresa->id,
  "buscar_total_visitas"=>1,
  "buscar_relacionados"=>1,
  "buscar_relacionados_offset"=>6,
));
if ($propiedad === FALSE || !isset($propiedad->nombre)) header("Location:".mklink("/"));
$titulo_pagina = $propiedad->tipo_operacion_link;

// Llenamos los parametros por defecto
$vc_link_tipo_operacion = $propiedad->tipo_operacion_link;
$vc_link_localidad = $propiedad->localidad_link;
$vc_id_tipo_inmueble = $propiedad->id_tipo_inmueble;
$vc_precio_maximo = $propiedad_model->get_precio_maximo(array(
  "id_tipo_operacion"=>$propiedad->id_tipo_operacion,
));
$vc_maximo = $vc_precio_maximo;

// Tomamos los datos de SEO
$seo_title = (!empty($propiedad->seo_title)) ? $propiedad->seo_title : $empresa->seo_title;
$seo_description = (!empty($propiedad->seo_description)) ? $propiedad->seo_description : $empresa->seo_description;
$seo_keywords = (!empty($propiedad->seo_keywords)) ? $propiedad->seo_keywords : $empresa->seo_keywords;

$cookie_id_cliente = (isset($_COOKIE['idc'])) ? $_COOKIE['idc'] : 0;
$cookie_hide_lightbox = (isset($_COOKIE['hide_lightbox'])) ? $_COOKIE['hide_lightbox'] : 0;

// Seteamos la cookie para indicar que el cliente ya entro a esta propiedad
$propiedad_model->set_tracking_cookie(array("id_propiedad"=>$propiedad->id));

if (!empty($propiedad->imagen)) $propiedad->images = array_merge(array($propiedad->imagen),$propiedad->images);
?>
<!doctype html>
<html lang="en">
<head>
<?php include "includes/head.php" ?>
<meta property="og:url" content="<?php echo current_url(); ?>" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo $propiedad->nombre; ?>" />
<meta property="og:description" content="<?php echo $propiedad->direccion_completa; ?>" />
<meta property="og:image" content="<?php echo $propiedad->imagen ?>"/>
<script>const ID_PROPIEDAD = "<?php echo $propiedad->id ?>";</script>
<script>const ID_EMPRESA_RELACION = "<?php echo $id_empresa ?>";</script>
<style type="text/css">
iframe { width: 100% !important }
</style>
</head>
<body>
  <!-- header part start here -->
  <?php include "includes/header.php" ?>
  <!--Detail 1 Page Start here -->
  <div class="detail_one_page">
    <div class="page_top_bar">
      <div class="container">
        <h3><?php echo $propiedad->tipo_operacion ?></h3>
        <ul>
          <a rel="nofollow" href="javascript:window.history.back()"><li>Volver a resultados</li></a>
        </ul>
      </div>
    </div>
    <div class="details_wraper pg_spc">
      <div class="container">
        <div class="details_wrap">
          <div class="row">
            <!-- left list details part start -->
            <div class="col-lg-9 paddi_right">
              <div class="left_detail_wraper">
                <span class="cod_span"><strong>Cod:</strong> <?php echo $propiedad->codigo ?></span>
                <h4 class="heading_details"> <?php echo $propiedad->nombre ?> </h4>
                <div class="row price_tages">
                  <div class="col-lg-3 col-md-3 dollar_price">
                    <h5 style="width: 400px"><?php echo $propiedad->precio ?></h5>
                  </div>
                  <div class="col-lg-9 col-md-9 muy text-right"> 
                    <?php if ($propiedad->total_visitas > 0) { ?>
                      <span class="muy_text">Muy solicitada</span>
                      <p> <span class="black_span"> <?php echo $propiedad->total_visitas ?> </span> personas vieron esta propiedad en la &uacute;ltima semana!</p>
                    <?php } ?>
                  </div>
                </div>
                <div class="address_details">
                  <p><img src="images/locate_icon.png" alt="locate"> <?php echo $propiedad->direccion_completa ?> | <span class="color_span"> <?php echo $propiedad->localidad ?></span></p>
                </div>
                <div class="border_btm">
                  <div class="row tab_list_bx">
                    <div class="col-lg-8 col-md-8">
                      <div class="tab_list_box_footer">
                        <ul>
                            <li>
                              <p><img src="images/mts_icon.png" alt="mts_icon">
                                <span class="color_span"><?php echo (!empty($propiedad->superficie_total)) ? $propiedad->superficie_total : "-" ?></span> Mts2</p>
                              </li>
                              <li>
                                <p><img src="images/hab_icon.png" alt="has_icon"> <span class="color_span"><?php echo (!empty($propiedad->dormitorios)) ? $propiedad->dormitorios : "-" ?></span> Hab</p>
                              </li>
                              <li>
                                <p><img src="images/banos_icon.png" alt="mts_icon"> <span class="color_span"><?php echo (!empty($propiedad->banios)) ? $propiedad->banios : "-" ?></span> Baños</p>
                              </li>
                              <li>
                                <p><img src="images/car_icon.png" alt="car_icon">
                                  <span class="color_span"><?php echo (!empty($propiedad->cocheras)) ? $propiedad->cocheras : "-" ?></span> Cochera
                                </p>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <div class="col-lg-4 col-md-4 hm_head text-right">
                          <?php if ($propiedad->apto_banco == 1 )  {   ?>  <p><img src="images/home_apto_icon.png" alt="home_apto_icon"> Apto crédito </p><?php } ?>
                        </div>
                      </div>
                    </div>

                    <div class="details_gallery">

                      <?php if (!empty($propiedad->pint)) { ?>
                        <div class="col-xs-12">
                          <div class="detail_video">
                            <iframe width="100%" height="500" class="mb40" src="<?php echo $propiedad->pint ?>"></iframe>
                          </div>
                        </div>
                      <?php } ?>

                      <?php if (!empty($propiedad->video)) {  ?>
                        <div class="col-xs-12">
                          <div class="detail_video">
                            <?php 
                            if (strpos($propiedad->video, "https://youtu.be/")>=0) {
                              $propiedad->video = str_replace("https://youtu.be/", '', $propiedad->video);
                              $propiedad->video = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$propiedad->video.'?playlist='.$propiedad->video.'&loop=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                            }
                            echo $propiedad->video ?>
                          </div>
                        </div>
                      <?php } ?>

                      <div class="row">

                        <?php if (!empty($propiedad->video)) {  ?>
                          <div class="w100p">
                            <hr class="mt20 mb20">
                            <h4 class="heading_info marg_heading">Galer&iacute;a de Fotos</h4>
                          </div>
                        <?php } ?>

                        <?php if (sizeof($propiedad->images) == 1) { ?>
                          <?php foreach($propiedad->images as $i) { ?>
                            <div class="col-lg-12 col-md-12 pad-col">
                              <div class="gallery_box_wrap">
                                <a data-fancybox="gallery" rel="nofollow" href="<?php echo $i ?>">
                                  <div class="gallery_box_img gallery_box_img_main marca_agua"> <img src="<?php echo $i ?>" alt="detailspop_img2"> </div>
                                </a> 
                              </div>
                            </div>
                          <?php } ?>
                        <?php } else if (sizeof($propiedad->images) == 2) { ?>
                          <?php foreach($propiedad->images as $i) { ?>
                            <div class="col-lg-6 col-md-6 pad-col">
                              <div class="gallery_box_wrap">
                                <a data-fancybox="gallery" rel="nofollow" href="<?php echo $i ?>">
                                  <div class="gallery_box_img gallery_box_img_main marca_agua"> <img src="<?php echo $i ?>" alt="detailspop_img2"> </div>
                                </a> 
                              </div>
                            </div>  
                          <?php } ?>
                        <?php }  else { ?>
                          <div class="row">
                            <?php $x=0;
                            foreach ($propiedad->images as $i) {  ?>
                              <div class="col-lg-<?php echo ($x <= 1)?"6":"4" ?> col-md-<?php echo ($x <= 1)?"6":"4" ?> pad-col <?php echo ($x>4)?"dn":"" ?>">
                                <div class="gallery_box_wrap"> 
                                  <a data-fancybox="gallery" rel="nofollow" href="<?php echo $i ?>">
                                    <div class="gallery_box_img gallery_box_img_second marca_agua"> 
                                      <img src="<?php echo $i ?>" alt="detailspop_img5"> 
                                    </div>
                                    <?php if ($x > 3) {  ?>
                                      <div class="gallery_box_con">
                                        <div class="display-table">
                                          <div class="display-table-cell">
                                            <p>Ver <?php $tot = sizeof($propiedad->images); echo $tot - 4 ?> fotos m&aacute;s</p>
                                          </div>
                                        </div>
                                      </div>
                                    <?php } ?>
                                  </a>
                                </div>
                              </div>
                              <?php $x++; } ?>
                            </div>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                    <div class="info_content">
                      <h4 class="heading_info marg_heading">Informacion general</h4>
                      <p><?php echo $propiedad->texto ?></p>
                    </div>
                    <?php if (!empty($propiedad->caracteristicas))  { ?>
                      <div class="cara_div">
                        <div class="row">
                          <div class="col-lg-3">
                            <h4 class="heading_info">Carateristicas</h4>
                          </div>
                          <div class="col-lg-9 cara_ul">
                            <?php $caracteristicas = explode(";;;",$propiedad->caracteristicas);?>
                            <?php $carac = array_chunk($caracteristicas,3); ?>

                            <?php if (!empty($carac[0])) {  ?>
                              <ul>
                                <?php foreach ($carac[0] as $c) {   ?>
                                  <li><?php echo utf8_encode($c) ?></li>
                                <?php } ?>
                              </ul>
                            <?php  }  ?>
                            <?php if (!empty($carac[1])) {  ?>
                              <ul>
                                <?php foreach ($carac[1] as $c) {   ?>
                                  <li><?php echo utf8_encode($c) ?></li>
                                <?php } ?>
                              </ul>
                            <?php  }  ?>
                            <?php if (!empty($carac[2])) {  ?>
                              <ul>
                                <?php foreach ($carac[2] as $c) {   ?>
                                  <li><?php echo utf8_encode($c) ?></li>
                                <?php } ?>
                              </ul>
                            <?php  }  ?>
                            <?php if (!empty($carac[3])) {  ?>
                              <ul>
                                <?php foreach ($carac[3] as $c) {   ?>
                                  <li><?php echo utf8_encode($c) ?></li>
                                <?php } ?>
                              </ul>
                            <?php  }  ?>
                            <?php if (!empty($carac[4])) {  ?>
                              <ul>
                                <?php foreach ($carac[4] as $c) {   ?>
                                  <li><?php echo utf8_encode($c) ?></li>
                                <?php } ?>
                              </ul>
                            <?php  }  ?>
                          </div>
                        </div>
                      </div>
                    <?php } else {  ?>
                    <hr>
                    <?php } ?>
                    <div class="ubi_div">
                      <div class="row">
                        <div class="col-lg-3">
                          <h4 class="heading_info">Ubicacion</h4>
                        </div>
                        <div class="col-lg-9 cara_ul">
                          <ul>
                            <li><?php echo $propiedad->direccion_completa ?></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <?php if ($propiedad->latitud != 0 && $propiedad->longitud != 0) { ?>
                      <div class="details_map">
                        <div id="mapid"></div>
                      </div>
                    <?php } ?>

                    <?php if (sizeof($propiedad->planos)>0) { ?>
                      <div class="info_content">
                        <h4 class="heading_info marg_heading">Planos</h4>
                        <?php foreach($propiedad->planos as $img) { ?>
                          <img src="<?php echo $img?>" alt="<?php echo $propiedad->nombre?>"/>
                        <?php } ?>
                      </div>
                    <?php } ?>

                    <div class="form_detail">
                      <div class="contact_form">
                        <h4>Consulta por esta propiedad</h4>
                        <form onsubmit="return enviar_contacto()">
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <input type="hidden" id="contacto_propiedad" value="<?php echo $propiedad->id ?>" name="">
                              <input class="form-control" id="contacto_nombre" placeholder="Nombre*" type="text">
                            </div>
                            <div class="form-group col-md-6">
                              <input class="form-control" id="contacto_telefono" placeholder="Telefono*" type="text">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <input class="form-control" id="contacto_email" placeholder="Email*" type="email">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <textarea class="form-textarea" id="contacto_mensaje" placeholder="Escribe tu consulta*"></textarea>
                            </div>
                          </div>
                          <div class="form-row ">
                            <div class="form-group col-md-12">
                              <button type="submit" id="contacto_submit" class="full_width_btn">consultar</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <?php include "includes/sidebar_prop.php" ?>                        
                  <!-- right sidebar part End -->
                </div>
              </div>


              <?php if (sizeof($propiedad->relacionados)>0) { ?>

                <div class="detail_list_slider">
                  <h3 class="heading_details">Tal vez te pueda interesar</h3>
                  <div class="owl-carousel owl-theme">
                  <?php foreach ($propiedad->relacionados as $l) {   ?>
                    <div class="item">
                      <div class="tab_list_box">
                        <div class="hover_box_div">
                          <div class="tab_list_box_img gallery_box_img_second">
                            <?php if (!empty($l->imagen)) { ?>
                              <img src="<?php echo $l->imagen ?>" alt="<?php echo ($l->nombre);?>">
                            <?php } else if (!empty($empresa->no_imagen)) { ?>
                              <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($l->nombre);?>">
                            <?php } else { ?>
                              <img src="images/no-imagen.png" alt="<?php echo ($l->nombre);?>">
                            <?php } ?>
                          </div>
                          <div class="hover_content">
                            <div class="display-table">
                              <div class="display-table-cell">
                                <a class="pluss_icon" href="<?php echo $l->link_propiedad ?>">
                                  <i class="fa fa-plus"></i>
                                </a>

                                <?php if (estaEnFavoritos($l->id)) { ?>
                                  <a class="likes_icon active" rel="nofollow" href="/admin/favoritos/eliminar/?id=<?php echo $l->id; ?>">
                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                  </a>
                                <?php } else { ?>
                                  <a class="likes_icon" rel="nofollow" href="/admin/favoritos/agregar/?id=<?php echo $l->id; ?>">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                  </a>
                                <?php } ?>
                              </div>

                            </div>
                          </div>
                        </div>
                        <div class="tab_list_box_content">
                          <h6><a href="<?php echo $l->link_propiedad ?>"><?php echo $l->nombre ?></a></h6>
                          <p>
                            <img src="images/locate_icon.png" alt="locate_icon"> <?php echo $l->direccion_completa ?>
                            <br/><span class="color_span"><?php echo $l->localidad ?></span>
                          </p>
                          <div class="cod_apto">
                            <h4 class="dollar_rs"> <?php echo $l->precio ?></h4>
                            <span class="text-right apto_like"> 
                              <?php if (estaEnFavoritos($l->id)) { ?>
                                <a class="like_btn active" rel="nofollow" href="/admin/favoritos/eliminar/?id=<?php echo $l->id; ?>">
                                  <i class="fa fa-heart" aria-hidden="true"></i>
                                </a>
                              <?php } else { ?>
                                <a class="like_btn" rel="nofollow" href="/admin/favoritos/agregar/?id=<?php echo $l->id; ?>">
                                  <i class="fa fa-heart" aria-hidden="true"></i>
                                </a>
                              <?php } ?>
                            </div>
                        </div>
                        <div class="tab_list_box_footer">
                          <ul>
                            <li>
                              <p><img src="images/mts_icon.png" alt="mts_icon">
                                <span class="color_span"><?php echo (!empty($l->superficie_total)) ? $l->superficie_total : "-" ?></span> Mts2
                              </p>
                            </li>
                            <li>
                              <p><img src="images/hab_icon.png" alt="has_icon"> <span class="color_span"><?php echo (!empty($l->dormitorios)) ? $l->dormitorios : "-" ?></span> Hab</p>
                            </li>
                            <li>
                              <p><img src="images/banos_icon.png" alt="mts_icon"> <span class="color_span"><?php echo (!empty($l->banios)) ? $l->banios : "-" ?></span> Baños</p>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

                  </div>
                </div>
              <?php } ?>


            </div>
          </div>
        </div>
      </div>

      <!--Detail 1 Page End here --> 

      <!-- Footer Part Start here -->
      <?php include "includes/footer.php" ?>

      <!-- Footer Part End here --> 

<div style="display: none" id="contacto_modal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m0">Solicitar una visita</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form onsubmit="return enviar_contacto_modal()">
          <div class="form-row">
            <div class="form-group col-md-6">
              <input class="form-control" id="contacto_modal_nombre" placeholder="Nombre*" type="text">
            </div>
            <div class="form-group col-md-6">
              <input class="form-control" id="contacto_modal_telefono" placeholder="Telefono*" type="text">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <input class="form-control" id="contacto_modal_email" placeholder="Email*" type="email">
            </div>
          </div>
          <div class="form-row ">
            <div class="form-group col-md-12">
              <button type="submit" id="contacto_modal_submit" class="full_width_btn">consultar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript
================================================== --> 
<script src="/admin/resources/js/jquery.js"></script> 

<!-- <script src="js/jquery-3.2.1.slim.min.js"></script>  -->
<script src="js/bootstrap.js"></script> 
<script src="js/popper.min.js"></script> 
<script type="text/javascript" src="js/jquery.fancybox.min.js"></script>
<script type="text/javascript" src="js/price-range.js"></script>
<script src="js/owl.carousel.js"></script> 
<script src="/admin/resources/js/moment.min.js"></script> 
<script type="text/javascript">
  $('.owl-carousel').owlCarousel({
    loop:false,
    margin:30,
    nav:true,
    responsive:{
      0:{
        items:1
      },
      600:{
        items:1
      },

      768:{
        items:2
      },

      1000:{
        items:3
      }
    }
  })
</script>





<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />
<!-- <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script> -->
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>


<?php if ($propiedad->latitud != 0 && $propiedad->longitud != 0) { ?>
<script type="text/javascript">
  var mymap = L.map('mapid').setView([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], <?php echo $propiedad->zoom ?>);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
    }).addTo(mymap);

  var greenIcon = L.icon({
    iconUrl: 'images/map-marker.png',
    iconSize:     [44, 50], // size of the icon
    iconAnchor:   [22, 50], // point of the icon which will correspond to marker's location
  });
  L.marker([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], {icon: greenIcon}).addTo(mymap);
</script>
<?php } ?>


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
<script type="text/javascript">
<?php 
$para = $empresa->email;
if ($propiedad->id_tipo_operacion == 1 || $propiedad->id_tipo_operacion == 4) {
  // Ventas y Emprendimientos
  $para = "ventas@menacho.com.ar";
} else if ($propiedad->id_tipo_operacion == 2) {
  // Alquileres
  $para = "alquileres@menacho.com.ar";
}
?>

function enviar_contacto() {

  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var mensaje = $("#contacto_mensaje").val();
  var telefono = $("#contacto_telefono").val();
  if (isEmpty(nombre) || nombre == "Nombre") {
    alert("Por favor ingrese un nombre");
    $("#contacto_nombre").focus();
    return false;          
  }

  if (isEmpty(telefono) || telefono == "telefono") {
    alert("Por favor ingrese un telefono");
    $("#contacto_telefono").focus();
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
    "nombre":nombre,
    "email":email,
    "mensaje":mensaje,
    "telefono":telefono,
    "asunto":"Contacto para <?php echo $propiedad->nombre ?> (Cod: <?php echo $propiedad->codigo ?>)",
    "para":"<?php echo $para ?>",
    "id_propiedad":"<?php echo $propiedad->id ?>",
    <?php if (isset($propiedad) && $propiedad->id_empresa != $empresa->id) { ?>
      "id_empresa_relacion":"<?php echo $propiedad->id_empresa ?>",
    <?php } ?>
    "id_empresa":ID_EMPRESA,
    "id_origen":<?php echo(isset($id_origen) ? $id_origen : 1); ?>,
  }
  $.ajax({
    "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
        window.location.href ='<?php echo mklink ("web/gracias/") ?>';
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $("#contacto_submit").removeAttr('disabled');
      }
    }
  });
  return false;
}

function abrir_contacto_modal() {
  $('#contacto_modal').modal('show')
}

function enviar_contacto_modal() {

  var nombre = $("#contacto_modal_nombre").val();
  var email = $("#contacto_modal_email").val();
  var mensaje = $("#contacto_modal_mensaje").val();
  var telefono = $("#contacto_modal_telefono").val();
  
  if (isEmpty(nombre) || nombre == "Nombre") {
    alert("Por favor ingrese un nombre");
    $("#contacto_modal_nombre").focus();
    return false;          
  }

  if (isEmpty(telefono) || telefono == "telefono") {
    alert("Por favor ingrese un telefono");
    $("#contacto_modal_telefono").focus();
    return false;          
  }

  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido");
    $("#contacto_modal_email").focus();
    return false;          
  }
  var mensaje = "";
  var fecha = $("#contacto_modal_fecha").val();
  fecha = moment(fecha).format("DD/MM/YYYY");
  mensaje += "Fecha: "+fecha+"\n";
  mensaje += "Hora: "+$("#contacto_modal_hora").val()+"\n";

  $("#contacto_modal_submit").attr('disabled', 'disabled');
  var datos = {
    "nombre":nombre,
    "email":email,
    "mensaje":mensaje,
    "telefono":telefono,
    "asunto":"Solicitar visita: <?php echo $propiedad->nombre ?> (Cod: <?php echo $propiedad->codigo ?>)",
    "para":"<?php echo $para ?>",
    "id_propiedad":"<?php echo $propiedad->id ?>",
    <?php if (isset($propiedad) && $propiedad->id_empresa != $empresa->id) { ?>
      "id_empresa_relacion":"<?php echo $propiedad->id_empresa ?>",
    <?php } ?>
    "id_empresa":ID_EMPRESA,
    "id_origen":<?php echo(isset($id_origen) ? $id_origen : 1); ?>,
    "bcc":"basile.matias99@gmail.com",
  }
  $.ajax({
    "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
        window.location.href ='<?php echo mklink ("web/gracias/") ?>';
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $("#contacto_modal_submit").removeAttr('disabled');
      }
    }
  });
  return false;
}

</script>
<script type="text/javascript">
$(document).ready(function(){
  var maximo = 0;
  $(".tab_list_box_content p").each(function(i,e){
    if ($(e).height() > maximo) maximo = $(e).height();
  });
  maximo = Math.ceil(maximo);
  $(".tab_list_box_content p").height(maximo);
  
});
$(document).ready(function(){
  var maximo = 0;
  $(".tab_list_box_content h6").each(function(i,e){
    if ($(e).height() > maximo) maximo = $(e).height();
  });
  maximo = Math.ceil(maximo);
  $(".tab_list_box_content h6").height(maximo);
  
});


function enviar_ficha_email() {
  var email = prompt("Escriba su email: ");
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido.");
  } else {
    var datos = {
      "email":email,
      "asunto":"Ficha de: <?php echo $propiedad->nombre ?> (Cod: <?php echo $propiedad->codigo ?>)",
      "para":email,
      "id_propiedad":"<?php echo $propiedad->id ?>",
      <?php if (isset($propiedad) && $propiedad->id_empresa != $empresa->id) { ?>
        "id_empresa_relacion":"<?php echo $propiedad->id_empresa ?>",
      <?php } ?>
      "id_empresa":ID_EMPRESA,
      "id_origen":<?php echo(isset($id_origen) ? $id_origen : 1); ?>,
      "bcc":"basile.matias99@gmail.com",
      "template":"ficha-propiedad",
      "link_ficha_propiedad":"<?php echo mklink("admin/propiedades/function/ficha/".$propiedad->hash) ?>",
    }
    $.ajax({
      "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
      "type":"post",
      "dataType":"json",
      "data":datos,
      "success":function(r){
        if (r.error == 0) {
          alert("Hemos enviado la ficha de la propiedad a '"+email+"'. Muchas gracias.");
        } else {
          alert("Ocurrio un error al enviar su email. Disculpe las molestias");
          $("#contacto_modal_submit").removeAttr('disabled');
        }
      }
    });
    return false;
  }
}
</script>
<?php 
// Creamos el codigo de seguimiento para registrar la visita
echo $propiedad_model->tracking_code(array(
  "id_propiedad"=>$propiedad->id,
  "id_empresa_compartida"=>$id_empresa,
  "id_empresa"=>$empresa->id,
));
?>
</body>
</html>