<header class="header-two">
    <div class="container">
        <a href="/" class="logo"><img src="assets/images/logo.png" alt="Logo"></a>
        <a href="javascript:void(0);" class="toggle-menu">
            <span></span>
        </a>
        <div class="header-right">
            <ul class="header-menu">
                <li><a href="/propiedades/ventas">Comprar</a></li>
                <li><a href="/propiedades/alquileres">Alquilar</a></li>
                <li><a href="/web/ventas">Vender</a></li>
                <li><a href="/web/nosotros">Nosotros</a></li>
                <li><a href="/web/contacto">Contacto</a></li>
            </ul>
            <div class="socials">
                <a href="https://wa.me/<?php echo $empresa->telefono; ?>"
                    class="btn btn-left-icon"><?php echo $empresa->telefono; ?></a>
                <ul>
                    <li><a href="https://instagram.com/<?php echo $empresa->instagram; ?>/"><img
                                src="assets/images/insta.png" alt="Instagram"></a></li>
                    <li><a href="https://www.linkedin.com/in/<?php echo $empresa->linkedin; ?>/"><img
                                src="assets/images/facebook.png" alt="Facebook"></a></li>
                </ul>
            </div>
        </div>
    </div>
</header>