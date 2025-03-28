<?php 
function antiguedad_seleccionada($opciones = array()) {
  global $vc_in_antiguedad;
  $ant_select = false; 
  if (isset($vc_in_antiguedad) && is_array($vc_in_antiguedad)) {
    for($i=0;$i<sizeof($vc_in_antiguedad);$i++) {
      $ant = $vc_in_antiguedad[$i];
      if (in_array($ant, $opciones)) {
        $ant_select = true;
        break;
      }
    }
  }
  return $ant_select;
}
?>

<section class="filter-box">
  <div class="container">
    <form id="form_buscador" onsubmit="return filtrar(this)" method="get">

      <a href="javascript:void(0)" class="multiple-checkbox drowdown-options-mobile mb15">
        <span>Filtrar</span>
        <i class="a">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
          </svg>
        </i>
      </a>

      <div class="drowdown-options-mobile-container">
      
        <input type="hidden" id="page" name="page" value="<?php echo isset($vc_page) ? $vc_page : "0" ?>"/>
        <input type="hidden" id="filter_order" name="orden" value="<?php echo isset($vc_orden) ? $vc_orden : "8" ?>"/>
        <input type="hidden" id="ver_mapa" name="view" value="<?php echo isset($vc_view) ? $vc_view : "" ?>"/>
        <input type="hidden" id="latitud_bound_1" name="latb1" value="<?php echo isset($vc_lat_b1) ? $vc_lat_b1 : "" ?>"/>
        <input type="hidden" id="longitud_bound_1" name="lngb1" value="<?php echo isset($vc_lng_b1) ? $vc_lng_b1 : "" ?>"/>
        <input type="hidden" id="latitud_bound_2" name="latb2" value="<?php echo isset($vc_lat_b2) ? $vc_lat_b2 : "" ?>"/>
        <input type="hidden" id="longitud_bound_2" name="lngb2" value="<?php echo isset($vc_lng_b2) ? $vc_lng_b2 : "" ?>"/>
        <textarea name="points" style="display: none;" id="filtrar_puntos"><?php echo $vc_points ?></textarea>

        <?php // Este filtro se rellena con la funcion de javascript filtro_antiguedad() definido en el footer.php ?>
        <input type="hidden" id="in_antiguedad" name="in_antiguedad"/>

        <input type="hidden" id="localidad_link_hidden" value="<?php echo $vc_link_localidad ?>" />
        <input type="hidden" id="localidad_id_hidden" name="id_localidad" value="<?php echo $vc_id_localidad ?>" />
        <input data-role="tagsinput" type="search" class="form-control localidad-select filter_localidad" id="filter_localidad" value="<?php echo $vc_nombre_localidad ?>" placeholder="Ingresá ubicación">
        
        <!-- <?php echo $vc_link_tipo_operacion ?>-->
        <select class="form-select form-control filter_tipo_operacion">
          <?php if ($vc_link_tipo_operacion == "emprendimientos") { ?>
            <option selected value="emprendimientos" data-id="4">Emprendimientos</option>
          <?php } else { ?>
            <?php $tipos_op = $propiedad_model->get_tipos_operaciones(array(
              "mostrar_todos"=>1,
            )); ?>
            <?php foreach ($tipos_op as $tipo) { ?>
              <?php if ($tipo->id > 3) continue; ?>
              <option <?php echo ($vc_link_tipo_operacion == $tipo->link)?"selected":"" ?> data-id="<?php echo $tipo->id ?>" value="<?php echo $tipo->link ?>"><?php echo $tipo->nombre ?></option>
            <?php } ?>
          <?php } ?>
        </select>

        <select id="filter_propiedad" class="form-select form-control filter_propiedad" name="tp">
          <option value="0">Propiedad</option>
          <?php $vc_tipo_inmueble = ""; ?>
          <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
          <?php foreach ($tipo_propiedades as $tipo) { ?>
            <?php if ($vc_id_tipo_inmueble == $tipo->id) $vc_tipo_inmueble = $tipo->nombre; ?>
            <option <?php echo ($vc_id_tipo_inmueble == $tipo->id)?"selected":"" ?> value="<?php echo $tipo->id ?>"><?php echo $tipo->nombre ?></option>
          <?php } ?>
        </select>

        <div class="multiple-checkbox drowdown-options mr5">
          <span>Precio</span>
          <a href="javascript:void(0)">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
              <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
            </svg>
          </a>
          <div class="checkbox-list checkbox-list-precios">
            <div class="p25">
              <label class="control-label">Filtrar por precio</label>
              <div class="checkbox-list-top">
                <div class="form-check">
                  <input <?php echo ($vc_moneda == "USD")?"checked":"" ?> name="m" class="form-check-input" type="radio" value="USD" id="monedaDolar">
                  <label class="form-check-label" for="monedaDolar">Dólares</label>
                </div>
                <div class="form-check">
                  <input <?php echo ($vc_moneda == "ARS")?"checked":"" ?> name="m" class="form-check-input" type="radio" value="ARS" id="monedaPeso">
                  <label class="form-check-label" for="monedaPeso">Pesos</label>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <input min="0" name="vc_minimo" type="number" value="<?php echo (empty($vc_minimo) ? "" : $vc_minimo) ?>" placeholder="Desde" class="form-control">
                </div>
                <div class="col-6">
                  <input min="0" name="vc_maximo" type="number" value="<?php echo (empty($vc_maximo) ? "" : $vc_maximo) ?>" placeholder="Hasta" class="form-control">
                </div>
              </div>
              <a href="javascript:void(0)" onclick="enviar_filtrar()" class="btn btn-green">Aplicar</a>
            </div>
          </div>
        </div>
        
        <div class="multiple-checkbox drowdown-options">
          <span>Otros filtros</span>
          <a href="javascript:void(0)">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
              <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
            </svg>
          </a>
          <div class="checkbox-list">

            <h6>Dormitorios</h6>
            <div class="checkbox-list-top">
              <div class="row">
                <div class="col-6">
                  <select id="filter_dormitorios" class="form-select form-control filter_dormitorios" name="dm">
                    <?php $dormitorios = $propiedad_model->get_dormitorios(); ?>
                    <option>Sin mínimo</option>
                    <?php foreach ($dormitorios as $dormitorio) { ?>
                      <?php if ($dormitorio->dormitorios > 0) { ?>
                        <option <?php echo ($vc_dormitorios == $dormitorio->dormitorios)?"selected":"" ?> value="<?php echo $dormitorio->dormitorios; ?>"><?php echo $dormitorio->dormitorios ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-6">
                  <select id="filter_dormitorios" class="form-select form-control filter_dormitorios" name="dm">
                    <?php $dormitorios = $propiedad_model->get_dormitorios(); ?>
                    <option>Sin máximo</option>
                    <?php foreach ($dormitorios as $dormitorio) { ?>
                      <?php if ($dormitorio->dormitorios > 0) { ?>
                        <option <?php echo ($vc_dormitorios == $dormitorio->dormitorios)?"selected":"" ?> value="<?php echo $dormitorio->dormitorios; ?>"><?php echo $dormitorio->dormitorios ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>

            <h6>Superficie</h6>
            <div class="checkbox-list-top">
              <div class="checkbox-list-top" style="border-bottom: none; padding-bottom: 5px; padding-left: 0px; width: 100%;">
                <div class="form-check">
                  <input <?php echo (isset($vc_tipo_superficie) && strtoupper($vc_tipo_superficie) == "C")?"checked":"" ?> name="tipo_superficie" class="form-check-input" type="radio" value="C" id="superficieCubierta">
                  <label class="form-check-label" for="superficieCubierta">Cubierta</label>
                </div>
                <div class="form-check">
                  <input <?php echo (isset($vc_tipo_superficie) && strtoupper($vc_tipo_superficie) == "T")?"checked":"" ?> name="tipo_superficie" class="form-check-input" type="radio" value="T" id="superficieTotal">
                  <label class="form-check-label" for="superficieTotal">Total</label>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <input min="0" name="superficie_minimo" type="number" value="<?php echo (isset($vc_superficie_minimo) && !empty($vc_superficie_minimo) ? $vc_superficie_minimo : "") ?>" placeholder="Desde" class="form-control">
                </div>
                <div class="col-6">
                  <input min="0" name="superficie_maximo" type="number" value="<?php echo (isset($vc_superficie_maximo) && !empty($vc_superficie_maximo) ? $vc_superficie_maximo : "") ?>" placeholder="Hasta" class="form-control">
                </div>
              </div>
            </div>

            <h6>Antiguedad</h6>
            <div class="checkbox-list-top">
              <div class="form-check">
                <?php 

                ?>
                <input class="form-check-input" <?php echo (antiguedad_seleccionada(array(-1)))?"checked":"" ?> type="checkbox" id="antiguedad_construccion">
                <label class="form-check-label" for="antiguedad_construccion">
                  En construcción
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" <?php echo (antiguedad_seleccionada(array(20)))?"checked":"" ?> type="checkbox" id="antiguedad_10_20">
                <label class="form-check-label" for="antiquedad_10_20">
                  Entre 10 y 20 años
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" <?php echo (antiguedad_seleccionada(array(1)))?"checked":"" ?> type="checkbox" id="antiguedad_estrenar">
                <label class="form-check-label" for="antiguedad_estrenar">
                  A estrenar
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" <?php echo (antiguedad_seleccionada(array(30,40,50)))?"checked":"" ?> type="checkbox" id="antiguedad_20_50">
                <label class="form-check-label" for="antiguedad_20_50">
                  Entre 20 y 50 años
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" <?php echo (antiguedad_seleccionada(array(2,5)))?"checked":"" ?> type="checkbox" id="antiguedad_5">
                <label class="form-check-label" for="antiguedad_5">
                  Hasta 5 años
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" <?php echo (antiguedad_seleccionada(array(60,70,80,90,100,200)))?"checked":"" ?> type="checkbox" id="antiguedad_50">
                <label class="form-check-label" for="antiguedad_50">
                  Más de 50 años
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" <?php echo (antiguedad_seleccionada(array(10)))?"checked":"" ?> type="checkbox" id="antiguedad_5_10">
                <label class="form-check-label" for="antiguedad_5_10">
                  Entre 5 y 10 años
                </label>
              </div>
            </div>

            <h6>Otros</h6> 
            <div class="checkbox-list-top">
              <div class="form-check">
                <input <?php echo ($vc_apto_banco == 1)?"checked":"" ?> class="form-check-input" type="checkbox" name="banco" value="1" id="flexCheckDefault7">
                <label class="form-check-label" for="flexCheckDefault7">
                  Apto crédito
                </label>
              </div>
              <div class="form-check">
                <input <?php echo ($vc_tiene_cochera > 0)?"checked":"" ?> class="form-check-input" type="checkbox" name="cochera" value="1" id="flexCheckDefault9">
                <label class="form-check-label" for="flexCheckDefault9">
                  Acepta permuta
                </label>
              </div>
            </div>

            <h6>Búsqueda por Código</h6>
            <div class="checkbox-list-bottom">
              <input name="superficie_minimo" type="text" value="<?php echo (isset($vc_superficie_minimo) && !empty($vc_superficie_minimo) ? $vc_superficie_minimo : "") ?>" placeholder="Ingrese el código de la propiedad" class="form-control">
            </div>

            <div class="dropdown-btn-block">
              <a href="javascript:void(0)" rel="nofollow" onclick="enviar_filtrar()" style="width: 100%; display: block; margin-left: 0px;" class="btn btn-green">Aplicar</a>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-green">Aplicar</button>
      </div>
    </form>
  </div>
</section>