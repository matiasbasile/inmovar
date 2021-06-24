<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script type="text/javascript" src="assets/js/jsapi.js"></script>
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-sticky.js"></script>
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
<script src="assets/js/jquery.bxslider.min.js"></script>
<script src="assets/js/jquery-mCustomScrollbar.concat.min.js"></script>

<?php if (!empty($propiedad->latitud) && !empty($propiedad->longitud)) { ?>
	<script type="text/javascript">
		$(document).ready(function(){

			var mymap = L.map('mapid').setView([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>], 15);

	    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
	      attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
	      tileSize: 512,
	      maxZoom: 18,
	      zoomOffset: -1,
	      id: 'mapbox/streets-v11',
	      accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
	    }).addTo(mymap);


			var icono = L.icon({
				iconUrl: 'assets/images/map-logo.png',
		      iconSize:     [101, 112], // size of the icon
		      iconAnchor:   [50, 112], // point of the icon which will correspond to marker's location
		    }); 

			L.marker([<?php echo $propiedad->latitud ?>,<?php echo $propiedad->longitud ?>],{
				icon: icono
			}).addTo(mymap);
		});
	</script>
<?php } ?>
<script>
  if( $("#lista_superficies li").length == 0 ){ $("#ficha_superficies").hide(); }
  if( $("#lista_informacion_basica li").length == 0 ){ $("#ficha_informacion_basica").hide(); }
  function stickCheck(){
      if ( $(window).width() > 767 ) {
          $(".tostick").sticky({topSpacing: 20, bottomSpacing: 20});
      }else{
          $(".tostick").unstick();
      }
  }
  $(document).ready(function(){
      stickCheck();
  });

  $(window).resize(function() {
      stickCheck();
  })
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-33967930-4', 'auto');
  ga('send', 'pageview');
  
  function center(){
    var parent_height = $('#big_img').parent().height();
    var parent_width = $('#big_img').parent().width();

    var image_height = $('#big_img').height();
    var image_width = $('#big_img').width();

    var top_margin = (parent_height - image_height)/2;
    var left_margin = (parent_width - image_width)/2;

    var next_margin = left_margin + image_width - 50;
    var close_margin = left_margin + image_width - 40;
    var close_top = top_margin - 40;

    $('#big_img').css( 'margin-top' , top_margin);
    $('#big_img').css( 'margin-left' , left_margin);
    /*$('#big_slides_prev').css( 'margin-left' , left_margin);
    $('#big_slides_next').css( 'margin-left' , next_margin);
    $('#big_slides_close').css ( 'margin-top', close_top);
    $('#big_slides_close').css ( 'margin-left', close_margin); */
  }
  var current_ix = 0;
  function enlarge(){
    src = $("#slider_thumbs").find(".active").find(".slider-thumb").data("big");
    if (src == undefined){
        src = 'img/no-image.svg';
    }
    $('#big_img').attr('src', src);
    $("#big_slides_container").height($(window).height());
    $("#big_slides_container").width($(window).width());
    current_ix = $("#slider_thumbs").find("a").index($("#slider_thumbs").find(".active"));
    $("#big_slides_container").fadeIn();
  }
  function next_enlarged(){
    if ($("#slider_thumbs").find("a").length-1 == current_ix){
        next_ix = 0;
    }else{
        next_ix = current_ix + 1;
    }
    $('#big_img').attr('src', $("#slider_thumbs").find("a").eq(next_ix).find('img').data("big"));
    current_ix = next_ix;
  }

  function prev_enlarged(){
    if (current_ix == 0){
        next_ix = $("#slider_thumbs").find("a").length-1;
    }else{
        next_ix = current_ix - 1;
    }
    $('#big_img').attr('src', $("#slider_thumbs").find("a").eq(next_ix).find('img').data("big"));
    current_ix = next_ix;
  }

  function close_enlarged(){
    $("#big_slides_container").fadeOut();
  }
  // using jQuery
  function getCookie(name) {
    var cookieValue = null;
    if (document.cookie && document.cookie != '') {
      var cookies = document.cookie.split(';');
      for (var i = 0; i < cookies.length; i++) {
        var cookie = jQuery.trim(cookies[i]);
        if (cookie.substring(0, name.length + 1) == (name + '=')) {
          cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
          break;
        }
      }
    }
    return cookieValue;
  }

    function csrfSafeMethod(method) {
      return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(method));
    }

    $.ajaxSetup({
      beforeSend: function(xhr, settings) {
        if (!csrfSafeMethod(settings.type) && !this.crossDomain) {
          xhr.setRequestHeader("X-CSRFToken", '0Ubdu16Okhymhr3I7WKnJ4OAQD3PujCP');
        }
      }
    });

    var sending = false;

    function validate_mail(mail){
      var filter = /[\w-\.]{1,}@([\w-]{1,}\.)*([\w-]{1,}\.)[\w-]{2,4}/;
      if(filter.test(mail))
        return true;
      else
        return false;
    }


    function is_form_valid(){
      if ($("#contact_name").val().trim() == "" & $("#contact_phone").val().trim() == "" & $("#contact_email").val().trim() == ""){
        $("#contact_name").attr("placeholder", "Complete su nombre por favor");
        $("#contact_phone").attr("placeholder", "Complete su telefono por favor");
        $("#contact_email").attr("placeholder", "Complete su email por favor");
        return false;
      }
      if( validate_mail($("#contact_email").val()) == false ){
        $("#contact_email").attr("placeholder", "El email es inválido");
        return false;
      }
      return true
    }

  function send_webcontact(){
    if (!sending & is_form_valid()){
      sending = true;
      $("#ficha_send").html("Enviando...")
      data = {
        "property_id": '3702409',
        "name": $("#contact_name").val(),
        "phone": $("#contact_phone").val(),
        "email": $("#contact_email").val(),
        "operation": $("#contact_operation").val(),
        "text": $("#contact_text").val(),
      };
      var jqxhr = $.ajax( '/webcontact/', {'type':"POST", 'data': data} )
      .done(function(result) {
        if (result == "Error"){
          $("#ficha_send").html("ENVIAR")
          alert("Ha ocurrido un error, intentalo nuevamente en unos minutos.Ha ocurrido un error. Vuelva a intentarlo en unos minutos")
        }else{
          $("#ficha_send").hide()
          $(".ficha_contacto_item").hide();
          $("#ficha_gracias").show();
          $("#ficha_gracias").append('<iframe frameborder="0" height="1" width="1" src="/gracias"></iframe>');
        }
        sending = false;
      })
      .fail(function() { })
    }
  }
  (function($){
    $(window).load(function(){
      $("#slider_thumbs").mCustomScrollbar({
        axis:"x",
        theme:"dark-thin",
        autoExpandScrollbar:true,
        advanced:{autoExpandHorizontalScroll:true}
      });
      $("#slider_thumbs").slideDown();
    });
  })(jQuery);
  $(document).ready(function(){
    $('.slides').bxSlider({
      pagerCustom: '#slider_thumbs'
    });
    $('.bx-prev').click(function (evt) {
      evt.stopPropagation();
      if($( "#mCSB_1_container" ).position().left > -40){
        $( "#mCSB_1_container" ).animate({ "left": (349-$( "#mCSB_1_container" ).width())}, "slow");
      }else{
        $( "#mCSB_1_container" ).animate({ "left": "+=94px" }, "slow" );
      }
    });
    $('.bx-next').click(function (evt) {
      evt.stopPropagation();
      if($( "#mCSB_1_container" ).position().left <  (360-$( "#mCSB_1_container" ).width())){
        $( "#mCSB_1_container" ).animate({ "left":"0"}, "slow");
      }else{
        $( "#mCSB_1_container" ).animate({ "left": "-=94px" }, "slow" );
      }
    });
  });
  $( window ).resize(function() {
    var newH = (600/800) * $(".resultados-list-home li").width();
    $(".prop-img").height( newH );
  });
</script>