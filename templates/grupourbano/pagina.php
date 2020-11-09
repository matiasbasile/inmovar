<?php
include_once("models/Propiedad_Model.php");
include_once("models/Entrada_Model.php");
include_once("includes/funciones.php");
$entrada_model = new Entrada_Model($empresa->id,$conx);
$propiedad_model = new Propiedad_Model($empresa->id,$conx);

$sql = "SELECT * ";
$sql.= "FROM web_paginas WHERE id = $id AND id_empresa = $empresa->id AND activo = 1 LIMIT 0,1";
$q = mysqli_query($conx,$sql);
if (mysqli_num_rows($q)<=0) {
	echo "Pagina incorrecta"; exit();
}
$pagina = mysqli_fetch_object($q);
$nombre_pagina = $pagina->link;

$titulo_pagina = $pagina->titulo_es;
$breadcrumb = array(
  array("titulo"=>$pagina->titulo_es,"link"=>$pagina->link)
);

// SEO
if (!empty($pagina->seo_title)) $seo_title = $pagina->seo_title;
if (!empty($pagina->seo_keywords)) $seo_keywords = $pagina->seo_keywords;
if (!empty($pagina->seo_description)) $seo_description = $pagina->seo_description;
?>
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
        <div class="section-title left"><big><?php echo ($pagina->titulo_es); ?></big></div>
        <?php if (!empty($pagina->path)) { ?>
          <div class="block-picture"><img src="/sistema/<?php echo $pagina->path ?>" alt="<?php echo ($pagina->titulo_es); ?>" /></div>
        <?php } ?>
        <?php if (!empty($pagina->subtitulo_es)) { ?>
          <div class="border-title"><?php echo ($pagina->subtitulo_es); ?></div>
        <?php } ?>
        <?php echo html_entity_decode($pagina->texto_es,ENT_QUOTES); ?>
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

</body>
</html>