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