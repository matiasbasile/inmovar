<form id="form_propiedades" onsubmit="return filtrar(this)" class="ts-form p-3 my-5 ts-border-radius__md <?php echo ($page_act == "home")?'ts-borderless-inputs':''?>" data-bg-color="rgba(255,255,255,.9)">
	<a href="#more-options-collapse" class="ts-form-advanced-search ts-circle collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="more-options-collapse">
		<i class="fa fa-plus ts-visible-on-collapsed"></i>
		<i class="fa fa-minus ts-visible-on-uncollapsed"></i>
	</a>
  <!-- <div class="position-absolute ts-bottom__0 ts-push-down__100 pl-4 ml-1 pt-3 ts-z-index__-1">
    <img src="assets/img/arrow.svg" alt="" class="ts-opacity__50">
    <small class="text-white pl-1 ts-push-down__50 d-inline-block">Más Opciones</small>
  </div> -->
  <div class="row no-gutters">
  	<div class="col-sm-6 col-md-2">
  		<div class="form-group my-2">
  			<input type="text" id="filter_codigo" class="form-control filter_codigo" name="cod" value="<?php echo isset($vc_codigo)?$vc_codigo:"" ?>" placeholder="Buscar por c&oacute;digo" />
  		</div>
  	</div>
  	<div class="col-sm-6 col-md-3">
  		<select class="custom-select my-2 border-left" id="tipo_operacion">
          <option value="">Tipo de Operación</option>
  			<?php $filter_tipos_operacion = $propiedad_model->get_tipos_operaciones();
  			foreach($filter_tipos_operacion as $r) { ?>
  				<option <?php echo (isset($vc_link_tipo_operacion) && $vc_link_tipo_operacion == $r->link) ? "selected":"" ?> value="<?php echo $r->link ?>"><?php echo $r->nombre ?></option>
  			<?php } ?>
  		</select>
  	</div>
  	<div class="col-sm-6 col-md-3">
  		<select id="localidad"  class="custom-select my-2 border-left" >
  			<option value="0">Localidad</option>
  			<?php $filter_localidades = $propiedad_model->get_localidades();
  			foreach($filter_localidades as $r) { ?>
  				<option <?php echo (isset($vc_link_localidad) && $vc_link_localidad == $r->link) ? "selected":"" ?> value="<?php echo $r->link ?>"><?php echo $r->nombre ?></option>
  			<?php } ?>
  		</select>
  	</div>
  	<div class="col-sm-6 col-md-4">
  		<div class="row no-gutters">
  			<div class="col-sm-6">
  				<select class="custom-select my-2 border-left" name="tp">
  					<option value="0">Tipo de Propiedad</option>
  					<?php $filter_tipos_propiedades = $propiedad_model->get_tipos_propiedades();
  					foreach($filter_tipos_propiedades as $r) { ?>
  						<option <?php echo (isset($vc_id_tipo_inmueble) && $vc_id_tipo_inmueble == $r->id) ? "selected":"" ?> value="<?php echo $r->id ?>"><?php echo $r->nombre ?></option>
  					<?php } ?>
  				</select>
  			</div>
  			<div class="col-sm-6">
  				<div class="form-group my-2">
  					<button type="submit" class="btn btn-primary w-100" id="search-btn">Buscar</button>
  				</div>
  			</div>
  		</div>
  	</div>
  </div>
  <div class="collapse text-left" id="more-options-collapse">
  	<div class="py-4">
  		<div class="form-row">
  			<div class="col-sm-2">
  				<div class="form-group">
  				  <label for="garages">Precio Mínimo</label>
            <div style="display: flex; justify-content: center; align-items: center;">
              <select style="width: 80px; align-self: center;" class="custom-select border-left" id="moneda_precio_minimo" onchange="cambiar_moneda_precio_minimo()" name="m">
              <option <?php echo (isset($vc_moneda) && $vc_moneda == "ARS")?"selected":"" ?> value="ARS">$</option>
              <option <?php echo (isset($vc_moneda) && $vc_moneda == "USD")?"selected":"" ?> value="USD">USD</option>
            </select>
            <input style="align-self: center;" class="form-control" placeholder="" id="precio_minimo" type="text" name="vc_minimo" value="<?php echo (isset($vc_minimo) ? (($vc_minimo == 0)?"":$vc_minimo) : "") ?>">  
            </div>
  				</div>
  			</div>
  			<div class="col-sm-2">
  				<div class="form-group">
  					<label for="garages">Precio Máximo</label>
            <div style="display: flex;justify-content: center;align-items: center;">
              <select style="align-self: center; width: 80px" class="custom-select border-left" id="moneda_precio_maximo" onchange="cambiar_moneda_precio_maximo()">
                <option <?php echo (isset($vc_moneda) && $vc_moneda == "ARS")?"selected":"" ?> value="ARS">$</option>
                <option <?php echo (isset($vc_moneda) && $vc_moneda == "USD")?"selected":"" ?> value="USD">USD</option>
              </select>  
  				    <input style="align-self: center;" class="form-control" placeholder="" id="precio_maximo" type="text" name="vc_maximo" value="<?php echo (isset($vc_maximo) ? (($vc_maximo == 0)?"":$vc_maximo) : "") ?>">
            </div>
  				</div>
  			</div>
        <div class="col-sm-2">
          <div class="form-group">
            <label for="bedrooms">Habitaciones</label>
            <select class="custom-select my2 border-left" name="dm">
              <?php $filter_dormitorios = $propiedad_model->get_dormitorios();
              foreach($filter_dormitorios as $r) { ?>
                <option <?php echo (isset($vc_dormitorios) && $vc_dormitorios == $r->dormitorios) ? "selected":"" ?> value="<?php echo $r->dormitorios ?>"><?php echo $r->dormitorios ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="form-group">
            <label for="bathrooms">Baños</label>
            <select class="custom-select my2 border-left" name="bn">
              <?php $filter_banios = $propiedad_model->get_banios();
              foreach($filter_banios as $r) { ?>
                <option <?php echo (isset($vc_banios) && $vc_banios == $r->banios) ? "selected":"" ?> value="<?php echo $r->banios ?>"><?php echo $r->banios ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="form-group">
            <label for="bathrooms">Cocheras</label>
            <select class="custom-select my2 border-left" name="gar">
              <?php $filter_cocheras = $propiedad_model->get_cocheras();
              foreach($filter_cocheras as $r) { ?>
                <option <?php echo (isset($vc_cocheras) && $vc_cocheras == $r->cocheras) ? "selected":"" ?> value="<?php echo $r->cocheras ?>"><?php echo $r->cocheras ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
  		</div>
  	</div>
  </div>
</form>
<script>
function cambiar_moneda_precio_minimo() {
  var v = $("#moneda_precio_minimo").val();
  $("#moneda_precio_maximo").val(v);
}
function cambiar_moneda_precio_maximo() {
  var v = $("#moneda_precio_maximo").val();
  $("#moneda_precio_minimo").val(v);
}

function filtrar() { 
  var link = "<?php echo mklink("propiedades/")?>";
  var tipo_operacion = $("#tipo_operacion").val();
  var localidad = $("#localidad").val();
  link = link + tipo_operacion + "/" + localidad + "/";
  $("#form_propiedades").attr("action",link);
  return true;
}
</script>