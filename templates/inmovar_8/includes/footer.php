<footer class="menacho_footer">
  <div class="container">
    <div class="main_footer">
      <div class="row footer_logo_social">
        <div class="col-lg-6 col-md-12 footer_logo self-center">
          <p>¿Tenés alguna consulta?</p>
          <a class="btn_outline" href="<?php echo mklink ("contacto/") ?>">contactanos</a> </div>
        <div class="col-lg-6 col-md-12 footer_social text-right m0">
          <i class="fa fa-clock-o hidden-xs" aria-hidden="true"></i>
          <p class="hidden-xs"><?php echo (($empresa->horario)) ?></p>
          <ul>
            <?php if (!empty($empresa->facebook)) {  ?><li> <a target="_blank" href="<?php echo $empresa->facebook ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a> </li><?php } ?>
            <?php if (!empty($empresa->instagram)) {  ?><li> <a target="_blank" href="<?php echo $empresa->instagram ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a> </li><?php } ?>
          </ul>
        </div>
      </div>
      <div class="quick_link">
        <ul>
         
          <?php if (isset($sobre_nosotros) && $sobre_nosotros != null) { ?>
            <li> <a href="<?php echo mklink ($sobre_nosotros->link) ?>">Sobre Nosotros</a> </li>
          <?php } ?>

          <li> <a href="<?php echo mklink ("propiedades/ventas/") ?>">VENTAS</a> </li>
          
          <?php if ($tiene_alquileres == 1) { ?>
            <li> <a href="<?php echo mklink ("propiedades/alquileres/") ?>">ALQUILERES</a> </li>
          <?php } ?>

          <?php if ($tiene_alquileres_temporarios == 1) { ?>
            <li> <a href="<?php echo mklink ("propiedades/alquileres-temporarios/") ?>">ALQUILERES TEMPORARIOS</a> </li>
          <?php } ?>

          <?php if ($tiene_emprendimientos == 1) { ?>
            <li> <a href="<?php echo mklink ("propiedades/emprendimientos/") ?>">EMPRENDIMIENTOS</a> </li>
          <?php } ?>
        </ul>
      </div>
      <div class="row copyright">
        <div class="col-lg-7 col-md-10 copyright_para">
          <p><?php echo $empresa->nombre." ".date("Y")?> | <span>Todos Los Derechos Reservados</span></p>
        </div>
        <div class="col-lg-5 col-md-2 text-right copyright_para1"> 
          <!-- <p>Diseno Web inmobiliarias</p> --> 
           <a target="_blank" href="http://www.inmovar.com">
            <img class="despegar" src="images/inmovar-despega.png" alt="Mistica Studio"></a>
          ¡Hacé despegar tu inmobiliaria!</div>
      </div>
    </div>
  </div>
</footer>
<?php include("templates/comun/clienapp.php") ?>