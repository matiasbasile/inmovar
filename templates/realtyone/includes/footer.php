<!-- Footer -->
<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-6">
        <div class="logo">
          <img src="assets/images/logo-footer.png" alt="logo">
        </div>
        <p class="text-white mt20">Acompañanos mientras seguimos pintando de dorado el país, revolucionando la industria inmobiliaria.</p>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="footer-info">
          <h6>Legales</h6>
          <ul>
            <li><a href="<?php echo mklink("propiedades/ventas/la-plata/?tp=2") ?>">Departamento en Venta La Plata</a></li>
            <li><a href="<?php echo mklink("propiedades/ventas/la-plata/?tp=1") ?>">Casa en Venta La Plata</a></li>
            <li><a href="<?php echo mklink("propiedades/ventas/la-plata/?tp=3") ?>">PH en Venta La Plata</a></li>
          </ul>
          <div class="link-text">
            <a href="<?php echo mklink("propiedades/ventas") ?>">Ver Más</a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="footer-info">
          <h6>Contactanos</h6>
          <div class="address-info mt0">
            <ul>
              <?php if (!empty($empresa->direccion)) { ?>
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                  </svg>
                  <a href="javascript:void(0);"><?php echo $empresa->direccion ?></a>
                </li>
              <?php } ?>
              <?php if (!empty($empresa->email)) { ?>
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                    <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
                  </svg>
                  <a href="mailto:<?php echo $empresa->email ?>"><?php echo $empresa->email ?></a>
                </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-6">
        <div class="socials">
          <ul>
            <?php if (!empty($empresa->facebook)) { ?>
              <li><a href="<?php echo $empresa->facebook ?>" target="_blank"><img src="assets/images/facebook-icon.svg" alt="icon"></a></li>
            <?php } ?>
            <?php if (!empty($empresa->instagram)) { ?>
              <li><a href="<?php echo $empresa->instagram ?>" target="_blank"><img src="assets/images/instagram-icon.svg" alt="icon"></a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>

<section class="copyright">
  <div class="container">
    <p><span>Realty One Group.</span> Todos los derechos reservados</p>
    <p>Diseño y Desarrollo Web <a href="https://www.misticastudio.com/" target="_blank"><img src="assets/images/copyright-logo.svg" alt="logo"></a></p>
  </div>
</section>

<!-- Back to top button -->
<a id="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z" />
  </svg></a>

<!-- Scripts -->
<script src="assets/js/jquery-min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/fancybox.umd.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false&amp;libraries=geometry&amp;v=3.13"></script>
<script src="assets/js/maplace-0.1.3.min.js"></script>
<script src="assets/js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>

<script>
// ======================================
// FUNCIONES DE FILTROS
// ======================================

function buscar_mapa() {
  $("#ver_mapa").val("0");
  $("#form_buscador").submit();
}

function buscar_listado() {
  $("#ver_mapa").val("1");
  $("#form_buscador").submit();
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

function filtro_antiguedad() {
  var antiguedad_construccion = $("#antiguedad_construccion").is(":checked") ? 1 : 0;
  var antiguedad_estrenar = $("#antiguedad_estrenar").is(":checked") ? 1 : 0;
  var antiguedad_5 = $("#antiguedad_5").is(":checked") ? 1 : 0;
  var antiguedad_5_10   = $("#antiguedad_5_10").is(":checked") ? 1 : 0;
  var antiguedad_10_20 = $("#antiguedad_10_20").is(":checked") ? 1 : 0;
  var antiguedad_20_50 = $("#antiguedad_20_50").is(":checked") ? 1 : 0;
  var antiguedad_50 = $("#antiguedad_50").is(":checked") ? 1 : 0;
  var antiguedades = new Array();
  if (antiguedad_construccion == 1) {
    antiguedades.push(-1);
  }
  if (antiguedad_estrenar == 1) {
    antiguedades.push(1);
  }
  if (antiguedad_5 == 1) {
    antiguedades.push(2);
    antiguedades.push(5);
  }
  if (antiguedad_5_10 == 1) {
    antiguedades.push(10);
  }
  if (antiguedad_10_20 == 1) {
    antiguedades.push(20);
  }
  if (antiguedad_20_50 == 1) {
    antiguedades.push(30);
    antiguedades.push(40);
    antiguedades.push(50);
  }
  if (antiguedad_50 == 1) {
    antiguedades.push(60);
    antiguedades.push(70);
    antiguedades.push(80);
    antiguedades.push(90);
    antiguedades.push(100);
    antiguedades.push(200);
  }
  var ant_s = antiguedades.join("-");
  console.log("ANTIGUEDAD: "+ant_s);
  $("#in_antiguedad").val(ant_s);
}

function filtrar(form) {
  var url = "<?php echo mklink("propiedades/") ?>";
  <?php if (isset($vc_link_tipo_operacion) && $vc_link_tipo_operacion == "emprendimientos") { ?>
    url = "<?php echo mklink("/") ?>";
  <?php } ?>

  filtro_antiguedad();
  
  var tipo_operacion = $(form).find(".filter_tipo_operacion").val();
  if (!isEmpty(tipo_operacion)) {
    url += tipo_operacion + "/";
  } else {
    alert("Seleccione un tipo de operación.");
    return false;
  }
  var linkLocalidad = $(form).find("#localidad_link_hidden").val()
  if (!isEmpty(linkLocalidad)) {
    url += linkLocalidad + "/";
  }
  $(form).attr("action", url);
}

function filtrar_ajax() {
  filtro_antiguedad();
  var data = $("#form_buscador").serialize();
  data += "&vc_ids_tipo_operacion="+$(".filter_tipo_operacion option:selected").data("id");
  $.ajax({
    "url":"<?php echo mklink("web/ajax/") ?>",
    "type":"get",
    "dataType":"html",
    "data":data,
    "success":function(r){
      $(".results").empty();
      $(".results").html(r);
      initOwl();
    }
  });
}

function pagination(pagina) {
  $("#page").val(pagina);
  filtrar_ajax();
}

function set_order() {
  var orden = $("#orden").val();
  $("#filter_order").val(orden);
  filtrar_ajax();
}

function enviar_filtrar() {
  $("#form_buscador").submit();
}


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
    "id_usuario": "<?php echo (isset($propiedad) ? $propiedad->id_usuario : 0) ?>",
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

// ======================================
// INICIALIZACION
// ======================================


$(document).ready(function(){
  
  // Autocomplete de localidades
  if ($(".localidad-select").length > 0) {
    var termTemplate = "<span class='ui-autocomplete-term'>%s</span>";
    $(".localidad-select").autocomplete({
      source: "/admin/locations/function/search_for_select/",
      minLength: 2,
      select: function( event, ui ) {
        $("#localidad_id_hidden").val(ui.item.id);
        $("#localidad_link_hidden").val(ui.item.link);
        // Submit form
      },
    })
    /*
    .autocomplete("instance")._renderItem = function (ul, item) {
      var newText = String(item.value).replace(new RegExp(this.term, "gi"),"<span class='ui-autocomplete-term'>$&</span>");
      return $("<li></li>")
        .data("item.autocomplete", item)
        .append("<div>" + newText + "</div>")
        .appendTo(ul);
    };
    */
  }
  
  // Carruseles
  initOwl();
})

function initOwl() {
 //Owl Carouel Slider Script
 $('.owl-carousel').each(function() {
  var $carousel = $(this);
  var $items = ($carousel.data('items') !== undefined) ? $carousel.data('items') : 1;
  var $items_tablet = ($carousel.data('items-tablet') !== undefined) ? $carousel.data('items-tablet') : 1;
  var $items_mobile_landscape = ($carousel.data('items-mobile-landscape') !== undefined) ? $carousel.data('items-mobile-landscape') : 1;
  var $items_mobile_portrait = ($carousel.data('items-mobile-portrait') !== undefined) ? $carousel.data('items-mobile-portrait') : 1;
  $carousel.owlCarousel ({
    loop : ($carousel.data('loop') !== undefined) ? $carousel.data('loop') : true,
    items : $carousel.data('items'),
    margin : ($carousel.data('margin') !== undefined) ? $carousel.data('margin') : 0,
    dots : ($carousel.data('dots') !== undefined) ? $carousel.data('dots') : true,
    nav : ($carousel.data('nav') !== undefined) ? $carousel.data('nav') : true,
    navText : [""],
    autoplay : ($carousel.data('autoplay') !== undefined) ? $carousel.data('autoplay') : true,
    autoplayTimeout : ($carousel.data('autoplay-timeout') !== undefined) ? $carousel.data('autoplay-timeout') : 3000,
    animateIn : ($carousel.data('animatein') !== undefined) ? $carousel.data('animatein') : false,
    animateOut : ($carousel.data('animateout') !== undefined) ? $carousel.data('animateout') : false,
    mouseDrag : ($carousel.data('mouse-drag') !== undefined) ? $carousel.data('mouse-drag') : true,
    autoWidth : ($carousel.data('auto-width') !== undefined) ? $carousel.data('auto-width') : false,
    autoHeight : ($carousel.data('auto-height') !== undefined) ? $carousel.data('auto-height') : false,
    center : ($carousel.data('center') !== undefined) ? $carousel.data('center') : false,
    responsiveClass: true,
    dotsEachNumber: true,
    smartSpeed: 600,
    autoplayHoverPause: true,
    animateOut: 'fadeOut',
    animateIn: 'fadeIn',
    responsive : {
      0 : {
        items : $items_mobile_portrait,
      },
      768 : {
        items : $items_mobile_landscape,
      },
      992 : {
        items : $items_tablet,
      },
      1200 : {
        items : $items,
      }
    }
  });
  var totLength = $('.owl-dot', $carousel).length;
  $('.total-no', $carousel).html(totLength);
  $('.current-no', $carousel).html(totLength);
  $carousel.owlCarousel();
  $('.current-no', $carousel).html(1);
  $carousel.on('changed.owl.carousel', function(event) {
    var total_items = event.page.count;
    var currentNum = event.page.index +1;
    $('.total-no', $carousel ).html(total_items);
    $('.current-no', $carousel).html(currentNum);
  });
  });  
}
</script>