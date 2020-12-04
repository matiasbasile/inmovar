<?php
$cant_favoritos = 0;
if (isset($_SESSION["favoritos"])) {
  $arr = explode(",",$_SESSION["favoritos"]);
  $cant_favoritos = sizeof($arr)-1;
}
?>
<section class="top-wrapper">
  <div class="container">
    <header>
      <a href="javascript:void(0);" onClick="$('nav').slideToggle();" class="toggle-button"><span></span> <span></span> <span></span></a>
      <nav style="float: none; text-align: center;">
        <ul style="float: none;">
          <li><a href="<?php echo mklink ("/") ?>" class="home-menu"><img src="images/home-icon.png" alt="Home" /></a></li>
          <li><a class="<?php echo ($nombre_pagina == "ventas")?"active":"" ?>" href="<?php echo mklink ("propiedades/ventas/")?>">Venta</a>
            <!--<ul>
              <li><a href="#">Edificio XXI</a></li>
              <li><a href="#">Edificio XXII</a></li>
              <li><a href="#">Edificio XXIII</a></li>
              <li><a href="#">Edificio XXIV</a></li>
            </ul>-->
          </li>
          <li><a class="<?php echo ($nombre_pagina == "alquileres")?"active":"" ?>" href="<?php echo mklink ("propiedades/alquileres/")?>">Alquiler</a></li>
          <li><a class="<?php echo ($nombre_pagina == "permutas")?"active":"" ?>" href="<?php echo mklink ("propiedades/ventas/?per=1")?>">Permutas</a></li>
          <li><a class="<?php echo ($nombre_pagina == "emprendimientos")?"active":"" ?>" href="<?php echo mklink ("propiedades/emprendimientos/")?>">Emprendimientos</a></li>
          <li><a class="<?php echo ($nombre_pagina == "obras")?"active":"" ?>" href="<?php echo mklink ("propiedades/obras/")?>">Obras</a></li>
          <li><a class="<?php echo ($nombre_pagina == "Nosotros")?"active":"" ?>" href="<?php echo mklink ("web/nosotros/")?>">Nosotros</a></li>
          <div style="display: inline-flex;">
          	<ul class="listado-social">
          		<li class="redes">
          			<a href="<?PHP echo mklink ("favoritos/") ?>"><i class="fa fa-heart"></i></a>
          		</li>
              <?php if (!empty($empresa->facebook)) { ?>
            		<li class="redes fb">
            			<a target="_blank" href="<?php echo $empresa->facebook ?>"><i class="fa fa-facebook-f"></i></a>
            		</li>
              <?php } ?>
              <?php if (!empty($empresa->instagram)) { ?>
            		<li class="redes">
            			<a target="_blank" href="<?php echo $empresa->instagram ?>"><i class="fa fa-instagram"></i></a>
            		</li>
              <?php } ?>
              <?php if (!empty($empresa->youtube)) { ?>
                <li class="redes">
                  <a target="_blank" href="<?php echo $empresa->youtube ?>"><i class="fa fa-youtube"></i></a>
                </li>
              <?php } ?>
          	</ul>
          </div>
        </ul>
      </nav>
      
    </header>
    <?php if ($nombre_pagina == "home") include("searchbar.php"); ?>
  </div>
  
</section>
<section style="background: #f5f5f5; width: 100%; float: left;">
  <div class="container">
    <?php if ($nombre_pagina != "home" && $nombre_pagina != "mapa") { ?>
      <div class="page-title">
        <div class="breadcrumb pt0">
          <div class="brand pr20"><img src="images/bertoiablack.png" alt="Grupo Urbano" width="286"  /></div>
          <div class="brand"><img src="images/grupoblack.png" alt="Grupo Urbano" width="286"  /></div>  
        </div>
          <big class="pt5"><?php echo (!empty($nombre_pagina))?$nombre_pagina:"Propiedades"; ?></big>
      </div>
    <?php } ?>
  </div>
</section>