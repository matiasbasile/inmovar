<div class="sidebar-nav">
  <div class="form-title">navegaci&oacute;n</div>
  <ul>
    <li><a href="<?php echo mklink ("/") ?>">home</a></li>
    <li><a href="<?php echo mklink ("/") ?>propiedades/ventas/">ventas</a></li>
    <li><a href="<?php echo mklink ("/") ?>propiedades/alquileres/">alquiler</a></li>
    <li><a href="<?php echo mklink ("/") ?>propiedades/emprendimientos/">emprendimientos</a></li>
    <li><a href="<?php echo mklink ("/") ?>propiedades/obras/">obras</a></li>
    <li><a href="<?php echo mklink ("web/nosotros/") ?>">staff</a></li>
    <?php
    $q = mysqli_query($conx,"SELECT * FROM not_categorias WHERE id_empresa = $empresa->id AND link = 'novedades' LIMIT 0,1");
    if (mysqli_num_rows($q)>0) {
      $nn = mysqli_fetch_object($q);
      $id_cat = $nn->id; ?>
      <li class="dropdown <?php echo (isset($id_categoria) && $id_categoria==$id_cat)?"open":"" ?>">
        <a href="javascript:void(0);">novedades</a>
        <ul style="<?php echo (isset($id_categoria) && $id_categoria==$id_cat)?"display:block":"" ?>">
          <?php
          $meses = $entrada_model->get_months(array(
            "id_categoria"=>$id_cat,
          ));
          foreach($meses as $m) {
            $a = explode("-",$m->aniomes);
            $anio = $a[0];
            $mes = $a[1];
            ?>
            <li><a href="<?php echo mklink ("entradas/novedades/$anio"."/".$mes."/") ?>"><?php echo nombre_mes($mes)." ".$anio ?> <span>(<?php echo $m->cantidad ?>)</span></a></li>
          <?php } ?>
        </ul>
      </li>
    <?php } ?>
    
    <?php
    $q = mysqli_query($conx,"SELECT * FROM not_categorias WHERE id_empresa = $empresa->id AND link = 'avisos' LIMIT 0,1");
    if (mysqli_num_rows($q)>0) {
      $nn = mysqli_fetch_object($q);
      $id_cat = $nn->id; ?>    
      <li class="dropdown <?php echo (isset($id_categoria) && $id_categoria==$id_cat)?"open":"" ?>">
        <a href="javascript:void(0);">avisos</a>
        <ul style="<?php echo (isset($id_categoria) && $id_categoria==$id_cat)?"display:block":"" ?>">
          <?php
          $meses = $entrada_model->get_months(array(
            "id_categoria"=>$id_cat,
          ));
          foreach($meses as $m) {
            $a = explode("-",$m->aniomes);
            $anio = $a[0];
            $mes = $a[1];
            ?>
            <li><a href="<?php echo mklink ("entradas/avisos/$anio"."/".$mes."/") ?>"><?php echo nombre_mes($mes)." ".$anio ?> <span>(<?php echo $m->cantidad ?>)</span></a></li>
          <?php } ?>
        </ul>
      </li>
    <?php } ?>
    
    <li><a href="<?php echo mklink ("web/contacto/")?> ">contacto</a></li>
  </ul>
</div>
