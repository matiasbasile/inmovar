<?php include_once 'includes/init.php'; ?>
<!DOCTYPE html>
<html dir="ltr" lang="es">
<head>
<?php $pageTitle = 'Inicio';
include 'includes/head.php'; ?>
</head>
<body class="home">

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

</body>

</html>