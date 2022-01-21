<?php
include_once("includes/funciones.php");
include_once("models/Web_Model.php");
$web_model = new Web_Model($empresa->id,$conx);
include_once("models/Propiedad_Model.php");
$propiedad_model = new Propiedad_Model($empresa->id,$conx);
include_once("models/Entrada_Model.php");
$entrada_model = new Entrada_Model($empresa->id,$conx);
$nombre_pagina = "cotizacion";

$cotizaciones = $web_model->get_cotizaciones();
if ($empresa->id != 1633) {
  header("Location: ".mklink("/"));
}
?><!DOCTYPE html>
<html lang="en-US">
<head>
<?php include("includes/head.php"); ?>
</head>
<style>
  .cotizacion .btn-group > div {float: left;padding: 7px;color:#3c3c3b;border: 1px solid #3c3c3b;font-size: 84%;}
  .cotizacion .btn-group > div:hover {background-color: #3c3c3b; cursor: pointer; color: white}
  .cotizacion .btn-item:first-child {border-top-left-radius: 5px;border-bottom-left-radius: 5px;}
  .cotizacion .btn-item:last-child {border-top-right-radius: 5px;border-bottom-right-radius: 5px;}
  .cotizacion .active {background-color: #3c3c3b !important;color:#fff!important}
  .cotizacion label{font-weight: 600;font-size: 18px;line-height: 23px;color: #3c3c3b;margin-top: 20px;display: block;}
  .cotizacion input[type='range'] {display: block;width: 100%;}
  .cotizacion input[type='range']:focus {  outline: none;}
  .cotizacion input[type='range'],input[type='range']::-webkit-slider-runnable-track,input[type='range']::-webkit-slider-thumb {-webkit-appearance: none;}
  .cotizacion input[type=range]::-webkit-slider-thumb {background-color: #777;width: 20px;height: 20px;border: 3px solid #333;border-radius: 50%;margin-top: -9px;}
  .cotizacion input[type=range]::-moz-range-thumb {background-color: #777;width: 15px;height: 15px;border: 3px solid #333;border-radius: 50%;}
  .cotizacion input[type=range]::-ms-thumb {background-color: #777;width: 20px;height: 20px;border: 3px solid #333;  border-radius: 50%;}
  .cotizacion input[type=range]::-webkit-slider-runnable-track {background-color: #777;height: 3px;}
  .cotizacion input[type=range]:focus::-webkit-slider-runnable-track {outline: none;}
  .cotizacion input[type=range]::-moz-range-track {background-color: #777;height: 3px;}
  .cotizacion input[type=range]::-ms-track {background-color: #777;height: 3px;}
  .cotizacion input[type=range]::-ms-fill-lower {background-color: HotPink}
  .cotizacion input[type=range]::-ms-fill-upper {background-color: black;} 
  .cotizacion h3{font-weight: 500;font-size: 20px;line-height: 25px;color: #3c3c3b;margin: 0px;}
  .cotizacion .inputDiv input{width: 300px;}
  .cotizacion .panel{width: 80%;font-weight: 500;font-size: 20px;line-height: 25px;color: #3c3c3b;margin: 0px;border-radius: 10px;padding: 5px;margin-top: 5px;}
  .cotizacion .panel.green{border: 2px solid rgb(219,185,102);}
  .cotizacion .panel.red{border: 2px solid #a4160f;}
  .cotizacion .subpanel{display: inline;text-align: center;float: left;letter-spacing: 2px;color: gray;width: 30%;border-top-left-radius: 5px;border-bottom-left-radius: 5px;color: white;font-weight: bold;height: 31px;margin-right: 8px;line-height: 29px;}
  .cotizacion .subpanel.green{border: solid 1px rgb(219,185,102);background-color: rgb(219,185,102);}
  .cotizacion .subpanel.red{border: solid 1px #a4160f;background-color: #a4160f;}
  .cotizacion .panel-label{font-size: 55%;font-weight: bold;color: grey;line-height: 13PX;}
  .cotizacion .panel-precio{font-size: 90%;font-weight: bold;line-height: 18PX;vertical-align: inherit;}
  .cotizacion .panel-precio.green{color: rgb(219,185,102);}
  .cotizacion .panel-precio.red{color: #a4160f;}
  .cotizacion hr{border-top: 2px solid green;width: 80%;margin-top: 10px;margin-bottom: 10px;}
  .cotizacion .info label{margin-top: 5px;}
  .cotizacion .aclaracion { color: #959595;font-size: 12px;margin-top: 15px }
  .cotizacion .texto_cotizacion { margin-top: 20px; color: black; font-weight: bold; font-size: 18px; margin-bottom: 20px; }
</style>
<body class="page-sub-page page-contact" id="page-top">
<div class="wrapper">
  <?php include("includes/header.php"); ?>
  <div class="container">

    <header class="mt50"><h1>Cotizador Online</h1></header>

    <section id="legal">
      <?php $t = $web_model->get_text("cotizador-texto"); ?>
      <p class="editable" data-id="<?php echo $t->id ?>" data-clave="<?php echo $t->clave ?>" data-id_empresa="<?php echo $t->id_empresa ?>"><?php echo $t->plain_text ?></p>
    </section>    

    <div class="row cotizacion mt30 mb50">
      <div class="col-md-4 col-sm-12">
        <img src="assets/img/cotizador.png" class="w100p" />
      </div>
      <div class="col-md-4 col-sm-12">

        <div class="inputDiv">
          <label>Monto a Solicitar</label>
          <input onchange="changeMonto()" type="text" value="1000000" class="form-control" id="monto_maximo">
          <input style="display: none;" step="50000" class="range" type="range" onchange="changeRange()" value="1000000" min="<?= $cotizaciones['datos']->cotizaciones_minimo ?>" max="<?= $cotizaciones['datos']->cotizaciones_maximo ?>" autocomplete="off">
        </div>

        <label>Plazo</label>
        <div class="plazo btn-group">
          <?php $i = 0; ?>
          <?php foreach ($cotizaciones['anios'] as $an) { ?>
            <div data-value="<?= $an->anios ?>" class="btn-item <?= ($i == 0) ? 'active' : '' ?>" onclick="changeFocus(this);"><?= $an->anios ?> Años</div>
            <?php $i++; ?>
          <?php } ?>
        </div>

        <div class="mt20">
          <a href="javascript:void(0)" class="btn btn-default" onclick="enviar_consulta()">Iniciar Consulta</a>
        </div>

        <p class="aclaracion">El resultado que surja del presente simulador de préstamos es meramente referencial, no reviste carácter contractual ni constituye una oferta o aceptación de la solicitud que presente el cliente.</p>

      </div>
      <div class="col-md-4 col-sm-12 mt20">
        <h3>Resumen del crédito:</h3>
        <div class="panel green mt20">
          <div class="panel-label">VALOR DE CUOTA</div>
          <div class="panel-precio green"><span class="cuota_inicial">-</span></div>
        </div>
        <div class="panel green">
          <div class="panel-label">TOTAL DE CUOTAS</div>
          <div class="panel-precio green"><span class="total_cuotas">-</span></div>
        </div>
        <p class="texto_cotizacion"></p>
      </div>

    </div>
  </div>
  <?php include("includes/footer.php"); ?>
</div>

<script type="text/javascript" src="assets/js/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-migrate-1.2.1.min.js"></script>
<?php include_once("templates/comun/mapa_js.php"); ?>
<script type="text/javascript" src="assets/js/markerwithlabel_packed.js"></script>
<script type="text/javascript" src="assets/js/infobox.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/smoothscroll.js"></script>
<script type="text/javascript" src="assets/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/js/retina-1.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/jshashtable-2.1_src.js"></script>
<script type="text/javascript" src="assets/js/jquery.numberformatter-1.2.3.js"></script>
<script type="text/javascript" src="assets/js/tmpl.js"></script>
<script type="text/javascript" src="assets/js/jquery.dependClass-0.1.js"></script>
<script type="text/javascript" src="assets/js/draggable-0.1.js"></script>
<script type="text/javascript" src="assets/js/jquery.slider.js"></script>

<script type="text/javascript" src="assets/js/custom-map.js"></script>
<script type="text/javascript" src="assets/js/custom.js"></script>
<script type="text/javascript" src="/admin/resources/js/common.js"></script>
<script type="text/javascript" src="/admin/resources/js/main.js"></script>
<!--[if gt IE 8]>
<script type="text/javascript" src="assets/js/ie.js"></script>
<![endif]-->
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script type="text/javascript">

  function enviar_consulta() {
    var plazo = $(".plazo .btn-item.active").attr("data-value");
    var monto = $("#monto_maximo").val();
    var mensaje = "Solicito prestamo de "+monto+" en el plazo de "+plazo+" años.";
    location.href = "<?php echo mklink("web/contacto/") ?>?m="+encodeURIComponent(mensaje);
  }

  function changeFocus(e) {
    var parent = $(e).parent();
    var clases = parent.attr("class").split(' ');
    $("."+clases[0]+" .btn-item").removeClass("active");
    $(e).addClass("active");
    calcular_datos();
  }

  function changeMonto() {

    var m = $("#monto_maximo").val();
    m = parseFloat(String(m).replace(/\D/g,''));
    var valor_monto = parseFloat(m);
    var minimo = parseFloat("<?php echo $cotizaciones['datos']->cotizaciones_minimo ?>");
    var maximo = parseFloat("<?php echo $cotizaciones['datos']->cotizaciones_maximo ?>");
    if (minimo > valor_monto) $("#monto_maximo").val(minimo);
    if (maximo < valor_monto) $("#monto_maximo").val(maximo);

    $(".range").val($("#monto_maximo").val());
    
    $("#monto_maximo").val(Number(valor_monto).format(0));
    calcular_datos();
  }

  function changeRange() {
    var m = $(".range").val();
    $("#monto_maximo").val(Number(m).format(0));
    calcular_datos();
  }

  $(document).ready(function(){
    calcular_datos();

    new AutoNumeric('#monto_maximo', { 
      'decimalPlaces':0,
      'decimalCharacter':',',
      'digitGroupSeparator':'.',
    });

  })

  function calcular_datos() {
    var plazo = parseInt($(".plazo .btn-item.active").attr("data-value"));
    var total_de_cuotas = plazo*12;
    var monto = $("#monto_maximo").val();
    monto = parseFloat(String(monto).replace(/\D/g,''));
    var cotizaciones = '<?php echo json_encode($cotizaciones['cotizaciones']); ?>';
    cotizaciones = JSON.parse(cotizaciones);
    var tasa = 0;
    $.each(cotizaciones, function(clave, valor) {
      if (valor.anios == plazo) {
        tasa = parseFloat(valor.taza / 100);
      }
    });
    $.ajax({
      "url":"/admin/creditos/function/obtener/",
      "dataType":"html",
      "type":"post",
      "data":{
        "monto":monto,
        "tna":tasa,
        "cuotas":total_de_cuotas,
      },
      "success":function(r) {
        var valor = $(r).find("tbody tr:first td:last").text();
        alert(valor);
      }
    })
  }
</script>
</body>
</html>