<?php function item_entrada($n)
{ ?>
<div class="noved-card">
    <a href="<?php echo mklink($n->link); ?>" class="noved-warp">
        <span>
            <img src="assets/images/icons/icon-15.png" alt="Icon">
        </span>
        <b class="fill-btn"><?php echo $n->categoria; ?></b>
        <img src="<?php echo $n->path; ?>" alt="Noved">
    </a>
    <div class="noved-inner">
        <a href="<?php echo mklink($n->link); ?>" class="noved-redirect">
            <h3><?php echo $n->titulo; ?></h3>
        </a>
        <?php
      $fecha = str_replace('/', '-', $n->fecha);
    $mes = get_mes(date('m', strtotime($fecha)));
    ?>
        <h5><small><?php echo $n->dia; ?></small><?php echo $mes; ?> del <?php echo $n->anio; ?></h5>
        <p><?php echo $n->descripcion; ?></p>
    </div>
</div>
<?php } ?>