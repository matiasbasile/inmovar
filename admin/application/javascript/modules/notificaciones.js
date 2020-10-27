(function ( models ) {
  models.Notificacion = Backbone.Model.extend({
    urlRoot: "notificaciones/",
    defaults: {
      titulo: "",
      tipo: "", // Tipo de Notificacion: lo usamos para cambiar el diseño
      texto: "",
      imagen: "",
      link: "",
    }
  });
})( app.models );


(function ( app ) {

  app.views.NotificacionItem = app.mixins.View.extend({
    template: _.template($('#notificacion_item_template').html()),
    className: "media list-group-item",
    myEvents: {
      "click .aceptar_permiso_red":function(){
        var self = this;
        var inversa = (this.$("#permiso_red_inversa").is(":checked")?1:0);
        $.ajax({
          "url":"permisos_red/function/aceptar_permiso/",
          "dataType":"json",
          "type":"post",
          "data":{
            "id_empresa_compartida":self.model.id,
            "inversa":inversa,
          },
          "success":function(){
            workspace.mostrar_notificaciones();
          }
        });
      },
      "click .descartar_permiso_red":function(){
        var self = this;
        $.ajax({
          "url":"permisos_red/function/descartar_permiso/",
          "dataType":"json",
          "type":"post",
          "data":{
            "id_empresa_compartida":self.model.id,
          },
          "success":function(){
            workspace.mostrar_notificaciones();
          }
        });
      },
      "click .limpiar_notificacion":function(){
        var self = this;
        $.ajax({
          "url":"notificaciones/function/limpiar_notificacion/",
          "dataType":"json",
          "type":"post",
          "data":{
            "id":self.model.id,
          },
          "success":function(){
            workspace.mostrar_notificaciones();
          }
        });
      },
    },
    initialize: function(options) {
      this.model.bind("change",this.render,this);
      this.model.bind("destroy",this.render,this);
      _.bindAll(this);
      this.render();
    },
    render: function() {
      $(this.el).html(this.template(this.model.toJSON()));
      return this;
    },
  });

})( app );