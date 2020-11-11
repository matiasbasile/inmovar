<?php include ("includes/init.php");
$detalle=$entrada_model->get($id);?>
<?php $page_act = "informacion" ?>
<!DOCTYPE html>
<html>
<head>
  <?php include ("includes/head.php");?>
</head>
<body>
<?php include ("includes/header.php");?>
    <div class="container">
        <h1 class="noticia_titulo"><?php echo $detalle->titulo?></h1>
        <div class="row">
            <div class="col-12">
                <div class="noticia_texto">
                    <?php echo $detalle->texto?>
                </div>
            </div>
        </div>
    </div>
<?php include ("includes/footer.php");?>