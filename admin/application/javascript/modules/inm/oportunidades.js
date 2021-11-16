/*
Ofertas
Oportunidad de Venta

Busco <tipo propiedad>
en <localidad>
zona <barrio>
con <ambientes> ambientes
con <dormitorios>
entre <valor> y <valor> USD
<perfil>
<color fondo>

Oportunidad de Compra

Codigo de propiedad (no obligatorio)
 <tipo propiedad>
en <localidad>
zona <barrio>
con <ambientes> ambientes
con <dormitorios>
<valor> USD
Ideal para <perfil>
<foto fondo>

*/
(function ( models ) {

  models.Oportunidades = Backbone.Model.extend({
    urlRoot: "oportunidades",
    defaults: {
      // Atributos que no se persisten directamente
      tipo: 0,
      activo: 1,
      id_propiedad: 0,
      tipo_inmueble: "",
      tipo_estado: "",
      localidad: "",
      id_pais: 0,
      id_provincia: 0,
      id_localidad: ((typeof ID_LOCALIDAD != "undefined") ? ID_LOCALIDAD : 0),
      ambientes: 0,
      dormitorios: 0,
      id_tipo_inmueble:0,
      moneda: "U$S",
      valor_desde: 0,
      valor_hasta: 0,
      fecha: "",
      texto: "",
      path: "",
      color: "",
      perfil_cliente: 0,
      usuario: "",
      id_empresa: ID_EMPRESA,
      id_usuario: ID_USUARIO,
      id_barrio: 0,
      telefono: TELEFONO,
      titulo: "",
      descripcion: "",
      images: [],
    },
  });
      
})( app.models );



// ----------------------
//   COLECCION PAGINADA
// ----------------------

(function (collections, model, paginator) {

  collections.Oportunidades = paginator.requestPager.extend({

    model: model,
    
    paginator_ui: {
      perPage: 10,
      order_by: 'fecha',
      order: 'desc',
    },

    paginator_core: {
      url: "oportunidades/",
    }
    
  });

})( app.collections, app.models.Oportunidades, Backbone.Paginator);



// -----------------------------------------
//   TABLA DE RESULTADOS
// -----------------------------------------
(function ( app ) {

  app.views.OportunidadesTableView = app.mixins.View.extend({

    template: _.template($("#oportunidades_resultados_template").html()),
        
    myEvents: {
      "click .nueva_oportunidad":"nueva_oportunidad",
      "click .buscar_tab":function(e) {
        this.$(".buscar_tab").removeClass("active");
        $(e.currentTarget).addClass("active");
        this.buscar();
      },
    },
        
    initialize : function (options) {
            
      var self = this;
      _.bindAll(this); // Para que this pueda ser utilizado en las funciones
      this.options = options;
      this.habilitar_seleccion = (this.options.habilitar_seleccion == undefined || this.options.habilitar_seleccion == false) ? false : true;
      this.vista_busqueda = (this.options.vista_busqueda != "undefined") ? this.options.vista_busqueda : false;
      this.ficha_contacto = (this.options.ficha_contacto != "undefined") ? this.options.ficha_contacto : null;
      this.permiso = this.options.permiso;

      // Filtros de la propiedad
      window.oportunidades_tipo = (typeof window.oportunidades_tipo != "undefined") ? window.oportunidades_tipo : -1;
      window.oportunidades_page = (typeof window.oportunidades_page != "undefined") ? window.oportunidades_page : 1;

      this.render();
      this.collection.off('sync');
      this.collection.on('sync', this.addAll, this);
      this.buscar();
      this.$('[data-toggle="tooltip"]').tooltip();
    },

    render: function() {

      var self = this;

      // Creamos la lista de paginacion
      this.pagination = new app.mixins.PaginationView({
        ver_filas_pagina: true,
        collection: this.collection
      });
      
      $(this.el).html(this.template({
        "permiso":control.check("oportunidades"),
      }));

      // Cargamos el paginador
      this.$(".pagination_container").html(this.pagination.el);

      let stories = new app.views.StoriesView({
        model: new app.models.AbstractModel(),
      });
      this.$(".stories_container").append(stories.el);

      return this;
    },
        
    buscar: function() {

      var cambio_parametros = false;

      var buscar_tipo = (this.$(".buscar_tab.active").attr("data-tipo"));
      if (window.oportunidades_buscar_tipo != buscar_tipo) {
        window.oportunidades_buscar_tipo = buscar_tipo;
        cambio_parametros = true;
      }

      // Si se cambiaron los parametros, debemos volver a pagina 1
      if (cambio_parametros) window.oportunidades_page = 1;

      var datos = {
        "tipo":window.oportunidades_buscar_tipo,
      };
      this.collection.server_api = datos;
      this.collection.goTo(window.oportunidades_page);
    },

    nueva_oportunidad: function() {
      var edicion = new app.views.OportunidadesEditView({
        model: new app.models.Oportunidades(),
      });
      crearLightboxHTML({
        "html":edicion.el,
        "width":700,
        "height":700,
      });
    },

    addAll : function () {
      console.log(this.collection);
      window.oportunidades_page = this.pagination.getPage();
      this.$("#oportunidades_tabla_cont").show();
      $(this.el).find(".tbody").empty();
      // Renderizamos cada elemento del array
      if (this.collection.length > 0) this.collection.each(this.addOne);
      this.$("#oportunidades_venta_total").html(this.collection.meta("total_venta"));
      this.$("#oportunidades_compra_total").html(this.collection.meta("total_compras"));
      this.$("#oportunidades_mias_total").html(this.collection.meta("total_mias"));
    },
        
    addOne : function ( item ) {
      var self = this;
      var view = new app.views.OportunidadesItemResultados({
        model: item,
      });
      this.$(".tbody").append(view.render().el);
    },
            
  });

})(app);




// -----------------------------------------
//   ITEM DE LA TABLA DE RESULTADOS
// -----------------------------------------
(function ( app ) {
  app.views.OportunidadesItemResultados = app.mixins.View.extend({
        
    template: _.template($("#oportunidades_item_resultados_template").html()),
    tagName: "tr",
    myEvents: {
      "click .editar":"editar",
      "click .data":"seleccionar",
      "click .activo":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        var activo = this.model.get("activo");
        activo = (activo == 1)?0:1;
        self.model.set({"activo":activo});
        this.change_property({
          "table":"oportunidades",
          "url":"oportunidades/function/change_property/",
          "attribute":"activo",
          "value":activo,
          "id":self.model.id,
          "success":function(){
            self.render();  
          }
        });
        return false;
      },

      "click .duplicar":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if (confirm("Desea duplicar el elemento?")) {
          $.ajax({
            "url":"oportunidades/function/duplicar/"+self.model.id,
            "dataType":"json",
            "success":function(r){
              location.reload();
            },
          });                    
        }
        return false;
      },
      "click .eliminar":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if (confirm("Realmente desea eliminar el elemento?")) {
          this.model.destroy();  // Eliminamos el modelo
          $(this.el).remove();  // Lo eliminamos de la vista
        }
        return false;
      },
    },
    seleccionar: function() {
    },
    editar: function() {
      location.href="app/#oportunidades/"+this.model.id;
    },
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      this.options = options;
      this.render();
    },
    render: function() {
      var self = this;
      var obj = { 
        edicion: true,
      };
      $.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));

      this.$('[data-toggle="tooltip"]').tooltip(); 
      return this;
    },

  });
})(app);


(function ( app ) {

  app.views.OportunidadesEditView = app.mixins.View.extend({

    template: _.template($("#oportunidades_edit_template").html()),
            
    myEvents: {
      "click .guardar": "guardar",
      "click .buscar_propiedades":"buscar_propiedades",

      "change #oportunidades_paises":function(){
        var id_provincia = this.$("#oportunidades_provincias").val();
        this.cambiar_paises(id_provincia);
      },
      "change #oportunidades_provincias":function(){
        var id_departamento = this.$("#oportunidades_departamentos").val();
        this.cambiar_provincias(id_departamento);
      },
      "change #oportunidades_departamentos":function(){
        var id_localidad = this.$("#oportunidades_localidades").val();
        this.cambiar_departamentos(id_localidad);
      },
      "change #oportunidades_localidades":function(){
        var id_localidad = this.$("#oportunidades_localidades").val();
        this.cargar_barrios(id_localidad);
      },
      "click .upload_multiple":function(e) {
        var self = this;
        this.open_multiple_upload({
          "model": self.model,
          "name": "images",
          "url": "propiedades/function/upload_images/",
          "view": self,
        });
      },
    },    
                
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      
      var edicion = false;
      this.options = control.check("oportunidades");
      if (control.check("oportunidades") > 1) edicion = true;
      var obj = { "edicion": edicion,"id":this.model.id }
      _.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));

      this.$("#oportunidades_tipos_inmueble").select2({});

      this.cambiar_paises(this.model.get("id_provincia"));
      if (this.model.get("id_localidad") != 0) {
        this.cambiar_provincias(this.model.get("id_departamento"));
        this.cargar_barrios(this.model.get("id_localidad"));
      }
      this.$("#oportunidades_paises").select2({});
      this.$("#oportunidades_provincias").select2({});
      createdatepicker($(this.el).find("#oportunidades_fecha"),moment().format("DD/MM/YYYY"));   

      this.$("#images_tabla").sortable({
        update:function(event,ui){
          self.reordenar_tabla_fotos();
        }
      });

      this.listenTo(this.model, 'change_table', self.render_tabla_fotos);
      this.render_tabla_fotos();
      

    },

    cambiar_paises: function(id_provincia) {
      var id_pais = this.$("#oportunidades_paises").val();
      this.$("#oportunidades_provincias").empty();
      for(var i=0;i< window.provincias.length;i++) { 
        var p = provincias[i];
        if (p.id_pais == id_pais) {
          var s = '<option data-id_pais="'+p.id_pais+'" '+((id_provincia == p.id)?"selected":"")+' value="'+p.id+'">'+p.nombre+'</option>';
          this.$("#oportunidades_provincias").append(s);
        }
      }
      this.$("#oportunidades_provincias").val(id_provincia);
      crear_select2("oportunidades_provincias");
      this.$("#oportunidades_provincias").trigger("change");
    },
    cambiar_provincias: function(id_departamento){
      var self = this;
      var id_provincia = this.$("#oportunidades_provincias").val();
      this.$("#oportunidades_departamentos").val(id_departamento);
      new app.mixins.Select({
        modelClass: app.models.ComDepartamento,
        url: "com_departamentos/function/get_select/?id_provincia="+id_provincia,
        //firstOptions: ["<option value='0'>Sin Definir</option>"],
        render: "#oportunidades_departamentos",
        selected: self.model.get("id_departamento"),
        onComplete:function(c) {
          crear_select2("oportunidades_departamentos");
          self.$("#oportunidades_departamentos").trigger("change");
        }
      });
    },
    cambiar_departamentos: function(id_localidad){
      var self = this;
      var id_departamento = this.$("#oportunidades_departamentos").val();
      this.$("#oportunidades_localidades").val(id_localidad);
      new app.mixins.Select({
        modelClass: app.models.Localidad,
        url: "localidades/function/get_select/?id_departamento="+id_departamento,
        //firstOptions: ["<option value='0'>Sin Definir</option>"],
        render: "#oportunidades_localidades",
        selected: self.model.get("id_localidad"),
        onComplete:function(c) {
          crear_select2("oportunidades_localidades");
          self.$("#oportunidades_localidades").trigger("change");
        }
      });
    },

    cargar_barrios: function(id_localidad) {
      var self = this;
      new app.mixins.Select({
        modelClass: app.models.Barrio,
        url: "barrios/function/buscar_por_localidad/?id_localidad="+id_localidad,
        firstOptions: ["<option value='0'>Sin Definir</option>"],
        render: "#oportunidades_barrio",
        selected: self.model.get("id_barrio"),
        onComplete:function(c) {
          crear_select2("oportunidades_barrio");
        }                    
      });
    },  

    buscar_propiedades: function() {
      var self = this;
      var view = new app.views.PropiedadesTableView({
        "collection":new app.collections.Propiedades(),
        "vista_busqueda":true,
      });
      crearLightboxHTML({
        "html":view.el,
        "width":860,
        "height":140,
        "callback":function() {
          self.seleccionar_propiedad();
        }
      });
    },

    seleccionar_propiedad: function() {
      if (typeof window.propiedad_seleccionado == "undefined") return;
      this.$("#operaciones_propiedad").val(window.propiedad_seleccionado.get("titulo"));
      this.$("#oportunidades_tipos_inmueble").val(window.propiedad_seleccionado.get("id_tipo_inmueble"));
      this.$("#oportunidades_ambientes").val(window.propiedad_seleccionado.get("ambientes"));
      this.$("#oportunidades_dormitorios").val(window.propiedad_seleccionado.get("dormitorios"));
      this.$("#oportunidades_paises").val(window.propiedad_seleccionado.get("id_pais"));
      this.$("#oportunidades_provincias").val(window.propiedad_seleccionado.get("id_provincia"));
      this.$("#oportunidades_departamentos").val(window.propiedad_seleccionado.get("id_departamento"));
      this.$("#oportunidades_localidades").val(window.propiedad_seleccionado.get("id_localidad"));
      this.$("#oportunidades_barrio").val(window.propiedad_seleccionado.get("id_barrio"));
      this.model.set({
        "id_propiedad":window.propiedad_seleccionado.id,
        "id_pais":window.propiedad_seleccionado.get("id_pais"),
        "id_provincia":window.propiedad_seleccionado.get("id_provincia"),
        "id_departamento":window.propiedad_seleccionado.get("id_departamento"),
        "id_localidad":window.propiedad_seleccionado.get("id_localidad"),
        "id_barrio":window.propiedad_seleccionado.get("id_barrio"),
        "id_tipo_inmueble":window.propiedad_seleccionado.get("id_tipo_inmueble"),
      });
      this.$("#oportunidades_paises").trigger("change");
      this.$("#oportunidades_provincias").trigger("change");
      this.$("#oportunidades_localidades").trigger("change");
      this.$("#oportunidades_tipos_inmueble").trigger("change");
    },


    reordenar_tabla_fotos: function() {
      var images = new Array();
      this.$("#images_tabla li .img_preview").each(function(i,e){
        images.push($(e).attr("src"));
      });
      this.model.set({
        "images":images,
      });
    },

    render_tabla_fotos: function() {
      var images = this.model.get("images");
      this.$("#images_tabla").empty();
      if (images.length == 0) {
        this.$("#images_container").removeClass('tiene');
      } else {
        this.$("#images_container").addClass('tiene');
        for(var i=0;i<images.length;i++) {
          var path = images[i];
          var pth = path+"?t="+parseInt(Math.random()*100000);
          var li = "";
          li+="<li class='list-group-item'>";
          li+=" <span><i class='fa fa-sort text-muted fa m-r-sm'></i> </span>";
          li+=" <img style='margin-left: 10px; margin-right:10px; max-height:75px' class='img_preview' src='"+pth+"'/>";
          li+=" <span class='dn filename'>"+path+"</span>";
          li+=" <span class='cp pull-right m-t eliminar_foto' data-property='images'><i class='fa fa-fw fa-times'></i> </span>";
          li+=" <span data-id='images' class='cp m-r pull-right m-t editar_foto_multiple'><i class='fa fa-pencil'></i> </span>";
          li+="</li>";
          this.$("#images_tabla").append(li);
        }
        this.$("#images_container").show();
      }
    },

    validar: function() {
      try {
        var self = this;
        this.model.set({
          "id_tipo_inmueble":self.$("#oportunidades_tipos_inmueble").val(),
          "fecha":((self.$("#oportunidades_fecha").length > 0) ? moment(self.$("#oportunidades_fecha").val(), "DD/MM/YYYY").format("YYYY-MM-DD"): ""),
          "id_barrio": (self.$("#oportunidades_barrio").length > 0) ? $(self.el).find("#oportunidades_barrio").val() : 0,
          "id_localidad": (self.$("#oportunidades_localidades").length > 0) ? ($(self.el).find("#oportunidades_localidades").val() == null ? 0 : $(self.el).find("#oportunidades_localidades").val()) : 0,
          "id_departamento": (self.$("#oportunidades_departamentos").length > 0) ? ($(self.el).find("#oportunidades_departamentos").val() == null ? 0 : $(self.el).find("#oportunidades_departamentos").val()) : 0,
          "id_provincia": (self.$("#oportunidades_provincias").length > 0) ? ($(self.el).find("#oportunidades_provincias").val() == null ? 0 : $(self.el).find("#oportunidades_provincias").val()) : 0,
          "id_pais": (self.$("#oportunidades_paises").length > 0) ? ($(self.el).find("#oportunidades_paises").val() == null ? 0 : $(self.el).find("#oportunidades_paises").val()) : 0,
          "ambientes": self.$("#oportunidades_ambientes").val(),
          "dormitorios": self.$("#oportunidades_dormitorios").val(),
          "tipo": self.$("#oportunidades_tipo").val(),
          "moneda": self.$("#oportunidades_monedas").val(),
          "valor_hasta": self.$("#oportunidades_valor_hasta").val(),
          "valor_desde": self.$("#oportunidades_valor_desde").val(),
          "descripcion": self.$("#oportunidades_descripcion").val(),
          "titulo": self.$("#oportunidades_titulo").val(),
          "telefono": self.$("#oportunidades_telefono").val(),
        });


        var images = new Array();
        this.$("#images_tabla .list-group-item .filename").each(function(i,e){
          images.push($(e).text());
        });
        if (images.length > 5) {
          alert ("El maximo es de 5 imagenes");
          return false;
        } 
        self.model.set({"images":images});

        $(".error").removeClass("error");
        return true;
      } catch(e) {
        console.log(e);
        return false;
      }
    },

    guardar:function() {
      if (this.validar()) {
        var nuevo = 0;
        if (this.model.id == null) {
          var nuevo = 1;
          this.model.set({id:0});
        }
        this.model.save({},{
          success: function(model,response) {
            if (response.error == 1) {
              show(response.mensaje);
              return;
            } else {
              window.location.reload();
            }
          }
        });
      }
    },
          
  });
})(app);
