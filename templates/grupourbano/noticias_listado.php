<?php
$nombre_pagina = "noticias";
include_once("includes/init.php");
include_once("includes/funciones.php");
// -----------------------------------

// PARAMETROS DE BUSQUEDA

$page = 0;
$anio = 0;
$mes = 0;

// Order
if (isset($_POST["order"])) { $_SESSION["order"] = filter_var($_POST["order"],FILTER_SANITIZE_STRING); }
$order = isset($_SESSION["order"]) ? $_SESSION["order"] : 0;

// Offset
if (isset($_POST["offset"])) { $_SESSION["offset"] = filter_var($_POST["offset"],FILTER_SANITIZE_STRING); }
$offset = isset($_SESSION["offset"]) ? $_SESSION["offset"] : 10;

// Filter
if (isset($_POST["filter"])) { $_SESSION["filter"] = filter_var($_POST["filter"],FILTER_SANITIZE_STRING); }
$filter = isset($_SESSION["filter"]) ? $_SESSION["filter"] : "";

// -----------------------------------

// FORMATOS DE URL:
// noticias/categoria/anio/mes/pagina/
// noticias/categoria/anio/mes/
// noticias/categoria/pagina/
// noticias/categoria/
// noticias/pagina/
// noticias/

$id_categoria = 0;
$categorias = array();

if (sizeof($params) > 1) {
  $pos1 = $params[1];
  if (is_numeric($pos1)) {
    // Numero de pagina
    $page = (int)$pos1;
  } else {
    // Nombre de categoria
    $sql = "SELECT * FROM not_categorias WHERE link = '".$pos1."' AND id_empresa = $empresa->id ";
    $q = mysqli_query($conx,$sql);
    if (mysqli_num_rows($q)>0) {
      $cat = mysqli_fetch_object($q);
      $categorias[] = $cat;
      $id_categoria = $cat->id;
      $titulo_pagina = $cat->nombre;
    } else {
      // La categoria no es valida, directamente redireccionamos
      header("Location: /404.php");
    }
  }
}

if (sizeof($params) > 2) {
  $pos2 = $params[2];
  if (sizeof($params)>3) {
    $anio = (int)$pos2;
    $mes = (int)$params[3];
    if (sizeof($params)>4) $page = (int)$params[4];
  } else {
    $page = (int)$pos2;
  }
}

$categorias = array();
for($i=1;$i<(sizeof($params));$i++) {
  $link_categoria = $params[$i];
}

$config = array();
$config["id_categoria"] = $id_categoria;
$config["mes"] = $mes;
$config["anio"] = $anio;
$config["limit"] = ($page * $offset);
$config["offset"] = $offset;
$entradas = $entrada_model->get_list($config);

$q_total = mysqli_query($conx,"SELECT FOUND_ROWS() AS total");
$t = mysqli_fetch_object($q_total);
$total = $t->total;

function filter() {
  global $offset, $total, $link, $page, $order; ?>
  <div class="filter">
    <div class="sort-by">
      <label for="sort-by">Ordenar por:</label>
      <select id="sort-by" onchange="filtrar2()">
        <option <?php echo($order == 0)?"selected":"" ?> value="0">Recientes</option>
        <option <?php echo($order == 1)?"selected":"" ?> value="1">Precio Mayor a Menor</option>
        <option <?php echo($order == 2)?"selected":"" ?> value="2">Precio Menor a Mayor</option>
      </select>
    </div>
    <?php
    $total_paginas = ceil($total / $offset);
    if ($total_paginas > 1) { ?>
      <div class="pagination">
        <?php if ($page > 0) { ?>
            <a class="prev" href="<?php echo $link.($page-1); ?>/"></a>
        <?php } ?>
        <?php for($i=0;$i<$total_paginas;$i++) { ?>
            <?php if (abs($page-$i)<2) { ?>
              <a class="<?php echo ($i==$page) ? "active" : ""?>" href="<?php echo $link.$i; ?>/"><?php echo ($i+1); ?></a>
            <?php } ?>
        <?php } ?>
        <?php if ($page < ($total_paginas-1)) { ?>
            <a class="next" href="<?php echo $link.($page+1); ?>/"></a>
        <?php } ?>
      </div>
    <?php } ?>
    <div class="present">
      <label for="show">Mostrar:</label>
      <select id="show" onchange="filtrar2()">
        <option <?php echo($offset==5)?"selected":"" ?> value="5">5</option>
        <option <?php echo($offset==10)?"selected":"" ?> value="10">10</option>
        <option <?php echo($offset==20)?"selected":"" ?> value="20">20</option>
        <option <?php echo($offset==50)?"selected":"" ?> value="50">50</option>
      </select>
    </div>    
  </div>
<?php } ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body>

<?php include("includes/header.php"); ?>

<!-- MAIN WRAPPER -->
<section class="main-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-9 primary">
        <?php if (sizeof($entradas)>0) { ?>
          <div class="tabs">
            <?php filter(); ?>
            <div class="tab-content" id="list-view">
              <?php foreach($entradas as $r) { ?>
                <div class="property-item noticia">
                  <div class="item-picture">
                    <div class="block">
                      <?php if (!empty($r->imagen)) { ?>
                        <img class="cover" src="<?php echo $r->imagen ?>" alt="<?php echo ($r->titulo); ?>" />
                      <?php } else if (!empty($empresa->no_imagen)) { ?>
                        <img class="cover" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->titulo); ?>" />
                      <?php } else { ?>
                        <img class="cover" src="images/no-image-1.jpg" alt="<?php echo ($r->titulo); ?>" />
                      <?php } ?>
                    </div>
                    <a class="view-more" href="<?php echo mklink($r->link) ?>"><span></span></a>
                  </div>
                  <div class="property-detail">
                    <div class="property-name"><a href="<?php echo mklink($r->link) ?>"><?php echo ($r->titulo); ?></a></div>
                    <div class="property-location">
                      <div class="pull-left"><?php echo ($r->subtitulo); ?></div>
                    </div>
                    <div class="noticia-fecha">
                      <?php echo full_date($r->fecha); ?>
                    </div>
                    <?php if (!empty($r->descripcion)) { ?>
                      <p class="property-description"><?php echo ((strlen($r->descripcion)>100) ? substr($r->descripcion,0,100)."..." : $r->descripcion); ?></p>
                    <?php } else {
                      $texto = strip_tags(html_entity_decode($r->texto,ENT_QUOTES)); ?>
                      <p class="property-description"><?php echo ((strlen($texto)>100) ? substr($texto,0,100)."..." : $texto); ?></p>                        
                    <?php } ?>
                    <div>
                      <a class="mt15 pull-right btn btn-blue" href="<?php echo mklink($r->link) ?>">LEER M&Aacute;S</a>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
            <?php filter(); ?>
          </div>
        <?php } else { ?>
          No se encontraron resultados.
        <?php } ?>
      </div>
      <div class="col-md-3 secondary">
        <div class="border-box">
          <?php include("includes/sidebar.php"); ?>
        </div>
      </div>      
    </div>
  </div>
</section>

<?php include("includes/footer.php"); ?>
<script type="text/javascript">
//OWL CAROUSEL(2) SCRIPT
jQuery(document).ready(function ($) {
"use strict";
$(".owl-carouselmarcas").owlCarousel({
      items : 5,
      itemsDesktop : [1279,2],
      itemsDesktopSmall : [979,2],
      itemsMobile : [639,1],
    });
});

$(document).ready(function(){
  // Alquileres y ventas
  var maximo = 0;
  $(".grid-view .property-detail").each(function(i,e){
    if ($(e).outerHeight() > maximo) maximo = $(e).outerHeight();
  });
  if (maximo > 0) $(".grid-view .property-detail").height(maximo);
  
  // Emprendimientos
  var maximo = 0;
  $(".for-enterprises .info-inner").each(function(i,e){
    if ($(e).outerHeight() > maximo) maximo = $(e).outerHeight();
  });
  if (maximo > 0) $(".for-enterprises .info-inner").height(maximo);
  
  var maximo = 0;
  $(".item-picture .block img").each(function(i,e){
    if ($(e).outerHeight() > maximo) maximo = $(e).outerHeight();
  });
  if (maximo > 0) $(".item-picture .block img").height(maximo);
  
  // Obras
  var maximo = 0;
  $(".work-list .item-picture img").each(function(i,e){
    if ($(e).outerHeight() > maximo) maximo = $(e).outerHeight();
  });
  if (maximo > 0) $(".work-list .item-picture img").height(maximo);
  
});

</script>
</body>
</html>
