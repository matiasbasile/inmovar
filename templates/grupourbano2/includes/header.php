<header>  
  <div class="container style-two">
    <nav class="navbar navbar-expand-lg">
      <a class="navbar-brand" href="<?php echo mklink("/"); ?> "><img src="assets/images/logo.png" alt="Lasa Papelera"></a>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item  <?php ($_GET["id_tipo_operacion"] == 1 ? "active" : "") ?>">
            <a class="nav-link" href="<?php echo mklink("web/propiedades_listado/?id_tipo_operacion=1") ?>">Ventas</a>
            <!-- <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#0">Request an Offer</a>
              <a class="dropdown-item" href="#0">Sell and Stay</a>
              <a class="dropdown-item" href="#0">How it Works</a>
            </div> -->
          </li>
          <li class="nav-item <?php ($_GET["id_tipo_operacion"] == 2 ? "active" : "") ?>">
            <a class="nav-link" href="<?php echo mklink("web/propiedades_listado/?id_tipo_operacion=2") ?>">alquileres</a>
          </li>
          <li class="nav-item <?php ($_GET["id_tipo_operacion"] == 4 ? "active" : "") ?>">
            <a class="nav-link" href="<?php echo mklink("web/propiedades_listado/?id_tipo_operacion=4") ?>">emprendimientos</a>
          </li>
          <li class="nav-item <?php ($_GET["id_tipo_operacion"] == 5 ? "active" : "") ?>">
            <a class="nav-link" href="<?php echo mklink("web/propiedades_listado/?id_tipo_operacion=5") ?>">obras</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo mklink("web/vendedores") ?>">nosotros</a>
          </li>
        </ul>
        <a href="#0" class="btn">contacto</a>
        <div class="social">
          <a href="#0"><i class="fa fa-facebook" aria-hidden="true"></i></a>
          <a href="#0"><i class="fa fa-instagram" aria-hidden="true"></i></a>
          <a href="#0"><i class="fa fa-play" aria-hidden="true"></i></a>
        </div>     
      </div>
    </nav> 
  </div>
</header>