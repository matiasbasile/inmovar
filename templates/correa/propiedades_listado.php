<?php 
include("includes/init.php");
$get_params["offset"] = 6;
extract($propiedad_model->get_variables());
$page_act = $vc_link_tipo_operacion;
$localidades = $propiedad_model->get_localidades();
foreach($localidades as $l) { 
 if ($l->link == $vc_link_localidad) { 
 	$vc_nombre_localidad = $l->nombre;
 }
}
$tipos_propiedades = $propiedad_model->get_tipos_propiedades();
foreach($tipos_propiedades as $l) { 
 if ($l->link == $vc_id_tipo_inmueble) { 
 	$vc_nombre_tipo_propiedad = $l->nombre;
 }
}
$vc_banios = isset($get_params["bn"]) ? $get_params["bn"] : 0;
$vc_dormitorios= isset($get_params["dm"]) ? $get_params["dm"] : 0;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
  <?php include "includes/head.php" ?>
  <style type="text/css">
    .edit {
    margin: 0 30px;
    min-width: 108px;
    height: 46px !important;
    padding: 8px 50px 8px 20px;
    line-height: normal;
    color: #222222 !important;
    border: 2px solid #dfdfdf !important;
    background-color: #fff !important;
    border-radius: 8px !important;
    text-align: center;
    font-size: 18px;
    text-transform: none;
    font-weight: 400 !important;
    background-position: 90% 50%;
    background-repeat: no-repeat;
    background-size: 15px auto;
   }
  </style>
</head>
<body>

  <?php include "includes/header.php" ?>

  <!-- Page Title -->
  <section class="page-title">
    <div class="container">
      <h1>
        <?php echo ($vc_link_tipo_operacion == "alquileres")?"Alquilar Propiedades":"" ?>
        <?php echo ($vc_link_tipo_operacion == "ventas")?"Comprar Propiedades":"" ?>
        <?php echo ($vc_link_tipo_operacion == "emprendimientos")?"Emprendimientos":"" ?>
      </h1>
    </div>
  </section>

  <!-- Product Category -->
  <form id="form_propiedades">
  	<input type="hidden" id="localidad" value="<?php echo (!empty($vc_link_localidad))?$vc_link_localidad:"todas" ?>" name="">
  	<input type="hidden" id="tp" value="<?php echo (!empty($vc_id_tipo_inmueble))?$vc_id_tipo_inmueble:"todas" ?>" name="tp">
  	<input type="hidden" id="dm" value="<?php echo (!empty($vc_dormitorios))?"$vc_dormitorios":"" ?>" name="dm">
  	<input type="hidden" id="bn" value="<?php echo (!empty($vc_banios))?"$vc_banios":"" ?>" name="bn">
  	<input type="hidden" id="tipo_operacion" value="<?php echo (!empty($vc_link_tipo_operacion))?$vc_link_tipo_operacion:"todas" ?>" name="">
  </form>
  <div class="product-category">
  <div class="container">
    <div class="left-menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdownlocalidades" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              	Localidades 
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownlocalidades">
              	<?php $localidades = $propiedad_model->get_localidades()?>
              	<?php foreach ($localidades as $l) {  ?>
	                <a class="localidad dropdown-item <?php echo ($l->link == $vc_link_localidad)?"active":"" ?>" href="javascript:void(0)" onclick="change_localidad('<?php echo $l->link ?>','<?php echo $l->nombre?>')"><?php echo $l->nombre ?></a>
	              <?php } ?>
                <div class="bottom-button">
                  <a href="javascript:void(0)">Cancelar</a>
                  <a href="javascript:void(0)" onclick="enviar_buscador_propiedades()">Aplicar</a>
                </div>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdowntipospropiedad" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              	Tipo de propiedad
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdowntipospropiedad">
              	<?php $tipos_propiedades = $propiedad_model->get_tipos_propiedades()?>
              	<?php foreach ($tipos_propiedades as $l) {  ?>
	                <a class="tp dropdown-item <?php echo ($l->link == $vc_id_tipo_inmueble)?"active":"" ?>" href="javascript:void(0)" onclick="change_tp('<?php echo $l->link ?>','<?php echo $l->nombre?>')"><?php echo $l->nombre ?></a>
	              <?php } ?>
                <div class="bottom-button">
                  <a href="javascript:void(0)">Cancelar</a>
                  <a href="javascript:void(0)" onclick="enviar_buscador_propiedades()">Aplicar</a>
                </div>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdowndormitorios" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              	Dormitorios
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdowndormitorios">
              	<?php $dormitorios = $propiedad_model->get_dormitorios()?>
              	<?php foreach ($dormitorios as $l) {  ?>
	                <a class="dm dropdown-item <?php echo ($vc_dormitorios == $l->dormitorios)?"active":""?>" href="javascript:void(0)" onclick="change_dm('<?php echo $l->dormitorios ?>')"><?php echo $l->dormitorios  ?></a>
	              <?php } ?>
                <div class="bottom-button">
                  <a href="javascript:void(0)">Cancelar</a>
                  <a href="javascript:void(0)" onclick="enviar_buscador_propiedades()">Aplicar</a>
                </div>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdownbanios" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              	Baños
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownbanios">
              	<?php $banios = $propiedad_model->get_banios()?>
              	<?php foreach ($banios as $l) {  ?>
	                <a class="bn dropdown-item <?php echo ($vc_banios == $l->banios)?"active":""?>" href="javascript:void(0)" onclick="change_bn('<?php echo $l->banios ?>')"><?php echo $l->banios  ?></a>
	              <?php } ?>
                <div class="bottom-button">
                  <a href="javascript:void(0)">Cancelar</a>
                  <a href="javascript:void(0)" onclick="enviar_buscador_propiedades()">Aplicar</a>
                </div>
              </div>
            </li>
            <!-- <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Rango de Precios
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item active" href="#">Brandsen</a>
                <a class="dropdown-item" href="#">Jeppener</a>
                <a class="dropdown-item" href="#">Altamirano</a>
                <a class="dropdown-item" href="#">Gomez</a>
                <a class="dropdown-item" href="#">La Plata</a>
                <div class="bottom-button">
                  <a href="#0">Cancelar</a>
                  <a href="#0">Aplicar</a>
                </div>
              </div>
            </li> -->
          </ul>
        </div>
      </nav>
    </div>
    <div class="right-button">
      <a class="btn btn-secoundry" href="<?php echo mklink ("propiedades/$vc_link_tipo_operacion/todas/") ?>">Limpiar Filtros</a>
    </div>
  </div>
</div>

  <!-- Product Listing -->
  <section class="product-listing inner-listing">
    <div class="container">
      <div class="section-title">
        <div class="title-left">
          <h2>
            <?php echo ($vc_link_tipo_operacion == "alquileres")?"Propiedades en alquiler":"" ?>
            <?php echo ($vc_link_tipo_operacion == "ventas")?"Propiedades en venta":"" ?>
            <?php echo ($vc_link_tipo_operacion == "emprendimientos")?"Emprendimientos":"" ?>
          </h2>
          <?php if (!empty($vc_listado)) {  ?>
            <span>Se encontr<?php echo (sizeof($vc_listado) > 1)?"aron":"ó" ?> <?php echo sizeof($vc_listado) ?> propiedad<?php echo (sizeof($vc_listado) > 1)?"es":"" ?></span>
          <?php } else { ?>
            <span>No se encontraron resultados para su búsqueda.</span>
          <?php }?>
        </div>
        <div class="title-right">
          <form action="<?php echo mklink ("propiedades/".(empty($vc_link_tipo_operacion)?"todas":$vc_link_tipo_operacion)."/".(empty($link_localidad)?"todas":$link_localidad)."/?".(empty($link_tipo_inmueble)?"":$link_tipo_inmueble)."/$vc_page/") ?>" method="GET" id="orden_form">
            <small>ordenar por:</small>
            <select onchange="enviar_orden()" name="orden" class="form-control">
              <option <?php echo ($vc_orden == -1 ) ? "selected" : "" ?> value="nuevo">Ver los más nuevos</option>
              <option <?php echo ($vc_orden == 2 ) ? "selected" : "" ?> value="barato">Precio menor a mayor</option>
              <option <?php echo ($vc_orden == 1 ) ? "selected" : "" ?> value="caro">Precio mayor a menor</option>
              <option <?php echo ($vc_orden == 4 ) ? "selected" : "" ?> value="destacados">Destacados</option>
            </select>  
          </form>
        </div>
      </div>
      <div class="row">
        <?php foreach ($vc_listado as $p) {   ?>
          <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="product-list-item">
              <div class="product-img">
                <img class="cover-home" src="/admin/<?php echo $p->path ?>" alt="Product">
              </div>
              <div class="product-details">
                <h4><?php echo $p->nombre ?></h4>
                <h5><?php echo $p->direccion_completa ?></h5>
                <ul>
                  <li>
                    <strong><?php echo $p->precio ?></strong>
                  </li>
                </ul>
                <div class="average-detail">
                  <span><img src="assets/images/badroom-icon.png" alt="Badroom Icon"> <?php echo $p->dormitorios  ?></span>
                  <span><img src="assets/images/shower-icon.png" alt="Shower Icon"> <?php echo $p->banios ?></span>
                  <span><img src="assets/images/sqft-icon.png" alt="SQFT Icon"> <?php echo $p->superficie_total ?></span>
                </div>
                <div class="btns-block">
                  <a href="<?php echo mklink ($p->link) ?>" class="btn btn-secoundry">Ver Detalles</a>
                  <a href="#0" class="icon-box"></a>
                  <a href="#0" data-toggle="modal" data-target="#exampleModalCenter"  class="icon-box whatsapp-box"></a>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <?php if ($vc_total_paginas > 1) {  ?>
        <nav aria-label="Page navigation">
          <ul class="pagination">
            <?php if ($vc_page > 0) { ?>
              <li class="page-item"><a class="page-link" href="<?php echo mklink ($vc_link.($vc_page-1)."/".$vc_params ) ?>"><i class="fa fa-chevron-left"></i></a></li>
            <?php } ?>
            <?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
              <?php if (abs($vc_page-$i)<2) { ?>
                <?php if ($i == $vc_page) { ?>
                  <li class="page-item active"><a class="page-link" href="javascript:void(0)"><?php echo $i+1 ?></a></li>
                <?php } else { ?>
                  <li class="page-item"><a class="page-link" href="<?php echo mklink ($vc_link.$i."/".$vc_params ) ?>"><?php echo $i+1 ?></a></li>
                <?php } ?>
              <?php } ?>
            <?php } ?>
            <?php if ($vc_page < $vc_total_paginas-1) { ?>
              <li class="page-item"><a class="page-link" href="<?php echo mklink ($vc_link.($vc_page+1)."/".$vc_params ) ?>"><i class="fa fa-chevron-right"></i></a></li>
            <?php } ?>
          </ul>
        </nav>
      <?php } ?>
    </div>
  </section>

  <!-- Footer -->
  <?php include "includes/footer.php" ?>

  <!-- Scripts -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/html5.min.js"></script>
  <script src="assets/js/respond.min.js"></script>
  <script src="assets/js/placeholders.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWmUapFYTBXV3IJL9ggjT9Z1wppCER55g&callback=initMap"></script>
  <script src="assets/js/scripts.js"></script>
  <script type="text/javascript">
  	function change_localidad (link,nombre) { 
			$('#localidad').val(link);
  		enviar_buscador_propiedades()
  	}
  	function change_tp (link,nombre) { 
			$('#tp').val(link);
  		enviar_buscador_propiedades()
  	}
  	function change_bn (link,nombre) { 
			$('#bn').val(link);
  		enviar_buscador_propiedades()
  	}
  	function change_dm (dm) { 
			$('#dm').val(dm);
  		enviar_buscador_propiedades()
  	}

  
   </script>
  <script type="text/javascript">
  $(document).ready(function(){
    var maximo = 0;
    $(".product-details h4").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    maximo = Math.ceil(maximo);
    $(".product-details h4").height(maximo);
  });

   $(document).ready(function(){
    var maximo = 0;
    $(".product-details h5").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    maximo = Math.ceil(maximo);
    $(".product-details h5").height(maximo);
  });
</script>
<script type="text/javascript">
  
  function enviar_orden() { 
    $("#orden_form").submit();
  }
  function enviar_buscador_propiedades() { 
    var link = "<?php echo mklink("propiedades/")?>";
    var tipo_operacion = $("#tipo_operacion").val();
    var localidad = $("#localidad").val();
    link = link + tipo_operacion + "/" + localidad + "/";
    $("#form_propiedades").attr("action",link);
    $("#form_propiedades").submit();
    return true;
  }
</script>
</body>
</html>