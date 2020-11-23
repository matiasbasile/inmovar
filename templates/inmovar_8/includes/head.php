<?php include ("templates/comun/pre_head.php") ?>

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.css" rel="stylesheet">
<!-- Custom styles -->
<link href="css/custom.css" rel="stylesheet">
<!-- Font Awesome styles -->
<link href="css/font-awesome.min.css" rel="stylesheet">
<link href="css/jquery.fancybox.min.css" rel="stylesheet">
<link href="css/price-range.css" rel="stylesheet">
<!-- Owl Stylesheets -->
<link rel="stylesheet" href="css/owl.carousel.min.css">
<link rel="stylesheet" href="css/owl.theme.default.min.css">

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

<?php include ("templates/comun/post_head.php") ?>
