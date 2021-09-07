<?php
include("includes/init.php");
extract($propiedad_model->get_variables());
isset($get_params["offset"])?$vc_offset = $get_params["offset"]:$vc_offset = 10;
$nombre_pagina = $vc_link_tipo_operacion;
function filter() {
  global $vc_offset, $vc_view, $vc_total_paginas, $vc_link, $vc_page, $vc_tipo_operacion, $vc_orden, $vc_params, $vc_dormitorios, $vc_id_tipo_inmueble, $vc_banios, $vc_apto_banco, $vc_acepta_permuta, $vc_minimo, $vc_maximo; ?>
  <div class="filter">
    <ul class="tab-button">
      <li><a class="grid-view <?php echo(($vc_view != "0")?"active":"") ?>" onclick="change_view(this,'grid')" href="javascript:void(0)"></a></li>
      <li><a class="list-view <?php echo(($vc_view == "0")?"active":"") ?>" onclick="change_view(this,'list')" href="javascript:void(0)"></a></li>
    </ul>
    <div class="sort-by">
      <label for="sort-by">Ordenar por:</label>
      <div id="orden_form" style="display: inline;">
        <select id="sort-by" onchange="enviar_orden()" name="orden">
          <option <?php echo ($vc_orden == -1 ) ? "selected" : "" ?> value="nuevo">Ver los más nuevos</option>
          <option <?php echo ($vc_orden == 2 ) ? "selected" : "" ?> value="barato">Precio menor a mayor</option>
          <option <?php echo ($vc_orden == 1 ) ? "selected" : "" ?> value="caro">Precio mayor a menor</option>
          <option <?php echo ($vc_orden == 4 ) ? "selected" : "" ?> value="destacados">Destacados</option>
        </select>  
      </div>
    </div>
    <?php if ($vc_total_paginas > 1) { ?>
      <div class="pagination">
        <?php if ($vc_page > 0) { ?>
            <a class="prev" href="<?php echo mklink ($vc_link.($vc_page-1)."/".$vc_params); ?>"></a>
        <?php } ?>
        <?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
            <?php if (abs($vc_page-$i)<2) { ?>
              <a class="<?php echo ($i==$vc_page) ? "active" : ""?>" href="<?php echo mklink ($vc_link.$i."/".$vc_params); ?>"><?php echo ($i+1); ?></a>
            <?php } ?>
        <?php } ?>
        <?php if ($vc_page < ($vc_total_paginas-1)) { ?>
            <a class="next" href="<?php echo mklink ($vc_link.($vc_page+1)."/".$vc_params); ?>"></a>
        <?php } ?>
      </div>
    <?php } ?>
    <div class="present">
      <div style="display: inline;" id="offset_form">
        <label for="show">Mostrar:</label>
        <select id="show" onchange="enviar_offset()" name="offset">
          <option <?php echo($vc_offset==5)?"selected":"" ?> value="5">5</option>
          <option <?php echo($vc_offset==10)?"selected":"" ?> value="10">10</option>
          <option <?php echo($vc_offset==20)?"selected":"" ?> value="20">20</option>
          <option <?php echo($vc_offset==50)?"selected":"" ?> value="50">50</option>
        </select>
      </div>
    </div>    
  </div>
<?php } ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body>

<!-- TOP WRAPPER -->
<div class="top-wrapper">
  <?php include("includes/header.php"); ?>
  <div class="page-title">
    <div class="page">
      <div class="breadcrumb">
        <a href="<?php echo mklink("/") ?>"><img src="images/home-icon3.png" alt="Home" /> Home</a>
        <?php if (!empty($vc_tipo_operacion)) { ?>
          <a href="<?php echo mklink("propiedades/".($vc_tipo_operacion)) ?>"></a>
          <?php if (!empty($localidad)) { ?>
            <a href="<?php echo mklink("propiedades/".$vc_tipo_operacion->link."/".$localidad->link."/") ?>"><?php echo ($localidad->nombre) ?></span>
          <?php } ?>
        <?php } ?>
      </div>
      <big><?php echo (!empty($vc_tipo_operacion)) ? ($vc_tipo_operacion) : "Propiedades"; ?></big>
    </div>
  </div>
</div>

<!-- MAIN WRAPPER -->
<div class="main-wrapper">
  <div class="page">
    <div class="row">
      <div class="col-md-9 primary">
        <?php if (!empty($vc_listado)) { ?>
          <div class="tabs">
            <?php filter(); ?>
            <div class="tab-content grid-view <?php echo(($vc_view == 0)?"dn":"") ?>" id="grid-view">
              <div class="row">
                <?php foreach($vc_listado as $r) { ?>
                  <div class="col-md-4">
                    <div class="property-item <?php echo ($r->id_tipo_estado==1)?"sold":"" ?>">
                      <div class="item-picture">
                        <div class="block">
                          <?php if (!empty($r->imagen)) { ?>
                            <img src="<?php echo $r->imagen ?>" alt="<?php echo $r->nombre; ?>" />
                          <?php } else if (!empty($empresa->no_imagen)) { ?>
                            <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo $r->nombre; ?>" />
                          <?php } else { ?>
                            <img src="images/logo.png" alt="<?php echo $r->nombre; ?>" />
                          <?php } ?>
                        </div>
                        <div class="view-more"><a href="<?php echo $r->link_propiedad ?>"></a></div>
                        <div class="property-status">
                          <?php if ($r->id_tipo_estado != 1) { ?>
                            <span><?php echo ($r->tipo_estado) ?></span>
                          <?php } else { ?>
                            <span><?php echo ($r->tipo_operacion) ?></span>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="property-detail">
                        <div class="property-name"><?php echo $r->direccion_completa ?></div>
                        <div class="property-location">
                          <div class="pull-left"><?php echo ($r->localidad); ?></div>
                          <?php if (!empty($r->codigo)) { ?>
                            <div class="pull-right">Cod: <span><?php echo ($r->codigo); ?></span></div>
                          <?php } ?>
                        </div>
                        <div class="property-facilities">
                            <div class="facilitie"><img src="images/room-icon.png" alt="Room" /> <?php echo (!empty($r->dormitorios))?$r->dormitorios:"-" ?> Hab</div>
                            <div class="facilitie"><img src="images/bathroom-icon.png" alt="Bathroom" /> <?php echo (!empty($r->banios))?$r->banios:"-" ?> Ba&ntilde;o<?php echo ($r->banios > 1)?"s":"" ?></div>
                            <div class="facilitie"><img src="images/garage-icon.png" alt="Garage" /> Cochera</div>
                            <div class="facilitie"><img src="images/grid-icon.png" alt="Grid" /> <?php echo (($r->superficie_total != 0))?$r->superficie_total:"-" ?> m2</div>
                        </div>
                        <?php if (!empty($r->plain_text)) { ?>
                          <p class="property-description"><?php echo (strlen($r->plain_text)>120) ? (substr($r->plain_text,0,120))."..." : ($r->plain_text) ?></p>
                        <?php } ?>
                        <div class="property-price">
                          <big><?php echo $r->precio ?></big>
                          <?php if (!empty($r->pint)) {  ?>
                            <a href="javascript:void(0)" class="favorites-properties design3d mr10"><span class="tooltip">Vista 360*</span></a>
                          <?php } ?>

                          <?php if (estaEnFavoritos($r->id)) { ?>
                            <a href="/admin/favoritos/eliminar/?id=<?php echo $r->id; ?>" class="favorites-properties active"><span class="tooltip">Borrar de Favoritos</span></a>
                          <?php } else { ?>
                            <a href="/admin/favoritos/agregar/?id=<?php echo $r->id; ?>" class="favorites-properties"><span class="tooltip">Guarda Tus Inmuebles Favoritos</span></a>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
            <div class="tab-content <?php echo(($vc_view != 0)?"dn":"") ?>" id="list-view">
              <?php foreach($vc_listado as $r) {  ?>
                <div class="property-item">
                  <div class="item-picture">
                    <div class="block">
                      <?php if (!empty($r->imagen)) { ?>
                        <img src="<?php echo $r->imagen ?>" alt="<?php echo $r->nombre; ?>" />
                      <?php } else if (!empty($empresa->no_imagen)) { ?>
                        <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo $r->nombre; ?>" />
                      <?php } else { ?>
                        <img src="images/logo.png" alt="<?php echo $r->nombre; ?>" />
                      <?php } ?>
                    </div>
                    <div class="view-more"><a href="<?php echo $r->link_propiedad ?>"></a></div>
                    <div class="property-status">
                      <?php if ($r->id_tipo_estado != 1) { ?>
                        <span><?php echo ($r->tipo_estado) ?></span>
                      <?php } else { ?>
                        <span><?php echo ($r->tipo_operacion) ?></span>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="property-detail">
                    <div class="property-name"><?php echo $r->direccion_completa ?></div>
                    <div class="property-location">
                      <div class="pull-left"><?php echo ($r->localidad); ?></div>
                      <?php if (!empty($r->codigo)) { ?>
                        <div class="pull-right">Cod: <span><?php echo ($r->codigo); ?></span></div>
                      <?php } ?>
                    </div>
                    <div class="property-facilities">
                      <?php if (!empty($r->dormitorios)) { ?>
                        <div class="facilitie"><img src="images/room-icon.png" alt="Room" /> <?php echo $r->dormitorios ?> Hab</div>
                      <?php } ?>
                      <?php if (!empty($r->banios)) { ?>
                        <div class="facilitie"><img src="images/bathroom-icon.png" alt="Bathroom" /> <?php echo $r->banios ?> Ba&ntilde;o<?php echo ($r->banios > 1)?"s":"" ?></div>
                      <?php } ?>
                      <?php if (!empty($r->cocheras)) { ?>
                        <div class="facilitie"><img src="images/garage-icon.png" alt="Garage" /> Cochera</div>
                      <?php } ?>
                      <?php if (!empty($r->superficie_total)) { ?>
                        <div class="facilitie"><img src="images/grid-icon.png" alt="Grid" /> <?php echo $r->superficie_total ?></div>
                      <?php } ?>
                    </div>
                    <?php if (!empty($r->plain_text)) { ?>
                      <p class="property-description"><?php echo (strlen($r->plain_text)>120) ? (substr($r->plain_text,0,120))."..." : ($r->plain_text) ?></p>
                    <?php } ?>
                    <div class="property-price">
                      <big><?php echo $r->precio ?></big>
                        <?php if (!empty($r->pint)) {  ?>
                          <a href="javascript:void(0)" class="favorites-properties design3d mr10"><span class="tooltip">Vista 360*</span></a>
                        <?php } ?>
                      <?php if (estaEnFavoritos($r->id)) { ?>
                        <a href="/admin/favoritos/eliminar/?id=<?php echo $r->id; ?>" class="favorites-properties active"><span class="tooltip">Borrar de Favoritos</span></a>
                      <?php } else { ?>
                        <a href="/admin/favoritos/agregar/?id=<?php echo $r->id; ?>" class="favorites-properties"><span class="tooltip">Guarda Tus Inmuebles Favoritos</span></a>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
             <?php if ($vc_total_paginas > 1) { ?>
              <div class="pagination">
                <?php if ($vc_page > 0) { ?>
                    <a class="prev" href="<?php echo mklink ($vc_link.($vc_page-1)."/".$vc_params); ?>"></a>
                <?php } ?>
                <?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
                    <?php if (abs($vc_page-$i)<2) { ?>
                      <a class="<?php echo ($i==$vc_page) ? "active" : ""?>" href="<?php echo mklink ($vc_link.$i."/".$vc_params); ?>"><?php echo ($i+1); ?></a>
                    <?php } ?>
                <?php } ?>
                <?php if ($vc_page < ($vc_total_paginas-1)) { ?>
                    <a class="next" href="<?php echo mklink ($vc_link.($vc_page+1)."/".$vc_params); ?>"></a>
                <?php } ?>
              </div>
            <?php } ?>
          </div>
        <?php } else { ?>
          No se encontraron resultados.
        <?php } ?>
      </div>
      <div class="col-md-3 secondary">
        <?php include("includes/sidebar.php"); ?>
      </div>
    </div>
  </div>
</div>

<?php include("includes/consulta_rapida.php"); ?>

<?php include("includes/footer.php"); ?>

<!-- SCRIPT'S --> 
<script type="text/javascript" src="js/jquery.min.js"></script> 
<script type="text/javascript" src="js/wNumb.js"></script> 
<script type="text/javascript" src="js/nouislider.js"></script> 
<script type="text/javascript" src="js/custom.js"></script> 
<script type="text/javascript">
//TABS SCRIPT
 $('.tabs_search ul').each(function(){
    var $active, $content, $links = $(this).find('a');
    $active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
    $active.addClass('active');
    $content = $($active[0].hash);
    $links.not($active).each(function () {
      $(this.hash).hide();
    });
    $(this).on('click', 'a', function(e){
      $active.removeClass('active');
      $content.hide();
      $active = $(this);
      $content = $(this.hash);
      $active.addClass('active');
      $content.show();
      e.preventDefault();
    });
 });
</script> 
<script type="text/javascript">
//UI SLIDER SCRIPT
$('.slider-snap').noUiSlider({
  start: [ <?php echo $vc_minimo ?>, <?php echo $vc_maximo ?> ],
  step: 10,
  connect: true,
  range: {
    'min': 0,
    'max': <?php echo $vc_precio_maximo ?>,
  },
  format: wNumb({
    decimals: 0,
    thousand: '.',
  })  
});
$('.slider-snap').Link('lower').to($('.slider-snap-value-lower'));
$('.slider-snap').Link('upper').to($('.slider-snap-value-upper'));

function change_view(e,view) {
  var vista = view;
  if (vista == "list") { 
    $(".grid-view").removeClass("active");
    $(".list-view").addClass("active");
    $("#grid-view").addClass("dn");
    $("#list-view").removeClass("dn");
  }
  if (vista == "grid") { 
    $(".grid-view").addClass("active");
    $(".list-view").removeClass("active");
    $("#list-view").addClass("dn");
    $("#grid-view").removeClass("dn");
  }
  }

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

$(document).ready(function(){
  <?php for($i=0;$i<5;$i++) { ?>
    $("#show-in-list-<?php echo $i ?>").click(function(){
      var v = $("#show-in-list-<?php echo $i ?>").prop("checked");
      $("#show-in-map-<?php echo $i ?>").prop("checked",!v);
    });
    $("#show-in-map-<?php echo $i ?>").click(function(){
      var v = $("#show-in-map-<?php echo $i ?>").prop("checked");
      $("#show-in-list-<?php echo $i ?>").prop("checked",!v);
    });
  <?php } ?>
});

</script>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript">
$(document).ready(function(){

  <?php if (!empty($empresa->latitud && !empty($empresa->longitud))) { ?>

    var mymap = L.map('map').setView([<?php echo $empresa->latitud ?>,<?php echo $empresa->longitud ?>], 16);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
      tileSize: 512,
      maxZoom: 18,
      zoomOffset: -1,
      id: 'mapbox/streets-v11',
      accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
    }).addTo(mymap);


    var icono = L.icon({
      iconUrl: 'images/map-place.png',
      iconSize:     [60, 60], // size of the icon
      iconAnchor:   [30, 30], // point of the icon which will correspond to marker's location
    });

    <?php
    $posiciones = explode("/",$empresa->posiciones);
    for($i=0;$i<sizeof($posiciones);$i++) { 
      $pos = explode(";",$posiciones[$i]); ?>
      L.marker([<?php echo $pos[0] ?>,<?php echo $pos[1] ?>],{
        icon: icono
      }).addTo(mymap);
    <?php } ?>

  <?php } ?>

});
</script>
<script type="text/javascript">
  function enviar_orden() { 
    $("#orden_h").val($("#sort-by").val());
    $("#form_propiedades").submit();
  }
  function enviar_offset() { 
    $("#offset_h").val($("#show").val());
    $("#form_propiedades").submit();
  }
</script>
</body>
</html>