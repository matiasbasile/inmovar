<div class="col-lg-3 pad-l4">
  <div class="rightsidebar custom_select_arrow">
    <div class="first_tab">
      <h5 class="heading_ng">Información</h5>
      <div class="date_notify_tab">
        <div id="accordion">
          <?php $categorias_info = $entrada_model->get_subcategorias(0,array(
            "buscar_hijos"=>0,
          ));
          foreach ($categorias_info as $cat) {  ?>
            <div class="card">
              <div class="card-header" id="<?php  echo $cat->link.'heading' ?>">
                <h5>
                  <button class="btn-link" data-toggle="collapse" data-target="#<?php echo $cat->link ?>" aria-expanded="true" aria-controls="<?php echo $cat->link ?>"> <?php echo utf8_encode($cat->nombre) ?> </button>
                </h5>
              </div>
              <div id="<?php echo $cat->link ?>" class="collapse <?php echo $titulo_pagina == $cat->link?"show":"" ?>" aria-labelledby="<?php  echo $cat->link.'heading' ?>" data-parent="#accordion">
                <div class="card-body">
                  <ul>
                    <?php $listado_side = $entrada_model->get_list(array("categoria"=>"$cat->link","offset"=>10000)) ?>
                    <?php foreach ($listado_side as $l) {  ?>
                      <li><a href="<?php echo mklink ($l->link) ?>"><?php echo $l->titulo ?></a></li>
                    <?php } ?>
                  </ul>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>