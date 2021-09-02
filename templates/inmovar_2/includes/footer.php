<!-- Footer start -->
<footer class="main-footer clearfix">
  <div class="container">
    
    <!-- Footer info-->
    <div class="footer-info">
      <div class="row">
        <!-- About us -->
        <div class="col-md-4 col-sm-12">
          <div class="footer-item">
            <div class="main-title-2">
              <h3>Contacto</h3>
            </div>
            <?php $t = $web_model->get_text("TextodeFooter","Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's printing and typesetting") ?>
            <p class="editable" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
              <?php echo $t->plain_text ?>
            </p>
            <ul class="personal-info">
              <?php if (!empty($empresa->direccion)) { ?>
                <li>
                  <i class="fa fa-map-marker"></i>
                  <?php echo $empresa->direccion ?>
                  <?php echo (!empty($empresa->ciudad)) ? " - ".$empresa->ciudad : "" ?>
                  <?php echo (!empty($empresa->codigo_postal)) ? " (".$empresa->codigo_postal.") " : "" ?>
                </li>
              <?php } ?>
              <?php if (!empty($empresa->email)) { ?>
                <li>
                  <i class="fa fa-envelope"></i>
                  <a href="mailto:<?php echo $empresa->email ?>"><?php echo $empresa->email ?></a>
                </li>
              <?php } ?>
              <?php if (!empty($empresa->telefono) || !empty($empresa->telefono_2)) { ?>
                <li>
                  <i class="fa fa-phone"></i>
                  <a href="tel:<?php echo $empresa->telefono ?>">
                    <?php echo $empresa->telefono ?>
                    <?php echo (!empty($empresa->telefono_2)) ? " / ".$empresa->telefono_2 : "" ?>
                  </a>
                </li>
              <?php } ?>
            </ul>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="footer-top">
            <div class="main-title-2">
              <h3>Newsletter</h3>
            </div>
            <form onsubmit="return enviar_newsletter();">
              <input type="text" class="form-contact" id="newsletter_email" name="email" placeholder="Email...">
              <button type="submit" name="submitNewsletter" id="newsletter_submit" class="btn btn-default button-small">
                <i class="fa fa-paper-plane"></i>
              </button>
            </form>
            <div class="main-title-2">
              <h3 class="redes">Redes sociales</h3>
            </div>
            <ul class="social-list clearfix">
              <?php if (!empty($empresa->facebook)) { ?>
                <li><a href="<?php echo $empresa->facebook ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
              <?php } ?>
              <?php if (!empty($empresa->twitter)) { ?>
                <li><a href="<?php echo $empresa->twitter ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
              <?php } ?>
              <?php if (!empty($empresa->linkedin)) { ?>
                <li><a href="<?php echo $empresa->linkedin ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
              <?php } ?>
              <?php if (!empty($empresa->google_plus)) { ?>
                <li><a href="<?php echo $empresa->google_plus ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
              <?php } ?>
              <?php if (!empty($empresa->instagram)) { ?>
                <li><a href="<?php echo $empresa->instagram ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
              <?php } ?>
            </ul>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="footer-item popular-posts">
            <div class="main-title-2">
              <h3>Últimas propiedades</h3>
            </div>
            <?php if (!empty($listado_full)) {  ?>
            <?php for($i=0;$i<2;$i++) { $p = $listado_full[$i] ?>      
              <div class="media">
                <div class="media-left">
                  <a href="<?php echo $p->link_propiedad ?>"><img class="media-object" src="<?php echo $p->imagen ?>" alt="small-properties-3"></a>
                </div>
                <div class="media-body">
                  <h3 class="media-heading">
                    <a href="<?php echo $p->link_propiedad ?>"><?php echo $p->nombre ?></a>
                  </h3>
                  <p><?php echo $p->tipo_operacion ?></p>
                  <div class="comments-icon">
                  <p><?php echo $p->localidad ?></p>
                  </div>
                </div>
              </div>
            <?php } ?>
          <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- Footer end -->

<!-- Copy right start -->
<div class="copy-right">
  <div class="container">
    <div class="row">
      <div class="col-sm-6 col1">
        <span class="copyright-texto"><?php echo date("Y") ?>. Todos los derechos reservados.</span>
      </div>
      <div class="col-sm-6">
        <a class="inmovar-logo" href="https://www.inmovar.com" target="_blank">
          <img class="inmovar-logo-img" src="images/inmovar-despega.png"/>  
          <span class="inmovar-letra">¡Hacé despegar tu inmobilaria!</span>
        </a>
      </div>
    </div>
    
  </div>
</div>
<!-- Copy end right-->

<script type="text/javascript" src="js/jquery-2.2.0.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-submenu.js"></script>
<script type="text/javascript" src="js/rangeslider.js"></script>
<script type="text/javascript" src="js/jquery.mb.YTPlayer.js"></script>
<script type="text/javascript" src="js/owl.carousel.min.js"></script>
<script type="text/javascript" src="js/wow.min.js"></script>
<script type="text/javascript" src="js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.scrollUp.js"></script>
<script type="text/javascript" src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="js/leaflet.js"></script>
<script type="text/javascript" src="js/leaflet-providers.js"></script>
<script type="text/javascript" src="js/leaflet.markercluster.js"></script>
<script type="text/javascript" src="js/dropzone.js"></script>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
   function enviar_newsletter() {
  if (typeof $ === "undefined") $ = jQuery;
  var email = $("#newsletter_email").val();
  if (!validateEmail(email)) {
  alert("Por favor ingrese un email valido.");
  $("#newsletter_email").focus();
  return false;
  }
  
  $("#newsletter_submit").attr('disabled', 'disabled');
  var datos = {
  "email":email,
  "mensaje":"Registro a Newsletter",
  "asunto":"Registro a Newsletter",
  "para":"<?php echo $empresa->email ?>",
  "id_empresa":ID_EMPRESA,
  "id_origen":2,
  }
  $.ajax({
  "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
  "type":"post",
  "dataType":"json",
  "data":datos,
  "success":function(r){
    if (r.error == 0) {
    alert("Muchas gracias por registrarse a nuestro newsletter!");
    location.reload();
    } else {
    alert("Ocurrio un error al enviar su email. Disculpe las molestias");
    $("#newsletter_submit").removeAttr('disabled');
    }
  }
  });  
  return false;
}
</script>
<script type="text/javascript">
  $(document).ready(function(){
  var maximo = 0;
  $(".our-service .content").each(function(i,e){
    if ($(e).height() > maximo) maximo = $(e).height();
  });
  maximo = Math.ceil(maximo);
  $(".our-service .content").height(maximo);
});
</script>

<?php include("templates/comun/clienapp.php") ?>