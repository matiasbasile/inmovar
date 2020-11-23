<footer class="menacho_footer">
  <div class="container">
    <div class="main_footer">
      <div class="row footer_logo_social">
        <div class="col-lg-7 col-md-12 footer_logo">
          <?php if (!empty($empresa->logo)) {  ?>
            <a href="<?php echo mklink ("/") ?>">
              <img src="/sistema/<?php echo $empresa->logo ?>" alt="footer_logo">
            </a>
          <?php } ?>
          <p>¿Tenés alguna consulta?</p>
          <a class="btn_outline" href="<?php echo mklink ("contacto/") ?>">contactanos</a> </div>
        <div class="col-lg-5 col-md-12 footer_social text-right m0"> <i class="fa fa-clock-o" aria-hidden="true"></i>
          <p><?php echo (($empresa->horario)) ?></p>
          <ul>
            <?php if (!empty($empresa->facebook)) {  ?><li> <a target="_blank" href="<?php echo $empresa->facebook ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a> </li><?php } ?>
            <?php if (!empty($empresa->instagram)) {  ?><li> <a target="_blank" href="<?php echo $empresa->instagram ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a> </li><?php } ?>
          </ul>
        </div>
      </div>
      <div class="quick_link">
        <ul>
          <li> <a href="<?php echo mklink ("/") ?>">home</a> </li>
          <li> <a href="<?php echo mklink ("entradas/empresa/") ?>">NOSOTROS</a> </li>
          <li> <a href="<?php echo mklink ("entradas/") ?>">información</a> </li>
          <li> <a href="<?php echo mklink ("propiedades/ventas/") ?>">VENTAS</a> </li>
          <li> <a href="<?php echo mklink ("propiedades/alquileres/") ?>">ALQUILERES</a> </li>
          <li> <a href="<?php echo mklink ("propiedades/emprendimientos/") ?>">EMPRENDIMIENTOS</a> </li>
        </ul>
      </div>
      <div class="row copyright">
        <div class="col-lg-7 col-md-10 copyright_para">
          <p><?php echo $empresa->nombre." ".date("Y")?> | <span>Todos Los Derechos Reservados</span></p>
        </div>
        <div class="col-lg-5 col-md-2 text-right copyright_para1"> 
          <!-- <p>Diseno Web inmobiliarias</p> --> 
          Tu Inmobiliaria Online! <a target="_blank" href="http://www.inmovar.com"><img src="images/varcreative-logo.png" alt="Mistica Studio"></a> INMOVAR</div>
      </div>
    </div>
  </div>
</footer>