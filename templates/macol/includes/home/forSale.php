<section class="for-sale">
    <div class="container">
        <div class="section-title">
            <?php $sale_title = $web_model->get_text('sale_title', 'Más de <span>10.000 propiedades</span> a la venta'); ?>
            <h2 class="editable" data-id="<?php echo $sale_title->id; ?>"
                data-clave="<?php echo $sale_title->clave; ?>">
                <?php echo $sale_title->plain_text; ?>
            </h2>
            <?php $sale_desc = $web_model->get_text('sale_desc', 'Encontrá las mejores opciones para comprar, alquilar o vender propiedades'); ?>
            <p class="editable" data-id="<?php echo $sale_desc->id; ?>" data-clave="<?php echo $sale_desc->clave; ?>">
                <?php echo $sale_desc->plain_text; ?>
            </p>
        </div>
        <div class="row gy-4">
            <div class="col-md-4 col-sm-6">
                <a href="<?php echo mklink("propiedades/ventas/") ?>" class="sale-item">
                    <span><img src="assets/images/sale1.png" alt="Sale"></span>
                    <?php $buy_title = $web_model->get_text('buy_title', 'Comprar'); ?>
                    <h3 class="editable" data-id="<?php echo $buy_title->id; ?>"
                        data-clave="<?php echo $buy_title->clave; ?>">
                        <?php echo $buy_title->plain_text; ?>
                    </h3>
                    <?php $buy_desc = $web_model->get_text('buy_desc', 'Explora nuestra amplia selección de propiedades en venta y elige con confianza con la ayuda de
                        expertos'); ?>
                    <p class="editable" data-id="<?php echo $buy_desc->id; ?>"
                        data-clave="<?php echo $buy_desc->clave; ?>">
                        <?php echo $buy_desc->plain_text; ?>
                    </p>
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="<?php echo mklink("entradas/vender/") ?>" class="sale-item">
                    <span><img src="assets/images/sale2.png" alt="Sale"></span>
                    <?php $sell_title = $web_model->get_text('sell_title', 'Vender'); ?>
                    <h3 class="editable" data-id="<?php echo $sell_title->id; ?>"
                        data-clave="<?php echo $sell_title->clave; ?>">
                        <?php echo $sell_title->plain_text; ?>
                    </h3>
                    <?php $sell_desc = $web_model->get_text('sell_desc', 'Explora nuestros alquileres flexibles y descubre un nuevo mundo de posibilidades en el lugar que
                        deseas'); ?>
                    <p class="editable" data-id="<?php echo $sell_desc->id; ?>"
                        data-clave="<?php echo $sell_desc->clave; ?>">
                        <?php echo $sell_desc->plain_text; ?>
                    </p>
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="<?php echo mklink("propiedades/alquileres/") ?>" class="sale-item">
                    <span><img src="assets/images/sale3.png" alt="Sale"></span>
                    <?php $alq_title = $web_model->get_text('alq_title', 'Alquilar'); ?>
                    <h3 class="editable" data-id="<?php echo $alq_title->id; ?>"
                        data-clave="<?php echo $alq_title->clave; ?>">
                        <?php echo $alq_title->plain_text; ?>
                    </h3>
                    <?php $alq_desc = $web_model->get_text('alq_desc', 'Confía en nuestro equipo para una venta rápida y efectiva, llegando a una amplia audiencia de
                        compradores'); ?>
                    <p class="editable" data-id="<?php echo $alq_desc->id; ?>"
                        data-clave="<?php echo $alq_desc->clave; ?>">
                        <?php echo $alq_desc->plain_text; ?>
                    </p>
                </a>
            </div>
        </div>
    </div>
</section>