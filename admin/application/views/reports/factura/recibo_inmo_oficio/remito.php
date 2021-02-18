<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE>
<html>
<head>
<title>Recibo</title>
<link href="/admin/resources/css/common.css" rel="stylesheet"/>
<link href="/admin/resources/css/bootstrap.css" rel="stylesheet"/>
<style type="text/css">
#barra {}
<?php $cborde = "#a1a1a1"; ?>

.titulo{
  font-size: 18px;
}
.subtitulo{
  font-size: 12px;
}
hr{
  margin: 1px;
  border: 2px solid black;
}
table{
  margin-top: 20px;
}
.separador{
  width: 100%;
  padding: 3px;
  background-color: grey;
  color: black;
  text-align: center;
  margin-top: 10px;
  margin-bottom: 10px;
}
th{
  margin: 10px 0;
  width: 100%;
  padding: 3px;
  background-color: grey;
  color: black;
  text-align: center;
}
@media print {
  body { -webkit-print-color-adjust: exact; } 
  .inner.second { margin-top: 45px; }
  .inner { padding: 0px 0px 0px 0px; }
  .a4inner { padding: 0px; }
  .a4 { page-break-after: always; padding: 20px; }
  .a4:last-child { page-break-after: avoid; }
}
@page {
  size: auto;
  margin: 0px;
}
</style>
</head>
<body>
  <?php echo $header; ?>

  <div id="printable">
    <div class="row">

      <?php for ($x = 0; $x < 3; $x++) { ?>
        <div class="col-xs-4">
          <?php foreach($facturas as $factura) { 

            $total_items = 0;
            foreach($factura->items as $i) { 
              $total_items += $i->monto;
            }
            $total_extras = 0;
            foreach($factura->extras as $i) { 
              $total_extras += $i->monto; 
            }
            $factura->total += $total_items + $total_extras;
          ?>
            <div class="col-xs-6">
              <span class="titulo">RECIBO <?php echo $factura->comprobante?></span><br>
              <span class="subtitulo">Documento no <br> valido como factura</span>
            </div>
            <div class="col-xs-6">
              <?php if(!empty($empresa->logo)) { ?>
                <img style="width: 100%; height: 60px;" src="/admin/<?php echo $empresa->logo ?>"/>
              <?php } ?>
            </div>
            <div class="col-xs-12">
              <p class="separador">DATOS INMOBILIARIA</p>
            </div>
            <div class="datos">
              <div class="col-xs-6">
                <?php if (isset($empresa->direccion_empresa) && !empty($empresa->direccion_empresa)) { ?>
                  <?php echo $empresa->direccion_empresa ?><br>
                <?php } ?>
                <?php if (isset($empresa->telefono_empresa) && !empty($empresa->telefono_empresa)) { ?>
                  <?php echo $empresa->telefono_empresa ?><br>
                <?php } ?>
                <?php if (isset($empresa->razon_social) && !empty($empresa->razon_social)) { ?>
                  <?php echo $empresa->razon_social?><br>
                <?php } ?>
                <i>Responsable monotributo</i>
              </div>
              <div class="col-xs-6">
                <span>Número:</span><br> <span>Fecha: <?php echo date("d/m/Y") ?></span><br>
                <?php if (isset($empresa->cuit) && !empty($empresa->cuit)) { ?>
                  <span>CUIT: <?php echo $empresa->cuit?></span><br>
                <?php } ?>
                <?php if (isset($empresa->numero_ib) && !empty($empresa->numero_ib)) { ?>
                  <span>INGRESOS BRUTOS: <?php echo $empresa->numero_ib?></span>
                <?php } ?>
                <?php if (isset($empresa->fecha_inicio) && !empty($empresa->fecha_inicio)) { ?>
                  <div>
                    INICIO ACT.: <span><?php echo $empresa->fecha_inicio ?></span>
                  </div>
                <?php } ?>
              </div>
            </div>
            <div class="col-xs-12">
              <p class="separador">DATOS DEL LOCADOR/A Y LOCATARIO/A</p>
            </div>
            <div class="col-xs-12">
              Locatario/a: <?php echo $factura->cliente ?> <br>
              Domicilio: <?php echo $factura->direccion ?><br>
              Tel: <br>
              Localidad<br>
              <hr>
              <div style="font-size: 15px; line-height: 20px; ">
                POR EL MANDATO DEL LOCADOR RECIBI
                LA SUMA DE PESOS <?php echo $letras->ValorEnLetras($factura->total) ?>
                POR EL ALQUILER DE <?php echo $factura->propiedad ?>
                QUE OCUPA EN <?php echo $factura->direccion ?>
                QUE VENCE EL <?php echo $factura->vencimiento ?>.<br/>
              </div>
            </div>
            <div class="col-xs-12">
              <table>
                <tr>
                  <th>CONCEPTOS ABONADOS</th>
                  <th></th>
                  <th>IMPORTE</th>
                </tr>
                <tbody>
                  <?php if (sizeof($factura->items)>0) { ?>
                    <?php foreach($factura->items as $i) { ?>
                      <tr>
                        <td><?php echo $i->nombre; ?></td>
                        <td></td>
                        <td>$ <?php echo number_format($i->monto,2); ?></td>
                      </tr>
                    <?php } ?>  
                  <?php } ?>
                  <?php if (sizeof($factura->extras)>0) { ?>
                    <?php foreach($factura->extras as $i) { ?>
                      <tr>
                        <td><?php echo $i->nombre; ?></td>
                        <td></td>
                        <td>$ <?php echo number_format($i->monto,2); ?></td>
                      </tr>
                    <?php } ?>  
                  <?php } ?>
                  <tr>
                    <td></td>
                    <td>TOTAL</td>
                    <td><?php echo ($factura->total) ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-xs-12">
              <p class="separador">FIRMA DE LOS CONTRATANTES</p>
            </div>
            <div class="col-xs-12">
              <div style="">
                RECIBÍ CONFORME:<br><br>
                FIRMA INMOBILIARIA: <br/><br/>
                ACLARACI&Oacute;N INMOBILIARIA:
              </div>
            </div>
          <?php } ?>
        </div>
      <?php } ?>



    </div>
  </div>
</body>
</html>