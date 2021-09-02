<footer id="page-footer">
  <div class="inner">
    <?php if ($empresa->comp_footer_grande == 1) { ?>
    <aside id="footer-main">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-sm-3">
            <article>
            <?php $t = $web_model->get_text("footer-texto-titulo"); ?>
            <h3 data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo $t->plain_text ?></h3>
            <?php $t = $web_model->get_text("footer-texto-texto"); ?>
            <div data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $empresa->id ?>" data-id="<?php echo $t->id ?>" class="editable"><?php echo $t->plain_text ?></div>
            <hr>
            <a href="<?php echo $t->link ?>" class="link-arrow">Leer m&aacute;s</a>
            </article>
          </div><!-- /.col-sm-3 -->
          <div class="col-md-3 col-sm-3">
            <!-- LATEST PROPERTIES -->
            <?php $ultimas = $propiedad_model->ultimas(array(
              "offset"=>2,
            ));
            if (sizeof($ultimas)>0) { ?>
              <article>
                <h3>&Uacute;ltimas Propiedades</h3>
                <?php foreach($ultimas as $r) { ?>
                  <div class="property small">
                    <a href="<?php echo $r->link_propiedad ?>">
                      <div class="property-image">
                        <?php if (!empty($r->imagen)) { ?>
                          <img src="<?php echo $r->imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                        <?php } else if (!empty($empresa->no_imagen)) { ?>
                          <img src="/admin/<?php echo $empresa->no_imagen ?>" alt="<?php echo ($r->nombre); ?>" />
                        <?php } else { ?>
                          <img src="images/logo.png" alt="<?php echo ($r->nombre); ?>" />
                        <?php } ?>
                      </div>
                    </a>
                    <div class="info">
                      <a href="<?php echo $r->link_propiedad ?>">
                        <h4><?php echo $r->nombre ?></h4>
                      </a>
                      <figure><?php echo $r->direccion_completa ?></figure>
                      <div class="tag price"><?php echo ($r->precio_final != 0 && $r->publica_precio == 1) ? $r->moneda." ".number_format($r->precio_final,0) : "Consultar"; ?></div>
                    </div>
                  </div>
                <?php } ?>
              </article>
            <?php } ?>
          </div><!-- /.col-sm-3 -->
          <div class="col-md-3 col-sm-3">
            <article>
              <h3>Contacto</h3>
              <address>
                <strong><?php echo ($empresa->nombre) ?></strong><br>
                <?php echo ($empresa->direccion) ?><br>
                <?php echo ($empresa->localidad) ?>
              </address>
              <?php if (!empty($empresa->telefono)) { ?>
                <?php echo $empresa->telefono ?><br>
              <?php } ?>
              <?php if (!empty($empresa->telefono_2)) { ?>
                <?php echo $empresa->telefono_2 ?><br>
              <?php } ?>
              <?php if (!empty($empresa->email)) { ?>
                <a href="mailto:<?php echo $empresa->email ?>">
                  <?php echo $empresa->email ?>
                </a>
              <?php } ?>
            </article>
          </div><!-- /.col-sm-3 -->
          <div class="col-md-3 col-sm-3">
            <article>
              <h3>Links</h3>
              <ul class="list-unstyled list-links">
                <li><a href="<?php echo mklink("propiedades/"); ?>">Propiedades</a></li>
                <?php
                // Obtenemos las entradas de esa categoria
                $entradas = $entrada_model->get_list(array(
                  "offset"=>4
                ));
                foreach($entradas as $r) { ?>
                  <li><a href="<?php echo mklink($r->link); ?>"><?php echo $r->titulo ?></a></li>
                <?php } ?>
              </ul>
            </article>
          </div><!-- /.col-sm-3 -->
        </div><!-- /.row -->
      </div><!-- /.container -->
    </aside><!-- /#footer-main -->
    <?php } ?>
    <aside id="footer-thumbnails" class="footer-thumbnails"></aside><!-- /#footer-thumbnails -->
    <aside id="footer-copyright">
      <div class="container">
        <span class="copyright">Copyright © <?php echo date("Y")?>. Todos los derechos reservados.</span>
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

<script type="text/javascript" src="/admin/resources/js/jquery.min.js"></script>
<script type="text/javascript" src="/admin/resources/js/libs/bootstrap.min.js"></script>
<!--<script type="text/javascript" src="assets/js/smoothscroll.js"></script>-->
<script type="text/javascript" src="/admin/resources/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.placeholder.js"></script>
<script type="text/javascript" src="assets/js/icheck.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.vanillabox-0.1.5.min.js"></script>
<script type="text/javascript" src="assets/js/retina-1.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/jshashtable-2.1_src.js"></script>
<script type="text/javascript" src="assets/js/jquery.numberformatter-1.2.3.js"></script>
<script type="text/javascript" src="assets/js/tmpl.js"></script>
<script type="text/javascript" src="assets/js/jquery.dependClass-0.1.js"></script>
<script type="text/javascript" src="assets/js/draggable-0.1.js"></script>
<script type="text/javascript" src="assets/js/jquery.slider.js"></script>
<script type="text/javascript" src="assets/js/jquery.numberformatter-1.2.3.js"></script>
<!--[if gt IE 8]>
<script type="text/javascript" src="assets/js/ie.js"></script>
<![endif]-->
<script type="text/javascript" src="/admin/resources/js/common.js"></script>
<script type="text/javascript" src="/admin/resources/js/main.js"></script>

<?php include("templates/comun/clienapp.php") ?>