<section class="module cta newsletter">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 col-md-7">
        <?php $t = $web_model->get_text("newsletter-title","Suscribite a nuestro <strong>newsletter.</strong>") ?> 
        <h3 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></h3>
        <?php $t = $web_model->get_text("newsletter-txt","Lorem molestie odio. Interdum et malesuada fames ac ante ipsum primis in faucibus.") ?> 
        <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></p>
      </div>
      <div class="col-lg-5 col-md-5">
        <form onsubmit="return enviar_newsletter()" id="newsletter-form" class="newsletter-form">
          <input id="newsletter_email" type="email" placeholder="Tu email..." />
          <button type="submit" id="newsletter_submit" form="newsletter-form"><i class="fa fa-send"></i></button>
        </form>
      </div>
    </div><!-- end row -->
  </div><!-- end container -->
</section>

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


<footer id="footer">
  <div class="container">
    <div class="row">
      <div class="col-sm-4 widget footer-widget">
        <?php if ($empresa->id == 730) { ?>
          <a class="footer-logo" href="<?php echo mklink("/") ?>">
            <img src="images/diego-blanco.png" alt="<?php echo $empresa->nombre ?>" />
          </a>
        <?php } else { ?>
          <h4><span>Sobre Nosotros</span> <hr class="divisorline footer"></h4>
        <?php } ?>
        <?php $t = $web_model->get_text("text-footer","Lorem ipsum dolor amet, consectetur adipiscing elit. Sed ut 
        purus eget nunc ut dignissim cursus at a nisl. Mauris vitae 
        turpis quis eros egestas tempor sit amet a arcu. Duis egestas 
        hendrerit diam.") ?>
        <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>"><?php echo $t->plain_text ?></p>
        <div class="divider"></div>
        <ul class="social-icons circle">
          <?php if (!empty($empresa->facebook)) {  ?><li><a target="_blank" href="<?php echo $empresa->facebook ?>"><i class="fa fa-facebook"></i></a></li><?php } ?>
          <?php if (!empty($empresa->instagram)) {  ?><li><a target="_blank" href="<?php echo $empresa->instagram ?>"><i class="fa fa-instagram"></i></a></li><?php } ?>
          <?php if (!empty($empresa->twitter)) {  ?><li><a target="_blank" href="<?php echo $empresa->twitter ?>"><i class="fa fa-twitter"></i></a></li><?php } ?>
          <?php if (!empty($empresa->youtube)) {  ?><li><a target="_blank" href="<?php echo $empresa->youtube ?>"><i class="fa fa-youtube"></i></a></li><?php } ?>
        </ul>
      </div>
      <div class="col-sm-4 widget footer-widget">
        <h4><span>Contacto</span> <hr class="divisorline footer"></h4>
        <p>
          <?php echo $empresa->ciudad ?> 
          <?php if (!empty($empresa->codigo_postal)) { ?>- Código Postal: <?php echo $empresa->codigo_postal ?><br/><?php } ?>
          <?php if (!empty($empresa->direccion)) { ?>Dirección: <?php echo ($empresa->direccion) ?> <br/><?php } ?>
        </p>
        <?php if (!empty($empresa->horario)) { ?> 
          <p>
            <b class="open-hours">Horario:</b><br/>
            <?php echo ($empresa->horario) ?>
          </p>
        <?php } ?>
        <b class="open-hours">Teléfonos:</b><br/>
        <?php if (!empty($empresa->telefono)) {  ?>
          <p class="footer-phone"><i class="fa fa-phone icon"></i> <?php echo $empresa->telefono ?></p>
        <?php } ?> 
        <?php if (!empty($empresa->telefono_2)) {  ?>
          <p class="footer-phone"><i class="fa fa-phone icon"></i> <?php echo $empresa->telefono_2 ?></p>
        <?php } ?> 
      </div>
      <?php $last_prop = $propiedad_model->ultimas(array("offset"=>2)) ?> 
      <?php if (!empty($last_prop)) {  ?>
        <div class="col-sm-4 widget footer-widget from-the-blog">
          <h4><span>Últimas Propiedades</span> <hr class="divisorline footer"></h4>
          <ul>
            <?php foreach ($last_prop as $p) {  ?>
              <li class="ultimas-footer">
                <div class="dt">
                  <div class="dtc vat">
                    <a href="<?php echo mklink ($p->link) ?>">
                      <img src="<?php echo $p->imagen ?>" alt="<?php echo $p->nombre ?>">
                    </a>
                  </div>
                  <div class="dtc vat">
                    <h3><?php echo ucwords(strtolower($p->nombre)) ?></h3>
                    <p><span><?php echo $p->tipo_operacion ?> - <?php echo $p->tipo_inmueble ?></span><br/><a  href="<?php echo mklink ($p->link)?>">Leer más</a></p>
                  </div>
                </div>
              </li>
            <?php } ?>
          </ul>
        </div>
      <?php } ?>      
    </div><!-- end row -->
  </div><!-- end footer container -->
</footer>
<div class="bottom-bar">
  <div class="container">
    <div class="slogan">© <?php echo date("Y")?>  |  <?php echo ($empresa->nombre) ?>  |  Todos los derechos reservados  </div>
    <a class="inmovar-logo" href="https://www.inmovar.com" target="_blank">
      <img class="inmovar-logo-img" src="images/inmovar-despega.png"/>  
      <span class="inmovar-frase">¡Hacé despegar tu inmobiliariae!</span>
    </a>
  </div>
</div>
<?php include("templates/comun/clienapp.php") ?>