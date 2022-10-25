<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("includes/init.php");
$page = isset($_GET["page"]) ? intval($_GET["page"]) : 0;
$offset = isset($_GET["offset"]) ? intval($_GET["offset"]) : 2;
$categoria = isset($_GET["categoria"]) ? $_GET["categoria"] : "";
$config = array(
  "page" => $page,
  "offset" => $offset,
  "categoria" => $categoria,
);

$mas_entradas = $entrada_model->get_list($config);

foreach ($mas_entradas as $ent) { ?>
  <div class="col-lg-4 col-md-6">
    <div class="noved-card">
      <div class="noved-warp">
        <span>
          <a href="<?php echo mklink($ent->link) ?>">
            <img src="assets/images/icons/icon-15.png" alt="Icon">
          </a>
        </span>
        <a href="#0" class="fill-btn fill-btn-solidarias"><?php echo $ent->categoria ?></a>
        <a href="<?php echo mklink($ent->link) ?>">
          <img src="<?php echo $ent->path ?>" alt="<?php echo $ent->titulo ?>">
        </a>
      </div>
      <div class="noved-inner">
        <a href="<?php echo mklink($n->link) ?>" class="noved-redirect">
          <h2 class="noved-redirect"><?php echo $ent->titulo ?></h2>
        </a>
        <div class="noved-inner">
          <?php
          $fecha = str_replace('/', '-', $ent->fecha);
          $mes =  $mes_month[date('n', strtotime($fecha))]
          ?>
          <h5><small><?php echo $ent->dia; ?></small><?php echo $mes ?> del <?php echo $ent->anio; ?></h5>
          <p>
            <?php echo $ent->plain_text ?>
          </p>
        </div>
      </div>
    </div>
  </div>
<?php } ?>