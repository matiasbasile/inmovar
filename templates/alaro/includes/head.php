<base href="/templates/<?php echo $empresa->template_path ?>/"/>
<meta charset="utf-8">
<title><?php echo (isset($seo_title)) ? (html_entity_decode($seo_title,ENT_QUOTES)) : (html_entity_decode($empresa->seo_title,ENT_QUOTES)); ?></title>
<meta name="description" content="<?php echo (isset($seo_description)) ? (html_entity_decode($seo_description,ENT_QUOTES)) : (html_entity_decode($empresa->seo_description,ENT_QUOTES)); ?>">
<meta name="keywords" content="<?php echo (isset($seo_keywords)) ? (html_entity_decode($seo_keywords,ENT_QUOTES)) : (html_entity_decode($empresa->seo_keywords,ENT_QUOTES)); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<link href="css/style.css?v=4" type="text/css" media="all" rel="stylesheet" />
<link href="css/slider.css?v=1" type="text/css" media="all" rel="stylesheet" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css?v=1">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css?v=1" media="all">
<link rel="stylesheet" type="text/css" href="css/swiper.min.css?v=1" media="all">
<link rel="stylesheet" type="text/css" href="css/custom-scroll.css?v=1" media="all">
<link rel="stylesheet" href="css/fancybox.css?v=1" media="screen">
<link href="/admin/resources/css/common.css?v=1" rel="stylesheet" media="screen">
<script type="text/javascript" src="/admin/resources/js/common.js"></script>
<script type="text/javascript" src="/admin/resources/js/main.js"></script>
<?php if (!empty($empresa->analytics)) { echo html_entity_decode($empresa->analytics,ENT_QUOTES); } ?>
<?php if (!empty($empresa->zopim)) { echo html_entity_decode($empresa->zopim,ENT_QUOTES); } ?>
<?php if (!empty($empresa->gtm_head)) { echo html_entity_decode($empresa->gtm_head,ENT_QUOTES); } ?>
<script type="text/javascript">
// Constantes que se utilizan en el admin
const ID_EMPRESA = "<?php echo $empresa->id ?>";
const CURRENT_URL = "<?php echo current_url(); ?>";
</script>