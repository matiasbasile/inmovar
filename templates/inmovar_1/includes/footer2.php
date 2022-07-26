<style>
  .footer_newtitle {
    text-align: center !important;
    color: rgb(26, 49, 70) !important;
    font-family: 'Roboto' !important;
    font-weight: 600 !important;
    margin-bottom: 10px !important;
  }

  h3 {
    margin-bottom: 0px !important;
  }

  .footer_newtitlebold {
    opacity: 1 !important;
    font-weight: 700;
    font-family: 'Roboto';
    text-align: center;
    margin-top: 10px;
  }

  @media(max-width: 768px) {
    .footer_newtitle {
      margin-top: 50px !important;
    }
  }
</style>

<footer id="page-footer">
  <div class="inner">
    <?php if ($empresa->comp_footer_grande == 1) { ?>
      <aside id="footer-main">
        <div class="container">
          <div class="row">
            <div class="col-md-4">
              <?php if ($empresa->id == 1518) { ?>
                <img src="assets/img/logofooter.jpg" alt="<?php echo ($empresa->nombre) ?>" style="width: 100%;">
              <?php } else if (!empty($empresa->logo_1)) { ?>
                <img src="/admin/<?php echo $empresa->logo_1 ?>" alt="<?php echo ($empresa->nombre) ?>" style="width: 100%;">
              <?php } ?>
            </div>
            <div class="col-md-4">
              <article>
                <h3 class="footer_newtitle">Oficina comercial</h3>
                <p class="footer_newtitlebold">Bourdin Bienes Raíces</p>
                <?php if (!empty($empresa->direccion)) { ?>
                  <p class="text-center"><?php echo $empresa->direccion ?></p>
                <?php  } ?>
              </article>
            </div>
            <div class="col-md-4 text-center">
              <article>
                <h3 class="footer_newtitle">Contacto</h3>
                <?php if (!empty($empresa->telefono)) { ?>
                  <?php echo $empresa->telefono ?><br>
                <?php } ?>
                <?php if (!empty($empresa->email)) { ?>
                  <a href="mailto:<?php echo $empresa->email ?>">
                    <?php echo $empresa->email ?>
                  </a>
                <?php } ?>
              </article>
            </div><!-- /.col-sm-3 -->
          </div><!-- /.row -->
        </div><!-- /.container -->
      </aside><!-- /#footer-main -->
    <?php } ?>
    <aside id="footer-thumbnails" class="footer-thumbnails"></aside><!-- /#footer-thumbnails -->
    <aside id="footer-copyright">
      <div class="container">
        <span class="copyright">Copyright © <?php echo date("Y") ?>. Todos los derechos reservados.</span>
        <span class="pull-right">
          <a class="inmovar-logo" href="https://www.inmovar.com" target="_blank">
            <img class="inmovar-logo-img" src="assets/img/inmovar-despega.png">
            <span class="inmovar-frase">¡Hacé despegar tu inmobiliaria!</span>
          </a>
        </span>
      </div>
    </aside>
  </div><!-- /.inner -->
</footer>