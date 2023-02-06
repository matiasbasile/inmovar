<?php include 'includes/init.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/head.php' ?>
  <style>
    .equo-con-title{
      padding: 50px 30px 30px 30px;;
    }
  </style>
</head>

<body>
  <?php include 'includes/header.php' ?>

  <section class="equipo-banner equo">
    <div class="container">
      <div class="equipo-content">
        <h1 class="banner-title">contacto</h1>
      </div>
    </div>
  </section>

  <div class="equo-con-title">
    <h2 class="color-title" style="color: #f23881;">conoce a nuestro</h2>
    <h3 class="small-title">equipo</h3>
  </div>

  <div id="#map1"></div>

  <div class="container" id="contacto-container">
    <h4 class="text-uppercase text-center contacto-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto eveniet maiores ut impedit ea earum</h4>
    <p class="contacto-descripcion">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate, vitae. Architecto aliquam adipisci, deleniti officia voluptates velit eaque labore vero autem facilis ex iusto earum reiciendis totam ab temporibus nam!
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate, vitae. Architecto aliquam adipisci, deleniti officia voluptates velit eaque labore vero autem facilis ex iusto earum reiciendis totam ab temporibus nam!
    </p>
  </div>

  <section class="ros-section ">
    <form onsubmit="return enviar_contacto()">
      <div class="container">
        <div class="ros-content">
          <h3 class="color-title" style="color: #f23881;">CONOCE A NUESTRO EQUIPO</h3>
          <h4 class="small-title">nosotros</h4>
        </div>
        <div class="ros-inner">
          <div class="row">
            <div class="col-lg-6">
              <input type="text" id="contacto_nombre" name="Nombre" placeholder="Nombre *">
            </div>
            <div class="col-lg-6">
              <input type="text" id="contacto_email" name="Email" placeholder="Email">
            </div>
            <div class="col-lg-6">
              <input type="text" id="contacto_telefono" name="Telefono" placeholder="Whatsapp (sin 0 ni 15) *">
            </div>
            <div class="col-lg-6">
              <div class="select-inner">
                <select id="contacto_asunto" class="round" name="venta">
                  <option value="australia">asunto</option>
                  <?php $asuntos = explode(";;;", $empresa->asuntos_contacto); ?>
                  <?php foreach ($asuntos as $a) { ?>
                    <option><?php echo $a ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-lg-12">
              <textarea id="contacto_mensaje">Mensaje</textarea>
            </div>
          </div>
        </div>
        <div class="fill-btn-inner">
          <button id="contacto_submit" class="fill-btn">enviar consulta</button>
        </div>
      </div>
    </form>
  </section>

  <?php include 'includes/footer.php' ?>

</body>

</html>