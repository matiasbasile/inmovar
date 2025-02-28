<?php 
$ultimas = $entrada_model->ultimas(array(
  "from_link_categoria"=>"noticias",
  "offset" => 3
));
$marcas = $articulo_model->get_marcas(); ?>

<section class="last-news">
  <?php if (!empty($ultimas)) { ?>
    <div class="container">
      <div class="section-title">
        <h2>últimas noticias</h2>
      </div>
      <div class="row">
        <?php foreach ($ultimas as $ult) { ?>
          <?php item_entrada($ult) ?>
        <?php } ?>
      </div>
      <div class="block mt15">
        <a href="<?php echo mklink("entradas/noticias/") ?>" class="btn">Ver Todas</a>
      </div>
    </div>
  <?php } ?>

  <?php if (!empty($marcas)) { ?>
    <div class="container">
      <div class="section-title title">
        <h2>Algunas de nuestras inmobiliarias más destacadas</h2>
      </div>
      <div class="owl-carousel owl-theme" data-outoplay="true" data-items="4" data-nav="true" data-dots="true" data-margin="20" data-items-tablet="3" data-items-mobile-landscape="2" data-items-mobile-portrait="1">
        <?php foreach ($marcas as $marca) { ?>
          <div class="item">
            <img src="<?php echo $marca->path ?>" alt="img">
          </div>
        <?php } ?>
      </div>
    </div>
  <?php } ?>
</section>