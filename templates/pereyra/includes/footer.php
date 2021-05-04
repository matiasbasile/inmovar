<footer>
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="logo">
          <a href="<?php echo mklink ("/") ?>"><img src="assets/images/logo02.png" alt="Logo"></a>
        </div>
        <?php $t = $web_model->get_text("slogan-footer","Somos una empresa joven, liderada por personal profesionalmente capacitado en el rubro inmobiliario y de la construcción.")?>
        <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
          <?php echo $t->plain_text ?>
        </p>
      </div>
      <div class="col-lg-5 pl-3">
      <h6>Accesos Rápidos</h6>        
        <div class="quick-links">
          <ul>
            <li><a href="<?php echo mklink ("/") ?>">Inicio</a></li>
            <li><a href="<?php echo mklink ("propiedades/emprendimientos/") ?>">Emprendimientos</a></li>
            <li><a href="<?php echo mklink ("propiedades/ventas/") ?>">Comprar</a></li>
            <li><a href="<?php echo mklink ("web/consorcio/") ?>">Administración de Consorcios</a></li>
            <li><a href="<?php echo mklink ("propiedades/alquileres/") ?>">Alquilar</a></li>
            <li><a href="<?php echo mklink ("contacto/") ?>">Contacto</a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-3"> 
        <h6>Vías de Comunicación</h6>       
        <div class="contact-info">
          <ul>
            <li>
              <img src="assets/images/map.png" alt="Find Us">
              <div class="right-content">
                <a href="javascript:void(0)"><?php echo $empresa->direccion ?></a>
              </div>
            </li>
            <li>
              <img src="assets/images/call-us.png" alt="Call Us">
              <div class="right-content">
                <a href="tel:<?php echo $empresa->telefono ?>"><?php echo $empresa->telefono ?></a>
              </div>
            </li>
            <li>
              <img src="assets/images/email-us.png" alt="Email Us">
              <div class="right-content">
                <a href="mailto:<?php echo $empresa->email ?>"><?php echo $empresa->email ?></a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>  
</footer>

 <!-- Copyright -->
<div class="copyright">
  <div class="container">
    <div class="float-left">
      Pereyra Propiedades. <span>Todos Los Derechos Reservados</span>
    </div>
    <div class="float-right">
     <span>Diseño Web Inmobiliarias <a target="_blank" href="https://www.misticastudio.com"><img src="assets/images/mistica-logo.png" alt="Mistica Logo"></a></span>
    </div>
  </div>
</div>

<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><span><i class="fa fa-chevron-up"></i></span></a>