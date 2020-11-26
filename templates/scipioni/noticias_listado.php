<?php include "includes/init.php" ;
if (isset ($_POST["buscador"]))  
  $buscador = $_POST["buscador"] ; 
else  
  $buscador = ""  ;
$offset = 2;
$page = 0 ; 
$link_general = "entradas/";
$id_categoria = 0;
$categorias = array();
$link_pagina = "";
$titulo_pagina = "Páginas";

for($i=1;$i<(sizeof($params));$i++) {
  // Nombre de categoria
  $p = $params[$i];
  $sql = "SELECT * FROM not_categorias WHERE link = '".$p."' AND id_empresa = $empresa->id ";
  $q = mysqli_query($conx,$sql);
  if (mysqli_num_rows($q)>0) {
    $cat = mysqli_fetch_object($q);
    $categorias[] = $cat;
    $id_categoria = $cat->id;
    $link_pagina = $cat->link;
    $titulo_cat = ($cat->nombre);
    $link_general.= $cat->link.'/' ;
    } else {
      // Si el ultimo parametro es un numero, es porque indica el numero de pagina
      if (is_numeric($p) && ($i == sizeof($params)-1)) {
        $page = (int)$p;
      } else {
        // La categoria no es valida, directamente redireccionamos
        header("Location: /404.php");          
      }
  }
}
if (!empty($link_pagina)) { $rout = $entrada_model->get_categorias($id_categoria) ;} ; 
$entradas = $entrada_model->get_list(array(
  "from_id_categoria"=>$id_categoria,
  "filter"=>$buscador,
  "offset"=>$offset,
  "limit"=>($page * $offset)
));
$total = $entrada_model->get_total_results();
$total_paginas = ceil($total / $offset);
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
  <?php include "includes/head.php" ?>
</head>
<body>
  <div class="home-slider">
    <?php include("includes/header.php") ?>
    <div class="container">
      <div class="breadcrumb-area">
        <h1 class="h1"><?php echo $titulo_pagina ?></h1>
        <ul class="breadcrumbs">
          <li><a href="<?php echo mklink ("/") ?>">Inicio</a></li>
          <li class="active"><?php echo (isset($titulo_cat)) ? $titulo_cat : $titulo_pagina ; ?></li>
        </ul>
      </div>
    </div>
  </div>
  
  <div class="blog-body content-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8 col-xs-12 col-md-push-4">
          <!-- Blog box start -->
            <?php foreach ($entradas as $l) { ?>
              <div class="thumbnail blog-box clearfix">
                <?php if (!empty($l->path)) { ?>
                  <img src="<?php echo $l->path ?>" alt="blog-02">
                <?php } ?>
                <div class="caption detail">
                  <div class="main-title-2">
                    <h1><a href="<?php echo mklink ($l->link ) ?>"><?php echo $l->titulo ?></a></h1>
                  </div>
                  <div class="post-meta">
                    <span><a href="javascript:void(0);"><i class="fa fa-clock-o"></i><?php echo fecha_full($l->fecha) ?></a></span>
                    <span><a href="<?php echo mklink ("entradas/$l->categoria_link/") ?>"><i class="fa fa-bars"></i> <?php echo $l->categoria ?></a></span>
                  </div>
                  <p><?php echo substr($l->texto,0,300); echo (strlen($l->texto) > 300) ? "..." : "" ;?></p>
                  <div class="clearfix"></div>
                  <a href="<?php echo mklink ($l->link ) ?>" class="btn button-sm button-theme">Leer más</a>
                </div>
              </div>
            <?php } ?>
          <!-- Blog box end -->

          <!-- Page navigation start -->
              <?php if ($total_paginas > 1) { ?>
                <nav aria-label="Page navigation">
                  <ul class="pagination">
                    <?php if ($page > 0) { ?>
                      <li>
                        <a href="<?php echo mklink ($link_general.($page-1)."/") ?>" aria-label="Previous">
                          <span aria-hidden="true">Anterior</span>
                        </a>
                      </li>
                    <?php } ?>
                      <?php for($i=0;$i<$total_paginas;$i++) { ?>
                       <?php if (abs($page-$i)<3) { ?>
                         <?php if ($i == $page) { ?>
                          <li class="active"><a><?php echo $i+1 ?></a></li>
                         <?php } else { ?>
                         <li ><a href="<?php echo mklink ($link_general.$i."/") ?>"><?php echo $i+1 ?></a></li>
                         <?php } ?>
                       <?php } ?>
                      <?php } ?>
                     <?php if ($page < $total_paginas-1) { ?>
                      <li><a href="<?php echo mklink ($link_general.($page+1)."/") ?>">Siguiente</a></li>
                    <?php } ?>
                  </ul>
                </nav>
              <?php } ?>
              <!-- Page navigation end-->
        </div>
        <div class="col-lg-4 col-md-4 col-xs-12 col-md-pull-8">
          <?php include("includes/sidebar_noticias.php"); ?>
        </div>
      </div>
    </div>
  </div>
  <!-- Blog body end -->
    <?php include "includes/footer.php" ?>
</body>
</html>