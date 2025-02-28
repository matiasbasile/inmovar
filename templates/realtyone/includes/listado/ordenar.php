<div class="sort">
  <div class="inner-text">
    <h4><?php echo (isset($menu_active) ? $menu_active : "Propiedades") ?></h4>
    <p>
      <strong id="pagina_inicio"><?php echo ((($vc_page+1) * $vc_offset) - ($vc_offset-1)) ?></strong> a 
      <?php $ultimo = (($vc_page+1) * $vc_offset); ?>
      <strong id="pagina_fin"><?php echo (($ultimo > $vc_total_resultados) ? $vc_total_resultados : $ultimo) ?></strong> de 
      <strong id="total_resultados"><?php echo $vc_total_resultados ?></strong> 
      Propiedades 
    </p>
  </div>

  <div class="right-text">
    <p>Ordenar por</p>

    <select onchange="set_order()" id="orden" class="form-select form-control">
      <option <?php echo($vc_orden == 8)?"selected":"" ?> value="8">Destacadas</option>
      <option <?php echo($vc_orden == 7)?"selected":"" ?> value="7">Más Nuevas</option>
      <option <?php echo($vc_orden == 11)?"selected":"" ?> value="11">Más Antiguas</option>
      <option <?php echo($vc_orden == 2)?"selected":"" ?> value="2">Menor Precio</option>
      <option <?php echo($vc_orden == 1)?"selected":"" ?> value="1">Mayor Precio</option>
    </select>

    <div class="location">
      <a onclick="buscar_listado()" href="javascript:void(0)" rel="nofollow" class="listing <?php echo ($vc_view == 1)?"green":"" ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
        </svg>
      </a>
      <a onclick="buscar_mapa()" href="javascript:void(0)" rel="nofollow" class="<?php echo ($vc_view == 0)?"green":"" ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
          <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
        </svg>
      </a>
    </div>

  </div>
  
</div>