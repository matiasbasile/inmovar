// -----------
//   MODELO
// -----------

(function ( models ) {

  models.Busquedas = Backbone.Model.extend({
    urlRoot: "busquedas",
    defaults: {
      // Atributos que no se persisten directamente
      id_empresa: ID_EMPRESA,
      tipo_inmueble: "",
      tipo_operacion: "",
      tipo_estado: "",
      tipo_ubicacion: 0, // 0 = Calle, 1 = Esquina, 2 = Ruta
      localidad: "",
      archivo: "",
      audio: "",
      id_localidad: ((typeof ID_LOCALIDAD != "undefined") ? ID_LOCALIDAD : 0),
      id_departamento: ((typeof ID_DEPARTAMENTO != "undefined") ? ID_DEPARTAMENTO : 0),
      id_provincia: ((typeof ID_PROVINCIA != "undefined") ? ID_PROVINCIA : 0),
      id_pais: ((typeof ID_PAIS != "undefined") ? ID_PAIS : 0),
      calle: "",
      altura: "",
      piso: "",
      numero: "",
      subtitulo: "",
      compartida: 1,
      entre_calles: "",
      entre_calles_2: "",
      valor_expensas: 0,

      permiso_web: 0,
      bloqueado_web: 0,
      id_inmobiliaria: 0,
      inmobiliaria: "",
      logo_inmobiliaria: "",
      
      id_tipo_inmueble:0,
      id_tipo_operacion:0,
      id_tipo_estado:0,
      moneda: "",
      nombre: "",
      descripcion: "",
      fecha_ingreso: "",
      fecha_publicacion: "",
      precio_desde: 0,
      precio_hasta: 0,
      activo: 1, // SIEMPRE ACTIVA
      nuevo: 0,
      destacado: 0,
      texto: "",
      path: "",
      seo_title: "",
      seo_keywords: "",
      seo_description: "",
      relacionados_tipo: "U", // U = Ultimos - A = Aleatorio
      relacionados_cantidad: 3, // Cantidad de elementos por categoria que se muestran
      texto_privado: "",
      cantidad_consultas: 0,
      video: "",
      heading: 0,
      pitch: 0,
      publica_precio: 1,
      usuario: "",
      id_usuario: ID_USUARIO,
      descripcion_ubicacion: "",
      apto_banco: 0,
      acepta_permuta: 0,
      publica_altura: 0,
      nota_publica: "",
      nota_privada: "",

      olx_habilitado:0,
      olx_id: "",
      olx_creado: "",
      olx_actualizado: "",

      ubicacion_departamento: "",
      balcon: 0,
      patio: 0,

      servicios_gas: 0,
      servicios_cloacas: 0,
      servicios_agua_corriente: 0,
      servicios_asfalto: 0,
      servicios_electricidad: 0,
      servicios_telefono: 0,
      servicios_cable: 0,
      apto_profesional: 0,
      servicios_wifi: 0,
      servicios_internet: 0,
      servicios_aire_acondicionado: 0,
      servicios_uso_comercial: 0,

      inmobusquedas_habilitado: 0,
      inmobusquedas_url: "",
      eldia_habilitado: 0,
      argenprop_habilitado: 0,
      argenprop_url: "",
      compartida_facebook: 0,
      id_barrio: 0,
      tipo_calle: 0,
      mts_frente: 0,
      mts_fondo: 0,
      pint: "",

      // PROPIEDADES ESPECIFICAS DE ALQUILERES TEMPORARIOS
      capacidad_maxima:1,
      capacidad_maxima_menores:0,
      habitacion_compartida:0,
      temporada: [],
      impuestos: [],
      alq_minimo_dias_reserva: 1,
      alq_tarifa_base_finde: 0,
      alq_tarifa_base_semana: 0,      
      alq_tarifa_base_mes: 0,
      alq_descuento_ultima_hora: 0,
      alq_ultima_hora_cantidad: 0,
      alq_descuento_por_anticipado: 0,
      alq_descuento_por_anticipado_cantidad: 0,
      alq_deposito_seguridad: 0,
      alq_precio_huesped_adicional: 0,
      alq_reservar_dias_antes: 1,
      links_ical: "",

      de_prueba: 0, // Indica si son busquedas cargadas de prueba

      acepta_financiacion: 0,
      parrilla: 0,
      permite_mascotas: 0,
      piscina: 0,
      vigilancia: 0,
      sala_juegos: 0,
      ascensor: 0,
      lavadero: 0,
      living_comedor: 0,
      terraza: 0,
      accesible: 0,
      gimnasio: 0,
    },
  });
      
})( app.models );



// ----------------------
//   COLECCION PAGINADA
// ----------------------

(function (collections, model, paginator) {

  collections.Busquedas = paginator.requestPager.extend({

    model: model,
    
    paginator_ui: {
      perPage: 10,
      order_by: 'A.fecha_publicacion DESC, A.id ',
      order: 'desc',
    },

    paginator_core: {
      url: "busquedas/function/ver",
    }
    
  });

})( app.collections, app.models.Busquedas, Backbone.Paginator);



// -----------------------------------------
//   TABLA DE RESULTADOS
// -----------------------------------------
(function ( app ) {

  app.views.BusquedasTableView = app.mixins.View.extend({

    template: _.template($("#busquedas_resultados_template").html()),
        
    myEvents: {
      "change #busquedas_buscar":"buscar",
      "click .buscar":"buscar",
      "click .exportar": "exportar",
      "click .importar_csv": "importar",
      "click .exportar_csv": "exportar_csv",
      "click .enviar": "enviar",
      "click .enviar_whatsapp": "enviar_whatsapp",
      "click .marcar_interes":"marcar_interes",

      "click .compartir_red_multiple":function(){
        this.compartir_red_multiple(1);
      },
      "click .no_compartir_red_multiple":function() {
        this.compartir_red_multiple(0);
      },      

      "click #buscar_propias_tab":function() {
        this.$(".buscar_tab").removeClass("active");
        this.$("#buscar_propias_tab").addClass("active");
        this.$(".ocultar_en_red").show();
        this.buscar();
      },
      "click #buscar_red_tab":function() {
        this.$(".buscar_tab").removeClass("active");
        this.$("#buscar_red_tab").addClass("active");
        this.$(".ocultar_en_red").hide();
        this.buscar();
      },
      "click #busquedas_ver_mapa":function() {
        this.$("#busquedas_ver_lista").removeClass("btn-info");
        this.$("#busquedas_ver_mapa").addClass("btn-info");
        window.busquedas_mapa = 1;
        this.buscar();
      },
      "click #busquedas_ver_lista":function() {
        this.$("#busquedas_ver_mapa").removeClass("btn-info");
        this.$("#busquedas_ver_lista").addClass("btn-info");
        window.busquedas_mapa = 0;
        this.buscar();
      },

      "change #busquedas_buscar_monto":"buscar",
      "change #busquedas_buscar_monto_2":"buscar",
      "change #busquedas_buscar_direccion":"buscar",
      "change #busquedas_buscar_dormitorios":"buscar",
      "change #busquedas_buscar_banios":"buscar",

      "keydown #busquedas_tabla tbody tr .radio:first":function(e) {
        // Si estamos en el primer elemento y apretamos la flechita de arriba
        if (e.which == 38) { e.preventDefault(); $("#busquedas_texto").focus(); }
      },

      "change #busquedas_buscar_compartida_en_filtros":function() {
        var f = this.$("#busquedas_buscar_compartida_en_filtros").val();
        if (f == "filtrar_todos") {
          window.busquedas_filtro_web = -1;
          window.busquedas_filtro_meli = -1;
          window.busquedas_filtro_olx = -1;
          window.busquedas_filtro_inmovar = -1;
          window.busquedas_filtro_inmobusquedas = -1;
          this.buscar();          
        } else if (f == "filtrar_web_activas") {
          window.busquedas_filtro_web = 1; this.buscar();
        } else if (f == "filtrar_web_inactivas") {
          window.busquedas_filtro_web = 0; this.buscar();
        } else if (f == "filtrar_meli_activos") {
          window.busquedas_filtro_meli = 1; this.buscar();
        } else if (f == "filtrar_meli_pausados") {
          window.busquedas_filtro_meli = 2; this.buscar();
        } else if (f == "filtrar_meli_finalizados") {
          window.busquedas_filtro_meli = 3; this.buscar();
        } else if (f == "filtrar_meli_sin_compartir") {
          window.busquedas_filtro_meli = 0; this.buscar();
        } else if (f == "filtrar_olx_activos") {
          window.busquedas_filtro_olx = 1; this.buscar();
        } else if (f == "filtrar_olx_pendientes") {
          window.busquedas_filtro_olx = 2; this.buscar();
        } else if (f == "filtrar_olx_sin_compartir") {
          window.busquedas_filtro_olx = 0; this.buscar();
        } else if (f == "filtrar_inmovar_compartidos") {
          window.busquedas_filtro_inmovar = 1; this.buscar();
        } else if (f == "filtrar_inmovar_no_compartidos") {
          window.busquedas_filtro_inmovar = 0; this.buscar();
        } else if (f == "filtrar_inmobusquedas_compartidos") {
          window.busquedas_filtro_inmobusquedas = 1; this.buscar();
        } else if (f == "filtrar_inmobusquedas_pendientes") {
          window.busquedas_filtro_inmobusquedas = 2; this.buscar();
        } else if (f == "filtrar_inmobusquedas_no_compartidos") {
          window.busquedas_filtro_inmobusquedas = 0; this.buscar();
        }
      },

      "click #busquedas_buscar_apto_banco":function() {
        this.$("#busquedas_buscar_apto_banco").toggleClass("btn-info");
        this.buscar();
      },
      "click #busquedas_buscar_acepta_permuta":function() {
        this.$("#busquedas_buscar_acepta_permuta").toggleClass("btn-info");
        this.buscar();
      },
      "click .setear_moneda":function(e) {
        this.$("#busquedas_buscar_monto_moneda").text($(e.currentTarget).text());
        this.buscar();
      },
      "click .setear_localidad":function(e) {
        var data = {
          id: $(e.currentTarget).data("id"),
          text: $(e.currentTarget).data("nombre")
        };
        var newOption = new Option(data.text, data.id, true, true);
        this.$('#busquedas_buscar_localidades').append(newOption).trigger('change');
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

      // Filtros de la busqueda
      window.busquedas_buscar_red = (typeof window.busquedas_buscar_red != "undefined") ? window.busquedas_buscar_red : 0;
      window.busquedas_buscar_red_empresa = (typeof window.busquedas_buscar_red_empresa != "undefined") ? window.busquedas_buscar_red_empresa : 0;
      window.busquedas_compartida_en = (typeof window.busquedas_compartida_en != "undefined") ? window.busquedas_compartida_en : "";
      window.busquedas_compartida_en_filtro = (typeof window.busquedas_compartida_en_filtro != "undefined") ? window.busquedas_compartida_en_filtro : "";
      window.busquedas_id_tipo_inmueble = (typeof window.busquedas_id_tipo_inmueble != "undefined") ? window.busquedas_id_tipo_inmueble : 0;
      window.busquedas_id_tipo_estado = (typeof window.busquedas_id_tipo_estado != "undefined") ? window.busquedas_id_tipo_estado : 0;
      window.busquedas_id_tipo_operacion = (typeof window.busquedas_id_tipo_operacion != "undefined") ? window.busquedas_id_tipo_operacion : 0;
      window.busquedas_id_localidad = (typeof window.busquedas_id_localidad != "undefined") ? window.busquedas_id_localidad : 0;
      window.busquedas_dormitorios = (typeof window.busquedas_dormitorios != "undefined") ? window.busquedas_dormitorios : "";
      window.busquedas_banios = (typeof window.busquedas_banios != "undefined") ? window.busquedas_banios : "";
      window.busquedas_filter = (typeof window.busquedas_filter != "undefined") ? window.busquedas_filter : "";
      window.busquedas_direccion = (typeof window.busquedas_direccion != "undefined") ? window.busquedas_direccion : "";
      window.busquedas_monto = (typeof window.busquedas_monto != "undefined") ? window.busquedas_monto : "";
      window.busquedas_monto_2 = (typeof window.busquedas_monto_2 != "undefined") ? window.busquedas_monto_2 : "";
      window.busquedas_monto_tipo = (typeof window.busquedas_monto_tipo != "undefined") ? window.busquedas_monto_tipo : "";
      window.busquedas_monto_moneda = (typeof window.busquedas_monto_moneda != "undefined") ? window.busquedas_monto_moneda : "$";
      window.busquedas_apto_banco = (typeof window.busquedas_apto_banco != "undefined") ? window.busquedas_apto_banco : 0;
      window.busquedas_acepta_permuta = (typeof window.busquedas_acepta_permuta != "undefined") ? window.busquedas_acepta_permuta : 0;
      window.busquedas_page = (typeof window.busquedas_page != "undefined") ? window.busquedas_page : 1;
      window.busquedas_filtro_meli = (typeof window.busquedas_filtro_meli != "undefined") ? window.busquedas_filtro_meli : -1;
      window.busquedas_filtro_olx = (typeof window.busquedas_filtro_olx != "undefined") ? window.busquedas_filtro_olx : -1;
      window.busquedas_filtro_inmovar = (typeof window.busquedas_filtro_inmovar != "undefined") ? window.busquedas_filtro_inmovar : -1;
      window.busquedas_filtro_inmobusquedas = (typeof window.busquedas_filtro_inmobusquedas != "undefined") ? window.busquedas_filtro_inmobusquedas : -1;
      window.busquedas_filtro_argenprop = (typeof window.busquedas_filtro_argenprop != "undefined") ? window.busquedas_filtro_argenprop : -1;
      window.busquedas_filtro_web = (typeof window.busquedas_filtro_web != "undefined") ? window.busquedas_filtro_web : -1;
      window.busquedas_mapa = (typeof window.busquedas_mapa != "undefined") ? window.busquedas_mapa : 0;

      // Flag que indica cuando se guardo una nueva busqueda
      window.busquedas_guardo_nueva_busqueda = (typeof window.busquedas_guardo_nueva_busqueda != "undefined") ? window.busquedas_guardo_nueva_busqueda : 0;

      window.busquedas_marcadas = new Array();

      if (window.busquedas_buscar_red == 1) this.$(".ocultar_en_red").hide();

      // Nombre y email de contacto
      this.id_cliente = (typeof this.options.id_cliente != "undefined") ? this.options.id_cliente : 0;
      this.email = (typeof this.options.email != "undefined") ? this.options.email : "";
      this.nombre = (typeof this.options.nombre != "undefined") ? this.options.nombre : "";
      this.telefono = (typeof this.options.telefono != "undefined") ? this.options.telefono : "";
      this.telefono = this.telefono.replace(" ","");
      this.telefono = this.telefono.replace("(","");
      this.telefono = this.telefono.replace(")","");
      this.telefono = this.telefono.replace("-","");

      this.render();
      this.collection.off('sync');
      this.collection.on('sync', this.addAll, this);
      this.buscar();
    },

    render: function() {

      var self = this;

      // Creamos la lista de paginacion
      this.pagination = new app.mixins.PaginationView({
        ver_filas_pagina: true,
        collection: this.collection
      });
      
      $(this.el).html(this.template({
        "permiso":this.permiso,
        "vista_busqueda":this.vista_busqueda,
        "email":this.email,
        "nombre":this.nombre,
        "seleccionar":this.habilitar_seleccion,
      }));

      this.$("#busquedas_buscar_localidades").select2({
        multiple: true,
        language: "es",
        minimumInputLength: 3,
        minimumResultsForSearch: -1,
        ajax: {
          url: "/admin/localidades/function/search_for_select/",
          dataType: "json",
          delay: 500,
        }
      });
      this.$("#busquedas_buscar_localidades").parent().find(".select2-search__field").attr("placeholder","Localidades");
      this.$("#busquedas_buscar_localidades").parent().find(".select2-search__field").css("width","100%");
      this.$("#busquedas_buscar_localidades").on("change.select2",function(e){
        self.buscar();
        self.$("#busquedas_buscar_localidades").parent().find(".select2-search__field").attr("placeholder","Localidades");
        self.$("#busquedas_buscar_localidades").parent().find(".select2-search__field").css("width","100%");
      });

      /*
      new app.mixins.Select({
        modelClass: app.models.Localidad,
        url: "localidades/function/utilizadas/?id_empresa="+ID_EMPRESA+"&id_proyecto="+ID_PROYECTO,
        render: "#busquedas_buscar_localidades",
        firstOptions: ["<option value='0'>Localidad</option>"],
        selected: window.busquedas_id_localidad,
        onComplete:function(c) {
          crear_select2("busquedas_buscar_localidades");
        }
      });            
      */

      // Cargamos el paginador
      this.$(".pagination_container").html(this.pagination.el);
      
      this.$("#busquedas_buscar_tipos_estado").select2({
        multiple: true,
        language: "es",
        placeholder: {
          id: 0,
          text: "Estado",
        }
      });
      if (window.busquedas_id_tipo_estado == 0) this.$("#busquedas_buscar_tipos_estado").val(null).trigger("change");
      this.$("#busquedas_buscar_tipos_estado").parent().find(".select2-search__field").attr("placeholder","Estado");
      this.$("#busquedas_buscar_tipos_estado").parent().find(".select2-search__field").css("width","100%");
      this.$("#busquedas_buscar_tipos_estado").on("change.select2",function(e){
        self.buscar();
        self.$("#busquedas_buscar_tipos_estado").parent().find(".select2-search__field").css("width","100%");
      });

      this.$("#busquedas_buscar_tipos_inmueble").select2({
        multiple: true,
        language: "es",
        placeholder: {
          id: 0,
          text: "Tipo de Inmueble",
        }
      });
      if (window.busquedas_id_tipo_inmueble == 0) this.$("#busquedas_buscar_tipos_inmueble").val(null).trigger("change");
      this.$("#busquedas_buscar_tipos_inmueble").parent().find(".select2-search__field").attr("placeholder","Tipo de Inmueble");
      this.$("#busquedas_buscar_tipos_inmueble").parent().find(".select2-search__field").css("width","100%");
      this.$("#busquedas_buscar_tipos_inmueble").on("change.select2",function(e){
        self.buscar();
        self.$("#busquedas_buscar_tipos_inmueble").parent().find(".select2-search__field").css("width","100%");
      });

      this.$("#busquedas_buscar_tipos_operacion").select2({
        multiple: true,
        language: "es",
        placeholder: {
          id: 0,
          text: "Operación",
        }
      });
      if (window.busquedas_id_tipo_operacion == 0) this.$("#busquedas_buscar_tipos_operacion").val(null).trigger("change");
      this.$("#busquedas_buscar_tipos_operacion").parent().find(".select2-search__field").attr("placeholder","Operación");
      this.$("#busquedas_buscar_tipos_operacion").parent().find(".select2-search__field").css("width","100%");
      this.$("#busquedas_buscar_tipos_operacion").on("change.select2",function(e){
        self.buscar();
        self.$("#busquedas_buscar_tipos_operacion").parent().find(".select2-search__field").css("width","100%");
      });

      this.$("#busquedas_buscar_compartida_en").select2({
        language: "es",
        placeholder: {
          id: 0,
          text: "Compartida",
        }
      });
      if (isEmpty(window.busquedas_compartida_en)) this.$("#busquedas_buscar_compartida_en").val(null).trigger("change");
      this.$("#busquedas_buscar_compartida_en").parent().find(".select2-search__field").attr("placeholder","Compartida");
      this.$("#busquedas_buscar_compartida_en").parent().find(".select2-search__field").css("width","100%");
      this.$("#busquedas_buscar_compartida_en").on("change.select2",function(e){
        var compartida_en = self.$("#busquedas_buscar_compartida_en").val();
        self.$("#busquedas_buscar_compartida_en_filtros").removeAttr("disabled");
        self.$("#busquedas_buscar_compartida_en_filtros").empty();
        var o = "";
        if (compartida_en == "red") {
          o+="<option value='filtrar_todos'>Todas</option>";
          o+="<option value='filtrar_inmovar_compartidos'>Compartidas</option>";
          o+="<option value='filtrar_inmovar_no_compartidos'>Sin Compartir</option>";
          self.$("#busquedas_buscar_compartida_en_filtros").append(o)
        } else if (compartida_en == "web") {
          o+="<option value='filtrar_todos'>Todas</option>";
          o+="<option value='filtrar_web_activas'>Activas</option>";
          o+="<option value='filtrar_web_inactivas'>Inactivas</option>";
          self.$("#busquedas_buscar_compartida_en_filtros").append(o)
        } else if (compartida_en == "meli") {
          o+="<option value='filtrar_todos'>Todas</option>";
          o+="<option value='filtrar_meli_activos'>Activas</option>";
          o+="<option value='filtrar_meli_pausados'>Pausadas</option>";
          o+="<option value='filtrar_meli_finalizados'>Finalizadas</option>";
          o+="<option value='filtrar_meli_sin_compartir'>Sin Compartir</option>";
          self.$("#busquedas_buscar_compartida_en_filtros").append(o)
        } else if (compartida_en == "olx") {
          o+="<option value='filtrar_todos'>Todas</option>";
          o+="<option value='filtrar_olx_activos'>Activas</option>";
          o+="<option value='filtrar_olx_pendientes'>Pendientes</option>";
          o+="<option value='filtrar_olx_sin_compartir'>Sin Compartir</option>";
          self.$("#busquedas_buscar_compartida_en_filtros").append(o)
        } else if (compartida_en == "inmobusquedas") {
          o+="<option value='filtrar_todos'>Todas</option>";
          o+="<option value='filtrar_inmobusquedas_compartidos'>Compartidas</option>";
          o+="<option value='filtrar_inmobusquedas_pendientes'>Pendientes</option>";
          o+="<option value='filtrar_inmobusquedas_no_compartidos'>Sin Compartir</option>";
          self.$("#busquedas_buscar_compartida_en_filtros").append(o)          
        } else if (compartida_en == "") {
          o+="<option value='filtrar_todos'>Todas</option>";
          self.$("#busquedas_buscar_compartida_en_filtros").append(o)          
        } else {
          self.$("#busquedas_buscar_compartida_en_filtros").attr("disabled","disabled");
        }
        self.buscar();
        self.$("#busquedas_buscar_compartida_en").parent().find(".select2-search__field").css("width","100%");
      });

      $('html').click(function(e) {
        if (typeof e.originalEvent != "undefined") {
          var clases = (e.originalEvent.target.className);
          if (clases.indexOf("menu-compartir-submenu-dropdown") > 0) return;
        }
        $(".menu-compartir").hide();
      });

      return this;
    },
        
    buscar: function() {

      var cambio_parametros = false;

      var buscar_red = (this.$("#buscar_red_tab").hasClass("active")?1:0);
      if (window.busquedas_buscar_red != buscar_red) {
        window.busquedas_buscar_red = buscar_red;
        cambio_parametros = true;
      }

      if (window.busquedas_id_tipo_estado != this.$("#busquedas_buscar_tipos_estado").val()) {
        window.busquedas_id_tipo_estado = (this.$("#busquedas_buscar_tipos_estado").val() == null) ? 0 : this.$("#busquedas_buscar_tipos_estado").val();  
        if ($.isArray(window.busquedas_id_tipo_estado)) window.busquedas_id_tipo_estado = window.busquedas_id_tipo_estado.join("-");
        cambio_parametros = true;
      }
      if (window.busquedas_id_tipo_inmueble != this.$("#busquedas_buscar_tipos_inmueble").val()) {
        window.busquedas_id_tipo_inmueble = (this.$("#busquedas_buscar_tipos_inmueble").val() == null) ? 0 : this.$("#busquedas_buscar_tipos_inmueble").val();
        if ($.isArray(window.busquedas_id_tipo_inmueble)) window.busquedas_id_tipo_inmueble = window.busquedas_id_tipo_inmueble.join("-");
        cambio_parametros = true;
      }
      if (window.busquedas_id_tipo_operacion != this.$("#busquedas_buscar_tipos_operacion").val()) {
        window.busquedas_id_tipo_operacion = (this.$("#busquedas_buscar_tipos_operacion").val() == null) ? 0 : this.$("#busquedas_buscar_tipos_operacion").val();  
        if ($.isArray(window.busquedas_id_tipo_operacion)) window.busquedas_id_tipo_operacion = window.busquedas_id_tipo_operacion.join("-");
        cambio_parametros = true;
      }
      if (window.busquedas_id_localidad != this.$("#busquedas_buscar_localidades").val()) {
        window.busquedas_id_localidad = this.$("#busquedas_buscar_localidades").val();
        if ($.isArray(window.busquedas_id_localidad)) window.busquedas_id_localidad = window.busquedas_id_localidad.join("-");
        cambio_parametros = true;
      }
      if (window.busquedas_filter != this.$("#busquedas_buscar").val()) {
        window.busquedas_filter = this.$("#busquedas_buscar").val();  
        cambio_parametros = true;
      }
      if (window.busquedas_direccion != this.$("#busquedas_buscar_direccion").val()) {
        window.busquedas_direccion = this.$("#busquedas_buscar_direccion").val();  
        cambio_parametros = true;
      }
      if (window.busquedas_monto_tipo != this.$("#busquedas_buscar_monto_tipo").val()) {
        window.busquedas_monto_tipo = this.$("#busquedas_buscar_monto_tipo").val();  
        cambio_parametros = true;
      }
      if (window.busquedas_monto_moneda != this.$("#busquedas_buscar_monto_moneda").text()) {
        window.busquedas_monto_moneda = this.$("#busquedas_buscar_monto_moneda").text();  
        cambio_parametros = true;
      }
      if (window.busquedas_monto != this.$("#busquedas_buscar_monto").val()) {
        window.busquedas_monto = this.$("#busquedas_buscar_monto").val();  
        cambio_parametros = true;
      }
      if (window.busquedas_monto_2 != this.$("#busquedas_buscar_monto_2").val()) {
        window.busquedas_monto_2 = this.$("#busquedas_buscar_monto_2").val();  
        cambio_parametros = true;
      }
      if (window.busquedas_dormitorios != this.$("#busquedas_buscar_dormitorios").val()) {
        window.busquedas_dormitorios = this.$("#busquedas_buscar_dormitorios").val();  
        cambio_parametros = true;
      }
      if (window.busquedas_banios != this.$("#busquedas_buscar_banios").val()) {
        window.busquedas_banios = this.$("#busquedas_buscar_banios").val();  
        cambio_parametros = true;
      }
      /*
      var apto_banco = (this.$("#busquedas_buscar_apto_banco").hasClass("btn-info")?1:0);
      if (window.busquedas_apto_banco != apto_banco) {
        window.busquedas_apto_banco = apto_banco;  
        cambio_parametros = true;
      }
      var acepta_permuta = (this.$("#busquedas_buscar_acepta_permuta").hasClass("btn-info")?1:0);
      if (window.busquedas_acepta_permuta != acepta_permuta) {
        window.busquedas_acepta_permuta = acepta_permuta;  
        cambio_parametros = true;
      }
      */

      if (this.$("#busquedas_buscar_compartida_en").length > 0 && this.$("#busquedas_buscar_compartida_en").val() != null) {
        var compatida_en = this.$("#busquedas_buscar_compartida_en").val();
        for(var j=0;j<compatida_en.length;j++) {
          var cp = compatida_en[j];
          if (cp == "olx") { window.busquedas_filtro_olx = 1; cambio_parametros = true; }
          else if (cp == "web") { window.busquedas_filtro_web = 1; cambio_parametros = true; }
          else if (cp == "meli") { window.busquedas_filtro_meli = 1; cambio_parametros = true; }
          else if (cp == "red") { window.busquedas_filtro_inmovar = 1; cambio_parametros = true; }
          else if (cp == "inmobusquedas") { window.busquedas_filtro_inmobusquedas = 1; cambio_parametros = true; }
          else if (cp == "argenprop") { window.busquedas_filtro_argenprop = 1; cambio_parametros = true; }
        }
      } else {
        window.busquedas_filtro_olx = -1;
        window.busquedas_filtro_meli = -1;
        window.busquedas_filtro_inmovar = -1;
        window.busquedas_filtro_inmobusquedas = -1;
        window.busquedas_filtro_argenprop = -1;
        window.busquedas_filtro_web = -1;
        cambio_parametros = true;
      }

      // Si se cambiaron los parametros, debemos volver a pagina 1
      if (cambio_parametros) window.busquedas_page = 1;

      var datos = {
        "buscar_red":window.busquedas_buscar_red,
        "buscar_red_empresa":window.busquedas_buscar_red_empresa,
        "filter":window.busquedas_filter,
        "calle":window.busquedas_direccion,
        "id_localidad":window.busquedas_id_localidad,
        "id_tipo_estado":window.busquedas_id_tipo_estado,
        "id_tipo_inmueble":window.busquedas_id_tipo_inmueble,
        "id_tipo_operacion":window.busquedas_id_tipo_operacion,
        "monto":window.busquedas_monto,
        "monto_2":window.busquedas_monto_2,
        "monto_tipo":window.busquedas_monto_tipo,
        "monto_moneda":window.busquedas_monto_moneda,
        //"apto_banco":window.busquedas_apto_banco,
        //"acepta_permuta":window.busquedas_acepta_permuta,
        "dormitorios":window.busquedas_dormitorios,
        "banios":window.busquedas_banios,
        "filtro_meli":window.busquedas_filtro_meli,
        "filtro_olx":window.busquedas_filtro_olx,
        "filtro_inmovar":window.busquedas_filtro_inmovar,
        "filtro_inmobusquedas":window.busquedas_filtro_inmobusquedas,
        "filtro_argenprop":window.busquedas_filtro_argenprop,
        "activo":window.busquedas_filtro_web,
      };
      if (SOLO_USUARIO == 1) datos.id_usuario = ID_USUARIO; // Buscamos solo los productos de ese usuario
      this.collection.server_api = datos;
      if (window.busquedas_mapa == 1) {
        this.collection.server_api.offset = 9999;
        this.collection.server_api.page = 1;
        this.collection.pager();
      } else {
        this.collection.goTo(window.busquedas_page);
      }
    },

    render_map: function() {
      var self = this;
      var centro_latitud = 0; 
      var centro_longitud = 0; 
      var cantidad = 0;
      var zoom = 12;
      var marcadores = new Array();
      if (this.collection.length > 0) {
        this.collection.each(function(p){
          if (p.get("latitud") != 0 && p.get("longitud") != 0) {
            var lat = parseFloat(p.get("latitud"));
            var lon = parseFloat(p.get("longitud"));
            marcadores.push({
              "lat":lat,
              "lon":lon,
              "id":p.id,
              "id_empresa":p.get("id_empresa"),
            });
            centro_latitud += lat;
            centro_longitud += lon;
            cantidad++;
          }
        });
      }
      if (cantidad > 0) {
        centro_latitud = centro_latitud / cantidad;
        centro_longitud = centro_longitud / cantidad;
      } else {
        centro_latitud = -34.6156625; 
        centro_longitud = -58.5033598;
      }

      self.coor = new google.maps.LatLng(centro_latitud,centro_longitud);
      var mapOptions = {
        zoom: zoom,
        center: self.coor
      }
      self.map = new google.maps.Map(document.getElementById("busquedas_mapa"), mapOptions);
      for(var i=0;i<marcadores.length;i++) {
        var m = marcadores[i];
        var marker = new google.maps.Marker({
          position: new google.maps.LatLng(m.lat,m.lon),
          map: self.map,
        })
        self.attachEvent(marker,m.id,m.id_empresa);
      }
    },

    attachEvent: function(marker,id,id_empresa) {
      var self = this;
      google.maps.event.addListener(marker,'click', function(){
        self.ver_lightbox(id,id_empresa);
      });
    },

    ver_lightbox: function(id,id_empresa) {
      var self = this;
      $.ajax({
        "url":"busquedas/function/ver_busqueda/"+id+"/"+id_empresa,
        "dataType":"json",
        "success":function(r) {
          var busqueda = new app.models.Busquedas(r);
          var view = new app.views.BusquedaPreview({
            model: busqueda,
            telefono: self.telefono,
            email: self.email,
            id_cliente: self.id_cliente,
            ficha_contacto: self.ficha_contacto,
          });
          crearLightboxHTML({
            "html":view.el,
            "width":1200,
            "height":500,
          });
        }
      });
    },

    addAll : function () {
      if (window.busquedas_mapa == 1) {
        this.$("#busquedas_tabla_cont").hide();
        this.$(".seccion_llena").show();
        this.$("#busquedas_mapa").show();

        var self = this;
        try {
          loadGoogleMaps('3',API_KEY_GOOGLE_MAPS).done(self.render_map);
        } catch(e) {
          setTimeout(function(){
            self.render_map();
          },1000);
        }
        setTimeout(function(){
          if (self.map == undefined) self.render_map();
          google.maps.event.trigger(self.map, "resize");
          self.map.setCenter(self.coor);
        },1000);        

      } else {
        window.busquedas_page = this.pagination.getPage();
        this.$("#busquedas_mapa").hide();
        this.$("#busquedas_tabla_cont").show();
        $(this.el).find(".tbody").empty();
        // Mostramos u ocultamos la parte de "No tenes ningun elemento...", solo la primera vez
        if (!this.$(".seccion_vacia").is(":visible") && !this.$(".seccion_llena").is(":visible")) {
          if (this.collection.length > 0) {
            this.$(".seccion_vacia").hide();
            this.$(".seccion_llena").show();
          } else {
            this.$(".seccion_llena").hide();
            this.$(".seccion_vacia").show();
          }
        }
        // Renderizamos cada elemento del array
        if (this.collection.length > 0) this.collection.each(this.addOne);
        this.$("#busquedas_propias_total").html(this.collection.totalResults);
      }
    },
        
    addOne : function ( item ) {
      var self = this;
      var view = new app.views.BusquedasItemResultados({
        model: item,
        habilitar_seleccion: this.habilitar_seleccion, 
        vista_busqueda: this.vista_busqueda,
        telefono: self.telefono,
        email: self.email,
        id_cliente: self.id_cliente,
        ficha_contacto: self.ficha_contacto,
      });
      this.$(".tbody").append(view.render().el);
    },
            
    importar: function() {
      app.views.importar = new app.views.Importar({
        "table":"busquedas"
      });
      crearLightboxHTML({
        "html":app.views.importar.el,
        "width":450,
        "height":140,
      });
    },
        
    exportar: function(obj) {
      // Reemplazamos el ver por el exportar
      var url = this.collection.url;
      url = url.replace("/ver/","/exportar/");
      // Los parametros de orden se envian por GET
      url += "?order="+this.collection.paginator_ui.order+"&order_by="+this.collection.paginator_ui.order_by;
      window.open(url,"_blank");
    },
    
    exportar_csv: function(obj) {
      window.open("busquedas/function/exportar_csv/","_blank");
    },
        
    enviar: function() {
      var self = this;
      var checks = this.$("#busquedas_tabla .check-row:checked");
      if (checks.length == 0) {
        alert("Por favor seleccione algun elemento de la tabla.");
        return;
      }
      var links_adjuntos = new Array();
      $(checks).each(function(i,e){
        var id = $(e).val();
        var art = self.collection.get(id);
        links_adjuntos.push({
          tipo: TIPO_ADJUNTO_PROPIEDAD,
          id_objeto: id,
          nombre: art.get("nombre"),
        });
      });
      var email = new app.models.Consulta({
        tipo: 1,
        links_adjuntos:links_adjuntos,
        asunto:"Fichas de Busquedas",
        email: self.email,
      });
      workspace.nuevo_email(email);
    },

    enviar_whatsapp: function() {
      var self = this;
      if (isEmpty(this.telefono)) {
        alert("El cliente no tiene cargado un telefono.");
        return;        
      }
      var checks = this.$("#busquedas_tabla .seleccionado");
      if (checks.length == 0) {
        alert("Por favor seleccione algun elemento de la tabla.");
        return;
      }
      var links_adjuntos = new Array();
      $(checks).each(function(i,e){
        var link = $(e).find(".link_completo").val();
        links_adjuntos.push(link);
      });
      var salida = "https://wa.me/"+this.telefono+"?text="+encodeURIComponent(links_adjuntos.join("\r\n"));
      window.open(salida,"_blank");
    },

    marcar_interes: function() {
      var self = this;
      var checks = this.$("#busquedas_tabla .check-row:checked");
      if (checks.length == 0) {
        alert("Por favor seleccione algun elemento de la tabla.");
        return;
      }
      var ids = new Array();
      $(checks).each(function(i,e){
        var id = $(e).val();
        ids.push(id);
      });
      $.ajax({
        "url":"contactos/function/guardar_busquedas_interesadas/",
        "type":"post",
        "dataType":"json",
        "data":{
          "ids":ids,
          "id_cliente":self.id_cliente,
        },
        "success":function(r) {
          if (r.error == 1) alert("Ocurrio un error al guardar los intereses de las busquedas seleccionadas.");
          else {
            $('#contacto_busquedas_interesadas').owlCarousel('destroy'); 
            self.ficha_contacto.render_busquedas_interesadas();
          }
        },
      });
    },

  });

})(app);




// -----------------------------------------
//   ITEM DE LA TABLA DE RESULTADOS
// -----------------------------------------
(function ( app ) {
  app.views.BusquedasItemResultados = app.mixins.View.extend({
        
    template: _.template($("#busquedas_item_resultados_template").html()),
    tagName: "tr",
    myEvents: {
      "click .editar":"editar",
      "click .ver_interesados":"ver_interesados",
      "click .data":"seleccionar",
      "click .duplicar":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if (confirm("Desea duplicar el elemento?")) {
          $.ajax({
            "url":"busquedas/function/duplicar/"+self.model.id,
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
      location.href="app/#busquedas/"+this.model.id;
    },
    editar: function() {
      location.href="app/#busquedas/"+this.model.id;
    },
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      this.options = options;
      this.habilitar_seleccion = (this.options.habilitar_seleccion == undefined || this.options.habilitar_seleccion == false) ? false : true;
      this.vista_busqueda = (this.options.vista_busqueda != "undefined") ? this.options.vista_busqueda : false;
      this.telefono = (this.options.telefono != "undefined") ? this.options.telefono : "";
      this.email = (this.options.email != "undefined") ? this.options.email : "";
      this.id_cliente = (typeof this.options.id_cliente != "undefined") ? this.options.id_cliente : 0;
      this.ficha_contacto = (this.options.ficha_contacto != "undefined") ? this.options.ficha_contacto : null;
      this.render();
    },
    render: function() {
      var self = this;
      this.link_completo = 'https://' + DOMINIO + ((DOMINIO.substr(DOMINIO.length - 1) == "/") ? "" : "/") + this.model.get("link");
      var obj = { 
        seleccionar: this.habilitar_seleccion, 
        vista_busqueda: this.vista_busqueda,
        link_completo: this.link_completo,
      };
      $.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));

      this.$('[data-toggle="tooltip"]').tooltip(); 
      return this;
    },

    ver_lightbox: function() {
      var self = this;
      $.ajax({
        "url":"busquedas/function/ver_busqueda/"+self.model.id+"/"+self.model.get("id_empresa"),
        "dataType":"json",
        "success":function(r) {
          var busqueda = new app.models.Busquedas(r);
          var view = new app.views.BusquedaPreview({
            model: busqueda,
            telefono: self.telefono,
            email: self.email,
            id_cliente: self.id_cliente,
            ficha_contacto: self.ficha_contacto,
          });
          crearLightboxHTML({
            "html":view.el,
            "width":1200,
            "height":500,
          });
        }
      });
    },
  });
})(app);



// -----------------------------------------
//   DETALLE DEL ARTICULO
// -----------------------------------------
(function ( app ) {

  app.views.BusquedasEditView = app.mixins.View.extend({

    template: _.template($("#busqueda_template").html()),
            
    myEvents: {
      "click .guardar": "guardar",

      "change #busqueda_tipo_ubicacion":function(){
        var tipo_ubicacion = this.$("#busqueda_tipo_ubicacion").val();
        if (tipo_ubicacion == 0) this.$("#busqueda_detalle_calle").show();
        else this.$("#busqueda_detalle_calle").hide();
      },

      "change #busqueda_paises":function(){
        var id_provincia = this.$("#busqueda_provincias").val();
        this.cambiar_paises(id_provincia);
      },
      "change #busqueda_provincias":function(){
        var id_departamento = this.$("#busqueda_departamentos").val();
        this.cambiar_provincias(id_departamento);
      },
      "change #busqueda_departamentos":function(){
        var id_localidad = this.$("#busqueda_localidades").val();
        this.cambiar_departamentos(id_localidad);
      },
      "change #busqueda_localidades":function(){
        var id_localidad = this.$("#busqueda_localidades").val();
        this.cargar_barrios(id_localidad);
      },

      // ABRIMOS MODAL PARA UPLOAD MULTIPLE
      "click .upload_multiple":function(e) {
        var self = this;
        this.open_multiple_upload({
          "model": self.model,
          "url": "busquedas/function/upload_images/",
          "view": self,
        });
      },
            
      "change #busqueda_tipos_operacion":function(e) {
        var id = $(e.currentTarget).val();
        // Si es un Alquiler Temporario
        if (id == 3) {
          this.$("#busqueda_precios").hide();
          this.$("#busqueda_precios_temporal").show();
          this.$("#busqueda_capacidad").show();
        } else {
          this.$("#busqueda_precios_temporal").hide();
          this.$("#busqueda_capacidad").hide();
          this.$("#busqueda_precios").show();
        }
      },
    },    
                
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      
      var edicion = false;
      this.options = options;
      if (this.options.permiso > 1) edicion = true;
      var obj = { "edicion": edicion,"id":this.model.id }
      _.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));

      this.item_temporada = null;
      this.item_impuesto = null;
      
      this.$("#busqueda_tipos_operacion").select2({});
      this.$("#busqueda_tipos_inmueble").select2({});

      this.cambiar_paises(this.model.get("id_provincia"));
      if (this.model.get("id_localidad") != 0) {
        this.cambiar_provincias(this.model.get("id_departamento"));
        this.cargar_barrios(this.model.get("id_localidad"));
      }
      this.$("#busqueda_paises").select2({});
      this.$("#busqueda_provincias").select2({});
    },

    cambiar_paises: function(id_provincia) {
      var id_pais = this.$("#busqueda_paises").val();
      this.$("#busqueda_provincias").empty();
      for(var i=0;i< window.provincias.length;i++) { 
        var p = provincias[i];
        if (p.id_pais == id_pais) {
          var s = '<option data-id_pais="'+p.id_pais+'" '+((id_provincia == p.id)?"selected":"")+' value="'+p.id+'">'+p.nombre+'</option>';
          this.$("#busqueda_provincias").append(s);
        }
      }
      this.$("#busqueda_provincias").val(id_provincia);
      crear_select2("busqueda_provincias");
      this.$("#busqueda_provincias").trigger("change");
    },
    cambiar_provincias: function(id_departamento){
      var self = this;
      var id_provincia = this.$("#busqueda_provincias").val();
      this.$("#busqueda_departamentos").val(id_departamento);
      new app.mixins.Select({
        modelClass: app.models.ComDepartamento,
        url: "com_departamentos/function/get_select/?id_provincia="+id_provincia,
        //firstOptions: ["<option value='0'>Sin Definir</option>"],
        render: "#busqueda_departamentos",
        selected: self.model.get("id_departamento"),
        onComplete:function(c) {
          crear_select2("busqueda_departamentos");
          self.$("#busqueda_departamentos").trigger("change");
        }
      });
    },
    cambiar_departamentos: function(id_localidad){
      var self = this;
      var id_departamento = this.$("#busqueda_departamentos").val();
      this.$("#busqueda_localidades").val(id_localidad);
      new app.mixins.Select({
        modelClass: app.models.Localidad,
        url: "localidades/function/get_select/?id_departamento="+id_departamento,
        //firstOptions: ["<option value='0'>Sin Definir</option>"],
        render: "#busqueda_localidades",
        selected: self.model.get("id_localidad"),
        onComplete:function(c) {
          crear_select2("busqueda_localidades");
          self.$("#busqueda_localidades").trigger("change");
        }
      });
    },

    cargar_barrios: function(id_localidad) {
      var self = this;
      new app.mixins.Select({
        modelClass: app.models.Barrio,
        url: "barrios/function/buscar_por_localidad/?id_localidad="+id_localidad,
        firstOptions: ["<option value='0'>Sin Definir</option>"],
        render: "#busqueda_barrio",
        selected: self.model.get("id_barrio"),
        onComplete:function(c) {
          crear_select2("busqueda_barrio");
        }                    
      });
    },   

    validar: function() {
      try {
        var self = this;
        
        this.model.set({
          //"destacado":(self.$("#busqueda_destacado").is(":checked")?1:0),
          "moneda":self.$("#busqueda_monedas").val(),
          "id_tipo_inmueble":self.$("#busqueda_tipos_inmueble").val(),
          "id_tipo_operacion":self.$("#busqueda_tipos_operacion").val(),
          "precio_desde":self.$("#busqueda_precio_desde").val(),
          "precio_hasta":self.$("#busqueda_precio_hasta").val(),
          "apto_banco":(self.$("#busqueda_apto_banco").val()),
          "acepta_permuta":(self.$("#busqueda_acepta_permuta").val()),
          "id_barrio": (self.$("#busqueda_barrio").length > 0) ? $(self.el).find("#busqueda_barrio").val() : 0,
          "id_localidad": (self.$("#busqueda_localidades").length > 0) ? ($(self.el).find("#busqueda_localidades").val() == null ? 0 : $(self.el).find("#busqueda_localidades").val()) : 0,
          "id_departamento": (self.$("#busqueda_departamentos").length > 0) ? ($(self.el).find("#busqueda_departamentos").val() == null ? 0 : $(self.el).find("#busqueda_departamentos").val()) : 0,
          "id_provincia": (self.$("#busqueda_provincias").length > 0) ? ($(self.el).find("#busqueda_provincias").val() == null ? 0 : $(self.el).find("#busqueda_provincias").val()) : 0,
          "id_pais": (self.$("#busqueda_paises").length > 0) ? ($(self.el).find("#busqueda_paises").val() == null ? 0 : $(self.el).find("#busqueda_paises").val()) : 0,
        });

        // Texto del busqueda
        //var cktext = CKEDITOR.instances['busqueda_texto'].getData();
        //self.model.set({"texto":cktext});

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
              // Si se guardo una busqueda nueva, activamos una bandera para mostrar el lightbox de buscar interesados
              if (nuevo) window.busquedas_guardo_nueva_busqueda = model.id;
              history.back();
            }
          }
        });
      }      
    },
          
  });
})(app);


(function ( views, models ) {
  views.BusquedaPreview = app.mixins.View.extend({
    template: _.template($("#busqueda_preview_template").html()),
    className: "busqueda_preview",
    myEvents: {
      "click .editar":function() {
        $('.modal:last').modal('hide');
        location.href="app/#busquedas/"+this.model.id;
      },
      "click .enviar":"enviar",
      "click .enviar_whatsapp":"enviar_whatsapp",
      "click .marcar_interes":"marcar_interes",
      "click #busqueda_preview_2_link":function() {
        var self = this;
        try {
          loadGoogleMaps('3',API_KEY_GOOGLE_MAPS).done(self.render_map);
        } catch(e) {
          setTimeout(function(){
            self.render_map();
          },1000);
        }
      },
    },
    initialize: function(options) {
      _.bindAll(this);
      this.telefono = (typeof options.telefono != "undefined") ? options.telefono : "";
      this.email = (typeof options.email != "undefined") ? options.email : "";
      this.id_cliente = (typeof options.id_cliente != "undefined") ? options.id_cliente : 0;
      this.ficha_contacto = (typeof options.ficha_contacto != "undefined") ? options.ficha_contacto : null;
      this.render();
    },
    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));
      this.render_galeria();
      return this;
    },
    enviar_whatsapp: function() {
      var self = this;
      if (isEmpty(this.telefono)) {
        alert("El cliente no tiene cargado un telefono.");
        return;        
      }
      var link_completo = 'https://' + DOMINIO + ((DOMINIO.substr(DOMINIO.length - 1) == "/") ? "" : "/") + this.model.get("link");
      var salida = "https://wa.me/"+this.telefono+"?text="+encodeURIComponent(link_completo);
      window.open(salida,"_blank");
    },
    marcar_interes: function() {
      var self = this;
      $.ajax({
        "url":"contactos/function/guardar_busquedas_interesadas/",
        "type":"post",
        "dataType":"json",
        "data":{
          "ids":new Array(self.model.id),
          "id_empresa_busqueda":self.model.get("id_empresa"),
          "id_cliente":self.id_cliente,
        },
        "success":function(r) {
          if (r.error == 1) alert("Ocurrio un error al guardar los intereses de las busquedas seleccionadas.");
          else {
            $('#contacto_busquedas_interesadas').owlCarousel('destroy'); 
            if (self.ficha_contacto != null) {
              self.ficha_contacto.render_busquedas_interesadas();
            }
          }
        },
      });
    },
    enviar: function() {
      var self = this;
      var links_adjuntos = new Array();
      links_adjuntos.push({
        tipo: TIPO_ADJUNTO_PROPIEDAD,
        id_objeto: self.model.id,
        nombre: self.model.get("nombre"),
      });
      var email = new app.models.Consulta({
        tipo: 1,
        links_adjuntos:links_adjuntos,
        asunto:"Fichas de Busquedas",
        email: self.email,
      });
      workspace.nuevo_email(email);
    },
    render_map: function() {
      var self = this;
      var latitud = self.model.get("latitud");
      var longitud = self.model.get("longitud");
      var zoom = parseInt(self.model.get("zoom"));
      if (latitud == 0 && longitud == 0) {
        latitud = -34.6156625; longitud = -58.5033598; zoom: 9;
      }
      self.geocoder = new google.maps.Geocoder();
      self.coor = new google.maps.LatLng(latitud,longitud);
      var mapOptions = {
        zoom: zoom,
        center: self.coor
      }
      self.map = new google.maps.Map(document.getElementById("busqueda_preview_mapa"), mapOptions);
      self.marker = new google.maps.Marker({
        position: self.coor,
        map: self.map,
      });
    },
    render_galeria: function() {
      // The slider being synced must be initialized first
      this.$('#busquedas_preview_carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 120,
        asNavFor: '#busquedas_preview_slider',
        prevText: "",
        nextText: "",
      });
      this.$('#busquedas_preview_slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#busquedas_preview_carousel",
        prevText: "",
        nextText: "",
      });
    }
  });
})(app.views, app.models);