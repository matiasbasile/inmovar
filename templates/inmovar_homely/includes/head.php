<base href="/templates/<?php echo $empresa->template_path ?>/"/>
<!-- Codif. Caract -->
<meta charset="utf-8">
<title><?php echo (isset($seo_title)) ? (html_entity_decode($seo_title,ENT_QUOTES)) : (html_entity_decode(($empresa->seo_title),ENT_QUOTES)); ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Opciones de buscadores -->
<meta name="description" content="<?php echo (isset($seo_description)) ? (html_entity_decode($seo_description,ENT_QUOTES)) : (html_entity_decode(($empresa->seo_description),ENT_QUOTES)); ?>">
<meta name="keywords" content="<?php echo (isset($seo_keywords)) ? (html_entity_decode($seo_keywords,ENT_QUOTES)) : (html_entity_decode(($empresa->seo_keywords),ENT_QUOTES)); ?>">
<!-- Permite RESPONSIVE -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<!-- CSS  aplica a todos los proyectos -->
<link href="/admin/resources/css/common.css" rel="stylesheet" media="screen">
<!-- JScript aplica a todos los proyectos -->
<script type="text/javascript" src="/admin/resources/js/common.js"></script>
<script type="text/javascript" src="/admin/resources/js/main.js"></script>

<?php if (!empty($empresa->analytics)) { echo html_entity_decode($empresa->analytics,ENT_QUOTES); } ?>
<?php if (!empty($empresa->zopim)) { echo html_entity_decode($empresa->zopim,ENT_QUOTES); } ?>
<?php if (!empty($empresa->google_site_verification)) { echo html_entity_decode($empresa->google_site_verification,ENT_QUOTES); } ?>
<?php if (!empty($empresa->remarketing)) { echo html_entity_decode($empresa->remarketing,ENT_QUOTES); } ?>
<?php if (!empty($empresa->adsense)) { echo html_entity_decode($empresa->adsense,ENT_QUOTES); } ?>
<?php if (!empty($empresa->pixel_fb)) { echo html_entity_decode($empresa->pixel_fb,ENT_QUOTES); } ?>
<script type="text/javascript">
const ID_EMPRESA = "<?php echo $empresa->id ?>";
const CURRENT_URL = "<?php echo current_url(); ?>";
</script>

<?php if (strpos(strtolower($empresa->favicon), ".png")>0) { ?>
  <link rel="shortcut icon" type="image/png" href="/admin/<?php echo $empresa->favicon ?>"/>
<?php } else if (strpos(strtolower($empresa->favicon), ".ico")>0) { ?>
  <link rel="shortcut icon" type="image/x-icon" href="/admin/<?php echo $empresa->favicon ?>" />
<?php } else { ?>
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<?php } ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Rype Creative [Chris Gipple]">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- CSS file links -->
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="fonts/font-awesome.min.css" rel="stylesheet" media="screen">
<link href="css/jquery-ui.min.css" rel="stylesheet">
<link href="css/owl.carousel.min.css" rel="stylesheet">
<link href="css/owl.theme.default.min.css" rel="stylesheet">
<link href="assets/chosen-1.6.2/chosen.min.css" rel="stylesheet">
<link href="css/nouislider.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/player.min.css">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/responsive.css" rel="stylesheet" type="text/css" media="all" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i" rel="stylesheet">

<style type="text/css">
:root {
  <?php if (!empty($empresa->color_principal)) { ?>
    --c1: <?php echo $empresa->color_principal ?>;
  <?php } ?>
  <?php if (!empty($empresa->color_secundario)) { ?>
    --c2: <?php echo $empresa->color_secundario ?>;
  <?php } ?>
  <?php if (!empty($empresa->color_terciario)) { ?>
    --c3: <?php echo $empresa->color_terciario ?>;
  <?php } ?>
  <?php if (!empty($empresa->color_4)) { ?>
    --c4: <?php echo $empresa->color_4 ?>;
  <?php } ?>
  <?php if (!empty($empresa->color_5)) { ?>
    --c5: <?php echo $empresa->color_5 ?>;
  <?php } ?>
  <?php if (!empty($empresa->color_6)) { ?>
    --c6: <?php echo $empresa->color_6 ?>;
  <?php } ?>
}
</style>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="js/html5shiv.min.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

<?php include "templates/comun/css.php" ?>

<?php if (!empty($empresa->texto_css)) { ?>
<style type="text/css"><?php echo $empresa->texto_css ?></style>
<?php } ?>

<?php if (!empty($empresa->marca_agua)) { ?>
<style type="text/css">
.marca_agua, .fancybox-content { position: relative; }
.marca_agua:after, .fancybox-content:after { content:" ";z-index:1;width:100%; height:100%; position:absolute;top:0;left:0;right:0;bottom:0;background-image: url("/admin/<?php echo $empresa->marca_agua ?>");background-repeat: no-repeat; background-size: 35%; }
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