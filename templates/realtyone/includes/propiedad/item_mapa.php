<?php function item_mapa($propiedad) { ?>
  <div class="property-box">
    <div class="img-block">
      <div class="owl-carousel owl-theme" data-items="1" data-nav="false" data-dots="true">
        <?php foreach ($propiedad->images as $img) { ?>
          <div class="item">
            <a target="_blank" href="<?php echo $propiedad->link_propiedad ?>">
              <img src="<?php echo $img ?>" loading="lazy" alt="img">
            </a>
          </div>
        <?php } ?>
      </div>
      <?php if ($propiedad->nuevo == 1) { ?>
        <small>Nuevo!</small>
      <?php } ?>
    </div>
    <div class="listing-box">
      <div class="title-box">
        <?php if ($propiedad->id_tipo_operacion != 4) { ?>
          <h4><?php echo $propiedad->precio ?>
            <?php if ($propiedad->precio_porcentaje_anterior < 0.00 && $propiedad->publica_precio == 1) { ?>
              <small> 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"></path>
                </svg> <?php echo round(floatval($propiedad->precio_porcentaje_anterior * -1),0) ?>%
              </small>
            <?php } ?>
          </h4>
        <?php } ?>
        <p><?php echo $propiedad->nombre ?></p>
        <span>
          <?php if ($propiedad->id_tipo_operacion != 4) { ?>
            <?php if ($propiedad->valor_expensas != 0 && $propiedad->publica_precio == 1) { ?>
              Expensas: <?php echo "$" . number_format($propiedad->valor_expensas,0,",",".") ?><br>
            <?php } else { ?>
              Expensas: - <br/>
            <?php } ?>
          <?php } ?>
          <?php echo ucwords(strtolower($propiedad->direccion_completa)) ?>
        </span>
      </div>
      <div class="aminities">
        <div class="inner-info">
          <span><?php echo (!empty($propiedad->superficie_cubierta) ? $propiedad->superficie_cubierta : "-") ?> m2</span>
        <ul>
          <li><img src="assets/images/featured-properties-icon1.svg" alt="img"> <?php echo (!empty($propiedad->dormitorios) ? $propiedad->dormitorios : "-") ?></li>
          <li><img src="assets/images/featured-properties-icon2.svg" alt="img"> <?php echo (!empty($propiedad->banios) ? $propiedad->banios : "-") ?></li>
          <li><img src="assets/images/featured-properties-icon3.svg" alt="img"> <?php echo (!empty($propiedad->cocheras) ? $propiedad->cocheras : "-") ?></li>
        </ul>
        </div>
        <?php /*
        <div class="icon-box">
          <a href="javascript:void(0)" rel="nofollow" onclick="abrirModal('whatsapp','Estoy interesado en <?php echo $propiedad->nombre ?> Cod: <?php echo $propiedad->codigo ?>')">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
              <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
            </svg>
          </a>
        </div>
        */ ?>
      </div>
    </div>
  </div>
<?php } ?>