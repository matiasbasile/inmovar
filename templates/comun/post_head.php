<?php if (!empty($empresa->marca_agua)) { ?>
<style type="text/css">
.marca_agua, .fancybox-content { position: relative; }
.marca_agua:after, .fancybox-content:after { content:" ";z-index:1;width:100%; height:100%; position:absolute;top:0;left:0;right:0;bottom:0;background-image: url("/admin/<?php echo $empresa->marca_agua ?>");background-repeat: no-repeat; background-size: 50%; }
<?php if ($empresa->marca_agua_posicion == 1) { ?>
  .marca_agua:after, .fancybox-content:after { background-position: bottom left; }
<?php } else if ($empresa->marca_agua_posicion == 2) { ?>
  .marca_agua:after, .fancybox-content:after { background-position: bottom center; }
<?php } else if ($empresa->marca_agua_posicion == 3) { ?>
  .marca_agua:after, .fancybox-content:after { background-position: bottom right; }
<?php } else if ($empresa->marca_agua_posicion == 5) { ?>
  .marca_agua:after, .fancybox-content:after { background-position: center center; }
<?php } else if ($empresa->marca_agua_posicion == 7) { ?>
  .marca_agua:after, .fancybox-content:after { background-position: top left; }
<?php } else if ($empresa->marca_agua_posicion == 8) { ?>
  .marca_agua:after, .fancybox-content:after { background-position: top center; }
<?php } else if ($empresa->marca_agua_posicion == 9) { ?>
  .marca_agua:after, .fancybox-content:after { background-position: top right; }
<?php } else if ($empresa->marca_agua_posicion == 10) { ?>
  .marca_agua:after, .fancybox-content:after { background-position: center center; background-size: contain; }
<?php } ?>
</style>
<?php } ?>

<script type="text/javascript" src="/admin/resources/js/common.js"></script>
<?php if (!empty($empresa->analytics)) { echo html_entity_decode($empresa->analytics,ENT_QUOTES); } ?>
<?php if (!empty($empresa->zopim)) { echo html_entity_decode($empresa->zopim,ENT_QUOTES); } ?>
<?php if (!empty($empresa->google_site_verification)) { echo html_entity_decode($empresa->google_site_verification,ENT_QUOTES); } ?>
<?php if (!empty($empresa->adsense)) { echo html_entity_decode($empresa->adsense,ENT_QUOTES); } ?>
<?php if (!empty($empresa->pixel_fb)) { echo html_entity_decode($empresa->pixel_fb,ENT_QUOTES); } ?>
<?php if (!empty($empresa->remarketing)) { echo html_entity_decode($empresa->remarketing,ENT_QUOTES); } ?>
<script type="text/javascript">
// Constantes que se utilizan en el sistema
const ID_EMPRESA = "<?php echo $empresa->id ?>";
const CURRENT_URL = "<?php echo current_url(); ?>";
</script>
<?php if (!empty($empresa->texto_css)) { ?>
<style type="text/css"><?php echo $empresa->texto_css ?></style>
<?php } ?>