<?php
include "includes/init.php" ;
$nombre_pagina = "favoritos";
$favoritos = $propiedad_model->favoritos();
$titulo_pagina = "Favoritos";
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body>
  <div class="home-slider">
    <?php include("includes/header.php") ?>
    <div class="container">
      <div class="breadcrumb-area">
        <h1 class="h1">Propieades favoritas</h1>
        <ul class="breadcrumbs">
          <li><a href="<?php echo mklink ("/") ?>">Inicio</a></li>
          <li class="active">Favoritos</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="properties-section-body content-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8 col-xs-12 col-md-push-4">
          <div id="grid">
            <div class="row">
              <?php 
              if (sizeof($favoritos) == 0) { ?>
                No hay propiedades favoritas.
              <?php } else { 
                foreach ($favoritos as $p) {  ?>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="property">
                      <div class="property-img">
                        <?php if ($p->id_tipo_estado >= 2) { ?>
                          <div class="property-tag button vendido alt featured"><?php echo $p->tipo_estado ?></div>
                        <?php } ?>                        
                        <div class="property-main-image">
                          <?php if (!empty($p->path)) { ?>
                            <img class="img-responsive" src="/admin/<?php echo $p->path ?>" alt="<?php echo ($p->nombre); ?>" />
                          <?php } else if (!empty($empresa->no_imagen)) { ?>
                            <img class="img-responsive" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($p->nombre); ?>" />
                          <?php } else { ?>
                            <img class="img-responsive" src="images/logo.png" alt="<?php echo ($p->nombre); ?>" />
                          <?php } ?>
                          <div class="hover">
                            <a href="<?php echo $p->link_propiedad ?>"><i class="fa fa-plus"></i></a>
                            <a href="/admin/favoritos/eliminar/?id=<?php echo $p->id; ?>"><i class="fa fa-heart"></i></a>
                          </div>                          
                        </div>
                      </div>
                      <div class="property-content">
                        <div class="height-igual">
                          <h2 class="title">
                            <a href="<?php echo $p->link_propiedad ?>"><?php echo $p->nombre ?></a>
                          </h2>
                          <div class="precio_final">
                            <?php echo ($p->precio_final != 0 && $p->publica_precio == 1) ? $p->moneda." ".number_format($p->precio_final,0) : "Consultar"; ?>
                          </div>                            
                          <?php echo ver_direccion($p); ?>
                          <?php echo ver_caracteristicas($p); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              <?php } ?>
            </div>
          </div>

        </div>
        <div class="col-lg-4 col-md-4 col-xs-12 col-md-pull-8">
          <?php include("includes/avanzada.php"); ?>

          <div class="links-listado">
            <a href="<?php echo mklink("entrada/preguntas-frecuentes-26721/") ?>" class="media">
              <div class="media-left">
                <img src="images/scipioni1.png" alt="Preguntas Frecuentes"/>
              </div>
              <div class="media-body">
                <h4>PREGUNTAS FRECUENTES</h4>
              </div>
            </a>
            <a href="<?php echo mklink("entrada/requisitos-de-alquiler-26722/") ?>" class="media">
              <div class="media-left">
                <img src="images/scipioni2.png" alt="Requisitos de Alquiler"/>
              </div>
              <div class="media-body">
                <h4>REQUISITOS DE ALQUILER</h4>
              </div>
            </a>
            <a href="<?php echo mklink("entrada/informacion-importante-26723/") ?>" class="media">
              <div class="media-left">
                <img src="images/scipioni3.png" alt="Información Importante"/>
              </div>
              <div class="media-body">
                <h4>INFORMACIÓN IMPORTANTE</h4>
              </div>
            </a>
            <a href="<?php echo mklink("entrada/informacion-sobre-ventas-26720/") ?>" class="media">
              <div class="media-left">
                <img src="images/scipioni4.png" alt="Información sobre ventas"/>
              </div>
              <div class="media-body">
                <h4>INFORMACIÓN SOBRE VENTAS</h4>
              </div>
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>  

<?php include("includes/footer.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
  var maximo = 0;
  $(".property .property-content").each(function(i,e){
    if ($(e).height() > maximo) maximo = $(e).height();
  });
  $(".property .property-content").height(maximo);
});
function enviar_orden() { 
  $("#orden_form").submit();
}
function grid_or_list(d) { 
  $(".active-view-btn").removeClass("active-view-btn");
  $(d).addClass('active-view-btn');
  var view = $(d).data("view");
  if (view == "grid") { 
    $("#lista").addClass("hide");
    $("#grid").removeClass("hide");
    $("#view_hidden").val("1");
  } else {
    $("#grid").addClass("hide");
    $("#lista").removeClass("hide");
    $("#view_hidden").val("0");
  }
}
</script>
</body>
</html>