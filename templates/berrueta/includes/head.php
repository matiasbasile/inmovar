<base href="/templates/<?php echo $empresa->template_path ?>/"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?php echo (isset($seo_title)) ? (html_entity_decode($seo_title,ENT_QUOTES)) : (html_entity_decode($empresa->seo_title,ENT_QUOTES)); ?></title>
<meta name="description" content="<?php echo (isset($seo_description)) ? (html_entity_decode($seo_description,ENT_QUOTES)) : (html_entity_decode($empresa->seo_description,ENT_QUOTES)); ?>">
<meta name="keywords" content="<?php echo (isset($seo_keywords)) ? (html_entity_decode($seo_keywords,ENT_QUOTES)) : (html_entity_decode($empresa->seo_keywords,ENT_QUOTES)); ?>">
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
<link href="css/main.css" type="text/css" media="all" rel="stylesheet" />
<!-- TODO: unificar los JS -->
<!-- TODO: Poner los JS en la carpeta del sistema, para que pueda ser compartido por varios proyectos -->
<script type="text/javascript" src="/admin/resources/js/common.js"></script>
<script type="text/javascript" src="/admin/resources/js/main.js"></script>
<link href="/admin/resources/css/common.css" type="text/css" media="all" rel="stylesheet">
<link href="/admin/resources/css/bootstrap-cols.css" type="text/css" media="all" rel="stylesheet">

<?php if (!empty($empresa->analytics)) { echo html_entity_decode($empresa->analytics,ENT_QUOTES); } ?>
<?php if (!empty($empresa->zopim)) { echo html_entity_decode($empresa->zopim,ENT_QUOTES); } ?>
<?php if (!empty($empresa->google_site_verification)) { echo html_entity_decode($empresa->google_site_verification,ENT_QUOTES); } ?>
<?php if (!empty($empresa->adsense)) { echo html_entity_decode($empresa->adsense,ENT_QUOTES); } ?>
<?php if (!empty($empresa->pixel_fb)) { echo html_entity_decode($empresa->pixel_fb,ENT_QUOTES); } ?>
<script type="text/javascript">
// Constantes que se utilizan en el sistema
const ID_EMPRESA = "<?php echo $empresa->id ?>";
const CURRENT_URL = "<?php echo current_url(); ?>";
</script>
<?php if (!empty($empresa->texto_css)) { ?>
<style type="text/css"><?php echo $empresa->texto_css ?></style>
<?php } ?>