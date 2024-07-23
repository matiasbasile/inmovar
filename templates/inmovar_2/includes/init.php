<?php 
include_once "admin/application/helpers/fecha_helper.php";
include_once "models/Entrada_Model.php";
include_once "models/Web_Model.php";
include_once "models/Propiedad_Model.php";
$entrada_model = new Entrada_Model($empresa->id,$conx) ; 
$web_model = new Web_Model($empresa->id,$conx) ;
$propiedad_model = new Propiedad_Model($empresa->id,$conx) ; 
/*-------------ARRAYS-----------*/
$tipos_operaciones  = $propiedad_model->get_tipos_operaciones();
$tipos_propiedades  = $propiedad_model->get_tipos_propiedades();
$dormitorios_list = $propiedad_model->get_dormitorios();
$localidades = $propiedad_model->get_localidades();
$cocheras_list =$propiedad_model->get_cocheras();
$banios_list = $propiedad_model->get_banios();
$sliders = $web_model->get_slider();
$listado_full = $propiedad_model->get_list(array("offset"=>6));

/*------------- Si la empresa es Armentia (id=1644) mostramos 9 destacadas (3 por defecto) -----------*/
if ($empresa->id == 1644) {
  $propiedades_destacadas = $propiedad_model->get_list(array("destacado"=>1,"offset"=>9,"solo_propias"=>1));
} else {
  $propiedades_destacadas = $propiedad_model->get_list(array("destacado"=>1,"offset"=>3,"solo_propias"=>1));
}

$listado_total_entradas = $entrada_model->get_list(array());

  function ver_caracteristicas($p) { ?>
  <?php if ($p->id_tipo_inmueble == 5 || $p->id_tipo_inmueble == 6 || $p->id_tipo_inmueble == 7) { ?>
    <?php if ($p->mts_frente != 0 && $p->mts_fondo != 0) { ?>
      <ul class="facilities-list clearfix">
        <li class="w50p">
          <i class="fa fa-arrows-h"></i>
          <span>Frente: <?php echo str_replace(".00", "", $p->mts_frente) ?> Mts.</span>
        </li>
        <li class="w50p">
          <i class="fa fa-arrows-v"></i>
          <span>Fondo: <?php echo str_replace(".00", "", $p->mts_fondo) ?> Mts.</span>
        </li>
      </ul>
    <?php } ?>
  <?php } else { ?>
    <?php if (!empty($p->dormitorios) || !empty($p->banios) || !empty($p->cocheras)) { ?>
      <ul class="facilities-list clearfix">
        <li>
          <i class="fa fa-bed"></i>
          <span><?php echo (!empty($p->dormitorios)) ? $p->dormitorios : "-" ?> Hab.</span>
        </li>
        <li>
          <i class="fa fa-bath"></i>
          <span><?php echo (!empty($p->banios)) ? $p->banios." ".(($p->banios == 1)?"Baño":"Baños") : "-" ?></span>
        </li>
        <li>
          <i class="fa fa-car"></i>
          <span><?php echo (!empty($p->cocheras)) ? (($p->cocheras == 1)?"Coch.":$p->cocheras." Coch.") : "-" ?></span>
        </li>
      </ul>
    <?php } ?>
  <?php } ?>
<?php } ?>

<?php function ver_direccion($p) { ?>
  <?php if (!empty($p->direccion_completa) || !empty($p->localidad)) { ?>
    <h3 class="property-address">
      <a href="<?php echo mklink($p->link) ?>">
        <i class="fa fa-map-marker"></i><?php echo ((!empty($p->direccion_completa)) ? $p->direccion_completa.", " : "")." ".$p->localidad ?>
      </a>
    </h3>
  <?php } ?>
  <h4 class="property-address">
    <a href="<?php echo mklink($p->link) ?>">
      Código: <?php echo (isset($p->codigo_completo) && !empty($p->codigo_completo)) ? $p->codigo_completo : $p->codigo ?>
    </a>
  </h4>
<?php } ?>