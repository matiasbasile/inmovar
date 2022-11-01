<?php 
$slider = $web_model->get_slider(array(
  "clave"=>"slider_1",
));
if (sizeof($slider)>0) { ?>
  <div id="slider">
    <div class="carousel slide carousel-fade" data-ride="carousel">
      <div class="carousel-inner" role="listbox">
        <?php 
        $i=0;
        foreach($slider as $r) { ?>
          <div class="item <?php echo ($i==0)?"active":"" ?>" style="background-image: url(<?php echo $r->path ?>); background-position: center center; background-size: cover; background-repeat: no-repeat;">
            <div class="container">
              <div class="overlay">
                <div class="info">
                  <?php if (!empty($r->linea_1)) { ?>
                    <?php if (!empty($r->link_1)) { ?><a href="<?php echo $r->link_1 ?>"><?php } ?>
                      <div class="tag price"><?php echo $r->linea_1 ?></div>
                    <?php if (!empty($r->link_1)) { ?></a><?php } ?>
                  <?php } ?>
                  <?php if (!empty($r->linea_2)) { ?>
                    <h3><?php echo $r->linea_2 ?></h3>
                  <?php } ?>
                  <?php if (!empty($r->linea_3)) { ?>
                    <figure><?php echo $r->linea_3 ?></figure>
                  <?php } ?>
                </div>
                <?php if (!empty($r->link_1)) { ?>
                  <a href="<?php echo $r->link_1 ?>" class="link-arrow">
                    <?php echo $r->texto_link_1 ?>
                  </a>
                <?php } ?>
              </div>
            </div>
          </div>
        <?php $i++; } ?>
      </div>
    </div>
  </div>
<?php } ?>