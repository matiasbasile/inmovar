<script>
window.enviando = 1;
window.page = 0;
window.marca = true;

function cargar() {
  if (window.enviando == 1) return;
  var search = window.location.search;
  search = search.slice(1);
  search = search.split("&");
  var data = {};
  search.forEach(element => {
    var nuevoArray = element.split("=");
    data[nuevoArray[0]] = nuevoArray[1];
  });

  window.page++;
  window.enviando = 1;
  data['id_empresa'] = ID_EMPRESA;
  data['page'] = window.page;
  data['offset'] = 6;
  data['categoria'] = "<?php echo $vc_link_categoria ?>"
  data['fecha'] = "<?php echo $fecha ?>"
  $("#cargarMas").text("buscando...");
  $.ajax({
    "url": "<?php echo mklink("web/get_list_entradas/") ?>",
    "type": "get",
    "data": data,
    "dataType": "html",
    "success": function(r) {
      var propiedades = document.querySelector(".propiedades");
      if (isEmpty(r)) {
        $("#cargarMas").hide();
      } else {
        propiedades.innerHTML += r;
        if ($("<div/>").append(r).find(".neighborhoods-list").length < 12)  {
          $("#cargarMas").hide();
        } else {
          $("#cargarMas").text("ver más entradas para tu búsqueda");
          $("#cargarMas").show();
        }
      }
      window.enviando = 0;
    },
    "error":function() {
      window.enviando = 0;
    }
  });
}
</script>