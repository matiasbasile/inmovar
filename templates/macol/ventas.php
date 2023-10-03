<?php include_once 'includes/init.php'; ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <?php $pageTitle = 'Inicio';
include 'includes/head.php'; ?>
</head>

<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <section class="communicate-us" style="padding-top:40px;">
        <div class="row gy-5 gx-0 align-items-center">
            <div class="form-wrap form-wrap-two">
                <div class="section-title">
                    <?php $contact = $web_model->get_text('contact', 'Comunicate con nosotros'); ?>
                    <h2 class="editable" data-id="<?php echo $contact->id; ?>"
                        data-clave="<?php echo $contact->clave; ?>">
                        <?php echo $contact->plain_text; ?>
                    </h2>
                </div>
                <form id="contactForm">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input id="contacto_nombre" class="form-control" type="text"
                                    placeholder="Nombre completo">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input id="contacto_telefono" class="form-control" type="text"
                                    placeholder="Whatsapp (sin 0 ni 15)">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input id="contacto_email" class="form-control" type="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">

                                <select id="contacto_asunto" class="form-control">
                                    <option value="">Elija asunto</option>
                                    <?php $asuntos = explode(';;;', $empresa->asuntos_contacto); ?>
                                    <?php foreach ($asuntos as $a) { ?>
                                    <option><?php echo $a; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <textarea id="contacto_mensaje" placeholder="Escriba sus comentarios"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <button id="contacto_submit" class="btn">enviar consulta</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="assets/js/owl.carousel.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWmUapFYTBXV3IJL9ggjT9Z1wppCER55g&callback=initMap">
    </script>
    <script src="assets/js/script.js"></script>
</body>

</html>