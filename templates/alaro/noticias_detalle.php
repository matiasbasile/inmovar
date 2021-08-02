<?php
include_once("sistema/application/helpers/fecha_helper.php");
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id,$conx);
include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id,$conx);
include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id,$conx);
$header_cat = "";
$page = 0;

$entrada = $entrada_model->get($id,array(
  "buscar_relacionados"=>0, // Se relaciona por etiquetas
));
$entrada->mostrar_relacionados = 1;

// Tomamos los datos de SEO
$seo_title = (!empty($entrada->seo_title)) ? ($entrada->seo_title) : $empresa->seo_title;
$seo_description = (!empty($entrada->seo_description)) ? ($entrada->seo_description) : $empresa->seo_description;
$seo_keywords = (!empty($entrada->seo_keywords)) ? ($entrada->seo_keywords) : $empresa->seo_keywords;

// Buscamos la categoria padre de todas y formamos el array
$link = mklink("entradas/");
$breadcrumb = $entrada_model->get_categorias($entrada->id_categoria,array(
  "link"=>$link
));

$nombre_pagina = $entrada->categoria_link;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body class="loading">
<?php include("includes/header.php"); ?>

<div class="page-title" style="background:url(<?php echo $entrada->categoria_path ?>) no-repeat 0 0; background-size:cover;">
  <div class="container">
    <div class="title-caption"><?php echo $entrada->categoria ?></div>
  </div>
</div>

<!--ABOUT US-->
<div class="about-page"> 
  
  <!--ABOUT US INFO-->
  <div class="about-us-info">
    <div class="container">
      <div class="center-text">
        <?php if (!empty($entrada->titulo)) { ?>
          <h2><?php echo $entrada->titulo ?></h2>
        <?php } ?>
        <?php if (!empty($entrada->subtitulo)) { ?>
          <p><?php echo $entrada->subtitulo ?></p>
        <?php } ?>
      </div>
      <p><?php echo html_entity_decode($entrada->texto,ENT_QUOTES); ?></p>
    </div>
  </div>
  
  <?php if ($entrada->categoria_link == "quienes-somos") { ?>
    <?php /*
    <div class="our-history">
      <div class="container">
        <div class="center-text">
          <h2>NUESTRA HISTORIA</h2>
          <p>UNA TRADICIÓN FAMILIAR que ya lleva más de 50 años</p>
        </div>
        <div class="accordion">
          <div class="accordion-item">
            <div class="accordion-title"><a class="active" href="#accordion-item">
              <div class="icon"></div>
              <div class="right-text"><strong>1956</strong> <i class="fa fa-circle" aria-hidden="true"></i> <strong>Guillermo Simonet</strong> (padre) comenzó con su actividad profesional como ingeniero en el año 1956. </div>
              </a></div>
            <div class="accordion-content open" id="accordion-item">
              <p>
                En el ámbito público, fue <strong>director de obras en el Ministerio de obras públicas de la provincia de Buenos Aires</strong>, y, entre otras cosas, dirigió la construcción de varios tribunales (San Isidro, San Martín, Mercedes, Junín, La Plata).<br/>
                En el ámbito privado  realizó  <strong>proyectos de departamentos en la ciudad de La Plata y en Villa Gesell</strong>; por otro lado, dirigió alrededor de <strong>100 viviendas particulares</strong>.<br/>
                En el ámbito universitario, fue profesor de la cátedra de estructuras durante 35 años en la Universidad Nacional de La Plata.
              </p>
            </div>
          </div>
          <div class="accordion-item">
            <div class="accordion-title"><a href="#accordion-item1">
              <div class="icon"></div>
              <div class="right-text"><strong>1986</strong> <i class="fa fa-circle" aria-hidden="true"></i> <strong>Guillermo Simonet</strong> (hijo), continuando con el legado familiar.</div>
              </a></div>
            <div class="accordion-content" id="accordion-item1">
              <p>
                Se recibió de Ingeniero en la UNLP en el año 1986 dispuesto a seguir los pasos de su padre.<br/>
                En sus comienzos, trabajó en el Instituto provincial de la vivienda, y en paralelo realizó viviendas privadas de forma independiente.<br/>
                Comenzó a dar clases en la cátedra de Estructuras III, de la Facultad de Arquitectura en la Universidad Nacional de La Plata. Ejercio la docencia por más de 20 años.
              </p>
            </div>
          </div>
          <div class="accordion-item">
            <div class="accordion-title"><a href="#accordion-item2">
              <div class="icon"></div>
              <div class="right-text"><strong>1992</strong> <i class="fa fa-circle" aria-hidden="true"></i> <strong>Comenzó su primer complejo de viviendas multifamiliares en la</strong> calle 2, entre 69 y 70, con 16 departamentos.</div>
              </a></div>
            <div class="accordion-content" id="accordion-item2">
              <p>
                En el año 1993 realizó 10 departamentos en la calle 116 entre 38 y 39. y en el año 1995, realizó un complejo de 12 departamentos en 8 entre 33 y 34.<br/>
                Paralelamente a estos complejos, desarrolló casas en distintos lugares de la ciudad de La Plata, incluidos varios countries tales como: <strong>Grand Bell, Campos de Roca, Haras del Sur, Los Ceibos</strong>. Hasta el día de la fecha lleva realizadas <strong>más de 60 casas</strong>.
              </p>
            </div>
          </div>
          <div class="accordion-item">
            <div class="accordion-title"><a href="#accordion-item3">
              <div class="icon"></div>
              <div class="right-text"><strong>2003</strong> <i class="fa fa-circle" aria-hidden="true"></i> <strong>En el año 2003 nace la marca ALARÓ EDIFICIOS.</strong> El nombre Alaró hace referencia al pueblo de origen del apellido Simonet.</div>
              </a></div>
            <div class="accordion-content" id="accordion-item3">
              <p>
                El comienzo de la marca se da con la construcción de un edificio situado en la <strong>calle 38 entre 14 y 15</strong>.<br/>
                Este año marcó un hito en la historia familiar, generando un salto de calidad que con el correr de los años posicionó a Edificios Alaró entre las desarrolladoras de proyectos más reconocidas en la ciudad de La Plata.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    */ ?>
  
    <!--OUR SPOT-->
    <div class="our-spot">
      <div class="container">
        <div class="video-control"><a href="javascript:void(0);" data-toggle="modal" data-target="#video-model"><img src="images/play-btn.png" alt="Play" /></a></div>
        <div class="video-title"><span>mira nuestro<br>
          spot hd</span></div>
      </div>
    </div>
  
    <!--NEWS BLOGS-->
    <div class="news-blogs">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="blog-picture"><img src="images/blog1.png" alt="Blog" /></div>
            <div class="white-box">
              <div class="blog-title">nuestra Misión</div>
              <p>Nuestro interés es generar la más alta satisfacción en nuestros clientes. No solamente queremos mejorar su calidad de vida, también queremos que puedan cumplir sus sueños y mudarse con su pareja, invertir, emprender un proyecto, terminar el objetivo que deseen y puedan crecer junto a nosotros.</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="blog-picture"><img src="images/blog2.jpg" alt="Blog" /></div>
            <div class="white-box">
              <div class="blog-title">nuestra visión</div>
              <p>Ser una empresa líder a nivel nacional, reconocida por sus rasgos más representativos: su profesionalismo, el comportamiento ético, la alta calidad de sus productos, su política de mejora continua, una sólida posición financiera y su premisa fundamental: <a href="#0">"Creciendo Juntos"</a>.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  
    <div class="value-caracteriza">
      <div class="container">
        <div class="center-text">
          <h2>Valores que nos caracterizan</h2>
          <p>Constituyen la proyección de los valores de su fundador</p>
        </div>
        <div class="row">
          <div class="col-md-5">
            <div class="caracteriza-picture"><a href="#0"><img src="images/characterize-img.jpg" alt="Characterize" /></a></div>
            <div class="about-caracteriza">
              <p><span>Complejo AGAPANTO</span> (Mar de las Pampas)</p>
              <p>Obra llevada a cabo por el Ingeniero Guillermo Simonet y su equipo de trabajo.</p>
              <p>Más imágenes en <a href="mailto:www.complejoagapanto.com.ar">www.complejoagapanto.com.ar</a></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="more-info">
              <p>Fomentar y afianzar relaciones honestas y a largo plazo con clientes y proveedores.<br>
                Desarrollar el mejor clima de trabajo, fomentando el trabajo en equipo y la realización personal y profesional de nuestros colaboradores.
                Concebir desarrollos que generen un valor agregado en la ciudad.
                Orientarse a la excelencia, el esfuerzo y dedicacion para la consecución de los mejores productos.<br>
                Construir en forma sustentable, respetando el medio ambiente y las normas establecidas.<br>
                Obrar con transparencia y rectitud en todos nuestros actos.
                Trato personalizado, cordial y respetuoso.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

</div>

<?php if (sizeof($entrada->images)>0) { ?>
  <div class="gallery-page">
    <?php foreach($entrada->images as $img) { ?>
      <div class="col-md-3">
        <div class="project-list"> 
          <img src="<?php echo $img ?>" alt="Gallery">
          <div class="about-project">
            <div class="small-list">
              <div class="overlay-info">
                <div class="center-content">
                  <div class="align-center"> <a class="fancybox" href="<?php echo $img ?>" data-fancybox-group="gallery"></a> </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
<?php } ?>

<?php include("includes/footer.php"); ?>
<script type="text/javascript" src="js/fancybox.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
  $('.fancybox').fancybox();

  var maximo = 0;
  $(".gallery-page .col-md-3 img").each(function(i,e){
    if ($(e).height() > maximo) maximo = $(e).height();
  });
  maximo = Math.ceil(maximo);
  $(".gallery-page .col-md-3 img").height(maximo);
  
});
</script>

<!-- MODEL -->
<div id="video-model" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/GDzGx_aq_bg" frameborder="0" allowfullscreen></iframe>
      </div>
    </div>
  </div>
</div>
</body>
</html>