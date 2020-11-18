<script type="text/template" id="estadisticas_publicidades_template">
  <% var modulo = control.get("estadisticas_publicidades") %>
  <?php include("print_header.php"); ?>

  <div id="estadisticas_publicidades_container" class="col">
    <div class="bg-light titulo-pagina lter b-b wrapper-md no-print">
      <div class="row">
        <div class="col-lg-6 col-sm-4 col-xs-12">
          <h1 class="m-n h3 text-black">
            <i class="fa fa-bar-chart icono_principal"></i><?php echo lang(array("es"=>"Estad&iacute;sticas","en"=>"Statistics")) ?>
            / <b><?php echo lang(array("es"=>"Publicidades","en"=>"Advertising")) ?></b>
          </h1>
        </div>
      </div>
    </div>

    <div class="wrapper-md">
      <div class="panel panel-default">
        <div class="panel-body no-print">
          <div class="">
            <div class="w160 pull-left">
              <div class="input-group">
                <input type="text" id="estadisticas_publicidades_fecha_desde" value="<%= fecha_desde %>" class="form-control">
                <span class="input-group-btn">
                  <button tabindex="-1" type="button" class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
                </span>              
              </div>
            </div>
            <div class="w160 pull-left m-l-xs">
              <div class="input-group">
                <input type="text" id="estadisticas_publicidades_fecha_hasta" value="<%= fecha_hasta %>" class="form-control">
                <span class="input-group-btn">
                  <button tabindex="-1" type="button" class="btn btn-default btn-cal"><i class="fa fa-calendar"></i></button>
                </span>              
              </div>
            </div>
            <div class="w200 pull-left m-l-xs">
              <select class="form-control no-model" id="estadisticas_publicidades_clientes"></select>
            </div>
            <?php /*
            <div class="w200 pull-left m-l-xs">
              <select multiple class="form-control" id="estadisticas_publicidades_campanias"></select>
            </div>
            <div class="w200 pull-left m-l-xs">
              <select class="form-control" id="estadisticas_publicidades_piezas"></select>
            </div>
            */ ?>
            <button class="btn btn-default buscar pull-left m-l-xs"><i class="fa fa-search"></i> <?php echo lang(array("es"=>"Buscar","en"=>"Search")) ?></button>
            <button class="btn btn-default imprimir pull-left m-l-xs"><i class="fa fa-print"></i></button>
          </div>
        </div>
      </div>
      <div id="estadisticas_publicidades_resultado"></div>
    </div>
  </div>
</script>

<script type="text/template" id="estadisticas_publicidades_graficos_template">
  <div class="pagina">

  </div>
</script>