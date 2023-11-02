<div class="section-title">
    <?php $titulo = $web_model->get_text('contacto-titulo', 'Comunicate con nosotros'); ?>
    <h2 class="editable" data-id="<?php echo $titulo->id; ?>" data-clave="<?php echo $titulo->clave; ?>">
        <?php echo $titulo->plain_text; ?>
    </h2>
    <?php $descripcion = $web_model->get_text('contacto-descripcion', 'Descripcion'); ?>
    <p class="editable" data-id="<?php echo $descripcion->id; ?>"
        data-clave="<?php echo $descripcion->clave; ?>">
        <?php echo $descripcion->plain_text; ?>
    </p>
</div>
<div class="contact-wrap">
    <div class="row">
        <div class="col-md-4 col-6">
            <div class="communicate-items">
                <img src="assets/images/map-logo.png" alt="Location">
                <?php $direccion = $web_model->get_text('direccion', 'DIRECCIÓN'); ?>
                <h3 class="editable" data-id="<?php echo $direccion->id; ?>"
                    data-clave="<?php echo $direccion->clave; ?>">
                    <?php echo $direccion->plain_text; ?>
                </h3>

                <p><?php echo $empresa->direccion; ?></p>
            </div>
        </div>
        <div class="col-md-4 col-6">
            <div class="communicate-items">
                <img src="assets/images/calendar.png" alt="Calendar">
                <?php $horarios = $web_model->get_text('horarios', 'HORARIOS'); ?>
                <h3 class="editable" data-id="<?php echo $horarios->id; ?>"
                    data-clave="<?php echo $horarios->clave; ?>">
                    <?php echo $horarios->plain_text; ?>
                </h3>
                <p><?php echo $empresa->horario; ?></p>
            </div>
        </div>
        <div class="col-md-4 col-6">
            <div class="communicate-items">
                <img src="assets/images/phone.png" alt="Phone">
                <?php $contacto = $web_model->get_text('contacto', 'CONTACTO'); ?>
                <h3 class="editable" data-id="<?php echo $contacto->id; ?>"
                    data-clave="<?php echo $contacto->clave; ?>">
                    <?php echo $contacto->plain_text; ?>
                </h3>
                <p class="d-flex flex-column">
                    <a href="tel:<?php echo $empresa->telefono; ?>"><?php echo $empresa->telefono; ?></a>
                    <a href="mailto:<?php echo $empresa->email; ?>"><?php echo $empresa->email; ?></a>
                </p>
            </div>
        </div>
    </div>
</div>