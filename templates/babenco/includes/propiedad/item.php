<?php
function propiedad_item($r) { ?>
  <div class="property-box">
    <?php if (sizeof($r->images)>0) { ?>
      <div class="img-block">
        <div class="owl-carousel owl-theme" data-outoplay="true" data-nav="true" data-dots="false">
          <?php foreach($r->images as $image) { ?>
            <div class="item">
              <a href="<?php echo $r->link_propiedad ?>">
                <img src="<?php echo $image ?>" alt="img">
              </a>
            </div>
          <?php } ?>
        </div>

        <?php if (estaEnFavoritos($r->id)) { ?>
          <a class="whishlist-icon active" href="/admin/favoritos/eliminar/?id=<?php echo $r->id; ?>">
            <img src="assets/images/wishlist2.png" alt="Icon">
          </a>
        <?php } else { ?>
          <a class="whishlist-icon" href="/admin/favoritos/agregar/?id=<?php echo $r->id; ?>">
            <img src="assets/images/wishlist1.png" alt="Icon">
          </a>
        <?php } ?>

        <?php if ($r->id_tipo_estado == 4) { ?>
          <small>reservada</small>
        <?php } else if ($r->id_tipo_estado == 3) { ?>
          <small>vendida</small>
        <?php } ?>
      </div>
    <?php } ?>
    <div class="title-box">
      <h4><a href="<?php echo $r->link_propiedad ?>"><?php echo $r->precio ?></a></h4>
      <p><?php echo $r->nombre ?></p>
      <span><?php echo $r->direccion_completa ?></span>
      <?php if ($r->id_tipo_operacion != 5) { ?>
        <div class="aminities">
          <span><?php echo $r->superficie_total ?> m2</span>
          <ul>
            <li><img src="assets/images/bedroom.png" alt="Icon"> <?php echo (empty($r->dormitorios)) ? "-" : $r->dormitorios ?></li>
            <li><img src="assets/images/shower.png" alt="Icon"> <?php echo (empty($r->banios)) ? "-" : $r->banios ?></li>
            <li><img src="assets/images/parking.png" alt="Icon"> <?php echo (empty($r->cocheras)) ? "-" : $r->cocheras ?></li>
          </ul>
        </div>
      <?php } ?>
    </div>
    <div class="btn-actions">
      <a href="mailto:emai@gmail.com" class="btn"><svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" clip-rule="evenodd" d="M3.75 5.25L3 6V18L3.75 18.75H20.25L21 18V6L20.25 5.25H3.75ZM4.5 7.6955V17.25H19.5V7.69525L11.9999 14.5136L4.5 7.6955ZM18.3099 6.75H5.68986L11.9999 12.4864L18.3099 6.75Z" fill="#080341"/>
      </svg> Email</a>
      <a href="#0" class="btn btn-green">
        <svg fill="#000000" width="800px" height="800px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M11.42 9.49c-.19-.09-1.1-.54-1.27-.61s-.29-.09-.42.1-.48.6-.59.73-.21.14-.4 0a5.13 5.13 0 0 1-1.49-.92 5.25 5.25 0 0 1-1-1.29c-.11-.18 0-.28.08-.38s.18-.21.28-.32a1.39 1.39 0 0 0 .18-.31.38.38 0 0 0 0-.33c0-.09-.42-1-.58-1.37s-.3-.32-.41-.32h-.4a.72.72 0 0 0-.5.23 2.1 2.1 0 0 0-.65 1.55A3.59 3.59 0 0 0 5 8.2 8.32 8.32 0 0 0 8.19 11c.44.19.78.3 1.05.39a2.53 2.53 0 0 0 1.17.07 1.93 1.93 0 0 0 1.26-.88 1.67 1.67 0 0 0 .11-.88c-.05-.07-.17-.12-.36-.21z"/><path d="M13.29 2.68A7.36 7.36 0 0 0 8 .5a7.44 7.44 0 0 0-6.41 11.15l-1 3.85 3.94-1a7.4 7.4 0 0 0 3.55.9H8a7.44 7.44 0 0 0 5.29-12.72zM8 14.12a6.12 6.12 0 0 1-3.15-.87l-.22-.13-2.34.61.62-2.28-.14-.23a6.18 6.18 0 0 1 9.6-7.65 6.12 6.12 0 0 1 1.81 4.37A6.19 6.19 0 0 1 8 14.12z"/></svg> 
        Whatsapp
      </a>
    </div>
  </div>
<?php } ?>