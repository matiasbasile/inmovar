<?php include 'includes/init.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <?php include 'includes/head.php' ?>
</head>

<body>

  <?php 
  $menu_active = "home";
  include 'includes/header.php' ?>

  <section class="premises-sale pagina-vender">
    <form onsubmit="return enviar_ventas()" class="container" id="form_ventas">
      <div class="row">
        <div class="col-xl-12">

          <div class="section-title">
            <h3>PONE EN VENTA TU PROPIEDAD</h3>
            <b>La comunidad de negocios inmobiliarios te ayuda a vender mas rapido!</b>
          </div>
          
          <div class="white-box">
            <div class="comunicate">
             <div class="icon-box">
               <img src="assets/images/white-box-icon1.svg" alt="icon">
             </div>
              <div class="right-text">
                <h5>DATOS PERSONALES</h5>
                <b>COMPLETE EL FORMULARIO PARA QUE PODAMOS COMUNICARNOS</b>
              </div>
            </div>

            <div class="form">
              <div class="row">
                <div class="col-md-6 col-sm-12">
                  <input id="contacto_nombre" type="text" class="form-control contacto_nombre" placeholder="Nombre">
                </div>
                <div class="col-md-6 col-sm-12">
                  <input id="contacto_apellido" type="text" class="form-control contacto_apellido" placeholder="Apellido">
                </div>
                <div class="col-md-6 col-sm-12">
                  <input id="contacto_email" type="email" class="form-control contacto_email" placeholder="Email">
                </div>
                <div class="col-md-6 col-sm-12">
                  <input id="contacto_telefono" type="number" class="form-control contacto_telefono" placeholder="Whatsapp (sin 0 ni 15)">
                </div>
              </div>
            </div>
          </div> 

          <div class="white-box">
            <div class="comunicate">
             <div class="icon-box">
               <img src="assets/images/icono-casa.png" alt="icon">
             </div>
              <div class="right-text">
               <h5>DATOS DE LA PROPIEDAD</h5>
               <b>INDIQUE EL TIPO DE PROPIEDAD QUE QUIERE PONER A LA VENTA</b>
              </div>
            </div>

            <div class="form">
              <div class="row">
                <div class="col-md-6 col-sm-12">
                  <input id="propiedad_ubicacion" type="text" class="form-control propiedad_ubicacion" placeholder="Ubicación">
                </div>
                <div class="col-md-6 col-sm-12">
                  <select class="form-control propiedad_tipo_propiedad" id="propiedad_tipo_propiedad">
                    <option value="0">Tipo de propiedad</option>
                    <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
                    <?php foreach ($tipo_propiedades as $tipo) { ?>
                      <option value="<?php echo $tipo->nombre ?>"><?php echo $tipo->nombre ?></option>
                    <?php } ?>                    
                  </select>
                </div>
                <div class="col-md-6 col-sm-12">
                  <select class="form-control propiedad_dormitorios" id="propiedad_dormitorios">
                    <option value="0">Dormitorios</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5 o más">5 o más</option>
                  </select>
                </div>
                <div class="col-md-6 col-sm-12">
                  <select class="form-control propiedad_banios" id="propiedad_banios">
                    <option value="0">Baños</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5 o más">5 o más</option>
                  </select>
                </div>
                <div class="col-md-6 col-sm-12">
                  <select class="form-control propiedad_cochera" id="propiedad_cochera">
                    <option value="0">Cochera</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5 o más">5 o más</option>
                  </select>
                </div>
                <div class="col-md-6 col-sm-12">
                  <input id="propiedad_metros" type="number" class="form-control propiedad_metros" placeholder="Cantidad de metros">
                </div>
                <div class="col-md-12">
                  <textarea placeholder="Otros comentarios que desee agregar" class="form-control contacto_mensaje" id="propiedad_otros_comentarios" rows="5"></textarea>
                </div>
                <div class="col-md-12">
                  <button class="btn btn-green contacto_submit">Enviar Solicitud</button>
                </div>

              </div>
            </div>
          </div> 

        </div>
      </div>
    </form>
  </section>

  <?php include 'includes/footer.php' ?>

<script>
function validar_ventas() {
  if (window.enviando == 1) throw false;
  var nombre = $("#form_ventas").find(".contacto_nombre").val();
  var apellido = $("#form_ventas").find(".contacto_apellido").val();
  var email = $("#form_ventas").find(".contacto_email").val();
  var telefono = $("#form_ventas").find(".contacto_telefono").val();
  var mensaje = $("#form_ventas").find(".contacto_mensaje").val();

  var propiedad_tipo_propiedad = $("#form_ventas").find(".propiedad_tipo_propiedad").val();
  var propiedad_ubicacion = $("#form_ventas").find(".propiedad_ubicacion").val();
  var propiedad_dormitorios = $("#form_ventas").find(".propiedad_dormitorios").val();
  var propiedad_banios = $("#form_ventas").find(".propiedad_banios").val();
  var propiedad_cochera = $("#form_ventas").find(".propiedad_cochera").val();
  var propiedad_metros = $("#form_ventas").find(".propiedad_metros").val();

  if (isEmpty(nombre)) {
    alert("Por favor ingrese un nombre");
    $("#form_ventas").find(".contacto_nombre").focus();
    throw false;
  }
  if (isEmpty(apellido)) {
    alert("Por favor ingrese un apellido");
    $("#form_ventas").find(".contacto_apellido").focus();
    throw false;
  }
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido");
    $("#form_ventas").find(".contacto_email").focus();
    throw false;
  }
  if (!isTelephone(telefono)) {
    alert("Por favor ingrese un telefono");
    $("#form_ventas").find(".contacto_telefono").focus();
    throw false;
  }

  if (isEmpty(propiedad_ubicacion)) {
    alert("Por favor ingrese la ubicacion");
    $("#form_ventas").find(".propiedad_ubicacion").focus();
    throw false;
  }

  var observaciones = "";
  observaciones += "Ubicacion: "+propiedad_ubicacion+"\n";
  observaciones += "Tipo de Propiedad: "+propiedad_tipo_propiedad+"\n";
  observaciones += "Dormitorios: "+propiedad_dormitorios+"\n";
  observaciones += "Baños: "+propiedad_banios+"\n";
  observaciones += "Cocheras: "+propiedad_cochera+"\n";
  observaciones += "Metros Cuadrados: "+propiedad_metros+"\n";
  observaciones += "Mensaje Adicional: "+mensaje+"\n";

  $("#form_ventas").find(".contacto_submit").attr('disabled', 'disabled');
  window.enviando = 1;
  var datos = {
    "nombre": nombre,
    "apellido": apellido,
    "email": email,
    "mensaje": mensaje,
    "telefono": telefono,
    "id_empresa": ID_EMPRESA,
    "asunto": "Vende tu Propiedad",
    "mensaje": observaciones,
  }
  return datos;
}

function enviar_ventas() {
  try {
    var datos = validar_ventas();
    datos.id_origen = 1;
    $.ajax({
      "url": "/admin/consultas/function/enviar/",
      "type": "post",
      "dataType": "json",
      "data": datos,
      "success": function(r) {
        if (r.error == 0) {
          alert("Su consulta ha sido enviada correctamente. Nos pondremos en contacto a la mayor brevedad!");
          location.reload();
        } else {
          alert("Ocurrio un error al enviar su email. Disculpe las molestias");
          $("#form_ventas").find(".contacto_submit").removeAttr('disabled');
        }
        window.enviando = 0;
      },
      "error":function() {
        $("#form_ventas").find(".contacto_submit").removeAttr('disabled');
        window.enviando = 0;
      }
    });
    return false;
  } catch(e) {
    $("#form_ventas").find(".contacto_submit").removeAttr('disabled');
    console.log(e);
  }
  return false;
}
</script>


</body>
</html>