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
body { font-family: "Calibri", Helvetica, Arial, sans-serif }
.titulo{
  font-size: 16px;
}
.subtitulo{
  font-size: 10px;
}
hr{
  margin-top: 5px;
  margin-bottom: 5px;
  height: 0px;
  width: 100%;
  border-top: 1px solid black; 
}
table{
  margin-top: 20px;
  width: 100%;
}
.separador{
  width: 100%;
  padding: 3px;
  background-color: #c7c7c7;
  color: black;
  text-align: center;
  margin-top: 10px;
  margin-bottom: 10px;
}
th{
  margin: 10px 0;
  padding: 3px;
  background-color: #c7c7c7;
  color: black;
  text-align: center;
}
td { padding: 3px; }
tbody tr{
  border-bottom: 1px solid #b2acac;
}
.total{ border-right: 1px solid #b2acac; }
.bodyprint{ border: 1px solid #b2acac !important; padding: 0px;}
@media print {
  body { -webkit-print-color-adjust: exact; font-size: 13px;} 
  .inner.second { margin-top: 45px; }
  .inner { padding: 0px 0px 0px 0px; }
  .a4inner { padding: 0px; }
  .a4 { page-break-after: always; padding: 20px; }
  .a4:last-child { page-break-after: avoid; }
  .separador { background-color: #b2acac !important; -webkit-print-color-adjust: exact; }
  hr { border: 1px solid #b2acac !important; -webkit-print-color-adjust: exact; }
  th {  background-color: #b2acac !important; -webkit-print-color-adjust: exact; }
  .bodyprint{ border: 1px solid #b2acac !important; -webkit-print-color-adjust: exact;  }
}
@page {
  size: auto;
  margin: 10px;
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
            $total = $factura->total - $total_items + $total_extras; ?>
            <div class="col-xs-12 bodyprint">
              <div class="col-xs-6 mt10 mb10">
                <span class="titulo">RECIBO X</span><br>
                <span class="subtitulo">Documento no <br> valido como factura</span>
              </div>
              <div class="col-xs-6 pl5 pr5">
                <?php if(!empty($empresa->logo)) { ?>
                  <img style="width: 100%; height: 60px; object-fit: contain;" src="/admin/<?php echo $empresa->logo ?>"/>
                <?php } ?>
              </div>
              <div class="col-xs-12 p0">
                <p class="separador">DATOS INMOBILIARIA</p>
              </div>
              <div class="datos">
                <div class="col-xs-12">
                  <div class="row">
                    <div class="col-xs-6">
                    <?php if (isset($empresa->direccion_empresa) && !empty($empresa->direccion_empresa)) { ?>
                      <?php echo $empresa->direccion_empresa ?><br>
                    <?php } ?>
                    <?php if (isset($empresa->telefono_empresa) && !empty($empresa->telefono_empresa)) { ?>
                      <?php echo "Tel: ".($empresa->id == 1392) ? "4216000" : $empresa->telefono_empresa ?><br>
                    <?php } ?>
                    </div>
                    <div class="col-xs-3 tac">
                      <span>Número: <br> <b><?php echo $factura->numero?></b> </span>
                    </div>
                    <div class="col-xs-3 tac">
                      <span>Fecha: <br> <?php echo date("d/m/Y") ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-xs-12 mt10">
                  <div class="row">
                    <div class="col-xs-5">
                      <?php if (isset($empresa->razon_social) && !empty($empresa->razon_social)) { ?>
                        <?php echo $empresa->razon_social?><br>
                      <?php } ?>
                      <?php if ($empresa->id == 1392) { ?>
                        <i>Responsable monotributo</i>
                      <?php } ?>
                    </div>
                    <div class="col-xs-7">
                      <?php if (isset($empresa->cuit) && !empty($empresa->cuit)) { ?>
                        <span>CUIT: <?php echo $empresa->cuit?></span><br>
                      <?php } ?>
                      <?php if (isset($empresa->numero_ib) && !empty($empresa->numero_ib)) { ?>
                        <span>Ing. Brutos: <?php echo $empresa->numero_ib?></span>
                      <?php } ?>
                      <?php if (isset($empresa->fecha_inicio) && !empty($empresa->fecha_inicio)) { ?>
                        <div>
                          Inicio de Act: <span><?php echo $empresa->fecha_inicio ?></span>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 p0">
                <p class="separador">DATOS DEL LOCADOR/A Y LOCATARIO/A</p>
              </div>
              <div class="col-xs-12">
                <?php if (isset($factura->propietario) && !empty($factura->propietario)) { ?>
                  Propietario/a: <?php echo $factura->propietario ?> <br>
                <?php } ?>
                <?php if (isset($cliente->direccion) && !empty($cliente->direccion)) { ?>
                  Domicilio: <?php echo $cliente->direccion ?><br>
                <?php } ?>
                <?php if (isset($cliente->celular) && !empty($cliente->celular)) { ?>
                  Tel: <?php echo $cliente->celular ?><br>
                <?php } ?>
                <?php if (isset($cliente->localidad) && !empty($cliente->localidad)) { ?>
                  Localidad <?php echo $cliente->localidad?><br>
                <?php } ?>
              </div>
              <div class="col-xs-12 p0">
                <hr>
              </div>
              <div class="col-xs-12">
                <div style="font-size: 13px; line-height: 17px; ">
                  POR EL MANDATO DEL PROPIETARIO ENTREGUE
                  LA SUMA DE <?php echo ($factura->moneda == 'U$D') ? 'DOLARES' : 'PESOS' ?> <?php echo strtoupper($letras->ValorEnLetras($total)) ?>
                  POR EL ALQUILER DE <?php echo strtoupper($factura->propiedad) ?>
                  QUE OCUPA EN <?php echo strtoupper($factura->direccion) ?>
                  EN EL PERÍODO <?php echo strtoupper($factura->corresponde_a) ?>
                  QUE VENCE EL <?php echo strtoupper($factura->vencimiento) ?>.<br/>
                </div>
              </div>
              <div class="col-xs-12 p0">
                <table>
                  <tr>
                    <th>CONCEPTOS ABONADOS</th>
                    <th class="w90">IMPORTE</th>
                  </tr>
                  <tbody>
                    <?php if ($factura->total_sin_comision != 0) { ?>
                      <tr>
                        <td class="pl5">ALQUILER <?php echo $factura->corresponde_a ?></td>
                        <td class="tar pr5">$ <?php echo round($factura->total_sin_comision,0); ?></td>
                      </tr>
                    <?php } ?>
                    <?php if ($factura->expensa != 0) { ?>
                      <tr>
                        <td class="pl5">EXPENSA</td>
                        <td class="tar pr5">$ <?php echo round($factura->expensa,0); ?></td>
                      </tr>
                    <?php } ?>
                    <?php if (sizeof($factura->items)>0) { ?>
                      <?php foreach($factura->items as $i) { ?>
                        <tr>
                          <td class="pl5"><?php echo $i->nombre; ?></td>
                          <td class="tar pr5"> $ -<?php echo round($i->monto,0); ?></td>
                        </tr>
                      <?php } ?>  
                    <?php } ?>
                    <?php if (sizeof($factura->expensas)>0) { ?>
                      <?php foreach($factura->expensas as $i) { ?>
                        <tr>
                          <td class="pl5"><?php echo $i->nombre; ?></td>
                          <td class="tar pr5">$ <?php echo round($i->monto,0); ?></td>
                        </tr>
                      <?php } ?>  
                    <?php } ?>
                    <?php if (sizeof($factura->extras)>0) { ?>
                      <?php foreach($factura->extras as $i) { ?>
                        <tr>
                          <td class="pl5"><?php echo $i->nombre; ?></td>
                          <td class="tar pr5">$ <?php echo round($i->monto,0); ?></td>
                        </tr>
                      <?php } ?>  
                    <?php } ?>
                    <?php if ($factura->comision != 0) { ?>
                      <tr>
                        <td class="pl5">COMISION (<?php echo $factura->comision ?>%)</td>
                        <td class="tar pr5">-$ <?php echo round($factura->total_sin_comision - $total,0); ?></td>
                      </tr>
                    <?php } ?>                  
                    <tr>
                      <td class="total tar pr5"><b>TOTAL</b></td>
                      <td class="tar pr5"><b>$ <?php echo round($total,0); ?></b></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-xs-12 p0">
                <p class="separador">FIRMA DE LOS CONTRATANTES</p>
              </div>
              <div class="col-xs-12">
                <div class="row tac">
                  <div class="col-xs-12">
                    RECIBÍ CONFORME ..............................<br>
                    <span style="¨margin-left: 10px">Propietario/a</span>
                  </div>
                  <div class="col-xs-6">
                    ..............................<br/>FIRMA INMOBILIARIA
                  </div>
                  <div class="col-xs-6">
                    ..............................<br/>ACLARACI&Oacute;N INMOBILIARIA
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      <?php } ?>



    </div>
  </div>
</body>
</html>