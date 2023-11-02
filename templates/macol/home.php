<?php include_once 'includes/init.php'; ?>
<!DOCTYPE html>
<html dir="ltr" lang="es">
<head>
<?php $pageTitle = 'Inicio';
include 'includes/head.php'; ?>
</head>
<body>

    <!-- Header -->
    <?php 
    $header_clase = "header-two";
    include 'includes/header.php'; ?>

    <!-- Banner -->
    <?php include 'includes/home/banner.php'; ?>

    <!-- For Sale -->
    <?php include 'includes/home/forSale.php'; ?>

    <!-- Your Dream -->
    <?php include 'includes/home/yourDream.php'; ?>

    <!-- Categories -->
    <?php include 'includes/home/categories.php'; ?>

    <!-- Articles -->
    <?php include 'includes/home/articles.php'; ?>

    <!-- Communicate -->
    <?php include 'includes/home/communicate.php'; ?>

    <!-- Communicate Us -->
    <?php include 'includes/home/contact.php'; ?>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="assets/js/owl.carousel.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWmUapFYTBXV3IJL9ggjT9Z1wppCER55g&callback=initMap">
    </script>
    <script src="assets/js/script.js"></script>
</body>

</html>