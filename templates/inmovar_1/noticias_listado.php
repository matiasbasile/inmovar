<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("includes/funciones.php");
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id,$conx);
include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id,$conx);
include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id,$conx);

// PARA QUE FUNCIONE EL BUSCADOR, SETEAMOS EL MAXIMO Y EL MINIMO
$sql = "SELECT IF(MAX(precio_final) IS NULL,0,MAX(precio_final)) AS maximo FROM inm_propiedades WHERE id_empresa = $empresa->id ";
$q_maximo = mysqli_query($conx,$sql);
$r_maximo = mysqli_fetch_object($q_maximo);
$precio_maximo = ($r_maximo->maximo == 0) ? 2000000 : (ceil($r_maximo->maximo/100)*100);
// Minimo
$minimo = isset($_SESSION["minimo"]) ? $_SESSION["minimo"] : 0;
if ($minimo == "undefined" || empty($minimo)) $minimo = 0;
// Maximo
$maximo = isset($_SESSION["maximo"]) ? $_SESSION["maximo"] : $precio_maximo;
if ($maximo == "undefined" || empty($maximo)) $maximo = $precio_maximo;

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
$titulo_pagina = "";
$nombre_pagina = "";

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
      $cat->nombre = ($cat->nombre);
      $categorias[] = $cat;
      $id_categoria = $cat->id;
      $titulo_pagina = $cat->nombre;
      $nombre_pagina = $cat->link;
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

for($i=1;$i<(sizeof($params));$i++) {
  $link_categoria = $params[$i];
}

$config = array();
$config["id_categoria"] = $id_categoria;
$config["mes"] = $mes;
$config["anio"] = $anio;
$config["limit"] = ($page * $offset);
$config["offset"] = $offset;
$listado = $entrada_model->get_list($config);
$total = $entrada_model->get_total_results();

// Mostramos siempre la primera
if (sizeof($listado)<=0) {
  header("Location: /404.php");
} else if (sizeof($listado)==1) {
  $entrada = $listado[0];
  header("Location: ".mklink($entrada->link));
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body class="page-sub-page page-blog-listing" id="page-top">
<!-- Wrapper -->
<div class="wrapper">
    <?php include("includes/header.php"); ?>
    <div id="page-content">
        <!-- Breadcrumb -->
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="<?php echo mklink("/"); ?>">Inicio</a></li>
                <?php $j=0; foreach($categorias as $c) { ?>
                    <li <?php if ($j==sizeof($categorias)-1) { ?>class="active"<?php } ?>>
                        <?php echo $c->nombre ?>
                    </li>
                <?php $j++; } ?>
            </ol>
        </div>
        <!-- end Breadcrumb -->

        <div class="container">
            <div class="row">
                <!-- Content -->
                <div class="col-md-9 col-sm-9">
                    <section id="content">
                        <header><h1><?php echo $titulo_pagina ?></h1></header>
                        <?php foreach($listado as $r) { ?>
                            <article class="blog-post">
                                <div class="row">
                                    <?php if (!empty($r->path)) { ?>
                                        <div class="col-md-6">
                                            <a href="<?php echo mklink($r->link); ?>">
                                                <img src="<?php echo $r->path ?>">
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <div class="<?php echo (empty($r->path))?"col-md-12":"col-md-6" ?>">
                                        <header>
                                            <a href="<?php echo mklink($r->link); ?>">
                                                <h2 class="blog-title"><?php echo $r->titulo ?></h2>
                                            </a>
                                        </header>
                                        <figure class="meta">
                                            <?php if ($r->publica_firma == 1) { ?>
                                                <a href="javascript:void(0)" class="link-icon"><i class="fa fa-user"></i>Admin</a>
                                            <?php } ?>
                                            <a href="javascript:void(0)" class="link-icon"><i class="fa fa-calendar"></i><?php echo $r->fecha ?></a>
                                        </figure>
                                        <p><?php echo substr($r->plain_text,0,200)."..." ?></p>
                                        <a href="<?php echo mklink($r->link); ?>" class="link-arrow">Leer m&aacute;s</a>
                                    </div>
                                </div>
                            </article><!-- /.blog-post -->
                        <?php } ?>
                        <div class="center">
                            <?php
                            $total_paginas = ceil($total / $offset);
                            if ($total_paginas > 1) { ?>
                                <ul class="pagination">
                                    <?php for($i=0;$i<$total_paginas;$i++) { ?>
                                        <?php if (abs($page-$i)<2) { ?>
                                            <li class="<?php echo ($i==$page) ? "active" : ""?>"><a href="<?php echo $link.$i; ?>/"><?php echo ($i+1); ?></a></li>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </div>
                    </section><!-- /#content -->
                </div><!-- /.col-md-9 -->
                <!-- end Content -->

                <!-- sidebar -->
                <div class="col-md-3 col-sm-3">
                    <section id="sidebar">
                        <aside id="edit-search">
                            <header><h3>Buscador</h3></header>
                            <?php include("includes/buscador.php"); ?>
                        </aside><!-- /#edit-search -->
                        <?php include("includes/destacadas.php"); ?>
                    </section><!-- /#sidebar -->
                </div><!-- /.col-md-3 -->
                <!-- end Sidebar -->
            </div><!-- /.row -->
        </div><!-- /.container -->
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
<script type="text/javascript" src="/sistema/resources/js/common.js"></script>
<script type="text/javascript" src="/sistema/resources/js/main.js"></script>

<!--[if gt IE 8]>
<script type="text/javascript" src="assets/js/ie.js"></script>
<![endif]-->

</body>
</html>