<section class="communicate-us-two">
    <div class="container">
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
        <div class="form-wrap form-wrap-two form-wrap-three">
            <div class="section-title">
                <?php $consulta = $web_model->get_text('consulta', 'Envía una consulta'); ?>
                <h2 class="editable" data-id="<?php echo $consulta->id; ?>"
                    data-clave="<?php echo $consulta->clave; ?>">
                    <?php echo $consulta->plain_text; ?>
                </h2>
            </div>
            <form id="contactForm">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input id="contacto_nombre" class="form-control" type="text" placeholder="Nombre">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input id="contacto_email" class="form-control" type="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input id="contacto_telefono" class="form-control" type="text"
                                placeholder="Whatsapp (Cod. área sin 0 ni 15)">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <select name="" id="contacto_asunto" class="form-control">
                                <option value="">Asunto</option>
                                <?php $asuntos = explode(';;;', $empresa->asuntos_contacto); ?>
                                <?php foreach ($asuntos as $a) { ?>
                                <option><?php echo $a; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <textarea id="contacto_mensaje" placeholder="Mensaje" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="btn-block">
                    <button type="submit" id="contacto_submit" class="btn">enviar consulta</button>
                </div>
            </form>
        </div>
    </div>
</section>