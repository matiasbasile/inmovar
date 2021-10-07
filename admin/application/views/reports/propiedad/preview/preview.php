<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<!DOCTYPE>
<html>
<head>
<title>Datos de la propiedad <?php echo $propiedad->nombre ?></title>

<style type="text/css">
#barra {}
<?php $cborde = "#a1a1a1"; ?>
.a4 {
  width: 210mm;
  height: 291mm;
  overflow: hidden;
  margin: 0 auto;
  background-color: white;
}
.a4inner { padding: 20px; }
.inner { padding: 0px; }
.inner.second { margin-top: 20px; }
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
.w55p { width: 55%; }
.w40p { width: 40%; display: inline-block;}
.w30p { width: 30%; }
.w20p { width: 20%; display: inline-block;}
.w100p { width: 100%; }
.oh { overflow: hidden; }
.bold { font-weight: bold; }
.p20 { padding: 20px; }
.ml30 { margin-left: 30px; }
.mt40 { margin-top: 40px; }
.mt10{margin-top: 10px;}
th { text-align: left; }

.tabla { min-height: 360px; border: solid 1px <?php echo $cborde; ?> }
.tabla table { width: 100%; border-collapse: collapse; font-size: 13px; }
.tabla table thead th { background-color: #e1e1e1; padding: 8px; }
.tabla table td { padding: 3px 8px; vertical-align: top; font-size: 13px; }
table td { font-size: 14px; }

.totales { }
.totales > p { margin-bottom: 3px; margin-top: 3px;}
.totales > p > span { font-weight: bold; display: inline-block; text-align: left; width: 48%; }
.totales > p > span:first-child { font-weight: normal; text-align: right;  }
#total { font-weight: bold; font-size: 16px; border-top: solid 1px <?php echo $cborde; ?>; padding-top: 5px; padding-bottom: 5px }

.cae_container { margin-top: 20px; }
.cae_container > p > span { text-align: left; margin-right: 10px; }
.cae_container > p > span:first-child { font-weight: bold;  }

.letra { position: relative; top: -21px; left: -56px; background-color: white; float: left; text-align: center; border: solid 1px <?php echo $cborde; ?>; }
.letra h1 { font-size: 42px; margin: 0px; padding: 10px 18px; border-bottom: solid 1px <?php echo $cborde; ?>; }
.letra .codigo_comprobante { font-size: 9px; margin-top: 3px; margin-bottom: 3px; }

.barcode { margin-top: 20px; font-size: 8px; text-align: center; }
.barcode > div { margin-bottom: 3px; }
button.btn-negro {
    background-color: #00babc;
    width: 100px;
    height: 30px;
    border-radius: 15px;
    color: white;
    border: none;
}
.img{
  text-align: center;
  margin-bottom: 20px;
}

.btn-negro:hover{cursor:pointer;}
body{font-family: 'product_sansregular',Helvetica, Arial, sans-serif;}
@media print {
  body {-webkit-print-color-adjust: exact;}
  .inner.second { margin-top: 60px; }
  .inner { padding: 0px 0px 0px 0px; }
  .a4inner { padding: 0px; }
  .a4 { page-break-after: always; padding: 20px; }
  .a4:last-child { page-break-after: avoid; }
  .press{display: none;}
}
.w60{width: 60%; display: inline-block;}
.w55{width: 55%; display: inline-block;}
.w40{width: 40%; display: inline-block;}

.w36{width: 36%; display: inline-block;}
.w50{width: 50%; display: inline-block;}
.w33{width: 33.3%; display: inline-block;}
.mt20{margin-top: 20px !important;}
.pl20{padding-left: 20px;}
.fs20{font-size: 20px;}
.text-info{color: #00babc}
.db{display: block;}
.bg-inmovar{background-color: #1d36c2;}
.bg-success{background-color: #0dd384;}
.text-muted{color: #ace4f5 !important;}
.text-muted2{color : #5a5a5a !important;}
.font-thin{font-weight: normal;}
.text-white{color: #fff;}
.h1{font-size: 36px;}
.pt20{padding-top: 20px;}
.br3{border-radius: 3px;}
.fs16{font-size: 16px;}
.op-venta{ padding: 0px;border-radius: 6px;background-color: #67cf8b;color: #FFF;display: inline-block;margin-bottom: 6px;margin-right: 10px;overflow: hidden;}
.op-operation{display: inline-block;vertical-align: middle;font-weight: normal;font-size: 16px;padding: 6px 10px;background-color: #55b175;}
.op-values{display: inline-block;vertical-align: middle;}
.op-value{display: inline-block;vertical-align: middle;font-weight: normal;font-size: 16px;padding: 6px 10px;}
.op-value:first-child {border-left: none;}
.text-title{display: block; margin-bottom: 5px; font-weight: bolder;margin-top: 10px;}
h3{border-bottom: 1px solid #1d36c2;padding-bottom: 20px;}
</style>
<script>
  function imprimir() {
      window.print();
  }
</script>
</head>
<body>
  <?php// echo $header; ?>
  <div id="printable">
    <div class="a4">
      <div class="a4inner">
        <div class="inner">

          <div style="display: flex;">
            <div class="w55">
              <img class="w100p" src="/admin/<?php echo $propiedad->images[0]; ?>">
            </div>
            <div class="w40 pl20">
              <div class="w100p">
                <h3 class="tac"><?php echo $propiedad->nombre; ?></h3>
              </div>
              <div class="w100p">
                <div class="op-venta">
                  <div class="op-operation"><?= ($propiedad->id_tipo_operacion == 1) ? 'Venta' : 'Alquiler' ?></div>
                  <div class="op-values"> 
                    <div class="op-value"><?= $propiedad->moneda; ?><?= intval($propiedad->precio_final); ?></div>
                  </div>
                </div>
              </div>
              <div style="display: flex;">
                <div class="w60">
                  <span class="text-title">Direccion:</span><?= !empty($propiedad->calle) ? "Calle $propiedad->calle" : ''; ?> <?= !empty($propiedad->altura) ? "altura $propiedad->altura" : ''; ?> <?= !empty($propiedad->piso) ? "piso $propiedad->piso" : ''; ?>
                </div>
                <div class="w40">
                  <span class="text-title">Localidad/Partido:</span><?= $propiedad->localidad ?>
                </div>
              </div>
            </div>

              
          </div>

          <div class="mt20 fs20 ">
            <div>Desde <?php echo date("d/m/Y", strtotime($propiedad->data_graficos->fechas_sql[0]));?> hasta <?php echo date("d/m/Y", strtotime($propiedad->data_graficos->fechas_sql[1]));?></div>
            <div class="block panel padder-v item bg-info mb0 bg-inmovar br3" style="height: 105px; margin-top: 20px;">
              <div class="h1 font-thin text-white h1 m-t-md total_visitas pt20 tac mt10"><?= $propiedad->data_graficos->total_web+$propiedad->data_graficos->total_panel ?></div>
              <span class="text-muted text-md tac db fs16">Visitas</span>
            </div>
            <div style="display: flex;">
              <div class="block panel padder-v item w33 mt10" style="height: 70px">
                <span class="font-thin h1 block m-t-md total_web tac db text-muted2"><?= $propiedad->data_graficos->total_web ?></span>
                <span class="text-muted2 text-md db tac fs16">En tu Web</span>
              </div>
              <div class="block panel padder-v item w33 mt10" style="height: 70px">
                <span class="font-thin h1 block m-t-md total_web tac db text-muted2">0</span>
                <span class="text-muted2 text-md db tac fs16">Otras Webs</span>
              </div>
              <div class="block panel padder-v item w33 mt10" style="height: 70px">
                <span class="font-thin h1 block m-t-md total_web tac db text-muted2"><?= $propiedad->data_graficos->total_panel ?></span>
                <span class="text-muted2 text-md db tac fs16">En el Panel</span>
              </div>
            </div>
            <div class="block panel padder-v item bg-info mb0 bg-success br3" style="height: 105px;">
              <div class="h1 font-thin text-white h1 m-t-md total_visitas pt20 tac mt10"><?= $propiedad->data_graficos->total_consultas_web+$propiedad->data_graficos->total_consultas_panel ?></div>
              <span class="text-muted text-md tac db fs16">Consultas</span>
            </div>
            <div style="display: flex;">
              <div class="block panel padder-v item w33 mt10" style="height: 70px">
                <span class="font-thin h1 block m-t-md total_web tac db text-muted2"><?= $propiedad->data_graficos->total_consultas_web ?></span>
                <span class="text-muted2 text-md db tac fs16">En tu Web</span>
              </div>
              <div class="block panel padder-v item w33 mt10" style="height: 70px">
                <span class="font-thin h1 block m-t-md total_web tac db text-muted2">0</span>
                <span class="text-muted2 text-md db tac fs16">Otras Webs</span>
              </div>
              <div class="block panel padder-v item w33 mt10" style="height: 70px">
                <span class="font-thin h1 block m-t-md total_web tac db text-muted2"><?= $propiedad->data_graficos->total_consultas_panel ?></span>
                <span class="text-muted2 text-md db tac fs16">En el Panel</span>
              </div>
            </div>
            <div id="vision_general_bar" style="height: 200px; margin-top: 20px;"></div>
          </div>


          <div class="mt20" style="display: flex;">
            <div class="">
              <?php foreach ($propiedad->data_graficos->clientes_consultas as $r) { ?>
                <?php
                if ($r->tipo == 1) $tipo = "A contactar";
                if ($r->tipo == 2) $tipo = "Contactado";
                if ($r->tipo == 3) $tipo = "Con actividad";
                if ($r->tipo == 4) $tipo = "En negociacion";
                ?>
                  <p><span class="text-info"> <?php echo $r->cliente_nombre ?></span> | <?php echo date("d/m/Y H:i:s", strtotime($r->fecha));?> | <?php echo $tipo ?> </p>
              <?php } ?>
            </div>
          </div>

          <input type="hidden" id="fecha_desde" value="<?php echo $propiedad->data_graficos->fechas_sql[0] ?>">
          <input type="hidden" id="fecha_hasta" value="<?php echo $propiedad->data_graficos->fechas_sql[1] ?>">
          <input type="hidden" id="visitas_web" value="<?php echo json_encode($propiedad->data_graficos->visitas_web) ?>">
          <input type="hidden" id="visitas_panel" value="<?php echo json_encode($propiedad->data_graficos->visitas_panel) ?>">
          <input type="hidden" id="consultas" value="<?php echo json_encode($propiedad->data_graficos->consultas) ?>">

          <div class="tar mt20 press">
            <button class="btn btn-negro" onclick="imprimir()">Imprimir</button>
          </div>
        </div>      
      </div>
    </div>
  </div>

<script src="/admin/resources/js/jquery/jquery.min.js"></script>
<script src="/admin/resources/js/jquery/highcharts.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    var fecha_desde = $("#fecha_desde").val();
    var visitas_web = $("#visitas_web").val();
    var visitas_panel = $("#visitas_panel").val();
    var consultas = $("#consultas").val();

    var desde_anio = fecha_desde.substr(0,4);
    var desde_mes = fecha_desde.substr(5,5);
    var desde_dia = fecha_desde.substr(8,11);
    
    $('#vision_general_bar').highcharts({
      chart: {
        type: 'area',
        zoomType: 'x'
      },
      title: { text: null },
      legend: {
        floating: true,
        align: "right",
        verticalAlign: "top",
      },
      colors: ['#28b492','#19a9d5','#e7953e'],
      xAxis: {
        type: 'datetime',
        dateTimeLabelFormats: {
          day: '%b %e',
          week: '%b %e'
        }      
      },
      yAxis: {
        allowDecimals: false,
        gridLineColor: '#f9f9f9',
        title: {
          text: null
        }
      },
      tooltip: {
        dateTimeLabelFormats: {
          day: '%e/%m/%Y',
          week: '%e/%m/%Y',
        }
      },
      plotOptions: {
        area: {
          marker: {
            enabled: false,
            symbol: 'circle',
            radius: 2,
            states: {
              hover: { enabled: true }
            }
          }
        },
        series: {
          pointStart: Date.UTC(desde_anio,desde_mes.substr(0,2),desde_dia),
          pointInterval: 24 * 3600 * 1000,
        }
      },
      series: [{
        name: 'Visitas Web ('+'<?php echo $propiedad->data_graficos->total_web ?>'+')',
        data: JSON.parse(visitas_web),
      },{
        name: 'Visitas Fisicas ('+'<?php echo $propiedad->data_graficos->total_panel ?>'+')',
        data: JSON.parse(visitas_panel),
      },{
        name: 'Consultas Web('+'<?php echo $propiedad->data_graficos->total_consultas ?>'+')',
        data: JSON.parse(consultas),
      }]
    });
  });
</script>
</body>
</html>