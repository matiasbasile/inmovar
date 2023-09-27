<base href="/frontend/<?php echo $empresa->template_path ?>/"/>
<meta charset="utf-8">
<title><?php echo (isset($seo_title)) ? utf8_encode(html_entity_decode($seo_title,ENT_QUOTES)) : utf8_encode(html_entity_decode($empresa->seo_title,ENT_QUOTES)); ?></title>
<meta name="description" content="<?php echo (isset($seo_description)) ? utf8_encode(html_entity_decode($seo_description,ENT_QUOTES)) : utf8_encode(html_entity_decode($empresa->seo_description,ENT_QUOTES)); ?>">
<meta name="keywords" content="<?php echo (isset($seo_keywords)) ? utf8_encode(html_entity_decode($seo_keywords,ENT_QUOTES)) : utf8_encode(html_entity_decode($empresa->seo_keywords,ENT_QUOTES)); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<link href="css/style.css" type="text/css" media="all" rel="stylesheet" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<link href="/sistema/resources/css/common.css" media="all" type="text/css" rel="stylesheet"/>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<script type="text/javascript">
// Constantes que se utilizan en el sistema
const ID_EMPRESA = "<?php echo $empresa->id ?>";
const CURRENT_URL = "<?php echo current_url(); ?>";
</script>
<?php if (!empty($empresa->texto_css)) { ?>
<style type="text/css"><?php echo $empresa->texto_css ?></style>
<?php } ?>
<?php if (!empty($empresa->analytics)) { echo html_entity_decode($empresa->analytics,ENT_QUOTES); } ?>
<?php if (!empty($empresa->zopim)) { echo html_entity_decode($empresa->zopim,ENT_QUOTES); } ?>
<?php if (!empty($empresa->google_site_verification)) { echo html_entity_decode($empresa->google_site_verification,ENT_QUOTES); } ?>
<?php if (!empty($empresa->adsense)) { echo html_entity_decode($empresa->adsense,ENT_QUOTES); } ?>
<?php if (!empty($empresa->pixel_fb)) { echo html_entity_decode($empresa->pixel_fb,ENT_QUOTES); } ?>
