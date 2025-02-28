<?php 
include "includes/init.php";
$entrada = $entrada_model->get($id); ?>
<!DOCTYPE html>
<html lang="es" >
<head>
  <?php include 'includes/head.php' ?>
</head>
<body>

<?php 
$menu_active = $entrada->link;
include 'includes/header.php'; ?>

<!-- Premises Sale -->
<section class="premises-sale entrada-detalle">
  <div class="container">
    <div class="row">
      <div class="col-xl-8">

        <div class="section-title">
          <h3><?php echo $entrada->titulo ?></h3>
        </div>

        <div class="section-date">
          <img src="assets/images/cal.jpg" />
          <?php echo $entrada->fecha ?>
        </div>
        
        <div class="slider">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <a href="javascript:void(0)" onclick="abrir_galeria()" class="nav-link active">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
                  <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                  <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
                </svg>
              </a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active">  
              <div class="owl-carousel owl-theme" data-outoplay="true" data-items="1" data-nav="true" data-dots="false">
                <?php foreach ($entrada->images as $img) { ?>
                  <div class="item">
                    <a href="javascript:void(0)" onclick="abrir_galeria()">
                      <img src="<?php echo $img ?>" alt="img">
                    </a>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>

        <div class="dn">
          <?php foreach ($entrada->images as $img) { ?>
            <a href="javascript:void(0)" data-fancybox="gallery" data-src="<?php echo $img ?>">
              <img src="<?php echo $img ?>" alt="img">
            </a>
          <?php } ?>
        </div>

    
        <?php if (!empty($entrada->texto)) { ?>
          <?php if (!empty($entrada->subtitulo)) { ?>
            <div class="section-title">
              <h3><?php echo $entrada->subtitulo ?></h3>
            </div>
          <?php } ?>
          <div class="title">
            <p><?php echo $entrada->texto ?></p>
          </div>
        <?php } ?>

      </div>

      <div class="col-xl-4">
        <div class="white-box">
          <div class="comunicate">
           <div class="icon-box">
             <img src="assets/images/white-box-icon1.svg" alt="icon">
           </div>
            <div class="right-text">
             <h5>COMUNICATE AHORA</h5>
            </div>
          </div>
          <form onsubmit="return false">
            <input id="contacto_nombre" type="text" class="form-control" placeholder="Nombre">
            <input id="contacto_email" type="email" class="form-control" placeholder="Email">
            <input id="contacto_telefono" type="text" class="form-control" placeholder="Whatsapp (sin 0 ni 15)">
            <textarea id="contacto_mensaje" class="form-control" placeholder="">Me comunico de la web interesado en <?php echo $entrada->titulo ?></textarea>
            <button onclick="enviar_whatsapp()" type="submit" class="btn btn-green"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
              <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
            </svg> Enviar Whatsapp</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php' ?>

<script>
  Fancybox.bind('[data-fancybox="gallery"]', {}); 
</script>

<script>
window.enviando = 0;
function validar() {
  if (window.enviando == 1) throw false;
  var nombre = $("#contacto_nombre").val();
  var email = $("#contacto_email").val();
  var telefono = $("#contacto_telefono").val();
  var mensaje = $("#contacto_mensaje").val();

  if (isEmpty(nombre) || nombre == "Nombre") {
    alert("Por favor ingrese un nombre");
    $("#contacto_nombre").focus();
    throw false;
  }
  if (isEmpty(telefono)) {
    alert("Por favor ingrese un telefono");
    $("#contacto_telefono").focus();
    throw false;
  }
  if (telefono.length != 10) {
    alert("Por favor ingrese su numero de telefono sin 0 ni 15.");
    $("#contacto_telefono").focus();
    throw false;    
  }
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido");
    $("#contacto_email").focus();
    throw false;
  }
  if (isEmpty(mensaje)) {
    alert("Por favor ingrese un mensaje");
    $("#contacto_mensaje").focus();
    throw false;
  }

  $(".contacto_submit").attr('disabled', 'disabled');
  window.enviando = 1;
  var datos = {
    "nombre": nombre,
    "email": email,
    "mensaje": mensaje,
    "telefono": telefono,
    "id_entrada": "<?php echo (isset($entrada) ? $entrada->id : 0) ?>",
    "para": "<?php echo ( (isset($usuario->email) && !empty($usuario->email)) ? $usuario->email : $empresa->email) ?>",
    "id_usuario": "<?php echo (isset($usuario->id) ? $usuario->id : 0) ?>",
    "id_empresa": ID_EMPRESA,
  }
  return datos;
}

function enviar_whatsapp() {
  try {
    var datos = validar();
    datos.id_origen = 27;
    $.ajax({
      "url": "/admin/consultas/function/enviar/",
      "type": "post",
      "dataType": "json",
      "data": datos,
      "success": function(r) {
        if (r.error == 0) {
          var url = "https://wa.me/"+"<?php echo isset($usuario->celular_f) ? $usuario->celular_f : ''  ?>";
          url+= "?text="+encodeURIComponent(datos.mensaje);
          var open = window.open(url,"_blank");
          if (open == null || typeof(open)=='undefined') {
            // Si se bloqueo el popup, se redirecciona
            location.href = url;
          }
        } else {
          alert("Ocurrio un error al enviar su email. Disculpe las molestias");
          $(".contacto_submit").removeAttr('disabled');
        }
        window.enviando = 0;
      },
      "error":function() {
        $(".contacto_submit").removeAttr('disabled');
        window.enviando = 0;
      }
    });
  } catch(e) {
    $(".contacto_submit").removeAttr('disabled');
    console.log(e);
  }
}

function abrir_galeria() {
  $('[data-fancybox="gallery"] img').first().trigger("click")
}
</script>
</body>
</html>