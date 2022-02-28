<script>
window.enviando = 0;
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
  data['order'] = "<?php echo $vc_orden ?>";
  data['offset'] = 12;
  data['id_localidad'] = "<?php echo $vc_id_localidad ?>";
  data['tipo_operacion'] = "<?php echo $vc_link_tipo_operacion ?>";
  data['vc_ids_tipo_operacion'] = "<?php echo $vc_ids_tipo_operacion ?>";
  data['vc_in_ids_localidades'] = "<?php echo $vc_in_ids_localidades ?>";
  data['vc_in_ids_tipo_inmueble'] = "<?php echo $vc_in_ids_tipo_inmueble ?>";
  data['vc_in_dormitorios'] = "<?php echo $vc_in_dormitorios ?>";
  $("#cargarMas").text("buscando...");
  $.ajax({
    "url": "<?php echo mklink("web/get_list/") ?>",
    "type": "get",
    "data": data,
    "dataType": "html",
    "success": function(r) {
      var propiedades = document.querySelector(".propiedades");
      if (isEmpty(r)) {
        $("#cargarMas").hide();
      } else {
        propiedades.innerHTML += r;
        $("#cargarMas").text("ver más propiedades para tu búsqueda");
      }
      window.enviando = 0;
    },
    "error":function() {
      window.enviando = 0;
    }
  });
}
</script>