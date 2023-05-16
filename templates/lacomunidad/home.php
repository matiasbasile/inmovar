<?php include 'includes/init.php' ?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <?php include 'includes/head.php' ?>
</head>
<body>

<?php include 'includes/header.php' ?>

<!-- Top Banner  -->
<section class="top-banner">
  <div class="owl-carousel owl-theme" data-outoplay="true" data-nav="false" data-dots="true">
    <div class="item">
      <img src="assets/images/top-banner-img1.jpg" alt="img">
    </div>
    <div class="item">
      <img src="assets/images/top-banner-img2.jpg" alt="img">
    </div>
    <div class="item">
      <img src="assets/images/top-banner-img1.jpg" alt="img">
    </div>
  </div>
  <div class="banner-caption">
    <div class="container">
      <h1>comunidad inmobiliaria
        club de negocios</h1>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="Comprar-tab" data-bs-toggle="tab" data-bs-target="#Comprar" type="button" role="tab" aria-controls="Comprar" aria-selected="true">Comprar</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="Alquilar-tab" data-bs-toggle="tab" data-bs-target="#Alquilar" type="button" role="tab" aria-controls="Alquilar" aria-selected="false">Alquilar</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="Vender-tab" data-bs-toggle="tab" data-bs-target="#Vender" type="button" role="tab" aria-controls="Vender" aria-selected="false">Vender</button>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <form>
              <select class="form-control form-select">
                <option>Departamento</option>
                <option>Departamento</option>
                <option>Departamento</option>
                <option>Departamento</option>
              </select>
              <input type="search" class="form-control" name="Ingresá ubicación" placeholder="Ingresá ubicación">
              <button type="submit" class="btn">Buscar</button>
            </form>
          </div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
          <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
        </div>
      </div>
  </div>
</section>

<?php include 'includes/home/destacadas.php' ?>

<!-- The Property -->
<section class="the-property">
  <div class="container">
    <div class="section-title">
      <h2>ENCONTRÁ LA PROPIEDAD QUE ESTÁS BUSCANDO</h2>
    </div>
    <div class="owl-carousel owl-theme" data-outoplay="true" data-items="4" data-nav="true" data-dots="false" data-margin="25" data-items-tablet="3" data-items-mobile-landscape="2" data-items-mobile-portrait="1">
      <div class="item">
        <div class="icon-box">
          <img src="assets/images/property-icon1.svg" alt="icon">
        </div>
        <div class="inner-text">
          <h5>Casas</h5>
          <p>435 <span>Disponibles</span></p>
        </div>
      </div>
      <div class="item">
        <div class="icon-box">
          <img src="assets/images/property-icon2.svg" alt="icon">
        </div>
        <div class="inner-text">
          <h5>Deptos</h5>
          <p>435 <span>Disponibles</span></p>
        </div>
      </div>
      <div class="item">
        <div class="icon-box">
          <img src="assets/images/property-icon3.svg" alt="icon">
        </div>
        <div class="inner-text">
          <h5>PH</h5>
          <p>435 <span>Disponibles</span></p>
        </div>
      </div>
      <div class="item">
        <div class="icon-box">
          <img src="assets/images/property-icon4.svg" alt="icon">
        </div>
        <div class="inner-text">
          <h5>Terrenos</h5>
          <p>435 <span>Disponibles</span></p>
        </div>
      </div>
      <div class="item">
        <div class="icon-box">
          <img src="assets/images/property-icon1.svg" alt="icon">
        </div>
        <div class="inner-text">
          <h5>Terrenos</h5>
          <p>435 <span>Disponibles</span></p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Ventures -->
<section class="ventures">
  <div class="container">
    <div class="section-title">
      <h2>EMPRENDIMIENTOS</h2>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-6">
        <div class="img-block">
          <img src="assets/images/ventures-img1.jpg" alt="img">
          <div class="overley">
            <div class="precio">
              <span>Precio desde </span>
              <h5><a href="#0" class="stretched-link"> U$S 40.000</a></h5>
            </div>
            <div class="canitas">
              <p>Cañitas Bell II</p>
              <span>73 E/ 56 Y 11</span>
              <div class="aminities">
                <span>156 M2</span>
                <ul>
                  <li><img src="assets/images/featured-properties-icon1.svg" alt="icon"> 3</li>
                  <li><img src="assets/images/featured-properties-icon2.svg" alt="icon"> 2</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="img-block">
          <img src="assets/images/ventures-img2.jpg" alt="img">
          <div class="overley">
            <div class="precio">
              <span>Precio desde </span>
              <h5><a href="#0" class="stretched-link">U$S 35.000</a></h5>
            </div>
            <div class="canitas">
              <p>Cañitas Bell II</p>
              <span>73 E/ 56 Y 11</span>
              <div class="aminities">
                <span>156 M2</span>
                <ul>
                  <li><img src="assets/images/featured-properties-icon1.svg" alt="icon"> 3</li>
                  <li><img src="assets/images/featured-properties-icon2.svg" alt="icon"> 2</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="img-block">
          <img src="assets/images/ventures-img3.jpg" alt="img">
          <div class="overley">
            <div class="precio">
              <span>Precio desde </span>
              <h5><a href="#0" class="stretched-link">U$S 239.000</a></h5>
            </div>
            <div class="canitas">
              <p>Cañitas Bell II</p>
              <span>73 E/ 56 Y 11</span>
              <div class="aminities">
                <span>156 M2</span>
                <ul>
                  <li><img src="assets/images/featured-properties-icon1.svg" alt="icon"> 3</li>
                  <li><img src="assets/images/featured-properties-icon2.svg" alt="icon"> 2</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="img-block">
          <img src="assets/images/ventures-img4.jpg" alt="img">
          <div class="overley">
            <div class="precio">
              <span>Precio desde </span>
              <h5><a href="#0" class="stretched-link">U$S 245.000</a></h5>
            </div>
            <div class="canitas">
              <p>Cañitas Bell II</p>
              <span>73 E/ 56 Y 11</span>
              <div class="aminities">
                <span>156 M2</span>
                <ul>
                  <li><img src="assets/images/featured-properties-icon1.svg" alt="icon"> 3</li>
                  <li><img src="assets/images/featured-properties-icon2.svg" alt="icon"> 2</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="img-block">
          <img src="assets/images/ventures-img5.jpg" alt="img">
          <div class="overley">
            <div class="precio">
              <span>Precio desde </span>
              <h5><a href="#0" class="stretched-link">U$S 230.000</a></h5>
            </div>
            <div class="canitas">
              <p>Cañitas Bell II</p>
              <span>73 E/ 56 Y 11</span>
              <div class="aminities">
                <span>156 M2</span>
                <ul>
                  <li><img src="assets/images/featured-properties-icon1.svg" alt="icon"> 3</li>
                  <li><img src="assets/images/featured-properties-icon2.svg" alt="icon"> 2</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="img-block">
          <img src="assets/images/ventures-img6.jpg" alt="img">
          <div class="overley">
            <div class="precio">
              <span>Precio desde </span>
              <h5><a href="#0" class="stretched-link">U$S 125.000</a></h5>
            </div>
            <div class="canitas">
              <p>Cañitas Bell II</p>
              <span>73 E/ 56 Y 11</span>
              <div class="aminities">
                <span>156 M2</span>
                <ul>
                  <li><img src="assets/images/featured-properties-icon1.svg" alt="icon"> 3</li>
                  <li><img src="assets/images/featured-properties-icon2.svg" alt="icon"> 2</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/home/ultimas_noticias.php' ?>

<?php include 'includes/footer.php' ?>

</body>
</html>