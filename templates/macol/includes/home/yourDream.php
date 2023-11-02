<section class="your-dream">
    <div class="container">
        <div class="section-title">
            <?php $dream_title = $web_model->get_text('dream_title', 'Tu mejor aliado para <span>encontrar el hogar</span> de tus sueños'); ?>
            <h2 class="editable" data-id="<?php echo $dream_title->id; ?>"
                data-clave="<?php echo $dream_title->clave; ?>">
                <?php echo $dream_title->plain_text; ?>
            </h2>
            <?php $dream_desc = $web_model->get_text('dream_desc', 'Nuestro equipo de expertos en bienes raíces está comprometido en brindarte un servicio personalizado y de
                calidad, guiándote en cada paso del proceso de compra o venta de tu propiedad. Contamos con una amplia
                selección de casas, apartamentos y terrenos en las ubicaciones más atractivas y en diversos rangos de
                precios para adaptarnos a tus necesidades.'); ?>
            <p class="editable" data-id="<?php echo $dream_desc->id; ?>" data-clave="<?php echo $dream_desc->clave; ?>">
                <?php echo $dream_desc->plain_text; ?>
            </p>
            <?php $dream_button = $web_model->get_text('dream_button', '¡Contáctanos hoy mismo!'); ?>
            <a class="editable btn" data-id="<?php echo $dream_button->id; ?>"
                data-clave="<?php echo $dream_button->clave; ?>" href="<?php echo mklink("contacto/") ?>">
                <?php echo $dream_button->plain_text; ?>
            </a>
        </div>
    </div>
</section>