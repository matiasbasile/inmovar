<?php include ("includes/init.php");
extract($propiedad_model->get_variables());
$page_active = $vc_link_tipo_operacion;
$page_act = $vc_link_tipo_operacion;?>
<!DOCTYPE html>
<html>
<head>
  <?php include ("includes/head.php");?>
</head>
<body>

<?php include ("includes/header.php");?>

  <main id="ts-main">
    <section id="page-title">
      <div class="container">

        <div class="ts-title">
          <h1><?php echo $vc_tipo_operacion ?></h1>
          <h5><?php echo $vc_total_resultados ?> propiedades encontradas.</h5>
        </div>

      </div>
    </section>

    <!--SEARCH FORM
      =========================================================================================================-->
    <section id="search-form">
      <div class="container">

        <?php include "includes/buscador.php" ?>

      </div>
      <!--end container-->
    </section>

    <!--ITEMS LISTING
      =========================================================================================================-->
    <section id="items-grid">
      <div class="container">
        
        <!--Featured Items-->
        <!--Row-->
        <div class="row">
          <?php if (!empty($vc_listado)) {  ?>
            <?php foreach ($vc_listado as $r){?>
              <div class="col-sm-6 col-lg-3">
                <div class="card ts-item ts-card">

                  <!--Card Image-->
                  <a href="<?php echo mklink($r->link)?>" class="card-img" data-bg-image="<?php echo $r->imagen?>">
                    <div class="ts-item__info-badge">
                      <?php echo $r->precio;?>
                    </div>
                    <figure class="ts-item__info">
                      <h4><?php echo $r->nombre; ?></h4>
                      <aside>
                        <i class="fa fa-map-marker mr-2"></i>
                        <?php echo ($r->calle." ".$r->altura) ?>
                      </aside>
                    </figure>
                  </a>

                  <!--Card Body-->
                  <div class="card-body">
                    <div class="ts-description-lists">
                      <dl>
                        <dt>Area</dt>
                        <dd><?php echo (!empty($r->superficie)) ? $r->superficie : "-" ?></dd>
                      </dl>
                      <dl>
                        <dt>Dormitorios</dt>
                        <dd><?php echo (!empty($r->dormitorios)) ? $r->dormitorios : "-" ?></dd>
                      </dl>
                      <dl>
                        <dt>Baños</dt>
                        <dd><?php echo (!empty($r->banios)) ? $r->banios : "-" ?></dd>
                      </dl>
                    </div>
                  </div>

                  <!--Card Footer-->
                  <a href="<?php echo mklink ($r->link)?>" class="card-footer">
                    <span class="ts-btn-arrow">Detalles</span>
                  </a>

                </div>
                <!--end ts-item-->
              </div>
            <?php } ?>
          <?php } else { ?>
            <h4>No se encontraron resultados para su búsqueda.</h4>
          <?php } ?>
        </div>
        <!--end row-->
      </div>
      <!--end container-->
    </section>

    <!--PAGINATION
      =========================================================================================================-->
    <section id="pagination">
      <div class="container">

        <!--Pagination-->
        <?php if ($vc_total_paginas > 1) { ?>
          <nav aria-label="Page navigation">
          <ul class="pagination">
            <?php if ($vc_page > 0) { ?>
            <li>
              <a href="<?php echo mklink ($vc_link.($vc_page-1)."/".$vc_params ) ?>" aria-label="Previous">
              <span aria-hidden="true">Anterior</span>
              </a>
            </li>
            <?php } ?>
            <?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
             <?php if (abs($vc_page-$i)<3) { ?>
               <?php if ($i == $vc_page) { ?>
              <li class="active"><a><?php echo $i+1 ?></a></li>
               <?php } else { ?>
               <li ><a href="<?php echo mklink ($vc_link.$i."/".$vc_params ) ?>"><?php echo $i+1 ?></a></li>
               <?php } ?>
             <?php } ?>
            <?php } ?>
             <?php if ($vc_page < $vc_total_paginas-1) { ?>
            <li><a href="<?php echo mklink ($vc_link.($vc_page+1)."/".$vc_params ) ?>">Siguiente</a></li>
            <?php } ?>
          </ul>
          </nav>
        <?php } ?>

      </div>
    </section>

  </main>
  <!--end #ts-main-->

  <!--*********************************************************************************************************-->
  <!--************ FOOTER *************************************************************************************-->
  <!--*********************************************************************************************************-->


<?php include ("includes/footer.php");?>
</body>
</html>