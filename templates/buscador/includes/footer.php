<footer id="page-footer">
  <div class="inner">
    <aside id="footer-copyright">
      <div class="container">
        <span class="copyright">Copyright © <?php echo date("Y")?>. Todos los derechos reservados.</span>
        <span class="pull-right">
          <a class="inmovar-logo" href="https://www.inmovar.com" target="_blank">
            <img class="inmovar-logo-img" src="assets/img/inmovar-despega.png">  
            <span class="inmovar-frase">¡Hacé despegar tu inmobiliaria!</span>
          </a>
        </span>
      </div>
    </aside>
  </div>
</footer>

<script type="text/javascript" src="/admin/resources/js/jquery.min.js"></script>
<script type="text/javascript" src="/admin/resources/js/libs/bootstrap.min.js"></script>
<!--<script type="text/javascript" src="assets/js/smoothscroll.js"></script>-->
<script type="text/javascript" src="/admin/resources/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.placeholder.js"></script>
<script type="text/javascript" src="assets/js/icheck.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.vanillabox-0.1.5.min.js"></script>
<script type="text/javascript" src="assets/js/retina-1.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/jshashtable-2.1_src.js"></script>
<script type="text/javascript" src="assets/js/jquery.numberformatter-1.2.3.js"></script>
<script type="text/javascript" src="assets/js/tmpl.js"></script>
<script type="text/javascript" src="assets/js/jquery.dependClass-0.1.js"></script>
<script type="text/javascript" src="assets/js/draggable-0.1.js"></script>
<script type="text/javascript" src="assets/js/jquery.slider.js"></script>
<script type="text/javascript" src="assets/js/jquery.numberformatter-1.2.3.js"></script>
<!--[if gt IE 8]>
<script type="text/javascript" src="assets/js/ie.js"></script>
<![endif]-->
<script type="text/javascript" src="/admin/resources/js/common.js"></script>
<script type="text/javascript" src="/admin/resources/js/main.js"></script>

<script>
$(document).ready(function(){
  $(".filter_tilde").change(function(e){
    if ($(e.currentTarget).val() == 0) $(e.currentTarget).removeClass("active");
    else $(e.currentTarget).addClass("active");
  });
});
</script>