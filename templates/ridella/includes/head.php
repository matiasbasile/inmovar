<title>
  <?php echo (isset($seo_title)) ? (html_entity_decode($seo_title,ENT_QUOTES)) : (html_entity_decode($empresa->seo_title,ENT_QUOTES)); ?>
</title>
<base href="/templates/<?php echo $empresa->template_path ?>/"/>
<!-- CSS  aplica a todos los proyectos -->
<link href="/sistema/resources/css/common.css" rel="stylesheet" media="screen">
<!-- JScript aplica a todos los proyectos -->
<script type="text/javascript" src="/sistema/resources/js/common.js"></script>
<script type="text/javascript" src="/sistema/resources/js/main.js"></script>
<!-- Estadisticas (Google) -->
<?php if (!empty($empresa->analytics)) { echo html_entity_decode($empresa->analytics,ENT_QUOTES); } ?>
<!-- Chat -->
<?php if (!empty($empresa->zopim)) { echo html_entity_decode($empresa->zopim,ENT_QUOTES); } ?>
<!-- Constantes que se utilizan en el sistema-->
<script type="text/javascript">
  const ID_EMPRESA = "<?php echo $empresa->id ?>";
  const CURRENT_URL = "<?php echo current_url(); ?>";
</script>
<!-- Meta Tags -->  
<meta name="keywords" content="<?php echo (isset($seo_keywords)) ? (html_entity_decode($seo_keywords,ENT_QUOTES)) : (html_entity_decode($empresa->seo_keywords,ENT_QUOTES)); ?>">
<meta name="description" content="<?php echo (isset($seo_description)) ? (html_entity_decode($seo_description,ENT_QUOTES)) : (html_entity_decode($empresa->seo_description,ENT_QUOTES)); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="author" content="Theme Garbage">
<meta charset="utf-8">
<link href="css/style.css" type="text/css" media="all" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="css/swiper.min.css" media="all">
<link rel="stylesheet" type="text/css" href="css/flexslider.css" media="all">
<link rel="stylesheet" type="text/css" href="css/flexslider.css" media="all">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">

<?php if (strpos(strtolower($empresa->favicon), ".png")>0) { ?>
  <link rel="shortcut icon" type="image/png" href="/sistema/<?php echo $empresa->favicon ?>"/>
<?php } else if (strpos(strtolower($empresa->favicon), ".ico")>0) { ?>
  <link rel="shortcut icon" type="image/x-icon" href="/sistema/<?php echo $empresa->favicon ?>" />
<?php } ?>