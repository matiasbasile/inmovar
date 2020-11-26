<footer class="main-footer clearfix">
  <div class="container">
    
    <div class="footer-info">
      <div>
        <a class="logo-footer" href="<?php echo mklink("/") ?>">
          <img src="images/scipioni.png" alt="<?php echo $empresa->nombre ?>"/>
        </a>
      </div>
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1">
          <span class="rounded"><i class="fa fa-map-marker"></i></span>
          <?php echo ($empresa->direccion) ?>
          <?php echo (!empty($empresa->ciudad)) ? " | ".$empresa->ciudad : "" ?>
          <?php echo (!empty($empresa->codigo_postal)) ? " (".$empresa->codigo_postal.") " : "" ?>
        </div>
        <div class="col-sm-2">
          <span class="rounded"><i class="fa fa-phone"></i></span>
          <a href="tel:<?php echo $empresa->telefono ?>"><?php echo $empresa->telefono ?></a>
        </div>
        <div class="col-sm-4">
          <span class="rounded"><i class="fa fa-envelope"></i></span>
          <a href="mailto:<?php echo $empresa->email ?>"><?php echo $empresa->email ?></a>
        </div>        
      </div>
      <div class="horarios">
        <h4>HORARIOS</h4>
        <?php echo ($empresa->horario) ?>
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
      <div class="col-sm-6 derecha">
        <a class="fr inmovar-logo" href="https://www.inmovar.com" target="_blank"><img class="inmovar-logo-img" src="/templates/inmovarweb/images/varcreative-logo.png"/></a>
        <?php if (!empty($empresa->instagram)) { ?>
          <a class="fr" href="<?php echo $empresa->instagram ?>" target="_blank"><i class="fa fa-instagram"></i></a>
        <?php } ?>        
        <?php if (!empty($empresa->facebook)) { ?>
          <a class="fr" href="<?php echo $empresa->facebook ?>" target="_blank"><i class="fa fa-facebook"></i></a>
        <?php } ?>
        <?php if (!empty($empresa->twitter)) { ?>
          <a class="fr" href="<?php echo $empresa->twitter ?>" target="_blank"><i class="fa fa-twitter"></i></a>
        <?php } ?>
        <?php if (!empty($empresa->linkedin)) { ?>
          <a class="fr" href="<?php echo $empresa->linkedin ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
        <?php } ?>
        <?php if (!empty($empresa->google_plus)) { ?>
          <a class="fr" href="<?php echo $empresa->google_plus ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
        <?php } ?>
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
  "url":"/admin/consultas/function/enviar/",
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