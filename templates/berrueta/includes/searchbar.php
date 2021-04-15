<!-- SEARCH PROPERTIES -->
<div class="search-properties">
  <div class="page">
    <div class="tabs tabs_search">
      <ul class="tab-button">
        <li><a <?php echo ($tipo_operacion->id == 1)?"active":"" ?> href="#for-1">En alquiler</a></li>
        <li><a <?php echo ($tipo_operacion->id == 2)?"active":"" ?> href="#for-2">En venta</a></li>
        <li><a <?php echo ($tipo_operacion->id == 4)?"active":"" ?> href="#for-4">Emprendimientos</a></li>
      </ul>
      <?php $tipos_operacion_admitidos = array(1,2,4);
	$i=1;
      foreach($tipos_operacion_admitidos as $tipo) { ?>
        <div class="tab-content" id="for-<?php echo $tipo ?>" style="<?php echo ($tipo == $tipo_operacion->id)?"display:block":"" ?>">
          <div class="row">
            <form onsubmit="return filtrar(this,<?php echo $i ?>)" method="post" class="search-form">
              <?php
              if ($tipo == "1") $tipo_operacion_l = "alquileres";
              else if ($tipo == "2") $tipo_operacion_l = "ventas";
              else if ($tipo == "4") $tipo_operacion_l = "emprendimientos";
              ?>
              <input type="hidden" class="filter_tipo_operacion" name="tipo_operacion" value="<?php echo $tipo_operacion_l ?>"/>
              <div class="pull-left">
                <input type="checkbox" <?php echo ($nombre_pagina != "mapa") ? 'checked="checked"' : '' ?> id="show-in-list-<?php echo $i ?>" />
                <label for="show-in-list-<?php echo $i ?>"><img src="images/list-view-icon.png" alt="List View" /> Listado</label>
                <input type="checkbox" <?php echo ($nombre_pagina == "mapa") ? 'checked="checked"' : '' ?> id="show-in-map-<?php echo $i ?>" />
                <label for="show-in-map-<?php echo $i ?>"><img src="images/location-icon.png" alt="Map View" /> Mapa</label>
              </div>
              <select class="filter_localidad">
                <option value="0">Localidad</option>
                <?php
                $sql = "SELECT DISTINCT L.nombre, L.link ";
                $sql.= "FROM inm_propiedades P ";
                $sql.= "INNER JOIN com_localidades L ON (P.id_localidad = L.id) ";
                $sql.= "WHERE P.id_empresa = $empresa->id ";
                $sql.= "AND P.activo = 1 ";
                $sql.= "ORDER BY L.nombre ASC";
                $q = mysqli_query($conx,$sql);
                while(($r=mysqli_fetch_object($q))!==NULL) { ?>
                  <option <?php echo (isset($id_localidad) && $id_localidad == $r->id) ? "selected":"" ?> value="<?php echo $r->link ?>"><?php echo ($r->nombre) ?></option>
                <?php } ?>
              </select>
              <select class="filter_tipo_propiedad" name="id_tipo_inmueble">
                <option value="0">Tipo de Propiedad</option>
                <?php
                $sql = "SELECT DISTINCT T.nombre, T.id ";
                $sql.= "FROM inm_propiedades P ";
                $sql.= "INNER JOIN inm_tipos_inmueble T ON (P.id_tipo_inmueble = T.id) ";
                $sql.= "WHERE P.id_empresa = $empresa->id ";
                $sql.= "AND P.activo = 1 ";
                $sql.= "ORDER BY T.nombre ASC";
                $q = mysqli_query($conx,$sql);
                while(($r=mysqli_fetch_object($q))!==NULL) { ?>
                  <option <?php echo (isset($id_tipo_inmueble) && $id_tipo_inmueble == $r->id) ? "selected":"" ?> value="<?php echo $r->id ?>"><?php echo ($r->nombre) ?></option>
                <?php } ?>
              </select>              
              <input type="text" name="codigo" value="<?php echo(isset($codigo)?$codigo:"") ?>" placeholder="C&oacute;digo de Propiedad" />
              <input type="submit" value="Buscar" class="btn btn-orange" />
            </form>
          </div>
        </div>
      <?php $i++; } ?>
    </div>
  </div>
</div>
