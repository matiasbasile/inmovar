<base href="/templates/<?php echo $empresa->template_path ?>/"/>
<meta charset="utf-8">
<title>
<?php echo (isset($seo_title)) ? (html_entity_decode($seo_title,ENT_QUOTES)) : (html_entity_decode($empresa->seo_title,ENT_QUOTES)); ?>
</title>
<meta name="keywords" content="<?php echo (isset($seo_keywords)) ? (html_entity_decode($seo_keywords,ENT_QUOTES)) : (html_entity_decode($empresa->seo_keywords,ENT_QUOTES)); ?>">
<meta name="description" content="<?php echo (isset($seo_description)) ? (html_entity_decode($seo_description,ENT_QUOTES)) : (html_entity_decode($empresa->seo_description,ENT_QUOTES)); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<link rel="canonical" href="<?php echo current_url(TRUE); ?>" />
<link rel='shortlink' href="<?php echo current_url(TRUE); ?>" />

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

<!-- External CSS libraries -->
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/animate.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-submenu.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-select.min.css">
<link rel="stylesheet" href="css/leaflet.css" type="text/css">
<link rel="stylesheet" href="css/map.css" type="text/css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/flaticon.css">
<link rel="stylesheet" type="text/css" href="css/linearicons/style.css">
<link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="css/owl.theme.default.min.css">
<link rel="stylesheet" type="text/css"  href="css/jquery.mCustomScrollbar.css">
<link rel="stylesheet" type="text/css"  href="css/dropzone.css">

<!-- Custom stylesheet -->
<link rel="stylesheet" type="text/css" href="css/style.css">
<style type="text/css">
<?php
$c1 = $empresa->color_principal;
$c2 = $empresa->color_secundario;
$c3 = $empresa->color_terciario;
$c4 = $empresa->color_4;
$c5 = $empresa->color_5;
$c6 = $empresa->color_6;
include_once("templates/".$empresa->template_path."/css/skins/default.php");
?>
</style>

<!-- Favicon icon -->
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" >

<!-- Google fonts -->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPlayfair+Display:400,700%7CRoboto:100,300,400,400i,500,700">
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Work+Sans:400,600,700&display=swap" rel="stylesheet">

<?php if (!empty($empresa->texto_css)) { ?>
<style type="text/css"><?php echo $empresa->texto_css ?></style>
<?php } ?>