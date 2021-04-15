<?php 
$cant_favoritos = 0;
if (isset($_SESSION["favoritos"])) {
  $arr = explode(",",$_SESSION["favoritos"]);
  $cant_favoritos = sizeof($arr)-1;
}
?>
<header>
  <?php if (!empty($empresa->logo_1)) {  ?>
    <a href="<?php echo mklink ("/") ?>" class="logo">
      <img src="/admin/<?php echo $empresa->logo_1 ?>" alt="Logo">
    </a>
  <?php } ?>
  <nav class="navbar navbar-expand-xl">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item <?php echo ($page_act=="ventas")?"active":"" ?>">
          <a class="nav-link" href="<?php echo mklink ("propiedades/ventas/") ?>">VENTAS</a>
        </li>
        <li class="nav-item <?php echo ($page_act=="alquileres")?"active":"" ?>">
          <a class="nav-link" href="<?php echo mklink ("propiedades/alquileres/") ?>">ALQUILERES</a>
        </li>
        <li class="nav-item <?php echo ($page_act=="emprendimientos")?"active":"" ?>">
          <a class="nav-link" href="<?php echo mklink ("propiedades/emprendimientos/") ?>">EMPRENDIMIENTOS</a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" href="<?php echo mklink ("propiedades/ventas/") ?>">informacion</a>
        </li> -->
        <?php if (!empty($empresa->telefono)) {  ?>
          <li class="nav-item call-us">
            <a class="nav-link" href="tel:<?php echo $empresa->telefono ?>">
              <img src="assets/images/call-us.png" alt="Call">
              <span class="right-block">
                <big>Teléfono:</big>
                <small><?php echo $empresa->telefono ?></small>
              </span>
            </a>
          </li>
        <?php } ?>
        <li class="nav-item">
          <a class="nav-link btn btn-red" href="<?php echo mklink ("contacto/") ?>">Contacto <img src="assets/images/right-arrow.png" alt="Arrow"></a>
        </li>
      </ul>
    </div>
  </nav>
</header>