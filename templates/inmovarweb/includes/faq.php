<?php $faq = $entrada_model->get_list(array(
  "categoria"=>"faq",
));
if (sizeof($faq)>0) { ?>
  <div id="faq" class="faqs-section">
    <div class="container">
      <div class="section-title">
        <?php $t = $web_model->get_text("faq-titulo","Vea estas respuestas a nuestras preguntas más frecuentes"); ?>
        <h3 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></h3>
        <?php $t = $web_model->get_text("faq-subtitulo","Preguntas frecuentes sobre Plan + Precios"); ?>
        <h4 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo nl2br($t->plain_text) ?></h4>
      </div>
       <div id="accordion">
        <?php 
        $i=0;
        foreach($faq as $r) { ?>
          <div class="card border-0">
            <div class="card-header" id="heading<?php echo $i ?>">
              <h5 class="mb-0">
                <button class="btn-link collapsed" data-toggle="collapse" data-target="#collapse<?php echo $i ?>" aria-expanded="true" aria-controls="collapse<?php echo $i ?>">
                  <?php echo $r->titulo ?>
                </button>
              </h5>
            </div>
            <div id="collapse<?php echo $i ?>" class="collapse" aria-labelledby="heading<?php echo $i ?>" data-parent="#accordion">
              <div class="card-body">
                <?php echo $r->texto ?>
              </div>
            </div>
          </div>
        <?php $i++; } ?>
      </div>
    </div>  
  </div>
<?php } ?>