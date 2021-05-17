<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>

<script >
  $( document ).ready(function() {

    $.ajax({
      url: 'https://www.inmobusqueda.com/quintanainfante',
      type: 'GET',
      success: function(respuesta) {
        console.log(respuesta.name);
      },
      error: function() {
        console.error("No es posible completar la operación");
      }
    });
  });
</script>
</body>
</html>