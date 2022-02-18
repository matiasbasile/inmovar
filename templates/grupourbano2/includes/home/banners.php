<section class="group-bertoia padding-default">
  <div class="container">
    <?php $t = $web_model->get_text("text1", "Grupo Urbano Bertoia Piñero"); ?>
    <h2 class="text-center editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?> </h2>
    <?php $t = $web_model->get_text("text2", "Somos la mejor opción para comprar o vender tu propiedad"); ?>
    <h5 class="text-center editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?> </h5>
    <div class="media mt-5">
      <?php $t = $web_model->get_text("icon-1-img", "assets/images/icon01.png"); ?>
      <img class="mr-4 editable editable-img" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="img" />
      <div class="media-body">
        <?php $t = $web_model->get_text("text3", "Quiero Comprar"); ?>
        <h4 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h4>

        <?php $t = $web_model->get_text("text4", "Te ofrecemos la cartera de propiedades más grande de la ciudad para que puedas elegir entre más de 10 mil propiedades en venta en zona."); ?>
        <p class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></p>

        <?php $t = $web_model->get_text("text5", "comenzar"); ?>
        <a href="<?php echo mklink("propiedades/ventas/") ?>" class="btn btn-outline-primary editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?> <i class="fa fa-chevron-right ml-3"></i></a>
      </div>
    </div>
    <div class="media mt-5">
      <?php $t = $web_model->get_text("icon-2-img", "assets/images/icon02.png"); ?>
      <img class="mr-4 editable editable-img" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>" src="<?php echo $t->plain_text ?>" alt="img" />
      <div class="media-body">
        <?php $t = $web_model->get_text("text6", "Quiero Vender"); ?>
        <h4 class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></h4>

        <?php $t = $web_model->get_text("text7", "Te ayudamos a vender tu propiedad más rápido generando contenido de calidad y promocionando en los portales y redes más populares."); ?>
        <p class="editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?></p>

        <?php $t = $web_model->get_text("text8", "comenzar"); ?>
        <a href="<?php echo mklink("contacto/") ?>" class="btn btn-outline-primary editable" data-id="<?php echo $t->id ?>" data-id_empresa="<?php echo $t->id_empresa ?>" data-clave="<?php echo $t->clave ?>"> <?php echo $t->plain_text ?> <i class="fa fa-chevron-right ml-3"></i></a>
      </div>
    </div>
  </div>
</section>