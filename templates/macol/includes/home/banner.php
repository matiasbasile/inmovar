<section class="banner">
    <div class="owl-carousel" data-items="1" data-items-xl="1" data-items-lg="1" data-items-md="1" data-items-sm="1"
        data-margin="0" data-nav="false" data-dots="true">
        <div class="item" style="background: url(assets/images/banner.png) no-repeat 50% 50% /cover;">
        </div>
        <div class="item" style="background: url(assets/images/banner.png) no-repeat 50% 50% /cover;">
        </div>
        <div class="item" style="background: url(assets/images/banner.png) no-repeat 50% 50% /cover;">
        </div>
    </div>
    <div class="container">
        <div class="banner-title">
            <?php $banner_title = $web_model->get_text('banner_title', 'Bienvenidos Macol Inmobiliaria'); ?>
            <span class="editable" data-id="<?php echo $banner_title->id; ?>"
                data-clave="<?php echo $banner_title->clave; ?>">
                <?php echo $banner_title->plain_text; ?>
            </span>
            <?php $banner_desc = $web_model->get_text('banner_desc', 'Encontrá la propiedad que buscas'); ?>
            <h1 class="editable title" data-id="<?php echo $banner_desc->id; ?>"
                data-clave="<?php echo $banner_desc->clave; ?>">
                <?php echo $banner_desc->plain_text; ?>
            </h1>
            <form id="form_buscador" onsubmit="return filtrar()">
                <input type="hidden" class="base_url"
                    value="<?php echo isset($buscador_mapa) ? mklink('mapa/') : mklink('propiedades/'); ?>" />
                <div class="form-wrap">
                    <div class="form-group">
                        <select id="filter_localidad" class="form-control filter_localidad">
                            <option value="">Localidad</option>
                            <?php $localidades = $propiedad_model->get_localidades(); ?>
                            <?php foreach ($localidades as $localidad) { ?>
                            <option value="<?php echo $localidad->link; ?>"><?php echo $localidad->nombre; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control filter_tipo_operacion">
                            <option value="">Tipo de Operación</option>
                            <?php $tipo_operaciones = $propiedad_model->get_tipos_operaciones(); ?>
                            <?php foreach ($tipo_operaciones as $tipo) { ?>
                            <option value="<?php echo $tipo->link; ?>"><?php echo $tipo->nombre; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control filter_propiedad" id="filter_propiedad" name="tp">
                            <option value="">Tipo de Propiedad</option>
                            <?php $tipo_propiedades = $propiedad_model->get_tipos_propiedades(); ?>
                            <?php foreach ($tipo_propiedades as $tipo) { ?>
                            <option value="<?php echo $tipo->id; ?>"><?php echo $tipo->nombre; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="button" id="submitButton" onclick="enviar_filtrar(true)" class="btn">Buscar <span><img
                                src="assets/images/search.png" alt="Search"></span></button>
                </div>
            </form>
        </div>
    </div>
</section>