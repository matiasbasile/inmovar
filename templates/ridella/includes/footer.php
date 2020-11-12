<footer>
  <div class="container">
    <div class="logo"><a href="#0"><img src="/admin/<?php echo $empresa->logo_1 ?>"></a></div>
    <div class="contact-info">
      <ul>
        <?php if (!empty($empresa->direccion)) { ?><li><span>Dirección:</span> <a href="javascript:void(0)"><?php echo ($empresa->direccion).". ".$empresa->ciudad ?></a></li><?php } ?>
        <?php if (!empty($empresa->telefono)) { ?><li><span>Teléfono:</span> <a href="tel:<?php echo $empresa->telefono ?>"><?php echo $empresa->telefono ?></a></li><?php } ?>
        <?php if (!empty($empresa->email)) { ?><li><span>Email:</span> <a href="mailto:<?php echo $empresa->email ?>"><?php echo $empresa->email ?></a></li><?php } ?>
      </ul>
    </div>
    <div class="socials">
      <ul>
          <?php if (!empty($empresa->facebook)) {  ?><li><a target="_blank" href="<?php echo $empresa->facebook ?>"><i class="fab fa-facebook-f"></i></a></li><?php } ?>
          <?php if (!empty($empresa->instagram)) {  ?><li><a target="_blank" href="<?php echo $empresa->instagram ?>"><i class="fab fa-instagram"></i></a></li><?php } ?>
        </ul>
    </div>
    <div class="copyright">
      <div class="pull-left">
        <span>Ridella Propiedades. <small>Todos Los Derechos Reservados</small></span>
      </div>
      <div class="pull-right">
        <span>Diseño Web Inmobiliarias <a href="www.misticastudio.com">MisticaStudio.com</a> <img src="images/mistica-logo.png"></span>
      </div>
    </div>
  </div>
</footer>
</div>

<div id="loading">
  <div id="loading-center">
    <div id="loading-center-absolute">
      <div class="object"></div>
      <div class="object"></div>
      <div class="object"></div>
      <div class="object"></div>
      <div class="object"></div>
      <div class="object"></div>
      <div class="object"></div>
      <div class="object"></div>
      <div class="object"></div>
      <div class="object"></div>
    </div>
  </div> 
</div>

<!-- Back To Top -->
<div class="back-top"><a href="javascript:void(0);"><i class="fa fa-angle-up" aria-hidden="true"></i></a></div>

<script src="js/jquery.min.js"></script> 
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins.js"></script>
<script src="js/swiper.js"></script>
<script src="js/jquery.flexslider.js"></script>
<script src="js/scripts.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script>
function abrir_form_propiedades() {
  $("#form_propiedades").slideToggle();
}

function enviar_buscador(form) {
  var link = "<?php echo mklink("propiedades/")?>";
  var localidad = $("#"+form).find(".buscador_localidad").val();
  var tipo_operacion = form.replace("formulario_","");
  var tipo_propiedad = $("#"+form).find(".buscador_tipo_propiedad").val();
  link = link + tipo_operacion + "/" + localidad + "/";
  $("#"+form).attr("action",link);
  return true;
}
</script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script>
$(document).ready(function(){
  if ($("#precio_minimo").length > 0) {
    new AutoNumeric('#precio_minimo', { 
      'decimalPlaces':0,
      'decimalCharacter':',',
      'digitGroupSeparator':'.',
    });
  }
  if ($("#precio_maximo").length > 0) {
    new AutoNumeric('#precio_maximo', { 
      'decimalPlaces':0,
      'decimalCharacter':',',
      'digitGroupSeparator':'.',
    });
  }
})
</script>

<?php include("templates/comun/clienapp.php") ?>