<?php include "templates/comun/pre_head.php" ?>

<link rel="canonical" href="<?php echo current_url(TRUE); ?>" />
<link rel='shortlink' href="<?php echo current_url(TRUE); ?>" />
<link href='https://fonts.googleapis.com/css?family=Roboto:300,400,700' rel='stylesheet' type='text/css'>
<link href="/admin/resources/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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


<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<![endif]-->
<?php include "templates/comun/post_head.php" ?>