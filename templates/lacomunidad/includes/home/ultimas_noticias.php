<?php $ultimas = $entrada_model->ultimas() ?>

<?php if (!empty($ultimas)) { ?>
  <section class="last-news">
    <div class="container">
      <div class="section-title">
        <h2>últimas noticias</h2>
      </div>
      <div class="row">
        <?php foreach ($ultimas as $ult) { ?>
          <?php item_entrada($ult) ?>
        <?php } ?>
      </div>
      <div class="block">
        <a href="<?php echo mklink("entradas/") ?>" class="btn">Ver Todas</a>
      </div>
    </div>
    <div class="container">
      <div class="section-title title">
        <h2>Algunas de nuestras inmobiliarias más destacadas</h2>
      </div>
      <div class="owl-carousel owl-theme" data-outoplay="true" data-items="4" data-nav="true" data-dots="true" data-margin="20" data-items-tablet="3" data-items-mobile-landscape="2" data-items-mobile-portrait="1">
        <div class="item">
          <img src="assets/images/the-news-logo1.svg" alt="img">
        </div>
        <div class="item">
          <img src="assets/images/the-news-logo2.svg" alt="img">
        </div>
        <div class="item">
          <img src="assets/images/the-news-logo3.svg" alt="img">
        </div>
        <div class="item">
          <img src="assets/images/the-news-logo4.svg" alt="img">
        </div>
        <div class="item">
          <img src="assets/images/the-news-logo1.svg" alt="img">
        </div>
        <div class="item">
          <img src="assets/images/the-news-logo2.svg" alt="img">
        </div>
        <div class="item">
          <img src="assets/images/the-news-logo3.svg" alt="img">
        </div>
        <div class="item">
          <img src="assets/images/the-news-logo4.svg" alt="img">
        </div>
        <div class="item">
          <img src="assets/images/the-news-logo1.svg" alt="img">
        </div>
        <div class="item">
          <img src="assets/images/the-news-logo2.svg" alt="img">
        </div>
      </div>
    </div>
  </section>
<?php } ?>