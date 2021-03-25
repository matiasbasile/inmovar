<?php include "includes/init.php";
$entrada = $entrada_model->get($id);

// Tomamos los datos de SEO
$seo_title = (!empty($entrada->seo_title)) ? ($entrada->seo_title) : $empresa->seo_title;
$seo_description = (!empty($entrada->seo_description)) ? ($entrada->seo_description) : $empresa->seo_description;
$seo_keywords = (!empty($entrada->seo_keywords)) ? ($entrada->seo_keywords) : $empresa->seo_keywords;
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include "includes/head.php" ?>
<meta property="og:url" content="<?php echo current_url(); ?>" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo $entrada->titulo; ?>" />
<meta property="og:description" content="<?php echo substr(strip_tags($entrada->texto),0,300).((strlen($entrada->texto) > 300) ? "..." : "");?>" />
<meta property="og:image" content="<?php echo current_url(TRUE)."/admin/".((!empty($entrada->path)) ? $entrada->path : $empresa->no_imagen); ?>"/>
</head>
<body>

  <div class="home-slider">
    <?php include("includes/header.php") ?>
    <div class="container">
      <div class="breadcrumb-area">
        <h1 class="h1"><?php echo $entrada->titulo ?></h1>
        <ul class="breadcrumbs">
          <li><a href="<?php echo mklink ("/") ?>">Inicio</a></li>
          <li class="active"><?php echo $entrada->categoria ?></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="blog-body content-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
          <!-- Blog box start -->
          <div class="thumbnail blog-box clearfix">
            <?php if (!empty($entrada->path)) { ?>
              <img src="<?php echo $entrada->path ?>" alt="blog-01" class="img-responsive">
            <?php } ?>
            <div class="caption detail">
              <div class="main-title-2">
                <h1><a href="javascript:void(0);"><?php echo $entrada->titulo ?></a></h1>
              </div>
              <?php if ($entrada->mostrar_fecha == 1) { ?>
                <div class="post-meta">
                  <span><a><i class="fa fa-clock-o"></i><?php echo fecha_full($entrada->fecha) ?></a></span>
                </div>
              <?php } ?>

              <?php if (!empty($entrada->path) || sizeof($entrada->images)>0) { ?>
                <div class="properties-detail-slider simple-slider mrg-btm-40 ">
                  <div id="carousel-custom" class="carousel slide" data-ride="carousel">
                    <div class="carousel-outer">
                      <!-- Wrapper for slides -->
                      <div class="carousel-inner">
                        <?php if (!empty($entrada->images)) {  ?>
                          <?php $i=0; 
                          foreach ($entrada->images as $img) { $i++; ?>
                            <div class="item <?php echo ($i==1) ? "active" : "" ?>">
                              <a data-fancybox="gallery" href="<?php echo $img ?>">
                                <img src="<?php echo $img ?>" class="thumb-preview" alt="Chevrolet Impala">
                              </a>
                            </div>
                            <a class="left carousel-control" href="#carousel-custom" role="button" data-slide="prev">
                              <span class="slider-mover-left no-bg" aria-hidden="true">
                                <i class="fa fa-angle-left"></i>
                              </span>
                              <span class="sr-only">Siguiente</span>
                            </a>
                            <a class="right carousel-control" href="#carousel-custom" role="button" data-slide="next">
                              <span class="slider-mover-right no-bg" aria-hidden="true">
                                <i class="fa fa-angle-right"></i>
                              </span>
                              <span class="sr-only">Anterior</span>
                            </a>
                          <?php } ?>
                        <?php } else if (!empty($entrada->path)) { ?>
                          <div class="item active">
                            <a data-fancybox="gallery" href="/admin/<?php echo $entrada->path ?>">
                              <img src="/admin/<?php echo $entrada->path ?>" class="thumb-preview">
                            </a>
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>

              <div class="oh mrg-btm-40">
                <?php echo $entrada->texto ?>
              </div>

              <?php if ($entrada->habilitar_contacto == 1) { ?>
                <div class="contact-form">
                  <div class="main-title-2">
                    <h1>Formulario de <span>contacto</span></h1>
                  </div>
                  <form onsubmit="return enviar_contacto();">
                    <div class="row">
                      <input type="hidden" value="<?php echo $entrada->titulo ?>" id="contacto_asunto" name="subject" class="input-text">
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group fullname">
                          <input type="text" id="contacto_nombre" name="full-name" class="input-text" placeholder="Nombre">
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group number">
                          <input type="text" id="contacto_telefono" name="phone" class="input-text" placeholder="Teléfono">
                        </div>
                      </div>                      
                      <div class="col-xs-12">
                        <div class="form-group enter-email">
                          <input type="email" id="contacto_email" name="email" class="input-text" placeholder="Email">
                        </div>
                      </div>
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix">
                        <div class="form-group message">
                          <textarea class="input-text" id="contacto_mensaje" name="message" placeholder="Escriba aquí su mensaje..."></textarea>
                        </div>
                      </div>
                      <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group send-btn">
                          <button type="submit" id="contacto_submit" class="button-md button-theme">Enviar mensaje</button>
                        </div>
                      </div>
                    </div>
                  </form>     
                </div>
              <?php } ?>

              <?php /*
              <div class="row clearfix t-s">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <!-- Blog Share start -->
                  <div class="blog-share">
                    <h2>Compartir en las redes</h2>
                    <ul class="social-list">
                      <li><a class="facebook" onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(current_url()) ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                      <li><a class="twitter" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo urlencode(html_entity_decode($entrada->titulo,ENT_QUOTES)) ?>&amp;url=<?php echo urlencode(current_url()) ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                      <li><a class="google" href="https://plus.google.com/share?url=<?php echo current_url() ?>" onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                      <li><a class="mail" href="mailto:?subject=<?php echo html_entity_decode($entrada->titulo,ENT_QUOTES) ?>&body=<?php echo(current_url()) ?>"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                      <li><a class="whatsapp" href="whatsapp://send?text=<?php echo urlencode(current_url()) ?>"><i class="fa fa-whatsapp"></i></a></li>
                    </ul>
                  </div>
                  <!-- Blog Share end -->
                </div>
              </div>*/ ?>
            </div>
          </div>
          <!-- Blog box end -->

        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <?php include("includes/sidebar_contacto.php") ?>
        </div>

      </div>
    </div>
  </div>
  <!-- Blog body end -->
  <?php include "includes/footer.php" ?>

<script type="text/javascript"> function enviar_contacto() {
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var telefono = $("#contacto_telefono").val();
  var mensaje = $("#contacto_mensaje").val();
  var asunto = $("#contacto_asunto").val();
  var id_entrada = "<?php echo $entrada->id ?>";
  var id_origen = <?php echo (isset($id_origen) ? $id_origen : 0) ?>;
  
  if (isEmpty(nombre) || nombre == "Nombre") {
      alert("Por favor ingrese un nombre");
      $("#contacto_nombre").focus();
      return false;          
  }
  if (!validateEmail(email)) {
      alert("Por favor ingrese un email valido");
      $("#contacto_email").focus();
      return false;          
  }
  if (isEmpty(telefono) || telefono == "Telefono") {
      alert("Por favor ingrese un telefono");
      $("#contacto_telefono").focus();
      return false;          
  }
  if (isEmpty(mensaje) || mensaje == "Mensaje") {
      alert("Por favor ingrese un mensaje");
      $("#contacto_mensaje").focus();
      return false;              
  }    
  
  $("#contacto_submit").attr('disabled', 'disabled');
  var datos = {
    "para":"<?php echo $empresa->email ?>",
    "nombre":nombre,
    "email":email,
    "mensaje":mensaje,
    "telefono":telefono,
    "asunto":asunto,
    "id_entrada":id_entrada,
    "id_empresa":ID_EMPRESA,
    "id_origen": ((id_origen != 0) ? id_origen : ((id_entrada != 0)?1:6)),
  }
  $.ajax({
    "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
        location.reload();
      } else {
        alert("Ocurrio un error al enviar su email. Disculpe las molestias");
        $("#contacto_submit").removeAttr('disabled');
      }
    }
  });
  return false;
}
</script>

</body>
</html>