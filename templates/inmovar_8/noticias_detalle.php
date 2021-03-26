<?php include "includes/init.php" ?>
<?php $entrada = $entrada_model->get($id)?>
<?php ($entrada->categoria_link=="empresa")?$titulo_pagina="empresa": $titulo_pagina = "informacion" ?>
<!doctype html>
<html lang="en">
<head>
  <?php include "includes/head.php" ?>
</head>
<body>
<!-- header part start here -->
<?php include "includes/header.php" ?>
<!--Detail 1 Page Start here -->
<div class="detail_one_page">
  <div class="page_top_bar">
    <div class="container">
      <h3>Información</h3>
      <ul>
      <li><?php echo $entrada->categoria ?> </li>
    </ul>
    </div>
  </div>
  <div class="details_wraper pg_spc">
    <div class="container">
      <div class="details_wrap">
        <div class="row">
          <div class="col-lg-9 paddi_right">
            <h4 class="heading_details"><?php echo $entrada->titulo ?> </h4>
            <?php if ($entrada->mostrar_fecha == 1) {  ?><div class="date_time"> <span><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $entrada->fecha ?></span> <span class="time_span"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $entrada->hora ?>HS.</span> </div><?php } ?>
              <div class="details_content_wrap"> 
                <?php array_unshift($entrada->images,$entrada->path )?>
                <?php if (!empty($entrada->path)) {  ?>
                <!--slider start here -->
                  <div class="details_carousel">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                      <ol class="carousel-indicators">
                        <?php $x=0;foreach ($entrada->images as $i) {  ?>
                          <li data-target="#myCarousel" data-slide-to="<?php echo $x ?>" class="<?php echo ($x==0)?"active":"" ?>"></li>
                        <?php $x++;} ?>
                      </ol>
                      <div class="carousel-inner">
                        <?php $x=0;foreach ($entrada->images as $i) {  ?>
                          <div class="carousel-item <?php echo ($x==0)?"active":"" ?>" style="background-image: url(<?php echo $i ?>);"> </div>
                        <?php $x++; } ?>
                      </div>
                      <?php if (sizeof($entrada->images)>1) {  ?>
                      <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev"> <i class="fa fa-long-arrow-left carousel_ctrl" aria-hidden="true"></i> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next"> <i class="fa fa-long-arrow-right carousel_ctrl" aria-hidden="true"></i> <span class="sr-only">Next</span> </a> <?php } ?></div>
                  </div>
                <!--slider end here -->
                <?php } ?>
            
                <div class="post_contet">
                  <h4 class="post_h4"><?php echo $entrada->subtitulo ?></h4>
                  <p><?php echo $entrada->texto ?></p>
                </div>
                <div class="contact_form">
                  <h4>Enviar Consulta</h4>
                  <form onsubmit="return enviar_contacto()">
                    <div class="form-row">
                      <input type="hidden" id="contacto_id_entrada" value="<?php echo $entrada->id ?>" name="">
                      <div class="form-group col-md-6">
                        <input id="contacto_nombre" class="form-control" placeholder="Nombre*" type="text">
                      </div>
                      <div class="form-group col-md-6">
                        <input id="contacto_telefono" class="form-control" placeholder="Telefono*" type="text">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-12">
                    <input id="contacto_email" class="form-control" placeholder="Email*" type="email">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <textarea id="contacto_mensaje" class="form-textarea" placeholder="Estoy interesado en esta propiedad *"></textarea>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <button id="contacto_submit" type="submit" class="full_width_btn">consultar</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
          </div>
            <?php include "includes/sidebar.php" ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Detail 1 Page End here --> 

<!-- Footer Part Start here -->
  <?php include "includes/footer.php" ?>


<!-- Footer Part End here --> 

<!-- JavaScript
  ================================================== --> 
<script src="/admin/resources/js/jquery.min.js"></script> 
<!-- <script src="js/jquery-3.2.1.slim.min.js"></script>  -->
<script src="js/bootstrap.js"></script> 
<script src="js/popper.min.js"></script> 
<script src="js/owl.carousel.js"></script>

<script type="text/javascript">
$('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
  if (!$(this).next().hasClass('show')) {
    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
  }
  var $subMenu = $(this).next(".dropdown-menu");
  $subMenu.toggleClass('show');


  $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
    $('.dropdown-submenu .show').removeClass("show");
  });


  return false;
});

$(document).ready(function(){
    $('.sub-menu-ul .dropdown-toggle').on('click',function(){
          if($(this).hasClass('menu_show')){
            $(this).removeClass('menu_show');
          }else{
            $(this).addClass('menu_show');
          }
       });
});
</script>
<script type="text/javascript">
  function enviar_contacto() {
    
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var id_entrada = $("#contacto_id_entrada").val();
  var mensaje = $("#contacto_mensaje").val();
  var telefono = $("#contacto_telefono").val();
  
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
    "asunto":"Contacto desde web",
    "id_entrada":id_entrada,
    "id_empresa":ID_EMPRESA,
  }
  $.ajax({
    "url":"https://app.inmovar.com/admin/consultas/function/enviar/",
    "type":"post",
    "dataType":"json",
    "data":datos,
    "success":function(r){
      if (r.error == 0) {
        alert("Muchas gracias por contactarse con nosotros. Le responderemos a la mayor brevedad!");
        window.location.href ='<?php echo mklink ("web/gracias/") ?>';
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