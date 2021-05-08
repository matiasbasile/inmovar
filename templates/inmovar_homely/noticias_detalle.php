<?php include "includes/init.php" ?> 
<?php $entrada = $entrada_model->get($id) ?>
<?php $page_active = "informacion" ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include "includes/head.php" ?> 
</head>
<body>
  <?php include "includes/header.php" ?> 
  <section class="subheader">
    <div class="container">
      <h1><?php echo $entrada->categoria ?></h1>
      <div class="breadcrumb right">
        <a href="<?php echo mklink ("/") ?>">Inicio <i class="fa fa-angle-right"></i></a>
        <a href="<?php echo mklink ("entradas/$entrada->categoria_link/") ?>"><?php echo $entrada->categoria ?></a>
      </div>
      <div class="clear"></div>
    </div>
  </section>

  <section class="module">
    <div class="container">

      <div class="row">
        <div class="col-lg-8 col-md-8">

          <div class="blog-post">
            <?php array_unshift($entrada->images,$entrada->path) ?>
            <?php if (sizeof($entrada->images) > 1) {  ?>
              <div class="property-gallery">
                <div class="slider-nav slider-nav-property-gallery">
                  <span class="slider-prev"><i class="fa fa-angle-left"></i></span>
                  <span class="slider-next"><i class="fa fa-angle-right"></i></span>
                </div>
                <div class="slide-counter"></div>
                <div class="slider slider-property-gallery">
                  <?php foreach ($entrada->images as $img) {  ?>
                    <div class="slide"><img src="<?php echo $img ?>" alt="<?php echo $entrada->titulo ?>" /></div>
                  <?php } ?>
                </div>
                <div class="slider property-gallery-pager">
                  <?php foreach ($entrada->images as $img) {  ?>
                    <a class="property-gallery-thumb"><img src="<?php echo $img ?>" alt="<?php echo $entrada->titulo ?>" /></a>
                  <?php } ?>
                </div>
              </div>
            <?php } else if (!empty($entrada->path)) {  ?>
              <a class="blog-post-img">
                <div class="img-fade"></div>
                <img src="<?php echo $entrada->path ?>" alt="<?php echo $entrada->titulo ?>" />
              </a>
            <?php } ?>
            
            <div class="content blog-post-content">
              <h3><?php echo $entrada->titulo ?></h3>
              <?php if ($entrada->mostrar_fecha == 1) { ?>
                <ul class="blog-post-details">
                  <li><i class="fa fa-calendar pr10"></i><?php echo fecha_full ($entrada->fecha) ?></li>
                </ul>
              <?php } ?>
              <div>
                <?php echo $entrada->texto ?>
              </div>
              <div class="blog-post-share">
                <div class="divider"></div>
                <ul class="social-icons">
                 <li><a class="td-social-sharing-buttons td-social-facebook" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(current_url()) ?>" onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;"><i class="td-icon-facebook fa fa-facebook"></i></a></li>
                 <li><a class="td-social-sharing-buttons td-social-twitter" href="https://twitter.com/intent/tweet?text=<?php echo urlencode(html_entity_decode($entrada->titulo,ENT_QUOTES)) ?>&amp;url=<?php echo urlencode(current_url()) ?>"><i class="td-icon-twitter fa fa-twitter"></i></a></li>
                 <li><a class="td-social-sharing-buttons td-social-email" href="mailto:?subject=<?php echo html_entity_decode($entrada->titulo,ENT_QUOTES) ?>&body=<?php echo(current_url()) ?>"><i class="td-icon-email fa fa-envelope"></i></a></li>
               </ul>
             </div>

           </div>
         </div><!-- end blog post -->

          <?php if (isset($entrada->habilitar_contacto) && $entrada->habilitar_contacto == 1) { ?>
            <div class="widget property-single-item property-location comment-form">
              <h4><span>Formulario de Consulta</span></h4><hr class="divisorline">
              <?php 
              $asunto = $entrada->titulo;
              include("includes/form_contacto.php"); ?>
            </div>
          <?php } ?>

       </div><!-- end blog posts -->

       <div class="col-lg-4 col-md-4 sidebar">

        <div class="widget widget-sidebar recent-properties">
          <h4><span>Categorías</span> <hr class="divisorline"></h4>
          <?php $cats = $entrada_model->get_subcategorias(0) ?> 
          <div class="widget-content box">
            <ul class="bullet-list">
              <?php foreach ($cats as $c) { ?>
                <li><a href="<?php echo mklink ("entradas/$c->link/") ?>"><?php echo ($c->nombre)?></a></li>
              <?php } ?>
            </ul>
          </div><!-- end widget content -->
        </div><!-- end widget -->

      </div><!-- end sidebar -->
      <?php 
      /*
      $relacionados = $entrada_model->get_list(array("offset"=>3)) ?>
      <div class="col-lg-12 ">
        <div class="widget blog-post-related">
          <h4><span>Publicaciones Similares</span> <hr class="divisorline"></h4>
          <div class="row">
            <?php foreach ($relacionados as $l) {  ?>
              <div class="col-lg-4 col-md-4">
                <div class="blog-post blog-post-creative shadow-hover">
                  <a href="<?php echo mklink ($l->link) ?>" class="blog-post-img">
                    <div class="img-fade"></div>
                    <img src="<?php echo $l->path ?>" alt="<?php echo $entrada->titulo ?>" />
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
          </div><!-- end row -->
        </div>
      </div>
      */ ?>
    </div>

  </div>
</section>

<?php include "includes/footer.php" ?>
<!-- JavaScript file links -->
<?php include "includes/scripts.php" ?>

</body>
</html>