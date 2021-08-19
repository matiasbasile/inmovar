<style type="text/css">
.gracias { min-height: 500px; clear: both; }
.gracias .pt100 { padding-top: 100px; padding-bottom: 100px }
.gracias h2 { font-weight: 800 }
.gracias .fa-check { font-size: 40px !important; color: #19ba55 !important }
.gracias a { color: #19ba55 }
.gracias a:hover { text-decoration: none }
.text-center  { text-align: center; }
</style>

<div class="container gracias">
	<div class="row m0">
		<div class="col-md-12 text-center pt100">
			<?php $t = $web_model->get_text("gracias-titulo","GRACIAS!")?>
			<h2 class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
				<?php echo $t->plain_text ?>
			</h2>
			<i class="fa fa-check"></i>
			<?php $t = $web_model->get_text("gracias-texto","Muchas gracias por contactarse con nosotros! Le responderemos a la brevedad")?>
			<p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>">
				<?php echo $t->plain_text ?>
			</p>
			<a href="<?php echo mklink ("/") ?>">Ir a la página principal</a>
		</div>
	</div>
</div>


<?php if (!empty($empresa->seguimiento_contacto)) { echo html_entity_decode($empresa->seguimiento_contacto,ENT_QUOTES); } ?>
