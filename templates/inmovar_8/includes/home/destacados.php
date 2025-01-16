<?php
$emprendimientos_destacados = $propiedad_model->get_list(array(
  "destacado"=>"1",
  "tipo_operacion"=>"emprendimientos",
  "offset"=>9,
  "solo_propias"=>1,
));

$alquileres_destacados = $propiedad_model->get_list(array(
  "destacado"=>"1",
  "tipo_operacion"=>"alquileres",
  "offset"=>9,
  "solo_propias"=>1,
));

$ventas_destacados = $propiedad_model->get_list(array(
  "destacado"=>"1",
  "tipo_operacion"=>"ventas",
  "offset"=>9,
  "solo_propias"=>1,
));
?>

<div class="tab_slider_section">
  <div class="container heading_container">
    <h2 class="heading2 margin_heading text-center">Propiedades Destacadas</h2>
  </div>
  <div class="slider_tab_bar <?php echo (empty($emprendimientos_destacados) && empty($alquileres_destacados)) ? "dn" : "" ?>">
    <div class="container">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item"> <a class="active" id="ventra-tab" data-toggle="tab" href="#ventra" role="tab" aria-controls="ventra" aria-selected="true"> <span><i class="fa fa-angle-down" aria-hidden="true"></i></span> En Venta</a> </li>
        <?php if (sizeof($alquileres_destacados)>0) { ?>
          <li class="nav-item"> <a id="alquile-tab" data-toggle="tab" href="#alquile" role="tab" aria-controls="alquile" aria-selected="false"> <span><i class="fa fa-angle-down" aria-hidden="true"></i></span> En Alquiler</a> </li>
        <?php } ?>
        <?php if (sizeof($emprendimientos_destacados)>0) { ?>
          <li class="nav-item"> <a id="emprendimientos-tab" data-toggle="tab" href="#emprendimientos" role="tab" aria-controls="emprendimientos" aria-selected="false"> <span><i class="fa fa-angle-down" aria-hidden="true"></i></span> Emprendimientos</a> </li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="listing_boxes mb30">
    <div class="container">
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade ajustar show active" id="ventra" role="tabpanel" aria-labelledby="ventra-tab">
          <div class="listing_boxes_wrap">
            <div class="enventa_list">
              <div class="row">
                <?php foreach ($ventas_destacados as $l) {  ?>
                  <div class="col-md-4">
                   <div class="tab_slider_st mb20">
                    <div class="tab_list_box">
                      <div class="hover_box_div">
                        <?php 
                        $path = "images/no-imagen.png";
                        if (!empty($l->imagen)) { 
                          $path = $l->imagen;
                        } else if (!empty($empresa->no_imagen)) {
                          $path = "/admin/".$empresa->no_imagen;
                        } ?>
                        <div class="tab_list_box_img gallery_box_img_second">
                          <img src="<?php echo $path ?>" alt="<?php echo ($l->nombre);?>">
                        </div>
                        <div class="hover_content">
                          <div class="display-table">
                            <div class="display-table-cell"> 
                              <a class="pluss_icon" href="<?php echo $l->link_propiedad ?>"><i class="fa fa-plus" aria-hidden="true"></i></a> 

                              <?php if (estaEnFavoritos($l->id)) { ?>
                                <a class="likes_icon active" rel="nofollow" href="/admin/favoritos/eliminar/?id=<?php echo $l->id; ?>">
                                  <i class="fa fa-heart-o" aria-hidden="true"></i>
                                </a>
                              <?php } else { ?>
                                <a class="likes_icon" rel="nofollow" href="/admin/favoritos/agregar/?id=<?php echo $l->id; ?>">
                                  <i class="fa fa-heart" aria-hidden="true"></i>
                                </a>
                              <?php } ?>

                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab_list_box_content">
                        <h6><a href="<?php echo $l->link_propiedad ?>"><?php echo $l->nombre ?></a></h6>
                        <p>
                          <img src="images/locate_icon.png" alt="locate_icon"> <?php echo $l->direccion_completa ?>
                          <br/><span class="color_span"><?php echo $l->localidad ?></span>
                        </p>
                        <h6 class="price_dollar"><?php echo $l->precio ?></h6>
                      </div>
                      <div class="tab_list_box_footer">
                        <ul>
                          <li>
                            <p><img src="images/mts_icon.png" alt="mts_icon">
                              <span class="color_span"><?php echo (!empty($l->superficie_total)) ? $l->superficie_total : "-" ?></span> Mts2
                            </p>
                          </li>
                          <li>
                            <p><img src="images/hab_icon.png" alt="has_icon"> <span class="color_span"><?php echo (!empty($l->dormitorios)) ? $l->dormitorios : "-" ?></span> Hab</p>
                          </li>
                          <li>
                            <p><img src="images/banos_icon.png" alt="mts_icon"> <span class="color_span"><?php echo (!empty($l->banios)) ? $l->banios : "-" ?></span> Baños</p>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }?>
            </div>
          </div>
        </div>
      </div>

        <?php if (sizeof($alquileres_destacados)>0) { ?>
          <div class="tab-pane fade ajustar" id="alquile" role="tabpanel" aria-labelledby="alquile-tab">
            <div class="listing_boxes_wrap">
              <div class="enventa_list">
                <div class="row">
                  <?php foreach ($alquileres_destacados as $l) {  ?>
                    <div class="col-md-4">
                      <div class="tab_slider_st mb20">
                      <div class="tab_list_box">
                        <div class="hover_box_div">
                          <?php 
                          $path = "images/no-imagen.png";
                          if (!empty($l->imagen)) { 
                            $path = $l->imagen;
                          } else if (!empty($empresa->no_imagen)) {
                            $path = "/admin/".$empresa->no_imagen;
                          } ?>
                          <div class="tab_list_box_img gallery_box_img_second">
                            <img src="<?php echo $path ?>" alt="<?php echo ($l->nombre);?>">
                          </div>
                          <div class="hover_content">
                            <div class="display-table">
                              <div class="display-table-cell"> 
                                <a class="pluss_icon" href="<?php echo $l->link_propiedad ?>"><i class="fa fa-plus" aria-hidden="true"></i></a> 
                                <?php if (estaEnFavoritos($l->id)) { ?>
                                  <a class="likes_icon active" rel="nofollow" href="/admin/favoritos/eliminar/?id=<?php echo $l->id; ?>">
                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                  </a>
                                <?php } else { ?>
                                  <a class="likes_icon" rel="nofollow" href="/admin/favoritos/agregar/?id=<?php echo $l->id; ?>">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                  </a>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab_list_box_content">
                          <h6><a href="<?php echo $l->link_propiedad ?>"><?php echo $l->nombre ?></a></h6>
                          <?php if(!empty($l->localidad)) {  ?>
                            <p>
                              <img src="images/locate_icon.png" alt="locate_icon"> <?php echo $l->direccion_completa ?>
                              <br/><span class="color_span"><?php echo $l->localidad ?></span>
                            </p>
                          <?php } ?>
                          <h6 class="price_dollar"><?php echo $l->precio ?></h6>
                        </div>
                        <div class="tab_list_box_footer">
                          <ul>
                            <li>
                            <p><img src="images/mts_icon.png" alt="mts_icon">
                              <span class="color_span"><?php echo (!empty($l->superficie_total)) ? $l->superficie_total : "-" ?></span> Mts2</p>
                            </li>
                            <li>
                              <p><img src="images/hab_icon.png" alt="has_icon"> <span class="color_span"><?php echo (!empty($l->dormitorios)) ? $l->dormitorios : "-" ?></span> Hab</p>
                            </li>
                            <li>
                              <p><img src="images/banos_icon.png" alt="mts_icon"> <span class="color_span"><?php echo (!empty($l->banios)) ? $l->banios : "-" ?></span> Baños</p>
                            </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php }?>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
        
        <?php if (sizeof($emprendimientos_destacados)>0) { ?>
          <div class="tab-pane fade" id="emprendimientos" role="tabpanel" aria-labelledby="emprendimientos-tab">
            <div class="listing_boxes_wrap">
              <div class="enventa_list">
                <div class="<?php echo (sizeof($emprendimientos_destacados)>3) ? "owl-carousel owl-theme home_owl_slider" : "row" ?>">
                  <?php foreach ($emprendimientos_destacados as $l) {  ?>
                    <div class="<?php echo (sizeof($emprendimientos_destacados)>3) ? "item" : "col-md-4" ?>">
                      <div class="tab_slider_st mb20">
                        <div class="tab_list_box">
                          <div class="hover_box_div">
                            <?php 
                            $path = "images/no-imagen.png";
                            if (!empty($l->imagen)) { 
                              $path = $l->imagen;
                            } else if (!empty($empresa->no_imagen)) {
                              $path = "/admin/".$empresa->no_imagen;
                            } ?>
                            <div class="tab_list_box_img gallery_box_img_second">
                              <img src="<?php echo $path ?>" alt="<?php echo ($l->nombre);?>">
                            </div>
                            <div class="hover_content">
                              <div class="display-table">
                                <div class="display-table-cell"> 
                                  <a class="pluss_icon" href="<?php echo mklink ($l->link) ?>"><i class="fa fa-plus" aria-hidden="true"></i></a> 
                                  <?php if (estaEnFavoritos($l->id)) { ?>
                                    <a class="likes_icon active" rel="nofollow" href="/admin/favoritos/eliminar/?id=<?php echo $l->id; ?>">
                                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    </a>
                                  <?php } else { ?>
                                    <a class="likes_icon" rel="nofollow" href="/admin/favoritos/agregar/?id=<?php echo $l->id; ?>">
                                      <i class="fa fa-heart" aria-hidden="true"></i>
                                    </a>
                                  <?php } ?>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="tab_list_box_content">
                            <h6><a href="<?php echo $l->link_propiedad ?>"><?php echo $l->nombre ?></a></h6>
                            <p>
                              <img src="images/locate_icon.png" alt="locate_icon"><?php echo $l->direccion_completa ?>
                              <br/><span class="color_span"><?php echo $l->localidad ?></span>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php }?>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>