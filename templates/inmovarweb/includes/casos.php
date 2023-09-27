<?php $casos = $entrada_model->get_list(array(
  "categoria"=>"casos"
));
if (sizeof($casos)>0) { ?>
  <div id="clientes" class="success-stories">
    <div class="container">
      <div class="section-title">
        <?php $t = $web_model->get_text("casos-exito-titulo","algunos casos de éxito"); ?>
        <h3 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?></h3>
        <?php $t = $web_model->get_text("casos-exito-subtitulo","Ellos ya crearon su tienda online"); ?>
        <h4 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo ($t->plain_text) ?></h4>
      </div>
      <div class="owl-carousel" data-items="3" data-margin="20" data-loop="false" data-nav="true" data-dots="true">
        <?php foreach($casos as $r) { ?>
          <div class="item">
            <?php if (!empty($r->custom_1)) { ?>
              <div class="product-showcase">
                <a href="<?php echo $r->link_externo ?>" target="_blank">
                  <img src="/sistema/<?php echo $r->custom_1 ?>" alt="<?php echo $r->titulo ?>">
                </a>
              </div>
            <?php } ?>
            <div class="project-info">
              <center>
                <?php if (!empty($r->link_externo)) { ?>
                  <a target="_blank" href="<?php echo $r->link_externo ?>" class="play-btn db tac"><i class="fa fa-play" aria-hidden="true"></i></a>
                <?php } ?>
                <div class="right-info">
                  <b><a target="_blank" href="<?php echo $r->link_externo ?>"><?php echo $r->titulo ?></a></b>
                  <?php if (!empty($r->subtitulo)) { ?>
                    <span><?php echo $r->subtitulo ?></span>
                  <?php } ?>
                </div>
              </center>
              <?php if (!empty($r->archivo)) { ?>
                <div class="brand-logo"><img class="db" src="/sistema/<?php echo $r->archivo ?>" alt="<?php echo $r->titulo ?>"></div>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
<?php } ?>