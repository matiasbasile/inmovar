<?php
include_once("includes/init.php");
$page_act = "gracias";
?>  
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
  <?php include "includes/head.php" ?>
</head>
<body>

  <!-- Header -->
  <?php include "includes/header.php" ?>
  
  <?php include "templates/comun/gracias.php" ?>  

  <!-- Footer -->
  <?php include "includes/footer.php" ?>


  <!-- Scripts -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/html5.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
  <script src="assets/js/scripts.js"></script>
  <script type="text/javascript">
  $(window).on("load",function(){
    $(".scroll-box").mCustomScrollbar();
  });
</script>
</body>
</html>