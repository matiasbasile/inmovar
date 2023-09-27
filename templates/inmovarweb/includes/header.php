<header>
  <div class="container">
    <div class="logo"><a href="<?php echo mklink("/"); ?>"><img src="images/logo.png" alt="Logo"><?php echo strtolower($empresa->nombre) ?></a></div>
    <nav class="navbar navbar-expand-xl navbar-light">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo mklink("/")."#caracteristicas" ?>">Caracter&iacute;sticas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo mklink("/")."#clientes" ?>">Clientes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo mklink("/")."#soporte" ?>">Soporte</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo mklink("/")."#faq" ?>">Preguntas</a>
          </li>
          <?php $secciones = $entrada_model->get_list(array(
            "categoria"=>"secciones"
          )); 
          foreach($secciones as $r) { ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo mklink($r->link) ?>"><?php echo $r->titulo ?></a>
            </li>
          <?php } ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo mklink("web/precios/") ?>">Precios</a>
          </li>
        </ul>             
        <div class="pull-right">
          <a class="btn btn-border" target="_blank" href="https://www.varcreative.com/sistema/"><i class="fa fa-user" aria-hidden="true"></i> Acceso</a>
          <a class="btn btn-aquamarine" href="<?php echo mklink("web/registro/"); ?>">Registro</a>
        </div>
      </div>
    </nav>
    <div class="pull-right">
      <a class="btn btn-border" target="_blank" href="https://www.varcreative.com/sistema/"><i class="fa fa-user" aria-hidden="true"></i> Acceso</a>
      <a class="btn btn-aquamarine" href="<?php echo mklink("web/registro/"); ?>">Registro</a>
    </div>
  </div>
</header>