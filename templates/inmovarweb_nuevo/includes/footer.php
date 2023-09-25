<footer>
	<div class="container">
		<?php if (!empty($empresa->logo_1)) {   ?>
			<a href="<?php echo mklink ("/") ?>" class="logo"><img src="/admin/<?php echo $empresa->logo_1 ?>" alt="Logo"></a>
		<?php } ?>
		<ul class="quick-links">
			<?php $info = $entrada_model->get_list(array("categoria"=>"informacion","offset"=>2))?>
			<?php foreach ($info as $i) { ?>
				<li><a href="<?php echo mklink ($i->link) ?>"><?php echo $i->titulo ?></a></li>
			<?php }?>
		</ul>
		<ul class="socials-links">
			<?php if (!empty($empresa->facebook)) {  ?><li class="fb"><a href="<?php echo $empresa->facebook ?>" target="_blank"></a></li><?php } ?>
			<?php if (!empty($empresa->instagram)) {  ?>
				<li class="insta"><a href="<?php echo $empresa->instagram ?>" target="_blank"></a></li>
			<?php } ?>
		</ul>
		<span><b>Inmovar <?php echo date("Y") ?>.</b> Todos Los Derechos Reservados</span>
	</div>
</footer>
