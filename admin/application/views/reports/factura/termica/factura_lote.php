<?php
error_reporting(0);
ini_set('display_errors', 0);

$copia = 0;
function ver_comprobante($id_tipo_comprobante) {
  $comprobante = "";
  switch ($id_tipo_comprobante) {
    case 1:
      $comprobante = ("FACTURA"); break;
    case 2:
      $comprobante = ("NOTA DE D&Eacute;BITO"); break;
    case 3:
      $comprobante = ("NOTA DE CR&Eacute;DITO"); break;
    case 4:
      $comprobante = ("RECIBO"); break;
    case 6:
      $comprobante = ("FACTURA"); break;
    case 7:
      $comprobante = ("NOTA DE D&Eacute;BITO"); break;
    case 8:
      $comprobante = ("NOTA DE CR&Eacute;DITO"); break;
    case 9:
      $comprobante = ("RECIBO"); break;
    case 11:
      $comprobante = ("FACTURA"); break;
    case 12:
      $comprobante = ("NOTA DE D&Eacute;BITO"); break;
    case 13:
      $comprobante = ("NOTA DE CR&Eacute;DITO"); break;
    case 15:
      $comprobante = ("RECIBO"); break;
    case 998:
      $comprobante = ("PRESUPUESTO"); break;
    case 999:
      $comprobante = ("REMITO"); break;
  }
  return $comprobante;
}

function discrimina_iva($id_tipo_comprobante) {
  return ($id_tipo_comprobante < 6) ? 1 : 0;
}

function ver_letra($id_tipo_comprobante) {
  if ($id_tipo_comprobante < 6) return "A";
  else if ($id_tipo_comprobante < 11) return "B";
  else if ($id_tipo_comprobante < 16) return "C";
  else return "R";
}

function mostrar_iva($id) {
  switch($id) {
    case 3: return "0%";
    case 4: return "10.5%";
    case 5: return "21%";
    case 6: return "27%";
    case 8: return "5%";
    case 9: return "2.5%";
  }
  return "";
}
?>
<!DOCTYPE>
<html>
<head>
<title>Impresion de comprobantes</title>
<script type="text/javascript" src="/sistema/resources/js/jquery.js"></script>
<style type="text/css">
#barra {}
<?php $cborde = "#a1a1a1"; ?>
.inner { padding: 5px; }
body { font-family: Arial; font-size: 14px; background-color: #EEE; }
h1 { font-size: 20px; }
.borde { border: solid 1px <?php echo $cborde; ?>; overflow: hidden; }
.tac { text-align: center; }
.tar { text-align: right; }
.tal { text-align: left; }
.fl { float: left; }
.fr { float: right; }
p { margin-top: 3px; margin-bottom: 5px; }
.w60p { width: 60%; }
.w50p { width: 50%; }
.w40p { width: 40%; }
.w100p { width: 100%; }
.oh { overflow: hidden; }
.bold { font-weight: bold; }
.p20 { padding: 20px; }
.ml30 { margin-left: 30px; }
.tabla { padding: 10px 0px; margin: 10px 0px; border-top: solid 1px <?php echo $cborde; ?>; border-bottom: solid 1px <?php echo $cborde; ?>; }
#total { font-weight: bold; font-size: 16px; margin-top: 15px; border-top: solid 1px <?php echo $cborde; ?>; padding-top: 15px; }
.barcode { margin-top: 20px; font-size: 8px; text-align: center; }
.barcode > div { margin-bottom: 3px; }
</style>
</head>
<body style="background-color: white;">
<?php echo $header; ?>
<!-- TERMICA_LOTE -->
<div id="printable">
  <?php foreach($facturas as $factura) { 

    // Le sacamos el IVA para no imprimirlo
    $discrimina_iva = discrimina_iva($factura->id_tipo_comprobante);
    $letra = ver_letra($factura->id_tipo_comprobante);
    $comprobante = ver_comprobante($factura->id_tipo_comprobante);
    $factura->iva = ($discrimina_iva == 1) ? $factura->iva : 0;
    ?>
    <div class="">
      <div class="inner">
        <div class="">
          <div>
            <h2 style="margin: 5px 0px; padding: 0px; font-size: 14px;"><?php echo $factura->comprobante; ?></h2>
            <?php if ($factura->id_tipo_comprobante < 900) { ?>
              <div style="font-size: 12px" class="codigo_comprobante">COD. <?php echo $codigo_comprobante; ?></div>
            <?php } ?>
            <p><?php echo $factura->fecha; ?></p>
          </div>
          <div class="">
            <p class="bold"><?php echo $empresa->razon_social?></p>
            <?php if (!empty($empresa->direccion)) { ?>
              <p><?php echo $empresa->direccion ?></p>
            <?php } ?>
            <p><?php echo $empresa->cuit; ?></p>
            <?php if (!empty($empresa->config["numero_ib"])) { ?>
              <p><b>Ingresos Brutos: </b><?php echo $empresa->config["numero_ib"]; ?></p>
            <?php } ?>
            <?php
            $fecha_inicio = $empresa->config["fecha_inicio"];
            if ($fecha_inicio != "0000-00-00" && $fecha_inicio != "00/00/0000") { ?>
              <p><b>Inicio de Actividades: </b> <?php echo $fecha_inicio ?></p>
            <?php } ?>
            <p><b>
            <?php
            switch($empresa->id_tipo_contribuyente) {
              case 1: echo "IVA RESPONSABLE INSCRIPTO"; break;
              case 2: echo "MONOTRIBUTO"; break;
              case 3: echo "IVA EXENTO"; break;
            }
            ?>
            </b></p>            
          </div>
          
        </div>
        <div style="padding-top: 10px; border-top: solid 1px black; margin: 5px 0px;">
          <p>
            <b>Cliente: </b>
            <br/><span><?php echo ($factura->cliente->nombre); ?></span>
          </p>
          <?php if(!empty($factura->cliente->cuit)) { ?>
            <p><b>CUIT: </b><span><?php echo $factura->cliente->cuit; ?></span></p>
          <?php } ?>
          <?php if (!empty($factura->cliente->direccion)) { ?>
            <p>
              <b>Domicilio: </b> 
              <span><?php echo ($factura->cliente->direccion); ?>
              <?php if (!empty($factura->cliente->localidad)) { ?>
                - <?php echo ($factura->cliente->localidad); ?>
              <?php } ?>
              </span>
            </p>
          <?php } ?>
          <p>
            <b>Condici&oacute;n IVA: </b> <span><?php echo $factura->cliente->tipo_iva; ?></span>
          </p>
        </div>
        <div class="tabla">
          <?php 
          $total_neto = 0; $total_con_iva = 0;
          foreach($factura->items as $i) { ?>
            <?php if ($i->anulado == 0) { ?>
              <?php if ($i->id_articulo != 0 && $i->cantidad == 0 && ($i->tipo_cantidad == "" || $i->tipo_cantidad == "X")) continue; ?>
              <p>
                <?php echo ($i->tipo_cantidad == "B")?"<b>Bonificado: </b>":"" ?>
                <?php echo $i->nombre; ?>
                <?php echo ((isset($i->variante) && !empty($i->variante))?"<br/><span>".($i->variante)."</span>":""); ?>
                <?php if (!empty($i->descripcion)) { ?>
                  <br/><span><?php echo $i->descripcion; ?></span>
                <?php } ?>
              </p>
              <p>
                Cant: <?php echo number_format($i->cantidad,2); ?> | Unit: $ <?php echo number_format((($discrimina_iva==1)?$i->neto:$i->precio),2); ?>
                | Subtotal: $ <?php echo number_format((($discrimina_iva==1)?$i->total_sin_iva:$i->total_con_iva),2); ?>
              </p>
              <?php $total_neto += $i->total_sin_iva; ?>
              <?php $total_con_iva += $i->total_con_iva; ?>
            <?php } ?>
          <?php } ?>
        </div>

        <?php if ($nro_pieza == sizeof($piezas_items)) { ?>
          <div>
            <?php if (!empty($factura->cae)) { ?>
              <p>
                <span>C.A.E.:</span>
                <span><?php echo $factura->cae ?></span>
              </p>
              <p>
                <span>Fecha Vto. de CAE:</span>
                <span><?php echo ($factura->fecha_vto); ?></span>
              </p>
            <?php } ?>
            <?php if ($factura->efectivo > 0) { ?>
              <?php if ($factura->tipo_pago == "O") { ?>
                <p><span>Forma Pago: Otro</span> <span><?php echo number_format($factura->efectivo - $factura->vuelto,2) ?></span></p>
              <?php } else { ?>
                <p><span>Efectivo: </span> <span>$ <?php echo number_format($factura->efectivo,2) ?></span></p>
                <p><span>Vuelto: </span> <span>$ <?php echo number_format($factura->vuelto,2) ?></span></p>
              <?php } ?>
            <?php } ?>
            <?php if ($factura->tarjeta > 0) { ?>
              <?php if ($factura->tipo_pago == "B") { ?>
                <p><span>Banco:</span> <span><?php echo number_format($factura->tarjeta,2) ?></span></p>
              <?php } else { ?>
                <p><span>Tarjeta:</span> <span><?php echo number_format($factura->tarjeta,2) ?></span></p>
              <?php } ?>
            <?php } ?>
            <?php if ($factura->cta_cte > 0) { ?>
              <p><span>Cta. Cte.:</span> <span><?php echo number_format($factura->cta_cte,2) ?></span></p>
            <?php } ?>
            <?php if ($factura->cheque > 0) { ?>
              <p><span>Cheque:</span> <span><?php echo number_format($factura->cheque,2) ?></span></p>
            <?php } ?>

            <?php if (!empty($factura->observaciones)) {
              // Analizamos las observaciones
              $obs = (nl2br($factura->observaciones));
              $obs = str_replace("{{COTIZACION_DOLAR}}",$factura->cotizacion_dolar,$obs);
              $obs = str_replace("{{TOTAL_EN_LETRAS}}",strtoupper($letras->ValorEnLetras(round($factura->total,2),"PESOS")),$obs);
              if ($factura->cotizacion_dolar == 0) {
                $obs = str_replace("{{TOTAL_EN_DOLARES}}","",$obs);
                $obs = str_replace("{{TOTAL_EN_DOLARES_EN_LETRAS}}","",$obs);
              } else {
                $total_dolares = round($factura->total / $factura->cotizacion_dolar,2);
                $obs = str_replace("{{TOTAL_EN_DOLARES}}",$total_dolares,$obs);
                $obs = str_replace("{{TOTAL_EN_DOLARES_EN_LETRAS}}",strtoupper($letras->ValorEnLetras($total_dolares,"DOLARES")),$obs);
              }
              ?>
              <p><?php echo $obs ?></p>
            <?php } ?>
            <div class="totales">
              <?php if ($discrimina_iva) { ?>
                <p id="subtotal">
                  <span>SUBTOTAL NETO:</span>
                  <span>$ <?php echo number_format($total_neto,2); ?></span>
                </p>
              <?php } ?>
              <?php if ($factura->porc_descuento > 0) { ?>
                <p id="descuento">
                  <span>DTO. <?php echo number_format($factura->porc_descuento,2) ?> %:</span>
                  <span>$ <?php echo number_format($factura->descuento,2) ?></span>
                </p>
              <?php } else if ($factura->descuento > 0) { ?>
                <p id="descuento">
                  <span>DESCUENTO:</span>
                  <span>$ <?php echo number_format($factura->descuento,2) ?></span>
                </p>
              <?php } ?>
              <?php if ($discrimina_iva == 1) { ?>
                <?php foreach($factura->ivas as $i) { ?>
                  <p id="iva">
                    <span>IVA <?php echo mostrar_iva($i->id_alicuota_iva); ?>:</span>
                    <span>$ <?php echo number_format($i->iva,2); ?></span>
                  </p>
                <?php } ?>
              <?php } ?>
              <?php if ($factura->interes > 0) { ?>
                <p id="descuento">
                  <span>RECARGO TARJETA:</span>
                  <span>$ <?php echo number_format($factura->interes,2) ?></span>
                </p>
              <?php } ?>
              <p id="total">
                <span>TOTAL:</span>
                <span>$ <?php echo number_format($factura->total,2); ?></span>
              </p>
            </div>
          </div>

          <?php if ($empresa->id == 1354) { ?>
            <p>
              <span>Retiro:</span>
              <span><?php echo $factura->fecha_vto ?></span>
            </p>
            <p>
              <span>Entrega:</span>
              <span><?php echo $factura->fecha_reparto ?></span>
            </p>
          <?php } else { ?>
            <div class="barcode">
              <div><img src="/sistema/application/helpers/barcode.php?text=<?php echo $barcode; ?>" /></div>
              <div><?php echo $barcode ?></div>
            </div>
          <?php } ?>
        <?php } ?>

      </div>
    </div>
  <?php } ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
  var altura = $("#footer_tabla_1").height();
  $("#footer_tabla_2").height(altura);

  <?php //if ($factura->id_empresa == 229 || $factura->id_empresa == 230) { ?>
    window.print();
  <?php //} ?>

});
</script>
</body>
</html>