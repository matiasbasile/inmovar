<?php include "includes/init.php" ?>
<?php 
$offset = 2 ;

/*-------ORDEN----*/ 
if (isset ($get_params['orden'])) {
 if ($get_params['orden']=='nuevos') { 
   $orden = "A.id DESC" ; }
 elseif ($get_params['orden']=='viejos') {
   $orden = "A.id ASC" ;         } 
 } else {
$orden = "A.id DESC"; } 
if (isset ($get_params['offset'])) { $offset = $get_params['offset'] ;}
$search = "";
if (isset ($get_params['q'])) { $search = $get_params['q'] ;}

$page = 0 ; 
$link_general = "entradas/";
$id_categoria = 0;
$categorias = array();
$titulo_pagina = "Información";
for($i=1;$i<(sizeof($params));$i++) {
  // Nombre de categoria
  $p = $params[$i];
  $sql = "SELECT * FROM not_categorias WHERE link = '".$p."' AND id_empresa = $empresa->id ";
  $q = mysqli_query($conx,$sql);
  if (mysqli_num_rows($q)>0) {
    $cat = mysqli_fetch_object($q);
    $categorias[] = $cat;
    $id_categoria = $cat->id;
    $id_padre = $cat->id_padre;
    $path_cat = $cat->path;
    $link_cat = $cat->link;
    $titulo_pagina = ($cat->nombre);
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
$listado = $entrada_model->get_list(array(
    'from_id_categoria'=>$id_categoria,
    "offset"=>$offset,
    "filter"=>$search,
    "order_by"=>$orden,
    "limit"=>($page * $offset),
)) ;
$page_active = "informacion";
//si hay uno solo redirige
// if (sizeof($listado)==1) { 
// $e=$listado[0];
// header("location:". mklink($e->link));
// }
$total = $entrada_model->get_total_results();
$total_paginas = ceil ($total / $offset);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include "includes/head.php" ?>
  </head>
<body>
  <?php include "includes/header.php" ?>
<section class="subheader">
  <div class="container">
    <h1><?php echo (!empty($titulo_pagina))?$titulo_pagina : "Información"  ?></h1>
    <div class="clear"></div>
  </div>
</section>
<section class="module">
  <div class="container">
    <div class="row">
      <?php if (!empty($listado)) {  ?>
        <?php if (!empty($search)) {  ?><div class="p20"><h5>Resultados para tu búsqueda: "<?php echo $search ?>"</h5></div><?php } ?>
        <?php foreach ($listado as $l) {  ?>
          <div class="col-lg-4 col-md-4">
            <div class="blog-post blog-post-creative shadow-hover">
              <a href="<?php echo mklink ($l->link) ?>" class="blog-post-img">
                <div class="img-fade"></div>
                <img src="<?php echo $l->path ?>" alt="" />
              </a>
              <div class="content blog-post-content">
                <h3><a href="<?php echo mklink ($l->link) ?>"><?php echo $l->titulo ?></a></h3>
                <ul class="blog-post-details">
                  <li><i class="fa fa-folder-open-o icon"></i><a href="<?php echo mklink ("entradas/$l->categoria_link/") ?>"><?php echo ($l->categoria)?></a></li>
                </ul>
                <p>
                  <?php  $l->texto = html_entity_decode(strip_tags($l->texto),ENT_QUOTES);echo   ((substr($l->texto,0,140))); echo (strlen($l->texto)>140)?"...":"" ?>                    
                </p>
                <a href="<?php echo mklink ($l->link) ?>" class="button button-icon small grey"><i class="fa fa-angle-right"></i> Leer más</a>
              </div>
            </div>
          </div>
        <?php } ?>
      <?php } else  { ?>
        <div> <h5>No se encontraron resultados para tu búsqueda<?php echo (!empty($search))?': "'.$search.'"' : "" ?>.</h5></div>
      <?php } ?>
    </div><!-- end row -->
    <?php if ($total_paginas > 1) {  ?>
      <div class="row">
         <div class="pagination">
          <div class="center">
            <ul>
              <?php if ($page > 0 ) {  ?> <li><a href="<?php echo mklink ($link_general.($page-1)."/") ?>" class="button small grey"><i class="fa fa-angle-left"></i></a></li><?php } ?>
                <?php for($i=0;$i<$total_paginas;$i++) { ?>
                   <?php if (abs($page-$i)<3) { ?>
                     <?php if ($i == $page) { ?>
                       <li class="current"><a class="button small grey"><?php echo $i+1?></a></li>
                     <?php } else { ?>
                       <li><a href="<?php echo mklink ($link_general.($i)."/") ?>" class="button small grey"><?php echo ($i + 1)?></a></li>
                     <?php } ?>
                  <?php } ?>
                <?php } ?>
              <?php if ($page < $total_paginas-1) {  ?>
                <li><a href="<?php echo mklink ($link_general.($page+1)."/") ?>" class="button small grey"><i class="fa fa-angle-right"></i></a></li>
              <?php } ?>
            </ul>
           </div>
          <div class="clear"></div>
        </div>
      </div>
    <?php } ?>
  </div><!-- end container -->
</section>
<?php include "includes/footer.php" ?>
<?php include "includes/scripts.php" ?>
</body>
</html>