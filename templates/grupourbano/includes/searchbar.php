<?php 
include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model ($empresa->id,$conx) ; 
$dormitorios_list = $propiedad_model->get_dormitorios();
?>
<div class="search-filter">
  <?php if($nombre_pagina != "mapa") { ?>
    <div class="logos-index">
      <span><img src="images/logo-1.png"></span>
      <span><img src="images/logo-2.png"></span>
    </div>
    <h1>comienza tu b&uacute;squeda</h1>
  <?php } ?>
  <div class="search-box">
    <div class="tabs">
      <ul class="tab-buttons">
        <li><a href="#on-sale" class="<?php echo(isset($tipo_operacion->id) && $tipo_operacion->id == 1)?"active":"" ?>">En Venta</a></li>
        <li><a href="#for-rent" class="<?php echo(isset($tipo_operacion->id) && $tipo_operacion->id == 2)?"active":"" ?>">En Alquiler</a></li>
        <li><a href="#developments" class="<?php echo(isset($tipo_operacion->id) && $tipo_operacion->id == 4)?"active":"" ?>">Emprendimientos</a></li>
        <li><a href="#our-works" class="<?php echo(isset($tipo_operacion->id) && $tipo_operacion->id == 5)?"active":"" ?>">Nuestras Obras</a></li>
      </ul>
      <div class="tab-content" id="on-sale" style="<?php echo(isset($tipo_operacion->id) && $tipo_operacion->id == 1)?"display:block":"" ?>">
        <form onsubmit="return filtrar(this)" method="get" class="search-form">
          <input type="hidden" class="filter_tipo_operacion" value="ventas"/>
          <input class="filter_codigo" style="width:53%" name="cod" type="text" placeholder="...Buscar por nombre o código de propiedad, ciudad o zona..." />
          <select id="localidad" style="width: 14%" class="filter_localidad">
            <option value="todas">Localidad</option>
            <?php $filter_localidades = $propiedad_model->get_localidades();
            foreach($filter_localidades as $r) { ?>
              <option <?php echo (isset($vc_link_localidad) && $vc_link_localidad == $r->link) ? "selected":"" ?> value="<?php echo $r->link ?>"><?php echo $r->nombre ?></option>
            <?php } ?>
          </select>
          <select class="filter_tipo_propiedad" name="tp">
            <option value="todas">Tipo de Propiedad</option>
            <?php $filter_tipos_propiedades = $propiedad_model->get_tipos_propiedades();
            foreach($filter_tipos_propiedades as $r) { ?>
              <option <?php echo (isset($vc_id_tipo_inmueble) && $vc_id_tipo_inmueble == $r->id) ? "selected":"" ?> value="<?php echo $r->id ?>"><?php echo $r->nombre ?></option>
            <?php } ?>
          </select>
          
          <button type="submit" class="btn btn-blue"><img src="images/search-icon.png" alt="Search Now" /> Buscar</button>
        </form>
      </div>
      <div class="tab-content" id="for-rent" style="<?php echo(isset($tipo_operacion->id) && $tipo_operacion->id == 2)?"display:block":"" ?>">
        <form onsubmit="return filtrar(this)" method="get" class="search-form">
          <input type="hidden" class="filter_tipo_operacion" value="alquileres"/>
          <input class="filter_codigo" style="width:53%" name="cod" type="text" placeholder="...Buscar por nombre o código de propiedad, ciudad o zona..." />
          <select id="localidad" style="width: 14%" class="filter_localidad">
            <option value="todas">Localidad</option>
            <?php $filter_localidades = $propiedad_model->get_localidades();
            foreach($filter_localidades as $r) { ?>
              <option <?php echo (isset($vc_link_localidad) && $vc_link_localidad == $r->link) ? "selected":"" ?> value="<?php echo $r->link ?>"><?php echo $r->nombre ?></option>
            <?php } ?>
          </select>
          <select class="filter_tipo_propiedad" name="tp">
            <option value="todas">Tipo de Propiedad</option>
            <?php $filter_tipos_propiedades = $propiedad_model->get_tipos_propiedades();
            foreach($filter_tipos_propiedades as $r) { ?>
              <option <?php echo (isset($vc_id_tipo_inmueble) && $vc_id_tipo_inmueble == $r->id) ? "selected":"" ?> value="<?php echo $r->id ?>"><?php echo $r->nombre ?></option>
            <?php } ?>
          </select>
          
          <button type="submit" class="btn btn-blue"><img src="images/search-icon.png" alt="Search Now" /> Buscar</button>
        </form>
      </div>
      <div class="tab-content" id="developments" style="<?php echo(isset($tipo_operacion->id) && $tipo_operacion->id == 4)?"display:block":"" ?>">
        <form onsubmit="return filtrar(this)" method="get" class="search-form">
          <input type="hidden" class="filter_tipo_operacion" value="emprendimientos"/>
          <input class="filter_codigo" style="width:53%" name="cod" type="text" placeholder="...Buscar por nombre o código de propiedad, ciudad o zona..." />
          <select id="localidad" style="width: 14%" class="filter_localidad">
            <option value="todas">Localidad</option>
            <?php $filter_localidades = $propiedad_model->get_localidades();
            foreach($filter_localidades as $r) { ?>
              <option <?php echo (isset($vc_link_localidad) && $vc_link_localidad == $r->link) ? "selected":"" ?> value="<?php echo $r->link ?>"><?php echo $r->nombre ?></option>
            <?php } ?>
          </select>
          <select class="filter_tipo_propiedad" name="tp">
            <option value="todas">Tipo de Propiedad</option>
            <?php $filter_tipos_propiedades = $propiedad_model->get_tipos_propiedades();
            foreach($filter_tipos_propiedades as $r) { ?>
              <option <?php echo (isset($vc_id_tipo_inmueble) && $vc_id_tipo_inmueble == $r->id) ? "selected":"" ?> value="<?php echo $r->id ?>"><?php echo $r->nombre ?></option>
            <?php } ?>
          </select>
          
          <button type="submit" class="btn btn-blue"><img src="images/search-icon.png" alt="Search Now" /> Buscar</button>
        </form>
      </div>
      <div class="tab-content" id="our-works" style="<?php echo(isset($tipo_operacion->id) && $tipo_operacion->id == 5)?"display:block":"" ?>">
        <form onsubmit="return filtrar(this)" method="get" class="search-form">
          <input type="hidden" class="filter_tipo_operacion" value="obras"/>
          <input class="filter_codigo" style="width:53%" name="cod" type="text" placeholder="...Buscar por nombre o código de propiedad, ciudad o zona..." />
          <select id="localidad" style="width: 14%" class="filter_localidad">
            <option value="todas">Localidad</option>
            <?php $filter_localidades = $propiedad_model->get_localidades();
            foreach($filter_localidades as $r) { ?>
              <option <?php echo (isset($vc_link_localidad) && $vc_link_localidad == $r->link) ? "selected":"" ?> value="<?php echo $r->link ?>"><?php echo $r->nombre ?></option>
            <?php } ?>
          </select>
          <select class="filter_tipo_propiedad" name="tp">
            <option value="todas">Tipo de Propiedad</option>
            <?php $filter_tipos_propiedades = $propiedad_model->get_tipos_propiedades();
            foreach($filter_tipos_propiedades as $r) { ?>
              <option <?php echo (isset($vc_id_tipo_inmueble) && $vc_id_tipo_inmueble == $r->id) ? "selected":"" ?> value="<?php echo $r->id ?>"><?php echo $r->nombre ?></option>
            <?php } ?>
          </select>
          
          <button type="submit" class="btn btn-blue"><img src="images/search-icon.png" alt="Search Now" /> Buscar</button>
        </form>
      </div>
    </div>
  </div>
  <div class="block">
    <div class="pull-right">
      <input type="checkbox" name="tipo_vista" id="show-in-list" <?php echo ($nombre_pagina!="mapa")?"checked":"" ?> />
      <label for="show-in-list">mostrar en lista</label>
      <input type="checkbox" name="tipo_vista" id="show-in-map" <?php echo ($nombre_pagina=="mapa")?"checked":"" ?> />
      <label for="show-in-map">mostrar en mapa</label>
    </div>
  </div>
</div>
