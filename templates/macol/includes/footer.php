<footer>
    <div class="container">
        <a href="/" class="footer-logo">
            <img src="assets/images/footer-logo.png" alt="Logo">
        </a>
        <div class="row gy-4">
            <div class="col-lg-3">
                <?php $footer_access = $web_model->get_text('footer_access', 'Accesos rápidos'); ?>
                <h2 class="editable" data-id="<?php echo $footer_access->id; ?>"
                    data-clave="<?php echo $footer_access->clave; ?>">
                    <?php echo $footer_access->plain_text; ?>
                </h2>
                <ul class="footer-menu">
                    <li><a href="/propiedades/ventas">Comprar</a></li>
                    <li><a href="/propiedades/alquileres">Alquilar</a></li>
                    <li><a href="/web/ventas">Vender</a></li>
                    <li><a href="/web/contacto">Nosotros</a></li>
                </ul>
            </div>
            <div class="col-lg-8">
                <?php $footer_contact = $web_model->get_text('footer_contact', 'Vías de comunicación'); ?>
                <h2 class="editable" data-id="<?php echo $footer_contact->id; ?>"
                    data-clave="<?php echo $footer_contact->clave; ?>">
                    <?php echo $footer_contact->plain_text; ?>
                </h2>
                <div class="communication">
                    <ul>
                        <li><a href="javascript:void(0)" class="pe-none">
                                <?php echo $empresa->direccion; ?>
                            </a></li>
                        <li><a href="javascript:void(0)" class="pe-none">
                                <?php echo $empresa->codigo_postal; ?>
                            </a></li>
                    </ul>
                    <ul>
                        <li><a href="tel:<?php echo $empresa->telefono_num ?>"><?php echo $empresa->telefono ?></a></li>
                        <li><a href="mailto:<?php echo $empresa->email; ?>"><?php echo $empresa->email; ?></a></li>
                    </ul>
                    <div class="socials">
                        <ul>
                            <?php if (!empty($empresa->instagram)) { ?>
                                <li><a target="_blank" href="<?php echo $empresa->instagram; ?>"><img
                                        src="assets/images/insta.png" alt="Instagram"></a></li>
                            <?php } ?>
                            <?php if (!empty($empresa->facebook)) { ?>
                                <li><a target="_blank" href="<?php echo $empresa->facebook; ?>"><img
                                        src="assets/images/facebook.png" alt="Facebook"></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <?php $footer_rights = $web_model->get_text('footer_rights', '<span>Macol Inmobiliaria. </span> Todos los Derechos Reservados'); ?>
            <p class="editable" data-id="<?php echo $footer_rights->id; ?>"
                data-clave="<?php echo $footer_rights->clave; ?>">
                <?php echo $footer_rights->plain_text; ?>
            </p>
            <?php $footer_design = $web_model->get_text('footer_design', 'Diseño Web Inmobiliarias'); ?>
            <p class="editable" data-id="<?php echo $footer_design->id; ?>"
                data-clave="<?php echo $footer_design->clave; ?>">
                <?php echo $footer_design->plain_text; ?>
                <a href="#0"><img src="assets/images/copyright.png" alt="Copyright"></a>
            </p>
        </div>
    </div>
</footer>


<script>
function buscar_mapa() {
    $("#form_buscador").find(".base_url").val("<?php echo mklink('mapa/'); ?>");
    $("#form_buscador").submit();
}

function buscar_listado(form) {
    $(form).parents("form").first().find(".base_url").val("<?php echo mklink('propiedades/'); ?>");
    $(form).parents("form").first().submit();
}

function cambiar_checkboxes(e) {
    var form = $(e).parents("form");
    $(form).submit();
}

function order_solo() {
    var orden = $("#form_buscador select[name=orden]").val();
    var base = "<?php echo current_url(false, true); ?>";
    base += (base.substr(-1) == "/") ? "" : "/";
    base += "?orden=" + orden;
    if ($("#styled-checkbox-1").is(":checked")) base += "&banco=1";
    if ($("#styled-checkbox-2").is(":checked")) base += "&per=1";
    location.href = base;
}

function enviar_filtrar(isHome) {
    if (isHome) {
        const localidad = $(".filter_localidad").val();
        const operacion = $(".filter_tipo_operacion").val();
        const propiedad = $(".filter_propiedad").val();
        if (isEmpty(localidad)) {
            alert("Por favor ingrese una localidad");
            $(".filter_localidad").focus();
            return false;
        }
        if (isEmpty(operacion)) {
            alert("Por favor ingrese un tipo de operacion");
            $(".filter_tipo_operacion").focus();
            return false;
        }
        if (isEmpty(propiedad)) {
            alert("Por favor ingrese un tipo de propiedad");
            $(".filter_propiedad").focus();
            return false;
        }
        $("#submitButton").attr('disabled', 'disabled');
    }
    $("#form_buscador").submit();
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
    var sort = $("#country").val();
    if (sort) {
        $("<input>").attr({
            type: "hidden",
            name: "sort",
            value: sort
        }).appendTo(form);
    }
    $(form).attr("action", url);
    return true;
}

const resetear = () => {
    let path = window.location.pathname
    path = path.split("/");
    location.replace(`/propiedades/${path[2]}`)
}

function buscar_mapa() {
    $("#form_buscador").find(".base_url").val("<?php echo mklink('mapa/'); ?>");
    $("#form_buscador").submit();
}
</script>

<!-- <script>
  var maximo = 0;
  $(".noved_img").each(function(i, e) {
    if ($(e).height() > maximo) maximo = $(e).height();
  });
  maximo = Math.ceil(maximo);
  $(".noved_img").height(maximo);
</script> -->

<script>
let img = document.querySelectorAll(".noved_img");
for (let i = 0; i < img.length; i++) {
    if (img[i].height > 302) {
        img[i].style.objectFit = "cover";
        img[i].style.height = 301;
        img[i].style.width = "100%";
    }
}
</script>
<script>
const contactForm = document.querySelector('#contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log(e)
        const nombre = $("#contacto_nombre").val();
        const email = $("#contacto_email").val();
        const telefono = $("#contacto_telefono").val();
        const asunto = $("#contacto_asunto").val();
        const mensaje = $("#contacto_mensaje").val();

        // var tipo_propiedad = $("#contacto_tipo_propiedad option:selected").text();
        // var dormitorios = $("#contacto_dormitorios").val();
        // var banios = $("#contacto_banios").val();
        // var localidad = $("#contacto_localidad").val();

        if (isEmpty(nombre)) {
            alert("Por favor ingrese un nombre");
            $("#contacto_nombre").focus();
            return false;
        }
        if (isEmpty(telefono)) {
            alert("Por favor ingrese un telefono");
            $("#contacto_telefono").focus();
            return false;
        }
        if (!validateEmail(email)) {
            alert("Por favor ingrese un email valido");
            $("#contacto_email").focus();
            return false;
        }
        if (isEmpty(asunto)) {
            alert("Por favor seleccione un asunto");
            $("#contacto_asunto").focus();
            return false;
        }
        if (isEmpty(mensaje)) {
            alert("Por favor ingrese un mensaje");
            $("#contacto_mensaje").focus();
            return false;
        }
        $("#contacto_submit").attr('disabled', 'disabled');
        var datos = {
            "para": "<?php echo $empresa->email; ?>",
            "nombre": nombre,
            "email": email,
            "telefono": telefono,
            "asunto": asunto,
            "mensaje": mensaje,
            "id_empresa": "<?php echo $empresa->id; ?>",
            "id_origen": 1,
        }
        enviando = 1;
        $.ajax({
            "url": "/admin/consultas/function/enviar/",
            "type": "post",
            "dataType": "json",
            "data": datos,
            "success": function(r) {
                console.log(r)
                if (r.error == 0) {
                    alert(
                        "Muchas gracias por enviar tu consulta. Nos comunicaremos a la mayor brevedad posible."
                    );
                } else {
                    alert("Ocurrio un error al enviar su email. Disculpe las molestias");
                    $("#contacto_submit").removeAttr('disabled');
                }
            }
        });
        return false;
    })
}
</script>


<?php include 'templates/comun/clienapp.php'; ?>