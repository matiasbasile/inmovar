<section class="communicate-us">
    <div class="row gy-5 gx-0 align-items-center">
        <div class="col-xl-6">
            <div class="form-wrap form-wrap-two">
                <div class="section-title">
                    <h2>Comunicate con nosotros</h2>
                </div>
                <form id="contactForm">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input id="contacto_nombre" class="form-control" type="text"
                                    placeholder="Nombre completo">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input id="contacto_telefono" class="form-control" type="text"
                                    placeholder="Whatsapp (sin 0 ni 15)">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input id="contacto_email" class="form-control" type="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">

                                <select id="contacto_asunto" class="form-control">
                                    <option value="">Elija asunto</option>
                                    <?php $asuntos = explode(';;;', $empresa->asuntos_contacto); ?>
                                    <?php foreach ($asuntos as $a) { ?>
                                    <option><?php echo $a; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <textarea id="contacto_mensaje" placeholder="Escriba sus comentarios"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <button id="contacto_submit" class="btn">enviar consulta</button>
                </form>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="img-wrap"> <img src="assets/images/communicate-us.png" alt="Communicate"></div>
        </div>
    </div>
</section>