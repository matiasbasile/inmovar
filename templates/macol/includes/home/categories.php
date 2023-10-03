<section class="categories">
    <div class="container">
        <div class="section-title">
            <?php $categories_title = $web_model->get_text('categories_title', 'Simplificá tu <span>búsqueda</span> filtrando por categoría'); ?>
            <h2 class="editable" data-id="<?php echo $categories_title->id; ?>"
                data-clave="<?php echo $categories_title->clave; ?>">
                <?php echo $categories_title->plain_text; ?>
            </h2>
            <?php $categories_desc = $web_model->get_text('categories_desc', 'Elegí cualquira de las categorías para refinar tu búsqueda'); ?>
            <p class="editable" data-id="<?php echo $categories_desc->id; ?>"
                data-clave="<?php echo $categories_desc->clave; ?>">
                <?php echo $categories_desc->plain_text; ?>
            </p>
        </div>
        <div class="row gy-5">
            <div class="col-xl-2 col-md-3 col-sm-4 col-6">
                <div class="categorie-item">
                    <a href="/propiedades/ventas/?tp=2"><img src="assets/images/categorie1.png" alt="Categorie"></a>
                    <h3>Departamentos</h3>
                </div>
            </div>
            <div class="col-xl-2 col-md-3 col-sm-4 col-6">
                <div class="categorie-item">
                    <a href="/propiedades/ventas/?tp=3"><img src="assets/images/categorie2.png" alt="Categorie"></a>
                    <h3>PH</h3>
                </div>
            </div>
            <div class="col-xl-2 col-md-3 col-sm-4 col-6">
                <div class="categorie-item">
                    <a href="/propiedades/ventas/?tp=1"><img src="assets/images/categorie3.png" alt="Categorie"></a>
                    <h3>CASAS</h3>
                </div>
            </div>
            <div class="col-xl-2 col-md-3 col-sm-4 col-6">
                <div class="categorie-item">
                    <a href="/propiedades/ventas/?tp=13"><img src="assets/images/categorie4.png" alt="Categorie"></a>
                    <h3>COCHERAS</h3>
                </div>
            </div>
            <div class="col-xl-2 col-md-3 col-sm-4 col-6">
                <div class="categorie-item">
                    <a href="/propiedades/ventas/?tp=11"><img src="assets/images/categorie5.png" alt="Categorie"></a>
                    <h3>OFICINAS</h3>
                </div>
            </div>
            <div class="col-xl-2 col-md-3 col-sm-4 col-6">
                <div class="categorie-item">
                    <a href="/propiedades/ventas/?tp=7"><img src="assets/images/categorie6.png" alt="Categorie"></a>
                    <h3>TERRENOS</h3>
                </div>
            </div>
        </div>
    </div>
</section>