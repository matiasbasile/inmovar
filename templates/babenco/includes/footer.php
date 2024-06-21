<footer class="footer">
  <div class="container">
    <div class="footer-top">
      <div class="row">
        <div class="col-lg-3 col-md-12">
          <div class="logo">
            <img src="assets/images/logo.png" alt="logo">
          </div>
        </div>
        <div class="col-lg-9 col-md-12">
          <div class="newsletter">
            <h5>Suscribe al Newsletter</h5>
            <form>
              <input class="form-control" type="email" name="Tu dirección de email" placeholder="Tu dirección de email">
              <button type="submit" class="btn">Enviar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="row">
        <div class="col-md-4">
          <h6>comunicate</h6>
          <p>Contáctanos en La Plata y Punta del Este para empezar a hacer realidad tus sueños de hogar en dos lugares excepcionales.</p>
        </div>

        <?php
        $oficinas_list = $entrada_model->get_list(array(
          "from_link_categoria" => "oficinas"
        ));
        $i = 0;
        foreach($oficinas_list as $oficina) { ?>
          <div class="col-md-4">
            <div class="map-contact">
              <div class="map">
                <img src="assets/images/map1.png" alt="Map">
              </div>
              <div class="contact-detail">
                <strong><?php echo $oficina->titulo ?></strong>
                <p><?php echo $oficina->video ?></p>
                <a href="javascript:void(0)" rel="nofollow">
                  <svg fill="#000000" width="800px" height="800px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M11.42 9.49c-.19-.09-1.1-.54-1.27-.61s-.29-.09-.42.1-.48.6-.59.73-.21.14-.4 0a5.13 5.13 0 0 1-1.49-.92 5.25 5.25 0 0 1-1-1.29c-.11-.18 0-.28.08-.38s.18-.21.28-.32a1.39 1.39 0 0 0 .18-.31.38.38 0 0 0 0-.33c0-.09-.42-1-.58-1.37s-.3-.32-.41-.32h-.4a.72.72 0 0 0-.5.23 2.1 2.1 0 0 0-.65 1.55A3.59 3.59 0 0 0 5 8.2 8.32 8.32 0 0 0 8.19 11c.44.19.78.3 1.05.39a2.53 2.53 0 0 0 1.17.07 1.93 1.93 0 0 0 1.26-.88 1.67 1.67 0 0 0 .11-.88c-.05-.07-.17-.12-.36-.21z"></path><path d="M13.29 2.68A7.36 7.36 0 0 0 8 .5a7.44 7.44 0 0 0-6.41 11.15l-1 3.85 3.94-1a7.4 7.4 0 0 0 3.55.9H8a7.44 7.44 0 0 0 5.29-12.72zM8 14.12a6.12 6.12 0 0 1-3.15-.87l-.22-.13-2.34.61.62-2.28-.14-.23a6.18 6.18 0 0 1 9.6-7.65 6.12 6.12 0 0 1 1.81 4.37A6.19 6.19 0 0 1 8 14.12z"></path></svg> 
                  +54 (221) 123-5678
                </a>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</footer>

<section class="copyright">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8 d-flex align-items-center">
        <div class="socials">
          <ul>
            <?php if (!empty($empresa->facebook)) { ?>
              <li>
                <a target="_blank" href="<?php echo $empresa->facebook ?>">
                  <svg fill="#000000" width="800px" height="800px" viewBox="0 0 32 32" id="Camada_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><style type="text/css">  .st0{fill-rule:evenodd;clip-rule:evenodd;}</style><path class="st0" d="M12.6,16.1v11.6c0,0.2,0.1,0.3,0.3,0.3h4.6c0.2,0,0.3-0.1,0.3-0.3V15.9h3.4c0.2,0,0.3-0.1,0.3-0.3l0.3-3.6  c0-0.2-0.1-0.3-0.3-0.3h-3.7V9.2c0-0.6,0.5-1.1,1.2-1.1h2.6C21.9,8.1,22,8,22,7.8V4.3C22,4.1,21.9,4,21.7,4h-4.4  c-2.6,0-4.7,1.9-4.7,4.3v3.4h-2.3c-0.2,0-0.3,0.1-0.3,0.3v3.6c0,0.2,0.1,0.3,0.3,0.3h2.3V16.1z"/></svg>
                </a>
              </li>
            <?php } ?>
            <?php if (!empty($empresa->instagram)) { ?>
              <li>
                <a target="_blank" href="<?php echo $empresa->instagram ?>">
                  <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M12 18C15.3137 18 18 15.3137 18 12C18 8.68629 15.3137 6 12 6C8.68629 6 6 8.68629 6 12C6 15.3137 8.68629 18 12 18ZM12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16Z" fill="#0F0F0F"/>
                  <path d="M18 5C17.4477 5 17 5.44772 17 6C17 6.55228 17.4477 7 18 7C18.5523 7 19 6.55228 19 6C19 5.44772 18.5523 5 18 5Z" fill="#0F0F0F"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M1.65396 4.27606C1 5.55953 1 7.23969 1 10.6V13.4C1 16.7603 1 18.4405 1.65396 19.7239C2.2292 20.8529 3.14708 21.7708 4.27606 22.346C5.55953 23 7.23969 23 10.6 23H13.4C16.7603 23 18.4405 23 19.7239 22.346C20.8529 21.7708 21.7708 20.8529 22.346 19.7239C23 18.4405 23 16.7603 23 13.4V10.6C23 7.23969 23 5.55953 22.346 4.27606C21.7708 3.14708 20.8529 2.2292 19.7239 1.65396C18.4405 1 16.7603 1 13.4 1H10.6C7.23969 1 5.55953 1 4.27606 1.65396C3.14708 2.2292 2.2292 3.14708 1.65396 4.27606ZM13.4 3H10.6C8.88684 3 7.72225 3.00156 6.82208 3.0751C5.94524 3.14674 5.49684 3.27659 5.18404 3.43597C4.43139 3.81947 3.81947 4.43139 3.43597 5.18404C3.27659 5.49684 3.14674 5.94524 3.0751 6.82208C3.00156 7.72225 3 8.88684 3 10.6V13.4C3 15.1132 3.00156 16.2777 3.0751 17.1779C3.14674 18.0548 3.27659 18.5032 3.43597 18.816C3.81947 19.5686 4.43139 20.1805 5.18404 20.564C5.49684 20.7234 5.94524 20.8533 6.82208 20.9249C7.72225 20.9984 8.88684 21 10.6 21H13.4C15.1132 21 16.2777 20.9984 17.1779 20.9249C18.0548 20.8533 18.5032 20.7234 18.816 20.564C19.5686 20.1805 20.1805 19.5686 20.564 18.816C20.7234 18.5032 20.8533 18.0548 20.9249 17.1779C20.9984 16.2777 21 15.1132 21 13.4V10.6C21 8.88684 20.9984 7.72225 20.9249 6.82208C20.8533 5.94524 20.7234 5.49684 20.564 5.18404C20.1805 4.43139 19.5686 3.81947 18.816 3.43597C18.5032 3.27659 18.0548 3.14674 17.1779 3.0751C16.2777 3.00156 15.1132 3 13.4 3Z" fill="#0F0F0F"/>
                  </svg>
                </a>
              </li>
            <?php } ?>
          </ul>
        </div>
        <p><span>Babenco Negocios Inmobiliarios.</span> Todos Los Derechos Reservados</p>
      </div>
      <div class="col-md-4 txt-right">
         <p>
          <a target="_blank" href="https://www.inmovar.com"><img src="assets/images/inmovar.png" alt="Inmovar Logo"></a>
          <a target="_blank" href="https://misticastudio.com"><img src="assets/images/mistica.png" alt="Mistica Logo"></a>
        </p>
      </div>
    </div>
  </div>
</section>

<a id="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
</svg></a>

<!-- Scripts -->
<script src="assets/js/jquery-min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/scripts.js"></script>
<script src="assets/js/fancybox.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>

<script src="/admin/resources/js/moment.min.js"></script>
<?php include_once("templates/comun/mapa_js.php"); ?>

<script>
// ======================================
// FUNCIONES DE CONTACTO
// ======================================

window.enviando = 0;
function validar(id_form) {
  if (window.enviando == 1) throw false;
  var nombre = $("#"+id_form).find(".contacto_nombre").val();
  var email = $("#"+id_form).find(".contacto_email").val();
  var telefono = $("#"+id_form).find(".contacto_telefono").val();
  var mensaje = $("#"+id_form).find(".contacto_mensaje").val();

  if (isEmpty(nombre) || nombre == "Nombre") {
    alert("Por favor ingrese un nombre");
    $("#"+id_form).find(".contacto_nombre").focus();
    throw false;
  }
  if (!isTelephone(telefono)) {
    alert("Por favor ingrese un telefono");
    $("#"+id_form).find(".contacto_telefono").focus();
    throw false;
  }
  if (!validateEmail(email)) {
    alert("Por favor ingrese un email valido");
    $("#"+id_form).find(".contacto_email").focus();
    throw false;
  }
  if (isEmpty(mensaje)) {
    alert("Por favor ingrese un mensaje");
    $("#"+id_form).find(".contacto_mensaje").focus();
    throw false;
  }

  $("#"+id_form).find(".contacto_submit").attr('disabled', 'disabled');
  window.enviando = 1;
  var datos = {
    "nombre": nombre,
    "email": email,
    "mensaje": mensaje,
    "telefono": telefono,
    "id_propiedad": "<?php echo (isset($propiedad) ? $propiedad->id : 0) ?>",
    <?php if (isset($propiedad) && $propiedad->id_empresa != $empresa->id) { ?>
      "id_empresa": "<?php echo $propiedad->id_empresa ?>",
      "id_empresa_relacion": "<?php echo $propiedad->id_empresa ?>",
    <?php } ?> 
    //"id_empresa": ID_EMPRESA,
  }
  return datos;
}

function enviar_visita(id_form) {
  try {
    // Validamos los datos del otro formulario en realidad
    var datos = validar('form_whatsapp_sidebar');

    // Validamos tambien que haya elegido una fecha
    var fecha = $("#"+id_form).find(".visita_fecha").val();
    if (isEmpty(fecha)) {
      alert("Por favor seleccione una fecha para la visita.");
      $("#"+id_form).find(".visita_fecha").focus();
      return false;
    }

    datos.id_origen = 8; // VISITA
    $.ajax({
      "url": "/admin/consultas/function/enviar/",
      "type": "post",
      "dataType": "json",
      "data": datos,
      "success": function(r) {
        if (r.error == 0) {
          var url = "https://wa.me/"+"<?php echo $empresa->whatsapp  ?>";
          url+= "?text="+encodeURIComponent(datos.mensaje);
          var open = window.open(url,"_blank");
          if (open == null || typeof(open)=='undefined') {
            // Si se bloqueo el popup, se redirecciona
            location.href = url;
          }
        } else {
          alert("Ocurrio un error al enviar su email. Disculpe las molestias");
          $("#"+id_form).find(".contacto_submit").removeAttr('disabled');
        }
        window.enviando = 0;
      },
      "error":function() {
        $("#"+id_form).find(".contacto_submit").removeAttr('disabled');
        window.enviando = 0;
      }
    });
  } catch(e) {
    $("#"+id_form).find(".contacto_submit").removeAttr('disabled');
    console.log(e);
  }
  return false;
}

function enviar_whatsapp(id_form) {
  try {
    var datos = validar(id_form);
    datos.id_origen = 27;
    $.ajax({
      "url": "/admin/consultas/function/enviar/",
      "type": "post",
      "dataType": "json",
      "data": datos,
      "success": function(r) {
        if (r.error == 0) {
          var url = "https://wa.me/"+"<?php echo (isset($celular_whatsapp) ? $celular_whatsapp : $empresa->whatsapp) ?>";
          url+= "?text="+encodeURIComponent(datos.mensaje);
          var open = window.open(url,"_blank");
          if (open == null || typeof(open)=='undefined') {
            // Si se bloqueo el popup, se redirecciona
            location.href = url;
          }
        } else {
          alert("Ocurrio un error al enviar su email. Disculpe las molestias");
          $("#"+id_form).find(".contacto_submit").removeAttr('disabled');
        }
        window.enviando = 0;
      },
      "error":function() {
        $("#"+id_form).find(".contacto_submit").removeAttr('disabled');
        window.enviando = 0;
      }
    });
  } catch(e) {
    $("#"+id_form).find(".contacto_submit").removeAttr('disabled');
    console.log(e);
  }
  return false;
}

function enviar_email(id_form) {
  try {
    var datos = validar(id_form);
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
          $("#"+id_form).find(".contacto_submit").removeAttr('disabled');
        }
        window.enviando = 0;
      },
      "error":function() {
        $("#"+id_form).find(".contacto_submit").removeAttr('disabled');
        window.enviando = 0;
      }
    });
  } catch(e) {
    $("#"+id_form).find(".contacto_submit").removeAttr('disabled');
    console.log(e);
  }
  return false;
}

function enviar_telefono(id_form) {
  try {
    var datos = validar(id_form);
    datos.id_origen = 1;
    $.ajax({
      "url": "/admin/consultas/function/enviar/",
      "type": "post",
      "dataType": "json",
      "data": datos,
      "success": function(r) {
        if (r.error == 0) {
          // Abrimos para hablar por telefono
          alert("Su consulta ha sido enviada correctamente. Nos pondremos en contacto a la mayor brevedad!");
          location.reload();
        } else {
          alert("Ocurrio un error al enviar su email. Disculpe las molestias");
          $("#"+id_form).find(".contacto_submit").removeAttr('disabled');
        }
        window.enviando = 0;
      },
      "error":function() {
        $("#"+id_form).find(".contacto_submit").removeAttr('disabled');
        window.enviando = 0;
      }
    });
  } catch(e) {
    $("#"+id_form).find(".contacto_submit").removeAttr('disabled');
    console.log(e);
  }
  return false;
}


function buscar_mapa() {
  $("#form_buscador").find(".base_url").val("<?php echo mklink("mapa/") ?>");
  $("#form_buscador").submit();
}

function buscar_listado(form) {
  $(form).parents("form").first().find(".base_url").val("<?php echo mklink("propiedades/") ?>");
  $(form).parents("form").first().submit();
}

function cambiar_checkboxes(e) {
  var form = $(e).parents("form");
  $(form).submit();
}

function order_solo() {
  var orden = $("#form_buscador select[name=orden]").val();
  var base = "<?php echo current_url(FALSE, TRUE) ?>";
  base += (base.substr(-1) == "/") ? "" : "/";
  base += "?orden=" + orden;
  if ($("#styled-checkbox-1").is(":checked")) base += "&banco=1";
  if ($("#styled-checkbox-2").is(":checked")) base += "&per=1";
  location.href = base;
}

function enviar_filtrar() {
  //$("#form_buscador").submit();
}

function filtrar() {
  var form = $("#form_buscador");
  var url = $(form).find(".base_url").val();
  var tipo_operacion = $(form).find(".filter_tipo_operacion").val();
  url += tipo_operacion + "/";
  var localidad = $(form).find(".filter_localidad").val();
  if (!isEmpty(localidad)) {
    url += localidad + "/";
  }
  var minimo = $("#filter_rango_precios option:selected").data("min");
  var maximo = $("#filter_rango_precios option:selected").data("max");
  $("#filter_minimo").val(minimo);
  $("#filter_maximo").val(maximo);
  $(form).attr("action", url);
  return false;
}

function filtrar_principal(form) {
  var operacion = $(form).find(".operacion").val();
  var localidad = $(form).find(".localidad").val();
  var action = $(form).attr("action");
  if (!isEmpty(operacion)) action += operacion + "/";
  if (!isEmpty(localidad)) action += localidad + "";
  $(form).attr("action",action);
  return true;
}

function copiar_select(id) {
  $("#"+id).val($("#"+id+"_2").val())
}

</script>

<?php include("templates/comun/clienapp.php") ?>