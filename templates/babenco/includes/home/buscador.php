<div class="tabs">
  <ul class="nav nav-tabs" id="myTabContent" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="Comprar-tab" data-bs-toggle="tab" data-bs-target="#Comprar" type="button" role="tab" aria-controls="Comprar" aria-selected="true"><img src="assets/images/tab-arrow.png" alt="Arrow"> La Plata</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="Alquilar-tab" data-bs-toggle="tab" data-bs-target="#Alquilar" type="button" role="tab" aria-controls="Alquilar" aria-selected="false"><img src="assets/images/tab-arrow.png" alt="Arrow"> Punta del Este</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="Comprar" role="tabpanel" aria-labelledby="Comprar-tab">
      <form action="<?php echo URL_LA_PLATA ?>propiedades/" onsubmit="return filtrar_principal(this)">

        <div class="select-box">
          <label>Tipo de Operación</label>
          <select class="form-control operacion">
            <option value="ventas">Venta</option>
            <option value="alquileres">Alquiler</option>
          </select>
        </div>

        <div class="select-box">
          <label>Localidad, Barrio o Zona</label>
          <select class="form-control localidad">
            <option value="">Localidad</option>
            <?php $localidades = $propiedad_model->get_localidades(); ?>
            <?php foreach ($localidades as $localidad) { ?>
              <option value="<?php echo $localidad->link ?>"><?php echo $localidad->nombre ?></option>
            <?php } ?>
          </select>
        </div>
        
        <div class="select-box">
          <label>tipo de Propiedad</label>
          <select class="form-control" name="tp">
            <option value="">Tipo</option>
            <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
            <?php foreach ($tipo_propiedades as $tipo) { ?>
              <option value="<?php echo $tipo->id ?>"><?php echo $tipo->nombre ?></option>
            <?php } ?>
          </select>
        </div>
        <button type="submit" class="btn btn-red">Buscar</button>
      </form>
    </div>
    <div class="tab-pane fade" id="Alquilar" role="tabpanel" aria-labelledby="Alquilar-tab">
      <form action="<?php echo URL_URUGUAY ?>propiedades/" onsubmit="return filtrar_principal(this)">

        <div class="select-box">
          <label>Tipo de Operación</label>
          <select class="form-control operacion">
            <option value="ventas">Venta</option>
            <option value="alquileres">Alquiler</option>
          </select>
        </div>

        <div class="select-box">
          <label>Localidad, Barrio o Zona</label>
          <select class="form-control localidad">
            <option value="">Localidad</option>
            <?php $localidades = $propiedad_model->get_localidades(); ?>
            <?php foreach ($localidades as $localidad) { ?>
              <option value="<?php echo $localidad->link ?>"><?php echo $localidad->nombre ?></option>
            <?php } ?>
          </select>
        </div>
        
        <div class="select-box">
          <label>tipo de Propiedad</label>
          <select class="form-control" name="tp">
            <option value="">Propiedad</option>
            <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
            <?php foreach ($tipo_propiedades as $tipo) { ?>
              <option value="<?php echo $tipo->id ?>"><?php echo $tipo->nombre ?></option>
            <?php } ?>
          </select>
        </div>

        <button type="submit" class="btn btn-red">Buscar</button>
      </form>
    </div>
  </div>
</div>