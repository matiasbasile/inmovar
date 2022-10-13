<?php $sobre = $entrada_model->get(44819) ?>
<?php if (!empty($sobre)) { ?>
  <section class="francesconi-cuento">
    <div class="container">
      <div class="row">
        <div class="col-lg-5">
          <div class="ceunto-warp">
            <img src="<?php echo $sobre->path ?>" alt="Cuento">
          </div>
        </div>
        <div class="col-lg-7">
          <div class="cuento-inner">
            <h2>te cuento sobre mi</h2>
            <h3 class="small-title"><?php echo $sobre->titulo ?></h3>
            <p><?php echo $sobre->plain_text ?></p>
            <div class="cuento-info">
              <a href="<?php echo mklink("web/equipo") ?>" class="border-btn">conocenos</a>
              <p>matrícula: <span><?php echo $empresa->codigo ?></span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php } ?>