<header class="header-two">
    <div class="container">
        <a href="<?php echo mklink("/") ?>" class="logo"><img src="assets/images/logo.png" alt="Logo"></a>
        <a href="javascript:void(0);" class="toggle-menu">
            <span></span>
        </a>
        <div class="header-right">
            <ul class="header-menu">
                <li><a href="<?php echo mklink("propiededes/ventas/") ?>">Comprar</a></li>
                <li><a href="<?php echo mklink("propiededes/alquileres/") ?>">Alquilar</a></li>
                <li><a href="<?php echo mklink("entradas/vender/") ?>">Vender</a></li>
                <li><a href="<?php echo mklink("entradas/nosotros/") ?>">Nosotros</a></li>
                <li><a href="<?php echo mklink("contacto/") ?>">Contacto</a></li>
            </ul>
            <div class="socials">
                <a href="https://wa.me/<?php echo $empresa->telefono_num; ?>"
                    class="btn btn-left-icon"><?php echo $empresa->telefono_num; ?></a>
                <ul>
                    <?php if (!empty($empresa->instagram)) { ?>
                        <li><a target="_blank" href="<?php echo $empresa->instagram ?>/"><img
                                src="assets/images/insta.png" alt="Instagram"></a></li>
                    <?php } ?>
                    <?php if (!empty($empresa->facebook)) { ?>
                        <li><a target="_blank" href="<?php echo $empresa->facebook ?>/"><img
                                src="assets/images/facebook.png" alt="Facebook"></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</header>