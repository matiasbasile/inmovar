<!-- SEARCH PROPERTIES -->
<div class="search-properties">
  <div class="page">
    <div class="tabs tabs_search">
      <ul class="tab-button">
        <li><a href="#for-1">En alquiler</a></li>
        <li><a href="#for-2">En venta</a></li>
        <li><a href="#for-4">Emprendimientos</a></li>
      </ul>
      <?php $tipos_operacion_admitidos = array(1,2,4);
	$i=1;
      foreach($tipos_operacion_admitidos as $tipo) { ?>
        <div class="tab-content" id="for-<?php echo $tipo ?>" style="<?php echo ($tipo == $vc_id_tipo_operacion)?"display:block":"" ?>">
          <div class="row">
            <form onsubmit="return filtrar_<?php echo $i ?>(this,<?php echo $i ?>)" method="post" class="search-form" id="form_propiedades_<?php echo $i?>">
              <?php
              if ($tipo == "1") $tipo_operacion_l = "alquileres";
              else if ($tipo == "2") $tipo_operacion_l = "ventas";
              else if ($tipo == "4") $tipo_operacion_l = "emprendimientos";
              ?>
              <input type="hidden" class="filter_tipo_operacion" id="tipo_operacion_<?php echo $i?>" name="tipo_operacion" value="<?php echo $tipo_operacion_l ?>"/>
              <div class="pull-left">
                <input name="radio<?php echo $i ?>" type="checkbox" value="lista" <?php echo ($nombre_pagina != "mapa") ? 'checked="checked"' : '' ?> id="show-in-list-<?php echo $i ?>" />
                <label for="show-in-list-<?php echo $i ?>"><img src="images/list-view-icon.png" alt="List View" /> Listado</label>
                <input name="radio<?php echo $i ?>" type="checkbox" value="mapa" <?php echo ($nombre_pagina == "mapa") ? 'checked="checked"' : '' ?> id="show-in-map-<?php echo $i ?>" />
                <label for="show-in-map-<?php echo $i ?>"><img src="images/location-icon.png" alt="Map View" /> Mapa</label>
              </div>
              <select class="filter_localidad" id="localidad_<?php echo $i?>">
                <option value="todas">Localidad</option>
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
              <select class="filter_tipo_propiedad" name="id_tipo_inmueble_<?php echo $i?>" id="tp_<?php echo $i?>">
                <option value="todas">Tipo de Propiedad</option>
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
              <input type="text" name="codigo" value="<?php echo(isset($codigo)?$codigo:"") ?>" placeholder="C&oacute;digo de Propiedad" id="codigo_<?php echo $i ?>" />
              <input type="submit" value="Buscar" class="btn btn-orange" />
            </form>
          </div>
        </div>
      <?php $i++; } ?>
    </div>
  </div>
</div>
<script type="text/javascript">
  function filtrar_1() { 
    var link = "";
    if ($("input[name=radio1]:checked").val() == "lista") {
      link = "<?php echo mklink("propiedades/")?>";
    } else {
      link = "<?php echo mklink("mapa/")?>";
    }
    var tipo_operacion = $("#tipo_operacion_1").val();
    var localidad = $("#localidad_1").val();
    var tp = $("#tp_1").val();
    var codigo = $("#codigo_1").val();
    link = link + tipo_operacion + "/" + localidad + "/?tp=" + tp + "&cod=" + codigo ;
    $("#form_propiedades_1").attr("action",link);
    return true;
  }

   function filtrar_2() { 
    var link = "";
    if ($("input[name=radio2]:checked").val() == "lista") {
      link = "<?php echo mklink("propiedades/")?>";
    } else {
      link = "<?php echo mklink("mapa/")?>";
    }
    var tipo_operacion = $("#tipo_operacion_2").val();
    var localidad = $("#localidad_2").val();
    var tp = $("#tp_2").val();
    var codigo = $("#codigo_2").val();

    link = link + tipo_operacion + "/" + localidad + "/?tp=" + tp + "&cod=" + codigo ;
    $("#form_propiedades_2").attr("action",link);
    return true;
  }

   function filtrar_3() { 
    var link = "";
    if ($("input[name=radio3]:checked").val() == "lista") {
      link = "<?php echo mklink("propiedades/")?>";
    } else {
      link = "<?php echo mklink("mapa/")?>";
    }
    var tipo_operacion = $("#tipo_operacion_3").val();
    var localidad = $("#localidad_3").val();
    var tp = $("#tp_3").val();
    var codigo = $("#codigo_3").val();
    link = link + tipo_operacion + "/" + localidad + "/?tp=" + tp + "&cod=" + codigo ;
    $("#form_propiedades_3").attr("action",link);
    return true;
  }
   
</script>