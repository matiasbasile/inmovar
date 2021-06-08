<?php
include("includes/init.php");
$get_params["offset"] = 48;
extract($propiedad_model->get_variables(array(
  "orden"=>2,
  "order_empresa"=>0,
)));
$nombre_pagina = $vc_link_tipo_operacion;
if (isset($_GET["test"])) print_r($vc_listado);
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body class="page-sub-page page-listing-lines page-search-results" id="page-top">
<div class="wrapper">
  <?php include("includes/header.php"); ?>
  
  <div id="page-content">
    
    <div class="container">
      <div class="row">
        <!-- Results -->
        <div class="col-md-9 col-sm-9">
          <section id="results" class="mt30">

            <header><h1><?php echo (empty($vc_tipo_operacion) ? "Propiedades" : $vc_tipo_operacion); ?></h1></header>

            <section id="search-filter">
              <figure>
                <h3><i class="fa fa-search"></i>Resultados de b&uacute;squeda:</h3>
                <span class="search-count"><?php echo $vc_total_resultados; ?></span>
                <div class="sorting">
                  <form class="form-group" action="<?php echo mklink ("propiedades/".(empty($vc_link_tipo_operacion)?"todas":$vc_link_tipo_operacion)."/".(empty($link_localidad)?"todas":$link_localidad)."/?".(empty($link_tipo_inmueble)?"":$link_tipo_inmueble)."/$vc_page/") ?>" method="GET" id="orden_form">
                    <label>Ordenar por:</label>
                    <select id="orden_select" onchange="enviar_orden()" name="orden">
                      <option <?php echo ($vc_orden == -1 ) ? "selected" : "" ?> value="nuevo">Más nuevos</option>
                      <option <?php echo ($vc_orden == 2 ) ? "selected" : "" ?> value="barato">Menor precio</option>
                      <option <?php echo ($vc_orden == 1 ) ? "selected" : "" ?> value="caro">Mayor precio</option>
                      <option <?php echo ($vc_orden == 4 ) ? "selected" : "" ?> value="destacados">Destacados</option>
                    </select>
                  </form>
                </div>
              </figure>
            </section>
            <section id="properties" class="display-lines">
              <?php foreach($vc_listado as $r) { ?>
                <div class="property">
                  <?php if (isset($r->pertenece_red) && $r->pertenece_red == 1) { ?>
                    <figure class="tag status">Red Inmovar</figure>
                  <?php } else { ?>
                    <?php if ($r->nuevo == 1) { ?>
                      <figure class="tag status">Nuevo</figure>
                    <?php } ?>
                  <?php } ?>
                  <div class="property-image">
                    <?php if ($r->id_tipo_estado == 2) { ?>
                      <figure class="ribbon">Alquilado</figure>
                    <?php } else if ($r->id_tipo_estado == 4) { ?>
                      <figure class="ribbon">Reservado</figure>
                    <?php } else if ($r->id_tipo_estado == 3) { ?>
                      <figure class="ribbon">Vendido</figure>
                    <?php } ?>
                    <a href="<?php echo $r->link_propiedad; ?>">
                      <?php if (!empty($r->imagen)) { ?>
                        <img src="<?php echo $r->imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                      <?php } else if (!empty($empresa->no_imagen)) { ?>
                        <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                      <?php } else { ?>
                        <img src="images/logo.png" alt="<?php echo ($r->nombre); ?>" />
                      <?php } ?>
                    </a>
                  </div>
                  <div class="info">
                    <header>
                      <a href="<?php echo $r->link_propiedad; ?>"><h3><?php echo $r->nombre ?></h3></a>
                      <figure>
                        <?php echo $r->direccion_completa; ?>
                        <?php echo (!empty($r->localidad)) ? ", ".$r->localidad : "" ?>
                      </figure>
                    </header>
                    <div class="tag price"><?php echo ($r->precio_final != 0 && $r->publica_precio == 1) ? $r->moneda." ".number_format($r->precio_final,0) : "Consultar"; ?></div>
                    <aside>
                      <p><?php echo substr($r->plain_text,0,140)."..."; ?></p>
                      <dl>
                        <?php if (!empty($r->superficie_total)) { ?>
                          <dt>Superficie:</dt>
                          <dd><?php echo $r->superficie_total ?> m<sup>2</sup></dd>
                        <?php } ?>
                        <dt>Habitaciones:</dt>
                        <dd><?php echo (!empty($r->dormitorios)) ? $r->dormitorios : "-" ?></dd>
                        <dt>Ba&ntilde;o:</dt>
                        <dd><?php echo (!empty($r->banios)) ? $r->banios : "-" ?></dd>
                        <dt>Garage:</dt>
                        <dd><?php echo (!empty($r->cocheras)) ? $r->cocheras : "-" ?></dd>
                      </dl>
                    </aside>
                    <a href="<?php echo $r->link_propiedad; ?>" class="link-arrow">Ver m&aacute;s</a>
                  </div>
                </div>
              <?php } ?>
              <!-- Pagination -->
              <div class="center">
                <?php
                if ($vc_total_paginas > 1) { ?>
                  <ul class="pagination">
                    <?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
                      <?php if (abs($vc_page-$i)<2) { ?>
                        <li class="<?php echo ($i==$vc_page) ? "active" : ""?>"><a href="<?php echo mklink($vc_link.$i."/").$vc_params ?>"><?php echo ($i+1); ?></a></li>
                      <?php } ?>
                    <?php } ?>
                  </ul>
                <?php } ?>
              </div>
            </section>
          </section>
        </div>

        <div class="col-md-3 col-sm-3">
          <section id="sidebar">
            <?php include("includes/buscador.php"); ?>
          </section>
        </div>
        
      </div>
    </div>
  </div>

  <?php include("includes/footer.php"); ?>
</div>

<script type="text/javascript" src="assets/js/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/smoothscroll.js"></script>
<script type="text/javascript" src="assets/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="assets/js/retina-1.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/jshashtable-2.1_src.js"></script>
<script type="text/javascript" src="assets/js/jquery.numberformatter-1.2.3.js"></script>
<script type="text/javascript" src="assets/js/tmpl.js"></script>
<script type="text/javascript" src="assets/js/jquery.dependClass-0.1.js"></script>
<script type="text/javascript" src="assets/js/draggable-0.1.js"></script>
<script type="text/javascript" src="assets/js/jquery.slider.js"></script>
<script type="text/javascript" src="assets/js/custom.js"></script>
<script type="text/javascript" src="/admin/resources/js/common.js"></script>
<script type="text/javascript" src="/admin/resources/js/main.js"></script>
<!--[if gt IE 8]>
<script type="text/javascript" src="assets/js/ie.js"></script>
<![endif]-->
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
  return true;
}
</script>
</body>
</html>