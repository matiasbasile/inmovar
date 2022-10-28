<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("includes/init.php");
$page = isset($_GET["page"]) ? intval($_GET["page"]) : 0;
$offset = isset($_GET["offset"]) ? intval($_GET["offset"]) : 6;
$categoria = isset($_GET["categoria"]) ? $_GET["categoria"] : "";
$fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : "";
$orden = 1;
if ($fecha === 'antigua') {
  $orden = 2;
  $order_by = "A.fecha ASC ";
} else {
  $orden = 1;
  $order_by = "A.fecha DESC ";
}

$config = array(
  "page" => $page,
  "offset" => $offset,
  "from_link_categoria" => $categoria,
  "order" => $orden,
);

// $mas_entradas = $entrada_model->get_list(array($config));
extract($entrada_model->get_variables($config));
echo "Categoria: " . $categoria;

$mes_month = array(
  1 => 'Enero',
  2 => 'Febrero',
  3 => 'Marzo',
  4 => 'Abril',
  5 => 'Mayo',
  6 => 'Junio',
  7 => 'Julio',
  8 => 'Agosto',
  9 => 'Septiembre',
  10 => 'Octubre',
  11 => 'Noviembre',
  12 => 'Diciembre',
);

foreach ($vc_listado as $ent) { ?>
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