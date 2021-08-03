<?php 
// De esa manera cuando paginamos pasamos los mismos parametros
// sin guardar nada en la session
$gets = "";
if(sizeof($get_params)>0) {
  $gets.="?";
  foreach($get_params as $key => $value) {
    $gets.=$key."=".$value."&";
  }
}

$config = array();
$config["limit"] = 0;
$config["offset"] = 999999;
$config["order_by"] = "A.fecha_publicacion DESC, A.id DESC ";
$config["buscar_etiquetas"] = 1;
$config["solo_propias"] = 1;

if ($tipo_operacion->id == 8) {
  $config["id_tipo_operacion"] = 8;
  $finalizados = $propiedad_model->get_list($config);
} else {
  $config["id_tipo_operacion"] = 6;
  $en_construccion_result = $propiedad_model->get_list($config);
  $config["id_tipo_operacion"] = 7;
  $proximos_result = $propiedad_model->get_list($config);  
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<body class="loading">
<?php include("includes/header.php"); ?>
<!-- RED BOX TITLE -->
<div class="red-box-title">
  <div class="container">
    <ul>
      <li>Proyectos En Curso</li>
    </ul>
  </div>
</div>
<div class="project-category-list">
  <?php if ($tipo_operacion->id != 8) { ?>
    <div class="list-tabs">
      <div class="container">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#projects-under-construction">Proyectos en Construcción</a></li>
          <li><a data-toggle="tab" href="#next-projects">Proyectos a Estrenar</a></li>
        </ul>
      </div>
    </div>
    <div class="container">
      <div class="tab-content">
        <div id="projects-under-construction" class="tab-pane fade in active">
          <div class="row">
            <?php foreach($en_construccion_result as $r) { ?>
              <div class="col-md-3">
                <div class="feature-item">
                  <?php mostrar_etiqueta($r) ?>
                  <div class="feature-image"> <a href="<?php echo mklink($r->link); ?>"><img src="/admin/<?php echo $r->path ?>" alt="<?php echo $r->nombre ?>" /></a>
                    <div class="overlay-info">
                      <div class="center-content">
                        <div class="align-center"> <a href="<?php echo mklink($r->link); ?>"></a> </div>
                      </div>
                    </div>
                    <div class="about-product"> <a href="<?php echo mklink($r->link); ?>"><?php echo $r->nombre ?>
                      <p><?php echo $r->calle ?><br>
                        <?php echo $r->localidad ?></p>
                      </a> </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div id="next-projects" class="tab-pane fade">
          <div class="row">
            <?php foreach($proximos_result as $r) { ?>
              <div class="col-md-3">
                <div class="feature-item">
                  <?php mostrar_etiqueta($r) ?>
                  <div class="feature-image"> <a href="<?php echo mklink($r->link); ?>"><img src="/admin/<?php echo $r->path ?>" alt="<?php echo $r->nombre ?>" /></a>
                    <div class="overlay-info">
                      <div class="center-content">
                        <div class="align-center"> <a href="<?php echo mklink($r->link); ?>"></a> </div>
                      </div>
                    </div>
                    <div class="about-product"> <a href="<?php echo mklink($r->link); ?>"><?php echo $r->nombre ?>
                      <p><?php echo $r->calle ?><br>
                        <?php echo $r->localidad ?></p>
                      </a> </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  <?php } else { ?>
    <div class="container">
      <div class="tab-content">
        <div id="projects-under-construction" class="tab-pane active">
          <div class="row">
            <?php foreach($finalizados as $r) { ?>
              <div class="col-md-3">
                <div class="feature-item">
                  <?php mostrar_etiqueta($r) ?>
                  <div class="feature-image"> <a href="<?php echo mklink($r->link); ?>"><img src="/admin/<?php echo $r->path ?>" alt="<?php echo $r->nombre ?>" /></a>
                    <div class="overlay-info">
                      <div class="center-content">
                        <div class="align-center"> <a href="<?php echo mklink($r->link); ?>"></a> </div>
                      </div>
                    </div>
                    <div class="about-product"> <a href="<?php echo mklink($r->link); ?>"><?php echo $r->nombre ?>
                      <p><?php echo $r->calle ?><br>
                        <?php echo $r->localidad ?></p>
                      </a> </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
</div>
<?php include("includes/footer.php"); ?>
</body>
</html>
