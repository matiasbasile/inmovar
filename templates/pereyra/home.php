<?php include "includes/init.php" ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include "includes/head.php" ?>
</head>
<body>

<!-- Header -->
<?php include "includes/header.php" ?>

<!-- Top Banner -->
<?php $slides = $web_model->get_slider() ?>
<section class="top-banner">  
  <div class="owl-carousel" data-items="1" data-margin="0" data-loop="true" data-nav="false" data-dots="true">
    <?php foreach ($slides as $s) {   ?>
      <div class="item" style="background: url(<?php echo $s->path ?>) no-repeat 0 0; background-size: cover">
      </div>
    <?php } ?>
  </div>
  <div class="container">
    <div class="banner-caption">
    <?php $x=1; foreach ($slides as $s) {  if ($x==1) {  ?>
      <h1><?php echo $s->linea_1 ?></h1>
      <h2><?php echo $s->linea_2 ?></h2>
      <p><?php echo $s->linea_3 ?></p>
    <?php } $x++;}?>
      <div class="form-box">
        <form onsubmit="filtrar()" id="form_propiedades" >
            <div class="row">
              <div class="col-lg-3 col-md-6">
                <?php $tipos_op = $propiedad_model->get_tipos_operaciones()?>
                <select class="form-control" id="tipo_operacion">
                  <option value="todas">Tipo de Operación</option>
                  <?php foreach ($tipos_op as $tp) {  ?>
                    <option value="<?php echo $tp->link ?>"><?php echo $tp->nombre ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-lg-3 col-md-6">
                <?php $tipos_prop = $propiedad_model->get_tipos_propiedades()?>
                <select class="form-control" id="tp" name="tp">
                  <option value="todas">Tipo de Propiedad</option>
                  <?php foreach ($tipos_prop as $tp) {  ?>
                    <option value="<?php echo $tp->id ?>"><?php echo $tp->nombre ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-lg-3 col-md-6">
                <?php $localidades = $propiedad_model->get_localidades()?>
                <select class="form-control" id="localidad">
                  <option value="todas">Localidades</option>
                  <?php foreach ($localidades as $tp) {  ?>
                    <option value="<?php echo $tp->link ?>"><?php echo $tp->nombre ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-lg-2 col-md-6">
                <button type="submit" class="btn btn-red">Buscar</button>
              </div>
            </div>
          </form>
      </div>
    </div>
  </div>
</section>

<!-- Featured properties -->
<section class="featured-properties">
  <div class="container">
    <div class="section-title">
      <?php $t = $web_model->get_text("prop-dest","Propiedades Destacadas")?>
      <h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
       <?php echo $t->plain_text ?>
      </h2>
      <?php $t = $web_model->get_text("pro-dest-text","Estas son algunas de las mejores propiedades que tenemos para ofrecerte")?>
      <span class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
        <?php echo $t->plain_text ?>
      </span>
    </div>
    <div class="row">
      <?php $propiedades = $propiedad_model->get_list(array("destacado"=>1,"offset"=>6))?>
      <?php foreach ($propiedades as $p) {  ?>
        <div class="col-xl-4 col-md-6">
          <div class="list-item">
            <?php if (!empty($p->imagen)) { ?>
              <img class="cover imagen-ppal" src="<?php echo $p->imagen ?>" alt="<?php echo ($p->nombre);?>">
            <?php } else if (!empty($empresa->no_imagen)) { ?>
              <img class="cover imagen-ppal" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($p->nombre);?>">
            <?php } else { ?>
              <img class="cover imagen-ppal" src="images/no-imagen.png" alt="<?php echo ($p->nombre);?>">
            <?php } ?>
            <div class="overlay-block">
              <div class="top-item">
                <div class="tag <?php echo ($p->id_tipo_operacion == 4)?"dark-blue":($p->id_tipo_operacion ==2)?"light-blue":"" ?>">
                  <?php echo ($p->id_tipo_operacion == 1)?"En Venta":"" ?>
                  <?php echo ($p->id_tipo_operacion == 2)?"En Alquiler":"" ?>
                  <?php echo ($p->id_tipo_operacion == 4)?"Emprendimientos":"" ?>
                </div>
                <big><?php echo $p->precio ?></big>
              </div>
              <div class="bottom-item">
                <h3><?php echo $p->nombre ?></h3>
                <span><?php echo $p->direccion_completa ?></span>
                <ul>
                  <li>Habitaciones: <small><?php echo ($p->dormitorios != "0")?$p->dormitorios:"-" ?></small></li>
                  <li>Baños: <small><?php echo ($p->banios != "0")?$p->banios:"-" ?></small></li>
                  <li>Metros: <small><?php echo ($p->superficie_total != "0")?$p->superficie_total:"-" ?></small></li>
                </ul>
              </div>
              <a class="plus" href="<?php echo ($p->link_propiedad) ?>"><img src="assets/images/plus-icon.png" alt="Plus Icon"></a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section>

<!-- Why Choose -->
<section class="why-choose">
  <div class="container">
    <div class="section-title">
      <?php $t = $web_model->get_text("elegirnos-tit","¿Por qué elegirnos?") ?>
      <h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h2>
      <?php $t = $web_model->get_text("elegirnos-txt","Somos líderes en el mercado inmobiliario con más de 30 años de experiencia en el rubro") ?>
      <span class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></span>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-6">
        <div class="white-box">
          <span><img src="assets/images/icon1.png" alt="Icon"></span>
          <?php $t = $web_model->get_text("box-1","Ventas") ?>
          <h4 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h4>
          <?php $t = $web_model->get_text("box-1-txt","Lorem Ipsum is simply dummy <br>text of the printing and typesetting") ?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></p>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="white-box">
          <span><img src="assets/images/icon2.png" alt="Icon"></span>
          <?php $t = $web_model->get_text("box-2","Alquiler") ?>
          <h4 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h4>
          <?php $t = $web_model->get_text("box-2-txt","Lorem Ipsum is simply dummy <br>text of the printing and typesetting") ?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></p>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="white-box">
          <span><img src="assets/images/icon3.png" alt="Icon"></span>
          <?php $t = $web_model->get_text("box-3","Emprendimientos") ?>
          <h4 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h4>
          <?php $t = $web_model->get_text("box-3-txt","Lorem Ipsum is simply dummy <br>text of the printing and typesetting") ?>
          <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Recently Added -->
<section class="featured-properties recently-added">
  <div class="container">
    <div class="section-title">
      <h2>Agregadas Recientemente</h2>
      <span>Conoce las últimas propiedades en La Plata y Alrededores</span>
    </div>
    <div class="row">
      <?php 
      $propiedades = $propiedad_model->ultimas(array("offset"=>6));
      foreach($propiedades as $p) { ?>
        <div class="col-xl-4 col-md-6">
          <div class="list-item">
            <div class="img-block">
              <a href="<?php echo ($p->link_propiedad) ?>">
                <?php if (!empty($p->imagen)) { ?>
                  <img class="imagen-ppal" src="<?php echo $p->imagen ?>" alt="<?php echo ($p->nombre);?>">
                <?php } else if (!empty($empresa->no_imagen)) { ?>
                  <img class="imagen-ppal" src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($p->nombre);?>">
                <?php } else { ?>
                  <img class="imagen-ppal" src="images/no-imagen.png" alt="<?php echo ($p->nombre);?>">
                <?php } ?>
              </a>
            </div>
            <div class="overlay-block">
              <div class="top-item">
                <div class="tag <?php echo ($p->id_tipo_operacion == 4)?"dark-blue":($p->id_tipo_operacion ==2)?"light-blue":"" ?>">
                  <?php echo ($p->id_tipo_operacion == 1)?"En Venta":"" ?>
                  <?php echo ($p->id_tipo_operacion == 2)?"En Alquiler":"" ?>
                  <?php echo ($p->id_tipo_operacion == 4)?"Emprendimientos":"" ?>
                </div>
                <big><?php echo $p->precio ?></big>
              </div>
              <div class="bottom-item">
                <h3><?php echo $p->nombre ?></h3>
                <span><?php echo $p->direccion_completa ?></span>
                <ul>
                  <li>Habitaciones: <small><?php echo ($p->dormitorios != "0")?$p->dormitorios:"-" ?></small></li>
                  <li>Baños: <small><?php echo ($p->banios != "0")?$p->banios:"-" ?></small></li>
                  <li>Metros: <small><?php echo ($p->superficie_total != "0")?$p->superficie_total:"-" ?></small></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <div class="col-md-12 text-center mt-5">
        <a href="<?php echo mklink ("propiedades/") ?>" class="btn">Ver Todas Las Propiedades</a>
      </div>
    </div>
  </div>
</section>

<!-- Our Partners -->
<?php $logos = $entrada_model->get(44795)?>
<?php if (!empty($logos)) {  ?>
  <section class="our-partners">
    <div class="container">
      <div class="owl-carousel" data-items="5" data-items-lg="3" data-items-md="2" data-items-sm="2"  data-margin="20" data-loop="true" data-nav="true" data-dots="false">
        <?php foreach ($logos->images as $i) { ?>
          <div class="item">
            <div class="logo-wrap">
              <img src="<?php echo $i ?>" alt="Logo">
            </div>
          </div>
        <?php } ?>
        </div>
      </div>
  </section>
<?php } ?>

<!-- Footer -->
<?php include "includes/footer.php" ?>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/html5.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<script src="assets/js/scripts.js"></script>
<script type="text/javascript">
  $(window).on("load",function(){
    $(".scroll-box").mCustomScrollbar();
  });
</script>
<script type="text/javascript">
  function filtrar() { 
    var link = "<?php echo mklink("propiedades/")?>";
    var tipo_operacion = $("#tipo_operacion").val();
    var localidad = $("#localidad").val();
    var tp = $("#tp").val();
    link = link + tipo_operacion + "/" + localidad + "/?tp=" + tp;
    $("#form_propiedades").attr("action",link);
    return true;
  }
</script>
<script type="text/javascript">
if (jQuery(window).width()>767) { 
  $(document).ready(function(){
    var maximo = 0;
    $(".bottom-item").each(function(i,e){
      if ($(e).height() > maximo) maximo = $(e).height();
    });
    maximo = Math.ceil(maximo);
    $(".bottom-item").height(maximo);
  });
}
</script>
</body>
</html>