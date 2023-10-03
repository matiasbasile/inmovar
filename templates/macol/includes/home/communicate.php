<section class="communicate">
    <div class="container">
        <div class="section-title">
            <?php $communicate_title = $web_model->get_text('communicate_title', 'Comunicate con nuestro <span>Staff</span>'); ?>
            <h2 class="editable" data-id="<?php echo $communicate_title->id; ?>"
                data-clave="<?php echo $communicate_title->clave; ?>">
                <?php echo $communicate_title->plain_text; ?>
            </h2>
            <?php $communicate_desc = $web_model->get_text('communicate_desc', 'Nuestro equipo te brindará la mejor atención'); ?>
            <p class="editable" data-id="<?php echo $communicate_desc->id; ?>"
                data-clave="<?php echo $communicate_desc->clave; ?>">
                <?php echo $communicate_desc->plain_text; ?>
            </p>
        </div>
        <div class="row">
            <?php $usuarios = $usuario_model->get_list(); ?>
            <?php foreach ($usuarios as $u) { ?>
            <div class="col-xl-4 col-md-6">
                <div class="communicate-item">
                    <img src="<?php echo $u->path; ?>" alt="Communicate" width="150px">
                    <h3><?php echo $u->nombre/* .' '.$u->apellido */; ?></h3>
                    <p><?php echo $u->cargo; ?></p>
                    <ul>
                        <li><a href="https://instagram.com/<?php echo $u->instagram; ?>"><img
                                    src="assets/images/insta.png" alt="Instagram"></a></li>
                        <li><a href="https://instagram.com/<?php echo $u->facebook; ?>" alt="Facebook"><img
                                    src="assets/images/facebook.png" alt="Facebook"></a></li>
                    </ul>
                    <div class="btn-block">
                        <?php $contacto_whatsapp = preg_replace('/[^0-9]/', '', $u->telefono); ?>
                        <a href="mailto:<?php echo $u->email; ?>" class="btn btn-small btn-icon"><img
                                src="assets/images/email.png" alt="Mail">Correo</a>
                        <a href="https://wa.me/<?php echo $contacto_whatsapp; ?>"
                            class="btn btn-small btn-black btn-icon"><img src="assets/images/whatsapp1.png"
                                alt="Whatsapp">Whatsapp</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>