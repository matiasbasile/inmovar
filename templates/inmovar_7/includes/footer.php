<footer id="ts-footer">
    <section id="ts-footer-main">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <a class="brand" href="<?php echo mklink("/")?>">
                        <img src="<?php echo "/sistema/".$empresa->logo_1;?>" class="logo" alt="">
                    </a>
                    <?php $t = $web_model->get_text("inmovar_7_p_footer_adsada","Find a Nice Place To Live");?>
                    <p class="mb-4 editable" data-clave="<?php echo $t->clave ?>" data-id="<?php echo $t->id ?>" >
                        <?php echo $t->plain_text?>
                    </p>
                    <a href="<?php echo mklink("web/contacto"); ?>" class="btn btn-outline-dark mb-4">Contactanos</a>
                </div>
                <div class="col-md-2">
                    <h4>Navegacion</h4>
                    <nav class="nav flex-row flex-md-column mb-4">
                        <a href="<?php echo mklink("/");?>" class="nav-link">Inicio</a>
                        <a href="<?php echo mklink("propiedades/ventas/");?>" class="nav-link">Ventas</a>
                        <a href="<?php echo mklink("propiedades/alquileres/");?>" class="nav-link">Alquileres</a>
                        <a href="<?php echo mklink("propiedades/emprendimientos/");?>" class="nav-link">Emprendimientos</a>
                    </nav>
                </div>
                <div class="col-md-4 footercontacto">
                    <h4>Contacto</h4>
                    <address class="ts-text-color-light">
                        <?php if (!empty($empresa->direccion)){
                            echo $empresa->direccion.", ".$empresa->ciudad.", Argentina";?>
                        <br>
                        <?php } ?>
                        <strong>Email: </strong>
                        <a href="mailto:<?php echo $empresa->email ?>"><?php echo $empresa->email?></a>
                        <br>
                        <?php if (!empty($empresa->telefono)){?>
                            <strong>Telefono:</strong>
                            <?php echo $empresa->telefono;?>
                            <br>
                        <?php } ?>
                    </address>
                    <?php if (!empty($empresa->facebook)){ ?>
                        <a href="<?php echo $empresa->facebook?>" class="nav-link">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    <?php } ?>
                    <?php if (!empty($empresa->twitter)){ ?>
                        <a href="<?php echo $empresa->twitter?>" class="nav-link">
                            <i class="fab fa-twitter"></i>
                        </a>
                    <?php } ?>
                    <?php if (!empty($empresa->instagram)){ ?>
                        <a href="<?php echo $empresa->instagram?>" class="nav-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                    <?php } ?>
                    <?php if (!empty($empresa->youtube)){ ?>
                        <a href="<?php echo $empresa->youtube?>" class="nav-link">
                            <i class="fab fa-youtube"></i>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <section id="ts-footer-secondary">
        <div class="container">
            <div class="ts-copyright">(C) 2020 Varcreative, All rights reserved</div>
        </div>
    </section>
</footer>
<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/leaflet.js"></script>
<script src="assets/js/custom.js"></script>
<script src="assets/js/map-leaflet.js"></script>
