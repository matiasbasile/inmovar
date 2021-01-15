<footer>
  <div class="container">
    <div class="footer-top">
      <?php if (!empty($empresa->logo)) {   ?>
        <a href="<?php echo mklink ("/") ?>" class="logo"><img src="/admin/<?php echo $empresa->logo?>" alt="Logo"></a>
      <?php } ?>
      <div class="socials">
        <ul>
          <?php if (!empty($empresa->facebook)) {  ?><li><a target="_blank" href="<?php echo $empresa->facebook ?>"><i class="fab fa-facebook-f"></i></a></li><?php } ?>
          <?php if (!empty($empresa->instagram)) {  ?><li><a target="_blank" href="<?php echo $empresa->instagram ?>"><i class="fab fa-instagram"></i></a></li><?php } ?>
          <?php if (!empty($empresa->twitter)) {  ?><li><a target="_blank" href="<?php echo $empresa->twitter ?>"><i class="fab fa-twitter"></i></a></li><?php } ?>
        </ul>
      </div>
    </div>
    <div class="footer-middle">
      <div class="row">
        <div class="col-xl-6 col-lg-8">
          <h6>accesos rápidos</h6>
          <ul>
            <li><a href="<?php echo mklink ("/") ?>">Inicio</a></li>
            <li><a href="<?php echo mklink ("propiedades/ventas/") ?>">Ventas</a></li>
            <li><a href="<?php echo mklink ("propiedades/alquileres/") ?>">Alquileres</a></li>
            <li><a href="<?php echo mklink ("propiedades/emprendimientos/") ?>">Emprendimientos</a></li>
            <li><a href="<?php echo mklink ("/") ?>">Contacto</a></li>           
          </ul>
        </div>
        <div class="col-xl-6 col-lg-4">
          <h6>vias de comunicacion</h6>
          <ul class="half-column">
            <?php if (!empty($empresa->direccion)) {  ?><li><a href="javascript:void(0)"><?php echo $empresa->direccion ?></a></li><?php } ?>
            <li><a href="mailto:<?php echo $empresa->email ?>"><?php echo $empresa->email ?></a></li>
            <li><a href="tel:<?php echo $empresa->telefono ?>"><?php echo $empresa->telefono ?></a></li> 
            <li><a href="javascript:void(0)">www.orlandobienesraices.com.ar</a></li>          
          </ul>
        </div>
      </div>
    </div>
    <div class="copyright">
      <div class="row">
        <div class="col-lg-6">
          <span><?php echo $empresa->nombre ?></span>
          <small>Todos los derechos reservados</small>
        </div>
        <div class="col-lg-6 text-right">
          <small>Diseño Web Inmobiliarias</small>
          <span><a href="www.misticastudio.com" target="_blank">MISTICASTUDIO.COM <img src="assets/images/mistica-logo.png" alt="Mistica Logo"></a></span>          
        </div>
      </div>
    </div>
  </div>
</footer>

<?php include("templates/comun/clienapp.php") ?>