<header class="<?php echo (isset($header_clase) ? $header_clase : "header") ?>">
    <div class="container">
        <a href="<?php echo mklink("/") ?>" class="logo">
            <?php if (isset($header_clase)) { ?>
                <img src="assets/images/logo.png" alt="Logo">
            <?php } else { ?>
                <img src="assets/images/logo-black.png" alt="Logo">
            <?php } ?>
        </a>
        <a href="javascript:void(0);" class="toggle-menu">
            <span></span>
        </a>
        <div class="header-right">
            <ul class="header-menu">
                <li><a href="<?php echo mklink("propiedades/ventas/") ?>">Comprar</a></li>
                <li><a href="<?php echo mklink("propiedades/alquileres/") ?>">Alquilar</a></li>
                <li><a href="<?php echo mklink("entradas/vender/") ?>">Vender</a></li>
                <li><a href="<?php echo mklink("entradas/nosotros/") ?>">Nosotros</a></li>
                <li><a href="<?php echo mklink("contacto/") ?>">Contacto</a></li>
            </ul>
            <div class="socials">
                <a href="https://wa.me/<?php echo $empresa->telefono_num; ?>"
                    class="btn btn-left-icon"><?php echo $empresa->telefono; ?></a>
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