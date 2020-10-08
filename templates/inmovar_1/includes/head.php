<base href="/templates/<?php echo $empresa->template_path ?>/"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?php echo (isset($seo_title)) ? (html_entity_decode($seo_title,ENT_QUOTES)) : (html_entity_decode($empresa->seo_title,ENT_QUOTES)); ?></title>
<meta name="description" content="<?php echo (isset($seo_description)) ? (html_entity_decode($seo_description,ENT_QUOTES)) : (html_entity_decode($empresa->seo_description,ENT_QUOTES)); ?>">
<meta name="keywords" content="<?php echo (isset($seo_keywords)) ? (html_entity_decode($seo_keywords,ENT_QUOTES)) : (html_entity_decode($empresa->seo_keywords,ENT_QUOTES)); ?>">
<link rel="canonical" href="<?php echo current_url(TRUE); ?>" />
<link rel='shortlink' href="<?php echo current_url(TRUE); ?>" />
<link href='https://fonts.googleapis.com/css?family=Roboto:300,400,700' rel='stylesheet' type='text/css'>
<link href="/sistema/resources/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" type="text/css">
<link rel="stylesheet" href="assets/css/bootstrap-select.min.css" type="text/css">
<link rel="stylesheet" href="assets/css/magnific-popup.css" type="text/css">
<link rel="stylesheet" href="assets/css/jquery.slider.min.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<style type="text/css">
<?php
$c1 = $empresa->color_principal;
$c2 = $empresa->color_secundario;
$c3 = $empresa->color_terciario;
$c4 = $empresa->color_4;
$c5 = $empresa->color_5;
$c6 = $empresa->color_6;
include_once("templates/".$empresa->template_path."/assets/css/custom.php");
?>
</style>
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<![endif]-->

<?php if (strpos(strtolower($empresa->favicon), ".png")>0) { ?>
  <link rel="shortcut icon" type="image/png" href="/sistema/<?php echo $empresa->favicon ?>"/>
<?php } else if (strpos(strtolower($empresa->favicon), ".ico")>0) { ?>
  <link rel="shortcut icon" type="image/x-icon" href="/sistema/<?php echo $empresa->favicon ?>" />
<?php } else { ?>
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<?php } ?>

<link href="/sistema/resources/css/common.css" type="text/css" media="all" rel="stylesheet">
<script type="text/javascript">
// Constantes que se utilizan en el sistema
const ID_EMPRESA = "<?php echo $empresa->id ?>";
</script>
<?php echo html_entity_decode($empresa->analytics,ENT_QUOTES); ?>
<?php echo html_entity_decode($empresa->zopim,ENT_QUOTES); ?>

<?php if (!empty($empresa->texto_css)) { ?>
<style type="text/css"><?php echo $empresa->texto_css ?></style>
<?php } ?>