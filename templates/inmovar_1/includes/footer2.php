<style>
    .footer_newtitle {
        text-align: center !important;
        color: rgb(26, 49, 70) !important;
        font-family: 'Roboto' !important;
        font-weight: 600 !important;
        margin-bottom: 0px !important;
    }

    h3 {
        margin-bottom: 0px !important;
    }

    .footer_newtitlebold {
        opacity: 1 !important;
        font-weight: 700;
        font-family: 'Roboto';
        text-align: center;
    }

    @media(max-width: 768px) {
        .footer_newtitle {
            margin-top: 50px !important;
        }
    }
</style>

<footer id="page-footer">
    <div class="inner">
        <?php if ($empresa->comp_footer_grande == 1) { ?>
            <aside id="footer-main">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <?php if (!empty($empresa->logo_1)) { ?>
                                <img src="/admin/<?php echo $empresa->logo_1 ?>" alt="<?php echo ($empresa->nombre) ?>" style="width: 100%;">
                            <?php } ?>
                        </div>
                        <div class="col-md-4">
                            <article>
                                <h3 class="footer_newtitle">Oficina comercial</h3>
                                <p class="footer_newtitlebold">Bourdin Bienes Raíces</p>
                                <?php if (!empty($empresa_direccion)) { ?>
                                    <p class="text-center"><?php echo $empresa_direccion ?></p>
                                <?php  } ?>
                            </article>
                        </div>
                        <div class="col-md-4">
                            <article>
                                <h3 class="footer_newtitle">Contacto</h3>
                                <?php if (!empty($empresa->telefono)) { ?>
                                    <?php echo $empresa->telefono ?><br>
                                <?php } ?>
                                <?php if (!empty($empresa->email)) { ?>
                                    <a class="text-center" href="mailto:<?php echo $empresa->email ?>">
                                        <?php echo $empresa->email ?>
                                    </a>
                                <?php } ?>
                            </article>
                        </div><!-- /.col-sm-3 -->
                    </div><!-- /.row -->
                </div><!-- /.container -->
            </aside><!-- /#footer-main -->
        <?php } ?>
        <aside id="footer-thumbnails" class="footer-thumbnails"></aside><!-- /#footer-thumbnails -->
        <aside id="footer-copyright">
            <div class="container">
                <span class="copyright">Copyright © <?php echo date("Y") ?>. Todos los derechos reservados.</span>
                <span class="pull-right">
                    <a class="inmovar-logo" href="https://www.inmovar.com" target="_blank">
                        <img class="inmovar-logo-img" src="assets/img/inmovar-despega.png">
                        <span class="inmovar-frase">¡Hacé despegar tu inmobiliaria!</span>
                    </a>
                </span>
            </div>
        </aside>
    </div><!-- /.inner -->
</footer>

<script type="text/javascript" src="/admin/resources/js/jquery.min.js"></script>
<script type="text/javascript" src="/admin/resources/js/libs/bootstrap.min.js"></script>
<!--<script type="text/javascript" src="assets/js/smoothscroll.js"></script>-->
<script type="text/javascript" src="/admin/resources/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.placeholder.js"></script>
<script type="text/javascript" src="assets/js/icheck.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.vanillabox-0.1.5.min.js"></script>
<script type="text/javascript" src="assets/js/retina-1.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/jshashtable-2.1_src.js"></script>
<script type="text/javascript" src="assets/js/jquery.numberformatter-1.2.3.js"></script>
<script type="text/javascript" src="assets/js/tmpl.js"></script>
<script type="text/javascript" src="assets/js/jquery.dependClass-0.1.js"></script>
<script type="text/javascript" src="assets/js/draggable-0.1.js"></script>
<script type="text/javascript" src="assets/js/jquery.slider.js"></script>
<script type="text/javascript" src="assets/js/jquery.numberformatter-1.2.3.js"></script>
<!--[if gt IE 8]>
<script type="text/javascript" src="assets/js/ie.js"></script>
<![endif]-->
<script type="text/javascript" src="/admin/resources/js/common.js"></script>
<script type="text/javascript" src="/admin/resources/js/main.js"></script>

<?php include("templates/comun/clienapp.php") ?>