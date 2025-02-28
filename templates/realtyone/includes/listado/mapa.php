<section class="properties-details listing-details1">
	<div class="row">
		<div class="col-xl-6">
			<div class="properties" style="overflow: auto;">

        <div class="results">
          <?php include("ordenar.php") ?>
          <?php 
          foreach ($vc_listado as $r) { 
            item_mapa($r);
          } ?>
          <?php include("paginador.php") ?>
        </div>
        
			</div>			
		</div>
    <div class="col-xl-6">
      <div class="map-block sticky-map">
        <div id="map"></div>
        <button class="btn btn-green" onclick="dibujar()" id="drawButton"><svg fill="white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M7.127 22.562l-7.127 1.438 1.438-7.128 5.689 5.69zm1.414-1.414l11.228-11.225-5.69-5.692-11.227 11.227 5.689 5.69zm9.768-21.148l-2.816 2.817 5.691 5.691 2.816-2.819-5.691-5.689z"/></svg></button>
        <button class="btn btn-green" onclick="borrar()" id="clearButton"><svg fill="white" clip-rule="evenodd" fill-rule="evenodd" width="20" height="20" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m20.015 6.506h-16v14.423c0 .591.448 1.071 1 1.071h14c.552 0 1-.48 1-1.071 0-3.905 0-14.423 0-14.423zm-5.75 2.494c.414 0 .75.336.75.75v8.5c0 .414-.336.75-.75.75s-.75-.336-.75-.75v-8.5c0-.414.336-.75.75-.75zm-4.5 0c.414 0 .75.336.75.75v8.5c0 .414-.336.75-.75.75s-.75-.336-.75-.75v-8.5c0-.414.336-.75.75-.75zm-.75-5v-1c0-.535.474-1 1-1h4c.526 0 1 .465 1 1v1h5.254c.412 0 .746.335.746.747s-.334.747-.746.747h-16.507c-.413 0-.747-.335-.747-.747s.334-.747.747-.747zm4.5 0v-.5h-3v.5z" fill-rule="nonzero"/></svg></button>
      </div>
    </div>
	</div>
</section>