<section id="banner">
  <div class="block has-dark-background background-color-default-darker center text-banner">
    <div class="container">
      <?php $t = $web_model->get_text("home-banner-titulo"); ?>
      <h1 data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" class="editable no-bottom-margin no-border"><?php echo $t->plain_text ?></h1>
      <?php if ($empresa->id == 1633) { ?>
        <a class="btn btn-default btn-cotizacion" href="<?php echo mklink("web/cotizacion/") ?>">COTIZÁ TU CRÉDITO HIPOTECARIO</a>
      <?php } ?>
    </div>
  </div>
</section><!-- /#banner -->
<section id="our-services" class="block">
  <div class="container">
    <?php $t = $web_model->get_text("home-servicios-titulo"); ?>
    <header data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" class="editable section-title"><h2><?php echo $t->plain_text ?></h2></header>
    <div class="row">
      <div class="col-md-4 col-sm-4">
        <div class="feature-box equal-height">
          <figure class="icon"><i class="fa fa-folder"></i></figure>
          <aside class="description">
            <?php $t = $web_model->get_text("home-servicios-1-titulo"); ?>
            <header><h3 data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo $t->plain_text ?></h3></header>
            <?php $t = $web_model->get_text("home-servicios-1-texto"); ?>
            <p data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo $t->plain_text ?></p>
            <?php if (!empty($t->link)) { ?>
              <a href="<?php echo $t->link ?>" class="link-arrow">Ver m&aacute;s</a>
            <?php } ?>
          </aside>
        </div><!-- /.feature-box -->
      </div><!-- /.col-md-4 -->
      <div class="col-md-4 col-sm-4">
        <div class="feature-box equal-height">
          <figure class="icon"><i class="fa fa-folder"></i></figure>
          <aside class="description">
            <?php $t = $web_model->get_text("home-servicios-2-titulo"); ?>
            <header><h3 data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo $t->plain_text ?></h3></header>
            <?php $t = $web_model->get_text("home-servicios-2-texto"); ?>
            <p data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo $t->plain_text ?></p>
            <?php if (!empty($t->link)) { ?>
              <a href="<?php echo $t->link ?>" class="link-arrow">Ver m&aacute;s</a>
            <?php } ?>
          </aside>
        </div><!-- /.feature-box -->
      </div><!-- /.col-md-4 -->
      <div class="col-md-4 col-sm-4">
        <div class="feature-box equal-height">
          <figure class="icon"><i class="fa fa-folder"></i></figure>
          <aside class="description">
            <?php $t = $web_model->get_text("home-servicios-3-titulo"); ?>
            <header><h3 data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo $t->plain_text ?></h3></header>
            <?php $t = $web_model->get_text("home-servicios-3-texto"); ?>
            <p data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo $t->plain_text ?></p>
            <?php if (!empty($t->link)) { ?>
              <a href="<?php echo $t->link ?>" class="link-arrow">Ver m&aacute;s</a>
            <?php } ?>
          </aside>
        </div><!-- /.feature-box -->
      </div><!-- /.col-md-4 -->
    </div><!-- /.row -->
  </div><!-- /.container -->
</section><!-- /#our-services -->
