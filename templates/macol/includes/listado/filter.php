<section class="filter">
    <div class="container">
        <form id="form_buscador" onsubmit="return filtrar()" method="get">
            <input type="hidden" name="orden" value="" id="ordenFilter" />
            <input type="hidden" class="base_url"
                value="<?php echo isset($buscador_mapa) ? mklink('mapa/') : mklink('propiedades/'); ?>" />
            <input type="hidden" id="tipo_operacion" class="filter_tipo_operacion"
                value="<?php echo $vc_link_tipo_operacion; ?>">
            <div class="form-wrap">
                <div class="form-group">
                    <select onchange="enviar_filtrar()" id="filter_localidad"
                        class="form-control filterSelect filter_localidad">
                        <option value="">Localidad</option>
                        <?php $localidades = $propiedad_model->get_localidades(); ?>
                        <?php foreach ($localidades as $localidad) { ?>
                        <option <?php echo ($localidad->link == $vc_link_localidad) ? 'selected' : ''; ?>
                            value="<?php echo $localidad->link; ?>"><?php echo $localidad->nombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <select onchange="enviar_filtrar()" id="filter_propiedad"
                        class="form-control filterSelect filter_propiedad" name="tp">
                        <option value="">Tipo de Propiedad</option>
                        <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
                        <?php foreach ($tipo_propiedades as $tipo) { ?>
                        <option <?php echo ($vc_id_tipo_inmueble == $tipo->id) ? 'selected' : ''; ?>
                            value="<?php echo $tipo->id; ?>"><?php echo $tipo->nombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <select onchange="enviar_filtrar()" id="filter_dormitorios"
                        class="form-control filterSelect filter_dormitorios" name="dm">
                        <option value="">Dormitorios</option>
                        <?php $dormitorios = $propiedad_model->get_dormitorios(); ?>
                        <?php foreach ($dormitorios as $dormitorio) { ?>
                        <option <?php echo ($vc_dormitorios == $dormitorio->dormitorios) ? 'selected' : ''; ?>
                            value="<?php echo $dormitorio->dormitorios; ?>">
                            <?php echo $dormitorio->dormitorios; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <select onchange="enviar_filtrar()" id="filter_banios" class="form-control filterSelect filter_banios"
                        name="bn">
                        <option value="">Baños</option>
                        <?php $banios = $propiedad_model->get_banios(); ?>
                        <?php foreach ($banios as $banio) { ?>
                        <option <?php echo ($vc_banios == $banio->banios) ? 'selected' : ''; ?>
                            value="<?php echo $banio->banios; ?>">
                            <?php echo $banio->banios; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <select onchange="enviar_filtrar()" id="filter_rango_precios" class="form-control filterSelect">
                        <option value="">Precios</option>
                        <?php if ($vc_link_tipo_operacion == 'alquileres') { ?>
                        <option <?php echo (isset($vc_maximo) && $vc_maximo == 25000) ? 'selected' : ''; ?> data-min="0"
                            data-max="25000">$ 0 - 25.000</option>
                        <option <?php echo (isset($vc_maximo) && $vc_maximo == 50000) ? 'selected' : ''; ?> data-min="25000"
                            data-max="50000">$ 25.000 - 50.000</option>
                        <option <?php echo (isset($vc_maximo) && $vc_maximo == 75000) ? 'selected' : ''; ?> data-min="50000"
                            data-max="75000">$ 50.000 - 75.000</option>
                        <option <?php echo (isset($vc_maximo) && $vc_maximo == 100000) ? 'selected' : ''; ?>
                            data-min="75000" data-max="100000">$ 75.000 - 100.000</option>
                        <option <?php echo (isset($vc_maximo) && $vc_maximo == 150000) ? 'selected' : ''; ?>
                            data-min="100000" data-max="150000">$ 100.000 - 150.000</option>
                        <option <?php echo (isset($vc_maximo) && $vc_maximo == 999999) ? 'selected' : ''; ?>
                            data-min="150000" data-max="999999">Más de $ 300.000</option>
                        <?php } else { ?>
                        <option <?php echo (isset($vc_maximo) && $vc_maximo == 25000) ? 'selected' : ''; ?> data-min="0"
                            data-max="25000">U$S 0 - 25.000</option>
                        <option <?php echo (isset($vc_maximo) && $vc_maximo == 50000) ? 'selected' : ''; ?> data-min="25000"
                            data-max="50000">U$S 25.000 - 50.000</option>
                        <option <?php echo (isset($vc_maximo) && $vc_maximo == 75000) ? 'selected' : ''; ?> data-min="50000"
                            data-max="75000">U$S 50.000 - 75.000</option>
                        <option <?php echo (isset($vc_maximo) && $vc_maximo == 100000) ? 'selected' : ''; ?>
                            data-min="75000" data-max="100000">U$S 75.000 - 100.000</option>
                        <option <?php echo (isset($vc_maximo) && $vc_maximo == 125000) ? 'selected' : ''; ?>
                            data-min="100000" data-max="125000">U$S 100.000 - 125.000</option>
                        <option <?php echo (isset($vc_maximo) && $vc_maximo == 150000) ? 'selected' : ''; ?>
                            data-min="125000" data-max="150000">U$S 125.000 - 150.000</option>
                        <option <?php echo (isset($vc_maximo) && $vc_maximo == 200000) ? 'selected' : ''; ?>
                            data-min="150000" data-max="200000">U$S 150.000 - 200.000</option>
                        <option <?php echo (isset($vc_maximo) && $vc_maximo == 300000) ? 'selected' : ''; ?>
                            data-min="200000" data-max="300000">U$S 200.000 - 300.000</option>
                        <option <?php echo (isset($vc_maximo) && $vc_maximo == 999999) ? 'selected' : ''; ?>
                            data-min="300000" data-max="999999">Más de U$S 300.000</option>
                        <input type="hidden" id="filter_moneda" name="m"
                            value="<?php echo !empty($vc_moneda) ? $vc_moneda : ($vc_link_tipo_operacion == 'alquileres' ? 'ARS' : 'USD'); ?>">
                        <input name="vc_minimo" id="filter_minimo" class="form-control filter_minimo" type="hidden"
                            value="<?php echo empty($vc_minimo) ? '' : $vc_minimo; ?>" min="0" placeholder="Precio Minimo">
                        <input name="vc_maximo" id="filter_maximo" class="form-control filter_maximo" type="hidden"
                            value="<?php echo empty($vc_maximo) ? '' : $vc_maximo; ?>" min="0" placeholder="Precio Maximo">
                        <?php } ?>
                    </select>
                </div>
                <button type="reset" onclick="resetear()" class="btn">limpiar</button>
            </div>
        </form>
    </div>
</section>