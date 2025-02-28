<section class="properties-details listing-details2">
  <div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="properties">

        <div class="results">
          <?php include("ordenar.php") ?>
          <?php 
          foreach ($vc_listado as $r) { 
            item_lista($r);
          } ?>
          <?php include("paginador.php") ?>
        </div>
				
			</div>			
		</div>
	</div>
</div>
</section>