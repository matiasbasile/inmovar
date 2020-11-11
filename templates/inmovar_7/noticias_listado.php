<?php include ("includes/init.php");?>
<?php $page_act = "informacion" ?>
<!DOCTYPE html>
<html>
<head>
  <?php include ("includes/head.php");?>
</head>
<body>

<?php include ("includes/header.php");?>

    <main id="ts-main">
        <section id="page-title">
            <div class="container">

                <div class="ts-title">
                    <h1>Ultimas noticias</h1>
                </div>

            </div>
        </section>
        <section id="agencies-list">
            <div class="container">

                <!--AGENCIES
                    =================================================================================================-->
                <section id="agencies">
                    <?php $noticias = $entrada_model->get_list(array("offset"=>4)); 
                    foreach ($noticias as $n){?>
                        <div class="card ts-item ts-item__list ts-item__company ts-card">
                            <a href="<?php echo mklink("$n->link");?>" class="card-img">
                                <img src="<?php echo $n->path;?>" alt="">
                            </a>
                            <div class="card-body">

                                <figure class="ts-item__info">
                                    <h4><?php echo $n->titulo;?></h4>
                                    <aside>
                                        <i class="fa fa-list mr-2"></i>
                                        <?php echo $n->categoria;?>
                                    </aside>
                                </figure>

                                <div class="ts-company-info">
                                    <?php echo substr($n->plain_text, 0, 400);?>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="<?php echo mklink("$n->link");?>" class="ts-btn-arrow">Leer mas</a>
                            </div>
                        </div>
                    <?php } ?>
                </section>
                <!--end #agencies-->

                <!--PAGINATION
                    =================================================================================================-->
                <section id="pagination">
                    <div class="container">

                        <!--Pagination-->
                        <nav aria-label="Page navigation">
                            <ul class="pagination ts-center__horizontal">
                                <li class="page-item">
                                    <a class="page-link ts-btn-arrow" href="#">Anterior</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link ts-btn-arrow" href="#">Siguiente</a>
                                </li>
                            </ul>
                        </nav>

                    </div>
                </section>

            </div>
        </section>
    </main>

<?php include ("includes/footer.php");?>
</body>
</html>