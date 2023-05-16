<!-- Header -->
<header class="header">
  <div class="logo">
    <img src="assets/images/header-logo.svg" alt="logo">
  </div>
  <div class="right-nav">
    <nav class="navbar navbar-expand-lg">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo mklink("/") ?>">INICIO</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo mklink("propiedades/") ?>">PROPIEDADES</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">EMPRENDIMIENTOS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">inversiones</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">LA COMU</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">miembros</a>
          </li>
          <li class="nav-item">
            <a class="btn" href="#">Vender</a>
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