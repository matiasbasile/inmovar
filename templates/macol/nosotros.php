<?php include_once 'includes/init.php'; ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <?php $pageTitle = 'Inicio';
include 'includes/head.php'; ?>
</head>

<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Communicate -->
    <?php include 'includes/home/communicate.php'; ?>

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