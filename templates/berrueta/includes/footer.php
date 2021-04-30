<!-- FOOTER -->
<div class="footer">
  <div class="page">
    <div class="row">
      <div class="col-md-3"><a href="<?php echo mklink("/") ?>"><img src="images/logo.png" alt="Berrueta" /></a></div>
      <div class="col-md-9">
        <div class="footer-content">
          <ul>
            <?php if (!empty($empresa->telefono)) { ?>
                <li><img src="images/call-icon.png" alt="Call Us" /> TEL&Eacute;FONOS: <?php echo ($empresa->telefono).((!empty($empresa->telefono_2)) ? " | ".($empresa->telefono_2) : "") ?></li>
            <?php } ?>
            <?php if (!empty($empresa->email)) { ?>
                <li><img src="images/email-icon.png" alt="Email Us" /> EMAIL: <?php echo ($empresa->email) ?></li>
            <?php } ?>
          </ul>
          <ul>
            <li>
              <img src="images/location-icon2.png" alt="Our Location" />
              DIRECCI&Oacute;N: <?php echo ($empresa->direccion) ?>
              | CP: <?php echo ($empresa->codigo_postal); ?>
              | <?php echo ($empresa->ciudad); ?>
            </li>
            <div class="social">
                <?php if (!empty($empresa->twitter)) { ?><a href="<?php echo $empresa->twitter; ?>"><img src="images/twitter.png" alt="Twitter" /></a><?php } ?>
                <?php if (!empty($empresa->facebook)) { ?><a href="<?php echo $empresa->facebook; ?>"><img src="images/facebook.png" alt="Facebook" /></a><?php } ?>
            </div>
          </ul>
          <div class="copyright">
            <div class="pull-left">Diego Berrueta Estudio Inmobiliario. Todos Los Derechos Reservados.</div>
            <div class="pull-right">Dise&ntilde;o Web Inmobiliarias <a href="http://www.misticastudio.com/" target="_blank"><img src="images/misticastudio.png" alt="Misticastudio" /></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

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