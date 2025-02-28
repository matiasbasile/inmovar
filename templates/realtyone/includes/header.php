<!-- Header -->
<header class="header">
  <div class="logo">
    <a href="<?php echo mklink("/") ?>">
      <img src="assets/images/logo.png" alt="logo">
    </a>
  </div>
  <div class="right-nav">
    <nav class="navbar navbar-expand-lg">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item <?php echo (isset($menu_active) && $menu_active == "propiedades") ? "active":"" ?>">
            <a class="nav-link" href="<?php echo mklink("propiedades/") ?>">PROPIEDADES</a>
          </li>
          <li class="nav-item <?php echo (isset($menu_active) && $menu_active == "emprendimientos") ? "active":"" ?>">
            <a class="nav-link" href="<?php echo mklink("emprendimientos/") ?>">EMPRENDIMIENTOS</a>
          </li>
          <!--
          <li class="nav-item <?php echo (isset($menu_active) && $menu_active == "inversiones") ? "active":"" ?>">
            <a class="nav-link" href="<?php echo mklink("inversiones/") ?>">inversiones</a>
          </li>
          -->
          <li class="nav-item <?php echo (isset($menu_active) && $menu_active == "el-club") ? "active":"" ?>">
            <a class="nav-link" href="<?php echo mklink("entrada/el-club/") ?>">EL CLUB</a>
          </li>
          <li class="nav-item <?php echo (isset($menu_active) && $menu_active == "nosotros") ? "active":"" ?>">
            <a class="nav-link" href="<?php echo mklink("entrada/nosotros/") ?>">NOSOTROS</a>
          </li>
          <li class="nav-item <?php echo (isset($menu_active) && $menu_active == "franquicias") ? "active":"" ?>">
            <a class="nav-link" href="<?php echo mklink("entrada/franquicias/") ?>">FRANQUICIAS</a>
          </li>

          <li class="nav-item <?php echo (isset($menu_active) && $menu_active == "miembros") ? "active":"" ?>">
            <a class="nav-link" href="<?php echo mklink("web/miembros/") ?>">miembros</a>
          </li>
          <li class="nav-item">
            <a target="_blank" class="btn" href="https://comunidadinmobiliaria.com.ar/admin/" style="min-width: auto;">CRM</a>
          </li>
          <li class="nav-item">
            <a target="_blank" class="btn" href="https://comunidadlaplata.com.ar/login">Acceso Socios</a>
          </li>
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
        </ul>
      </div>
    </nav>

  </div>
</header>