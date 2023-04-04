<script type="text/template" id="menu_alquileres_edit_panel_template">
  <div class="padder">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label class="control-label">% de tu comision</label>
          <input type="number" value="<%= comision_inmobiliaria %>" class="form-control" name="comision_inmobiliaria" id="menu_alquileres_comision_inmobiliaria">
        </div>
      </div>
    </div>
    <hr>
    <div class="tar mt20">
      <button class="btn guardar btn-info"><?php echo lang(array("es"=>"Guardar","en"=>"Save")); ?></button>
    </div>
  </div>
</script>