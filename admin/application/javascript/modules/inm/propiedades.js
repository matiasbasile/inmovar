// -----------
//   MODELO
// -----------

(function ( models ) {

  models.Propiedades = Backbone.Model.extend({
    urlRoot: "propiedades",
    defaults: {
      // Atributos que no se persisten directamente
      images: [],
      planos: [],
      images_meli: [],
      departamentos: [],
      gastos: [],
      permutas: [],
      relacionados: [], // Productos relacionados
      tipo_inmueble: "",
      tipo_operacion: "",
      tipo_estado: "",
      tipo_ubicacion: 0, // 0 = Calle, 1 = Esquina, 2 = Ruta
      direccion_completa: "",
      direccion_completa_red: "",
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
      titulo: "", // Este campo no se guarda sino que se usa para mostrar nada mas
      subtitulo: "",
      compartida: 2,
      entre_calles: "",
      entre_calles_2: "",
      valor_expensas: 0,
      id_propietario: 0,

      permiso_web: 0,
      bloqueado_web: 0,
      id_inmobiliaria: 0,
      inmobiliaria: "",
      logo_inmobiliaria: "",
      
      superficie_semicubierta: 0,
      superficie_descubierta: 0,
      superficie_cubierta: 0,
      superficie_total: 0,
      ambientes: 0,
      dormitorios: 0,
      cocheras: 0,
      banios: 0,
      
      latitud: 0,
      longitud: 0,
      zoom: 9,
      id_tipo_inmueble:0,
      id_tipo_operacion:0,
      id_tipo_estado:0,
      moneda: "U$S",
      codigo: "",
      codigo_completo: "", // Tiene el codigo de la empresa + codigo de la propiedad
      nombre: "",
      descripcion: "",
      fecha_ingreso: "",
      fecha_publicacion: "",
      precio_final: 0,
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
      id_usuario: 0,
      descripcion_ubicacion: "",
      codigo_seguimiento: "",
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
      incluye_comision_35: 0,

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
      servicios_escritura: 0,
      servicios_reglamento: 0,
      servicios_plano_obra: 0,
      servicios_plano_ph: 0,
      servicios_fecha_chequeado: "",
      servicios_reservas: 0, 
      servicios_boleto: 0,
      plazo_reserva: 0,
      plazo_boleto: 0,
      plazo_escritura: 0,
      documentacion_escritura: 0,
      documentacion_estado_parcelario: 0,
      documentacion_estado: 0,
      documentacion_impuesto: 0,
      documentacion_coti: 0,

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

      de_prueba: 0, // Indica si son propiedades cargadas de prueba

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
      data_graficos: [],
    },
  });
      
})( app.models );



// ----------------------
//   COLECCION PAGINADA
// ----------------------

(function (collections, model, paginator) {

  collections.Propiedades = paginator.requestPager.extend({

    model: model,
    
    paginator_ui: {
      perPage: 10,
      order_by: 'A.fecha_publicacion DESC, A.id ',
      order: 'desc',
    },

    paginator_core: {
      url: "propiedades/function/ver",
    }
    
  });

})( app.collections, app.models.Propiedades, Backbone.Paginator);



// -----------------------------------------
//   TABLA DE RESULTADOS
// -----------------------------------------
(function ( app ) {

  app.views.PropiedadesTableView = app.mixins.View.extend({

    template: _.template($("#propiedades_resultados_template").html()),
        
    myEvents: {
      "change #propiedades_buscar":"buscar",
      "change #propiedad_usuarios": "buscar",
      "click .buscar":"buscar",
      "click .exportar": "exportar",
      "click .importar_csv": "importar",
      "click .exportar_csv": "exportar_csv",
      "click .enviar": "enviar",
      "click .enviar_whatsapp": "enviar_whatsapp",
      "click .compartir_meli":"compartir_meli",
      "click .meli_pausar_multiple":"meli_pausar_multiple",
      "click .marcar_interes":"marcar_interes",
      "change #propiedades_tipo_activo": "buscar",
      "click .compartir_red_multiple":function(){
        this.compartir_red_multiple(1);
      },
      "click .no_compartir_red_multiple":function() {
        this.compartir_red_multiple(0);
      },    

      "click .enviar_por_whatsapp": function(){
        var array = [];
        $(".check-row:checked").each(function(i,e){
          array.push({
            "id":$(e).val(),
            "id_empresa":$(e).data("id_empresa"),
          });
        });
        var self = this;
        var edicion = new app.views.EnviarPlantillaView({
          model: new app.models.AbstractModel({
            plantilla: "whatsapp",
            propiedades: array,
          }),
        });
        crearLightboxHTML({
          "html":edicion.el,
          "width":900,
          "height":700,
        });
      },  

      "click #buscar_propias_tab":function() {
        this.$(".buscar_tab").removeClass("active");
        this.$("#buscar_propias_tab").addClass("active");
        this.$(".ocultar_en_red").show();
        this.$(".mostrar_en_red").hide();
        this.buscar();
      },
      "click #buscar_red_tab":function() {
        this.$(".buscar_tab").removeClass("active");
        this.$("#buscar_red_tab").addClass("active");
        this.$(".ocultar_en_red").hide();
        this.$(".mostrar_en_red").show();
        this.buscar();
      },
      "click #propiedades_ver_mapa":function() {
        this.$("#propiedades_ver_lista").removeClass("btn-info");
        this.$("#propiedades_ver_mapa").addClass("btn-info");
        window.propiedades_mapa = 1;
        this.buscar();
      },
      "click #propiedades_ver_lista":function() {
        this.$("#propiedades_ver_mapa").removeClass("btn-info");
        this.$("#propiedades_ver_lista").addClass("btn-info");
        window.propiedades_mapa = 0;
        this.buscar();
      },

      "change #propiedades_buscar_monto":"buscar",
      "change #propiedades_buscar_monto_2":"buscar",
      "change #propiedades_buscar_direccion":"buscar",
      "change #propiedades_entre_calles":"buscar",
      "change #propiedades_entre_calles_2":"buscar",
      "change #propiedades_buscar_dormitorios":"buscar",
      "change #propiedades_buscar_banios":"buscar",
      "change #propiedades_buscar_cocheras":"buscar",
      "change #propiedades_buscar_compartida_en":"buscar",
      "change #propiedades_buscar_inmobiliarias":"buscar",
      "change #propiedades_buscar_propietarios":"buscar",

      "keydown #propiedades_tabla tbody tr .radio:first":function(e) {
        // Si estamos en el primer elemento y apretamos la flechita de arriba
        if (e.which == 38) { e.preventDefault(); $("#propiedades_texto").focus(); }
      },

      "click #propiedades_buscar_apto_banco":function() {
        this.$("#propiedades_buscar_apto_banco").toggleClass("btn-info");
        this.buscar();
      },
      "click #propiedades_buscar_acepta_permuta":function() {
        this.$("#propiedades_buscar_acepta_permuta").toggleClass("btn-info");
        this.buscar();
      },
      "click .setear_moneda":function(e) {
        this.$("#propiedades_buscar_monto_moneda").text($(e.currentTarget).text());
        this.buscar();
      },
      "click .setear_localidad":function(e) {
        var data = {
          id: $(e.currentTarget).data("id"),
          text: $(e.currentTarget).data("nombre")
        };
        var newOption = new Option(data.text, data.id, true, true);
        this.$('#propiedades_buscar_localidades').append(newOption).trigger('change');
      },
      "click .setear_dormitorio":function(e) {
        var data = {
          id: $(e.currentTarget).data("id"),
          text: $(e.currentTarget).data("nombre")
        };
        var newOption = new Option(data.text, data.id, true, true);
        this.$('#propiedades_buscar_dormitorios').append(newOption).trigger('change');
      },
      "click .setear_banio":function(e) {
        var data = {
          id: $(e.currentTarget).data("id"),
          text: $(e.currentTarget).data("nombre")
        };
        var newOption = new Option(data.text, data.id, true, true);
        this.$('#propiedades_buscar_banios').append(newOption).trigger('change');
      },
      "click .setear_cochera":function(e) {
        var data = {
          id: $(e.currentTarget).data("id"),
          text: $(e.currentTarget).data("nombre")
        };
        var newOption = new Option(data.text, data.id, true, true);
        this.$('#propiedades_buscar_cocheras').append(newOption).trigger('change');
      },
      "click .ttn":function(e) {
        if ($(e.currentTarget).hasClass("sort")){
          $(".sort.ttn i").addClass("dn");
          $(e.currentTarget).children().removeClass("dn");
        } else {
          $(".sort-a.ttn i").addClass("dn");
          $(e.currentTarget).children().removeClass("dn");          
        }
        this.buscar();
      },
      "click .guardar_busqueda":function() {
        var self = this;
        var localidades = this.$("#propiedades_buscar_localidades").val();
        if ($.isArray(localidades)) localidades = localidades.join("-");
        var id_tipo_operacion = this.$("#propiedades_buscar_tipos_operacion").val();
        if ($.isArray(id_tipo_operacion)) id_tipo_operacion = id_tipo_operacion.join("-");
        var id_tipo_inmueble = this.$("#propiedades_buscar_tipos_inmueble").val();
        if ($.isArray(id_tipo_inmueble)) id_tipo_inmueble = id_tipo_inmueble.join("-");
        $.ajax({
          "url":"contactos/function/guardar_busqueda/",
          "dataType":"json",
          "type":"post",
          "data": {
            "id_cliente":self.id_cliente,
            "id_localidad":localidades,
            "id_tipo_operacion":id_tipo_operacion,
            "id_tipo_inmueble":id_tipo_inmueble,
            //"apto_banco":apto_banco,
            //"precio_desde":precio_desde,
            //"precio_hasta":precio_hasta,
          },
          "success":function() {
            if (self.ficha_contacto != null) self.ficha_contacto.render_busquedas();
          }
        })
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
      window.propiedades_entre_calles = (typeof window.propiedades_entre_calles != "undefined") ? window.propiedades_entre_calles : "";
      window.propiedades_entre_calles_2 = (typeof window.propiedades_entre_calles_2 != "undefined") ? window.propiedades_entre_calles_2 : "";
      window.propiedades_buscar_red = (typeof window.propiedades_buscar_red != "undefined") ? window.propiedades_buscar_red : 0;
      window.propiedades_buscar_red_empresa = (typeof window.propiedades_buscar_red_empresa != "undefined") ? window.propiedades_buscar_red_empresa : 0;
      window.propiedades_compartida_en = (typeof window.propiedades_compartida_en != "undefined") ? window.propiedades_compartida_en : "";
      window.propiedades_compartida_en_filtro = (typeof window.propiedades_compartida_en_filtro != "undefined") ? window.propiedades_compartida_en_filtro : "";
      window.propiedades_id_tipo_inmueble = (typeof window.propiedades_id_tipo_inmueble != "undefined") ? window.propiedades_id_tipo_inmueble : 0;
      window.propiedades_id_tipo_estado = (typeof window.propiedades_id_tipo_estado != "undefined") ? window.propiedades_id_tipo_estado : 0;
      window.propiedades_id_tipo_operacion = (typeof window.propiedades_id_tipo_operacion != "undefined") ? window.propiedades_id_tipo_operacion : 0;
      window.propiedades_id_localidad = (typeof window.propiedades_id_localidad != "undefined") ? window.propiedades_id_localidad : 0;
      window.propiedades_dormitorios = (typeof window.propiedades_dormitorios != "undefined") ? window.propiedades_dormitorios : "";
      window.propiedades_banios = (typeof window.propiedades_banios != "undefined") ? window.propiedades_banios : "";
      window.propiedades_cocheras = (typeof window.propiedades_cocheras != "undefined") ? window.propiedades_cocheras : "";
      window.propiedades_filter = (typeof window.propiedades_filter != "undefined") ? window.propiedades_filter : "";
      window.propiedades_direccion = (typeof window.propiedades_direccion != "undefined") ? window.propiedades_direccion : "";
      window.propiedades_monto = (typeof window.propiedades_monto != "undefined") ? window.propiedades_monto : "";
      window.propiedades_monto_2 = (typeof window.propiedades_monto_2 != "undefined") ? window.propiedades_monto_2 : "";
      window.propiedades_monto_tipo = (typeof window.propiedades_monto_tipo != "undefined") ? window.propiedades_monto_tipo : "";
      window.propiedades_monto_moneda = (typeof window.propiedades_monto_moneda != "undefined") ? window.propiedades_monto_moneda : "U$D";
      window.propiedades_apto_banco = (typeof window.propiedades_apto_banco != "undefined") ? window.propiedades_apto_banco : 0;
      window.propiedades_acepta_permuta = (typeof window.propiedades_acepta_permuta != "undefined") ? window.propiedades_acepta_permuta : 0;
      window.propiedades_page = (typeof window.propiedades_page != "undefined") ? window.propiedades_page : 1;
      window.propiedades_filtro_meli = (typeof window.propiedades_filtro_meli != "undefined") ? window.propiedades_filtro_meli : -1;
      window.propiedades_filtro_olx = (typeof window.propiedades_filtro_olx != "undefined") ? window.propiedades_filtro_olx : -1;
      window.propiedades_filtro_inmovar = (typeof window.propiedades_filtro_inmovar != "undefined") ? window.propiedades_filtro_inmovar : -1;
      window.propiedades_filtro_inmobusquedas = (typeof window.propiedades_filtro_inmobusquedas != "undefined") ? window.propiedades_filtro_inmobusquedas : -1;
      window.propiedades_filtro_argenprop = (typeof window.propiedades_filtro_argenprop != "undefined") ? window.propiedades_filtro_argenprop : -1;
      window.propiedades_filtro_web = (typeof window.propiedades_filtro_web != "undefined") ? window.propiedades_filtro_web : 1;
      window.propiedades_mapa = (typeof window.propiedades_mapa != "undefined") ? window.propiedades_mapa : 0;
      window.propiedades_tipo_activo = (typeof window.propiedades_tipo_activo != "undefined") ? window.propiedades_tipo_activo : 1;
      window.propiedades_id_propietario = (typeof window.propiedades_id_propietario != "undefined") ? window.propiedades_id_propietario : 0;
      window.propiedades_id_usuario = (typeof window.propiedades_id_usuario != "undefined") ? window.propiedades_id_usuario : 0;
      // Flag que indica cuando se guardo una nueva propiedad
      window.propiedades_guardo_nueva_propiedad = (typeof window.propiedades_guardo_nueva_propiedad != "undefined") ? window.propiedades_guardo_nueva_propiedad : 0;

      window.propiedades_marcadas = new Array();

      if (window.propiedades_buscar_red == 1) this.$(".ocultar_en_red").hide();

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
        "permiso":control.check("propiedades"),
        "vista_busqueda":this.vista_busqueda,
        "email":this.email,
        "nombre":this.nombre,
        "seleccionar":this.habilitar_seleccion,
      }));

      this.$("#propiedades_buscar_localidades").select2({
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
      this.$("#propiedades_buscar_localidades").parent().find(".select2-search__field").attr("placeholder","Localidades");
      this.$("#propiedades_buscar_localidades").parent().find(".select2-search__field").css("width","100%");
      this.$("#propiedades_buscar_localidades").on("change.select2",function(e){
        self.buscar();
        self.$("#propiedades_buscar_localidades").parent().find(".select2-search__field").attr("placeholder","Localidades");
        self.$("#propiedades_buscar_localidades").parent().find(".select2-search__field").css("width","100%");
      });

      this.$("#propiedades_buscar_dormitorios").select2({
        multiple: true,
        language: "es",
      });
      this.$("#propiedades_buscar_dormitorios").parent().find(".select2-search__field").attr("placeholder","Dormitorios");
      this.$("#propiedades_buscar_dormitorios").parent().find(".select2-search__field").css("width","100%");
      this.$("#propiedades_buscar_dormitorios").on("change.select2",function(e){
        self.buscar();
        self.$("#propiedades_buscar_dormitorios").parent().find(".select2-search__field").attr("placeholder","Dormitorios");
        self.$("#propiedades_buscar_dormitorios").parent().find(".select2-search__field").css("width","100%");
      });

      this.$("#propiedades_buscar_banios").select2({
        multiple: true,
        language: "es",
      });
      this.$("#propiedades_buscar_banios").parent().find(".select2-search__field").attr("placeholder","Baños");
      this.$("#propiedades_buscar_banios").parent().find(".select2-search__field").css("width","100%");
      this.$("#propiedades_buscar_banios").on("change.select2",function(e){
        self.buscar();
        self.$("#propiedades_buscar_banios").parent().find(".select2-search__field").attr("placeholder","Baños");
        self.$("#propiedades_buscar_banios").parent().find(".select2-search__field").css("width","100%");
      });

      this.$("#propiedades_buscar_cocheras").select2({
        multiple: true,
        language: "es",
      });
      this.$("#propiedades_buscar_cocheras").parent().find(".select2-search__field").attr("placeholder","Cocheras");
      this.$("#propiedades_buscar_cocheras").parent().find(".select2-search__field").css("width","100%");
      this.$("#propiedades_buscar_cocheras").on("change.select2",function(e){
        self.buscar();
        self.$("#propiedades_buscar_cocheras").parent().find(".select2-search__field").attr("placeholder","Cocheras");
        self.$("#propiedades_buscar_cocheras").parent().find(".select2-search__field").css("width","100%");
      });

      /*
      new app.mixins.Select({
        modelClass: app.models.Localidad,
        url: "localidades/function/utilizadas/?id_empresa="+ID_EMPRESA+"&id_proyecto="+ID_PROYECTO,
        render: "#propiedades_buscar_localidades",
        firstOptions: ["<option value='0'>Localidad</option>"],
        selected: window.propiedades_id_localidad,
        onComplete:function(c) {
          crear_select2("propiedades_buscar_localidades");
        }
      });            
      */

      new app.mixins.Select({
        modelClass: app.models.Propietario,
        url: "propietarios/",
        firstOptions: ["<option value='0'>Propietario</option>"],
        render: "#propiedades_buscar_propietarios",
        selected: window.propiedades_id_propietario,
        onComplete:function(c) {
          crear_select2("propiedades_buscar_propietarios");
        }                    
      });      

      // Cargamos el paginador
      this.$(".pagination_container").html(this.pagination.el);

      this.$("#propiedades_buscar_inmobiliarias").select2();
      
      this.$("#propiedades_buscar_tipos_estado").select2({
        multiple: true,
        language: "es",
        placeholder: {
          id: 0,
          text: "Estado",
        }
      });
      if (window.propiedades_id_tipo_estado == 0) this.$("#propiedades_buscar_tipos_estado").val(null).trigger("change");
      this.$("#propiedades_buscar_tipos_estado").parent().find(".select2-search__field").attr("placeholder","Estado");
      this.$("#propiedades_buscar_tipos_estado").parent().find(".select2-search__field").css("width","100%");
      this.$("#propiedades_buscar_tipos_estado").on("change.select2",function(e){
        self.buscar();
        self.$("#propiedades_buscar_tipos_estado").parent().find(".select2-search__field").css("width","100%");
      });

      this.$("#propiedades_buscar_tipos_inmueble").select2({
        multiple: true,
        language: "es",
        placeholder: {
          id: 0,
          text: "Tipo de Inmueble",
        }
      });
      if (window.propiedades_id_tipo_inmueble == 0) this.$("#propiedades_buscar_tipos_inmueble").val(null).trigger("change");
      this.$("#propiedades_buscar_tipos_inmueble").parent().find(".select2-search__field").attr("placeholder","Tipo de Inmueble");
      this.$("#propiedades_buscar_tipos_inmueble").parent().find(".select2-search__field").css("width","100%");
      this.$("#propiedades_buscar_tipos_inmueble").on("change.select2",function(e){
        self.buscar();
        self.$("#propiedades_buscar_tipos_inmueble").parent().find(".select2-search__field").css("width","100%");
      });

      this.$("#propiedades_buscar_tipos_operacion").select2({
        multiple: true,
        language: "es",
        placeholder: {
          id: 0,
          text: "Operación",
        }
      });
      if (window.propiedades_id_tipo_operacion == 0) this.$("#propiedades_buscar_tipos_operacion").val(null).trigger("change");
      this.$("#propiedades_buscar_tipos_operacion").parent().find(".select2-search__field").attr("placeholder","Operación");
      this.$("#propiedades_buscar_tipos_operacion").parent().find(".select2-search__field").css("width","100%");
      this.$("#propiedades_buscar_tipos_operacion").on("change.select2",function(e){
        self.buscar();
        self.$("#propiedades_buscar_tipos_operacion").parent().find(".select2-search__field").css("width","100%");
      });

      // Si se guardo una nueva propiedad
      if (window.propiedades_guardo_nueva_propiedad != 0) {
        var modelo = new app.models.Propiedades({
          id: window.propiedades_guardo_nueva_propiedad
        });
        modelo.fetch({
          "success":function(m) {
            var view = new app.views.PropiedadBuscarInteresadosView({
              model: m
            });
            crearLightboxHTML({
              "html":view.el,
              "width":900,
              "height":500,
            });
          }
        });
        // Levantamos el flag para que no vuelva a aparecer el lighbox
        window.propiedades_guardo_nueva_propiedad = 0;
      }

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
      if (window.propiedades_buscar_red != buscar_red) {
        window.propiedades_buscar_red = buscar_red;
        cambio_parametros = true;
      }

      if (window.propiedades_buscar_red == 1) {
        if (window.propiedades_buscar_red_empresa != this.$("#propiedades_buscar_inmobiliarias").val()) {
          window.propiedades_buscar_red_empresa = this.$("#propiedades_buscar_inmobiliarias").val();
          cambio_parametros = true;
        }
      } else {
        cambio_parametros = true;
        window.propiedades_buscar_red_empresa = 0;
      }

      if (window.propiedades_id_propietario != this.$("#propiedades_buscar_propietarios").val()) {
        window.propiedades_id_propietario = (this.$("#propiedades_buscar_propietarios").val() == null) ? 0 : this.$("#propiedades_buscar_propietarios").val();
        cambio_parametros = true;
      }      

      if (window.propiedades_id_tipo_estado != this.$("#propiedades_buscar_tipos_estado").val()) {
        window.propiedades_id_tipo_estado = (this.$("#propiedades_buscar_tipos_estado").val() == null) ? 0 : this.$("#propiedades_buscar_tipos_estado").val();  
        if ($.isArray(window.propiedades_id_tipo_estado)) window.propiedades_id_tipo_estado = window.propiedades_id_tipo_estado.join("-");
        cambio_parametros = true;
      }
      if (window.propiedades_id_tipo_inmueble != this.$("#propiedades_buscar_tipos_inmueble").val()) {
        window.propiedades_id_tipo_inmueble = (this.$("#propiedades_buscar_tipos_inmueble").val() == null) ? 0 : this.$("#propiedades_buscar_tipos_inmueble").val();
        if ($.isArray(window.propiedades_id_tipo_inmueble)) window.propiedades_id_tipo_inmueble = window.propiedades_id_tipo_inmueble.join("-");
        cambio_parametros = true;
      }
      if (window.propiedades_id_tipo_operacion != this.$("#propiedades_buscar_tipos_operacion").val()) {
        window.propiedades_id_tipo_operacion = (this.$("#propiedades_buscar_tipos_operacion").val() == null) ? 0 : this.$("#propiedades_buscar_tipos_operacion").val();  
        if ($.isArray(window.propiedades_id_tipo_operacion)) window.propiedades_id_tipo_operacion = window.propiedades_id_tipo_operacion.join("-");
        cambio_parametros = true;
      }
      if (window.propiedades_id_localidad != this.$("#propiedades_buscar_localidades").val()) {
        window.propiedades_id_localidad = this.$("#propiedades_buscar_localidades").val();
        if ($.isArray(window.propiedades_id_localidad)) window.propiedades_id_localidad = window.propiedades_id_localidad.join("-");
        cambio_parametros = true;
      }

      if (window.propiedades_filter != this.$("#propiedades_buscar").val()) {
        window.propiedades_filter = this.$("#propiedades_buscar").val();  
        cambio_parametros = true;
      }

      if (window.propiedades_id_usuario != this.$("#propiedad_usuarios").val()) {
        window.propiedades_id_usuario = this.$("#propiedad_usuarios").val();  
        cambio_parametros = true;
      }
      if (window.propiedades_direccion != this.$("#propiedades_buscar_direccion").val()) {
        window.propiedades_direccion = this.$("#propiedades_buscar_direccion").val();  
        cambio_parametros = true;
      }
      if (window.propiedades_direccion != this.$("#propiedades_buscar_direccion").val()) {
        window.propiedades_direccion = this.$("#propiedades_buscar_direccion").val();  
        cambio_parametros = true;
      }
      if (window.propiedades_tipo_activo != this.$("#propiedades_tipo_activo").val()) {
        window.propiedades_tipo_activo = this.$("#propiedades_tipo_activo").val();  
        cambio_parametros = true;
      }
      if (window.propiedades_monto_moneda != this.$("#propiedades_buscar_monto_moneda").text()) {
        window.propiedades_monto_moneda = this.$("#propiedades_buscar_monto_moneda").text();  
        cambio_parametros = true;
      }
      if (window.propiedades_monto != this.$("#propiedades_buscar_monto").val()) {
        window.propiedades_monto = this.$("#propiedades_buscar_monto").val();  
        cambio_parametros = true;
      }
      if (window.propiedades_monto_2 != this.$("#propiedades_buscar_monto_2").val()) {
        window.propiedades_monto_2 = this.$("#propiedades_buscar_monto_2").val();  
        cambio_parametros = true;
      }

      if (window.propiedades_dormitorios != this.$("#propiedades_buscar_dormitorios").val()) {
        window.propiedades_dormitorios = this.$("#propiedades_buscar_dormitorios").val();
        if ($.isArray(window.propiedades_dormitorios)) window.propiedades_dormitorios = window.propiedades_dormitorios.join("-");
        cambio_parametros = true;
      }

      if (window.propiedades_banios != this.$("#propiedades_buscar_banios").val()) {
        window.propiedades_banios = this.$("#propiedades_buscar_banios").val();
        if ($.isArray(window.propiedades_banios)) window.propiedades_banios = window.propiedades_banios.join("-");
        cambio_parametros = true;
      }

      if (window.propiedades_cocheras != this.$("#propiedades_buscar_cocheras").val()) {
        window.propiedades_cocheras = this.$("#propiedades_buscar_cocheras").val();
        if ($.isArray(window.propiedades_cocheras)) window.propiedades_cocheras = window.propiedades_cocheras.join("-");
        cambio_parametros = true;
      }

      if (window.propiedades_entre_calles != this.$("#propiedades_entre_calles").val()) {
        window.propiedades_entre_calles = this.$("#propiedades_entre_calles").val();  
        cambio_parametros = true;
      }
      if (window.propiedades_entre_calles_2 != this.$("#propiedades_entre_calles_2").val()) {
        window.propiedades_entre_calles_2 = this.$("#propiedades_entre_calles_2").val();  
        cambio_parametros = true;
      }
      /*
      var apto_banco = (this.$("#propiedades_buscar_apto_banco").hasClass("btn-info")?1:0);
      if (window.propiedades_apto_banco != apto_banco) {
        window.propiedades_apto_banco = apto_banco;  
        cambio_parametros = true;
      }
      var acepta_permuta = (this.$("#propiedades_buscar_acepta_permuta").hasClass("btn-info")?1:0);
      if (window.propiedades_acepta_permuta != acepta_permuta) {
        window.propiedades_acepta_permuta = acepta_permuta;  
        cambio_parametros = true;
      }
      */

      if (this.$("#propiedades_buscar_compartida_en").length > 0) {
        var cp = this.$("#propiedades_buscar_compartida_en").val();
        window.propiedades_filtro_olx = -1;
        window.propiedades_filtro_meli = -1;
        window.propiedades_filtro_inmovar = -1;
        window.propiedades_filtro_inmobusquedas = -1;
        window.propiedades_filtro_argenprop = -1;
        window.propiedades_filtro_web = -1;
        //window.propiedades_tipo_activo = -1;
        if (cp == "olx") { window.propiedades_filtro_olx = 1; cambio_parametros = true; }
        else if (cp == "no_olx") { window.propiedades_filtro_olx = 0; cambio_parametros = true; }
        else if (cp == "web") { window.propiedades_filtro_web = 1; cambio_parametros = true; }
        else if (cp == "no_web") { window.propiedades_filtro_web = 0; cambio_parametros = true; }
        else if (cp == "meli") { window.propiedades_filtro_meli = 1; cambio_parametros = true; }
        else if (cp == "no_meli") { window.propiedades_filtro_meli = 0; cambio_parametros = true; }
        else if (cp == "red") { window.propiedades_filtro_inmovar = 1; cambio_parametros = true; }
        else if (cp == "no_red") { window.propiedades_filtro_inmovar = 0; cambio_parametros = true; }
        else if (cp == "inmobusquedas") { window.propiedades_filtro_inmobusquedas = 1; cambio_parametros = true; }
        else if (cp == "no_inmobusquedas") { window.propiedades_filtro_inmobusquedas = 0; cambio_parametros = true; }
        else if (cp == "argenprop") { window.propiedades_filtro_argenprop = 1; cambio_parametros = true; }
        else if (cp == "no_argenprop") { window.propiedades_filtro_argenprop = 0; cambio_parametros = true; }
      }

      // Si se cambiaron los parametros, debemos volver a pagina 1
      if (cambio_parametros) window.propiedades_page = 1;

      var datos = {
        "buscar_red":window.propiedades_buscar_red,
        "buscar_red_empresa":window.propiedades_buscar_red_empresa,
        "filter":window.propiedades_filter,
        "calle":window.propiedades_direccion,
        "entre_calles":window.propiedades_entre_calles,
        "entre_calles_2":window.propiedades_entre_calles_2,
        "id_localidad":window.propiedades_id_localidad,
        "id_tipo_estado":window.propiedades_id_tipo_estado,
        "id_tipo_inmueble":window.propiedades_id_tipo_inmueble,
        "id_tipo_operacion":window.propiedades_id_tipo_operacion,
        "monto":window.propiedades_monto,
        "monto_2":window.propiedades_monto_2,
        "monto_tipo":window.propiedades_monto_tipo,
        "monto_moneda":window.propiedades_monto_moneda,
        "id_propietario":window.propiedades_id_propietario,
        //"apto_banco":window.propiedades_apto_banco,
        //"acepta_permuta":window.propiedades_acepta_permuta,
        "dormitorios":window.propiedades_dormitorios,
        "banios":window.propiedades_banios,
        "cocheras":window.propiedades_cocheras,
        "filtro_meli":window.propiedades_filtro_meli,
        "filtro_olx":window.propiedades_filtro_olx,
        "filtro_inmovar":window.propiedades_filtro_inmovar,
        "filtro_inmobusquedas":window.propiedades_filtro_inmobusquedas,
        "filtro_argenprop":window.propiedades_filtro_argenprop,
        "activo":window.propiedades_tipo_activo,
        "id_usuario":window.propiedades_id_usuario,
      };



      //Acá hacemos el filtro de order y order by
      //order_by es el nombre del campo y order es ASC o DESC
      //sort es la clase para diferenciar order_by y sort-a para diferenciar order
      
      var order_by = '';
      
      $(".sort i").each(function(index) {
        if (!$(this).hasClass("dn")){
          order_by = $(this).attr("data-val");
        }
      });
      //Si encontramos algun filtro de order_by
      //Revisamos si es ASC o DESC y despues lo ingresamos al array de datos
      if (order_by !== '') {
        var order = 'ASC'; //Inicializamos ASC por default
        $(".sort-a i").each(function(index) {
          if (!$(this).hasClass("dn")){
            order = $(this).attr("data-val");
          }
        });    

        datos['order_by'] = order_by;
        datos['order'] = order;    
      }


      //if (SOLO_USUARIO == 1) datos.id_usuario = ID_USUARIO; // Buscamos solo los productos de ese usuario
      this.collection.server_api = datos;
      if (window.propiedades_mapa == 1) {
        this.collection.server_api.offset = 9999;
        this.collection.server_api.page = 1;
        this.collection.pager();
      } else {
        this.collection.goTo(window.propiedades_page);
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
      self.map = new google.maps.Map(document.getElementById("propiedades_mapa"), mapOptions);
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
        "url":"propiedades/function/ver_propiedad/"+id+"/"+id_empresa,
        "dataType":"json",
        "success":function(r) {
          var propiedad = new app.models.Propiedades(r);
          var view = new app.views.PropiedadPreview({
            model: propiedad,
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
      if (window.propiedades_mapa == 1) {
        this.$("#propiedades_tabla_cont").hide();
        this.$(".seccion_llena").show();
        this.$("#propiedades_mapa").show();

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
        window.propiedades_page = this.pagination.getPage();
        this.$("#propiedades_mapa").hide();
        this.$("#propiedades_tabla_cont").show();
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
        this.$("#propiedades_propias_total").html(this.collection.meta("total_propias"));
        this.$("#propiedades_red_total").html(this.collection.meta("total_red"));
      }
    },
        
    addOne : function ( item ) {
      var self = this;
      var view = new app.views.PropiedadesItemResultados({
        model: item,
        habilitar_seleccion: this.habilitar_seleccion, 
        vista_busqueda: this.vista_busqueda,
        telefono: self.telefono,
        email: self.email,
        id_cliente: self.id_cliente,
        ficha_contacto: self.ficha_contacto,
        parent: self,
      });
      this.$(".tbody").append(view.render().el);
    },
            
    importar: function() {
      app.views.importar = new app.views.Importar({
        "table":"propiedades"
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
      window.open("propiedades/function/exportar_csv/","_blank");
    },
        
    enviar: function() {
      var self = this;
      var checks = this.$("#propiedades_tabla .check-row:checked");
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
        asunto:"Fichas de Propiedades",
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
      var checks = this.$("#propiedades_tabla .seleccionado");
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
      var checks = this.$("#propiedades_tabla .check-row:checked");
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
        "url":"contactos/function/guardar_propiedades_interesadas/",
        "type":"post",
        "dataType":"json",
        "data":{
          "ids":ids,
          "id_cliente":self.id_cliente,
        },
        "success":function(r) {
          if (r.error == 1) alert("Ocurrio un error al guardar los intereses de las propiedades seleccionadas.");
          else {
            $('#contacto_propiedades_interesadas').owlCarousel('destroy'); 
            self.ficha_contacto.render_propiedades_interesadas();
          }
        },
      });
    },

    compartir_meli: function() {
      if (isEmpty(ML_ACCESS_TOKEN)) {
        alert("La sincronizacion con MercadoLibre no esta habilitada. Puede hacerlo desde la configuracion avanzada.");
        location.href="app/#web_seo";
        return;
      }
      var propiedades_marcadas = new Array();
      var checks = this.$("#propiedades_tabla .check-row:checked");
      $(checks).each(function(i,e){
        var id = $(e).val();
        propiedades_marcadas.push(id);
      });
      if (propiedades_marcadas.length == 0) return;

      // Controlamos que todas las propiedades marcadas pertenezcan al mismo tipo de propiedad y al mismo tipo de operacion
      var id_1 = propiedades_marcadas[0];
      var tipo_propiedad_1 = $("#"+id_1+"_tipo_propiedad").val();
      var tipo_operacion_1 = $("#"+id_1+"_tipo_operacion").val();
      for(var i=1;i<propiedades_marcadas.length;i++) {
        var id = propiedades_marcadas[i];
        var tipo_propiedad = $("#"+id+"_tipo_propiedad").val();
        var tipo_operacion = $("#"+id+"_tipo_operacion").val();
        var localidad = $("#"+id+"_localidad").val();
        if (tipo_propiedad != tipo_propiedad_1 || tipo_operacion != tipo_operacion_1) {
          alert("ERROR: Para compartir multiples propiedades a la vez, todas deben tener la misma operacion y ser el mismo tipo de inmueble.");
          return;
        }
        if (localidad == 0 || isEmpty(localidad)) {
          alert("ERROR: Algunas propiedades que esta intentando compartir no tienen localidad asignada.");
          return;
        }
      }

      var view = new app.views.PropiedadMercadoLibreView({
        model: new app.models.AbstractModel({
          "titulo_meli":"",
          "precio_meli":0,
          "texto_meli":"",
          "images_meli":[],
        }),
        multiple: true,
      });
      crearLightboxHTML({
        "html":view.el,
        "width":900,
        "height":500,
        "escapable":false,
      });
    },

    meli_pausar_multiple: function() {
      if (isEmpty(ML_ACCESS_TOKEN)) {
        alert("La sincronizacion con MercadoLibre no esta habilitada. Puede hacerlo desde la configuracion avanzada.");
        location.href="app/#web_seo";
        return;
      }
      var propiedades_marcadas = new Array();
      var checks = this.$("#propiedades_tabla .check-row:checked");
      $(checks).each(function(i,e){
        var id = $(e).val();
        propiedades_marcadas.push(id);
      });
      if (propiedades_marcadas.length == 0) return;

      var art_marcados = propiedades_marcadas.join(",");
      workspace.esperar("Pausando publicaciones...");
      $.ajax({
        "url":"propiedades_meli/function/pausar_multiple/",
        "type":"post",
        "data":{
          "ids":art_marcados,
        },
        "dataType":"json",
        "success":function(r) {
          if (r.error == 0) {
            location.reload();
          } else if (r.error == 1) {
            $(".modal:last").trigger('click');
            alert(r.mensaje);
          }
        },
      });
    },

    compartir_red_multiple: function(compartir) {
      var self = this;
      var propiedades_marcadas = new Array();
      var checks = this.$("#propiedades_tabla .check-row:checked");
      $(checks).each(function(i,e){
        var id = $(e).val();
        propiedades_marcadas.push(id);
      });
      if (propiedades_marcadas.length == 0) return;

      var art_marcados = propiedades_marcadas.join(",");
      $.ajax({
        "url":"propiedades/function/compartir_red_multiple/",
        "type":"post",
        "data":{
          "ids":art_marcados,
          "compartir":compartir,
        },
        "dataType":"json",
        "success":function(r) {
          if (r.error == 0) {
            self.buscar();
          } else if (r.error == 1) {
            $(".modal:last").trigger('click');
            alert(r.mensaje);
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
  app.views.PropiedadesItemResultados = app.mixins.View.extend({
        
    template: _.template($("#propiedades_item_resultados_template").html()),
    tagName: "tr",
    myEvents: {
      "click .editar":"editar",
      "click .ver_interesados":"ver_interesados",
      "click .meli_eliminar":"meli_eliminar",
      "click .meli_pausar":"meli_pausar",
      "click .meli_reactivar":"meli_reactivar",
      "click .meli_finalizar":"meli_finalizar",
      "click .compartir_meli":"compartir_meli",
      "click .compartir_olx":"compartir_olx",
      "click .buscar_interesados":"buscar_interesados",
      "click .btn-menu-compartir":function(e) {
        e.stopPropagation();
        $(".menu-compartir").hide();
        var menu = $(e.currentTarget).parent().find(".menu-compartir");
        var top = $(e.currentTarget).css("top");
        $(menu).toggle();
      },

      "click .data":"seleccionar",
      "focus .radio":function(e) {
        $(e.currentTarget).parents(".tbody").find("tr").removeClass("fila_roja");
        $(e.currentTarget).parents("tr").addClass("fila_roja");
        $(e.currentTarget).prop("checked",true);
        e.stopPropagation();
        e.preventDefault();
        return false;
      },
      "blur .radio":function(e) {
        $(e.currentTarget).parents(".tbody").find("tr").removeClass("fila_roja");
        $(".radio").prop("checked",false);
        e.stopPropagation();
        e.preventDefault();
        return false;
      },
      "click .apto_banco":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        var apto_banco = this.model.get("apto_banco");
        apto_banco = (apto_banco == 1)?0:1;
        self.model.set({"apto_banco":apto_banco});
        this.change_property({
          "table":"inm_propiedades",
          "url":"propiedades/function/change_property/",
          "attribute":"apto_banco",
          "value":apto_banco,
          "id":self.model.id,
          "success":function(){
            self.render();
          }
        });
        return false;
      },
      "click .acepta_permuta":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        var acepta_permuta = this.model.get("acepta_permuta");
        acepta_permuta = (acepta_permuta == 1)?0:1;
        self.model.set({"acepta_permuta":acepta_permuta});
        this.change_property({
          "table":"inm_propiedades",
          "url":"propiedades/function/change_property/",
          "attribute":"acepta_permuta",
          "value":acepta_permuta,
          "id":self.model.id,
          "success":function(){
            self.render();
          }
        });
        return false;
      },
      "click .destacado":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        var destacado = this.model.get("destacado");
        destacado = (destacado == 1)?0:1;
        self.model.set({"destacado":destacado});
        this.change_property({
          "table":"inm_propiedades",
          "url":"propiedades/function/change_property/",
          "attribute":"destacado",
          "value":destacado,
          "id":self.model.id,
          "success":function(){
            self.render();
          }
        });
        return false;
      },
      "click .compartida":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        var compartida = this.model.get("compartida");
        compartida = (compartida >= 1)?0:1;
        self.model.set({"compartida":compartida});
        this.change_property({
          "table":"inm_propiedades",
          "url":"propiedades/function/change_property/",
          "attribute":"compartida",
          "value":compartida,
          "id":self.model.id,
          "success":function(){
            self.render();
          }
        });
        return false;
      },
      "click .compartida_2":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        var compartida = this.model.get("compartida");
        compartida = (compartida == 2)?1:2;
        self.model.set({"compartida":compartida});
        this.change_property({
          "table":"inm_propiedades",
          "url":"propiedades/function/change_property/",
          "attribute":"compartida",
          "value":compartida,
          "id":self.model.id,
          "success":function(){
            self.render();
          }
        });
        return false;
      },
      "click .inmobusquedas_habilitado":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        var inmobusquedas_habilitado = this.model.get("inmobusquedas_habilitado");
        if (inmobusquedas_habilitado == 0) {
          // Estamos queriendo compartir en inmobusquedas, controlamos que la propiedad tenga precio y barrio
          if (self.model.get("precio_final") == 0) {
            alert("Error: no se puede compartir una propiedad sin precio.");
            return;
          }
          if (self.model.get("id_localidad") == 0) {
            alert("Error: por favor especifique una localidad para la propiedad.");
            return;
          }
          if (self.model.get("id_localidad") == 513 && self.model.get("id_barrio") == 0) {
            // Solamente para La Plata
            alert("Error: por favor especifique un barrio para la propiedad.");
            return;
          }
        }
        inmobusquedas_habilitado = (inmobusquedas_habilitado == 1)?0:1;
        self.model.set({"inmobusquedas_habilitado":inmobusquedas_habilitado});
        this.change_property({
          "table":"inm_propiedades",
          "url":"propiedades/function/change_property/",
          "attribute":"inmobusquedas_habilitado",
          "value":inmobusquedas_habilitado,
          "id":self.model.id,
          "success":function(){
            self.render();
          }
        });
        return false;
      },
      "click .argenprop_habilitado":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        //if (!isEmpty(self.model.get("argenprop_url"))) return;
        $.ajax({
          "url":"propiedades/function/compartir_argenprop/",
          "data":{
            "id_propiedad":self.model.id,
          },
          "dataType":"json",
          "type":"get",
          "success":function(r){
            if (r.error == 1) {
              alert(r.mensaje);
            } else {
              window.open(r.mensaje,"_blank");
              self.render();  
            }
          }
        });
        return false;
      },
      "click .argenprop_pausar":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        $.ajax({
          "url":"propiedades/function/suspender_argenprop/",
          "data":{
            "id_propiedad":self.model.id,
          },
          "dataType":"json",
          "type":"get",
          "success":function(r){
            if (r.error == 1) alert(r.mensaje);
            else location.reload();
          }
        });
        return false;
      },
      "click .argenprop_activar":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        $.ajax({
          "url":"propiedades/function/activar_argenprop/",
          "data":{
            "id_propiedad":self.model.id,
          },
          "dataType":"json",
          "type":"get",
          "success":function(r){
            if (r.error == 1) alert(r.mensaje);
            else location.reload();
          }
        });
        return false;
      },
      "click .argenprop_eliminar":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        $.ajax({
          "url":"propiedades/function/eliminar_argenprop/",
          "data":{
            "id_propiedad":self.model.id,
          },
          "dataType":"json",
          "type":"get",
          "success":function(r){
            if (r.error == 1) alert(r.mensaje);
            else location.reload();
          }
        });
        return false;
      },
      "click .eldia_habilitado":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        var eldia_habilitado = this.model.get("eldia_habilitado");
        eldia_habilitado = (eldia_habilitado == 1)?0:1;
        self.model.set({"eldia_habilitado":eldia_habilitado});
        this.change_property({
          "table":"inm_propiedades",
          "url":"propiedades/function/change_property/",
          "attribute":"eldia_habilitado",
          "value":eldia_habilitado,
          "id":self.model.id,
          "success":function(){
            self.render();
          }
        });
        return false;
      },
      "click .nuevo":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        var nuevo = this.model.get("nuevo");
        nuevo = (nuevo == 1)?0:1;
        self.model.set({"nuevo":nuevo});
        this.change_property({
          "table":"inm_propiedades",
          "url":"propiedades/function/change_property/",
          "attribute":"nuevo",
          "value":nuevo,
          "id":self.model.id,
          "success":function(){
            self.render();
          }
        });
        return false;
      },
      "click .activo":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        var activo = this.model.get("activo");
        activo = (activo == 1)?0:1;
        if (activo == 1) {
          self.model.set({"activo":activo});
          this.change_property({
            "table":"inm_propiedades",
            "url":"propiedades/function/change_property/",
            "attribute":"activo",
            "value":activo,
            "id":self.model.id,
            "success":function(){
              if (!isEmpty(self.model.get("id_meli"))) {
                // Si esta compartida en MercadoLibre, tenemos que sincronizar
                if (activo == 1) self.meli_reactivar();
                else self.meli_pausar();
              } else {
                self.render();  
              }
            }
          });
        } else {
          var self = this;
          var propiedad = new app.models.PropiedadDesactivar({
            "id_propiedad": self.model.id,
            "id_empresa": ID_EMPRESA,
            "id_usuario": ID_USUARIO,
          });
          var view = new app.views.PropiedadDesactivar({
            model: propiedad,
          });
          crearLightboxHTML({
            "html":view.el,
            "width":600,
            "height":500,
            "escapable": false,
            "callback":function() {
              self.parent.buscar();
            }
          });          
        }
        return false;
      },

      "click .bloqueado_web":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        var bloqueado_web = this.model.get("bloqueado_web");
        bloqueado_web = (bloqueado_web == 1)?0:1;
        self.model.set({"bloqueado_web":bloqueado_web});
        $.ajax({
          "url":"propiedades/function/bloquear_en_web/",
          "dataType":"json",
          "type":"get",
          "data":{
            "id_empresa":ID_EMPRESA,
            "id_propiedad":self.model.id,
            "id_empresa_propiedad":self.model.get("id_empresa"),
            "bloqueo":bloqueado_web,
          },
          "success":function(){
            self.render();
          }
        });
        return false;
      },

      "change .usuario_asignado":function(e){
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        var id_usuario = $(e.currentTarget).val();
        self.model.set({"id_usuario":id_usuario});
        this.change_property({
          "table":"inm_propiedades",
          "url":"propiedades/function/change_property/",
          "attribute":"id_usuario",
          "value":id_usuario,
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
            "url":"propiedades/function/duplicar/"+self.model.id,
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
      "click .facebook":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        self.model.set({"compartida_facebook":1});
        this.change_property({
          "table":"inm_propiedades",
          "url":"propiedades/function/change_property/",
          "attribute":"compartida_facebook",
          "value":1,
          "id":self.model.id,
          "success":function(){
            window.open("https://www.facebook.com/sharer/sharer.php?u="+self.link_completo);
            self.render();
          }
        });        
        return false;
      },   
      "click .ver_ficha":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        window.open("propiedades/function/ver_ficha/"+this.model.get("id_empresa")+"/"+this.model.id+"/"+ID_EMPRESA,"_blank");
        return false;
      },
      "click .ver_ficha_web":function(e){
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        window.open("https://app.inmovar.com/ficha/"+ID_EMPRESA+"/"+this.model.get("hash"),"_blank");
        return false;
      },
      "click .compartir_olx":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        var olx_habilitado = this.model.get("olx_habilitado");
        olx_habilitado = (olx_habilitado == 1)?0:1;
        self.model.set({"olx_habilitado":olx_habilitado});
        this.change_property({
          "table":"inm_propiedades",
          "url":"propiedades/function/change_property/",
          "attribute":"olx_habilitado",
          "value":olx_habilitado,
          "id":self.model.id,
          "success":function(){
            self.render();
          }
        });
        return false;
      },
    },
    marcar: function(e) {
      var self = this;
      e.stopPropagation();
      e.preventDefault();
      if($(e.currentTarget).attr("disabled") == "disabled") return;

      var el = e.currentTarget;
      if ($(el).is(":checked")) {
        $(this.el).addClass("seleccionado");
        window.propiedades_marcadas.push(this.model.id);
      } else {
        $(this.el).removeClass("seleccionado");
        window.propiedades_marcadas = _.reject(window.propiedades_marcadas,function(m){
          return (m == self.model.id);
        });
      }
      $(".cantidad_seleccionados").html(window.propiedades_marcadas.length);
      var imagenes = "";
      $(".check-row:checked").each(function(i,e){
        imagenes += "<img class='ml10' width='40' height='40' src='"+$(e).attr("data-img")+"'>";
      });
      $(".imagenes_propiedades").html(imagenes);

      // Si hay alguno marcado
      var marcado = false;
      $(".check-row").each(function(i,e){
        if ($(e).is(":checked")) marcado = true;
      });
      if (marcado) $(".bulk_action").slideDown();
      else $(".bulk_action").slideUp();
      return false;
    },
    seleccionar: function() {
      if (this.habilitar_seleccion || this.vista_busqueda) {
        window.codigo_propiedad_seleccionado = this.model.get("codigo");
        window.propiedad_seleccionado = this.model;
        $('.modal:last').modal('hide');
      } else {
        this.ver_lightbox();
      }
    },
    editar: function() {
      location.href="app/#propiedades/"+this.model.id;
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
      this.parent = (this.options.parent != "undefined") ? this.options.parent : null;
      this.render();
    },
    render: function() {
      var self = this;
      this.link_completo = 'https://' + DOMINIO + ((DOMINIO.substr(DOMINIO.length - 1) == "/") ? "" : "/") + this.model.get("link");
      var obj = { 
        seleccionar: this.habilitar_seleccion, 
        vista_busqueda: this.vista_busqueda,
        link_completo: this.link_completo,
        edicion: (control.check("propiedades")>1),
      };
      $.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));

      if (typeof window.propiedades_marcadas != "undefined" && window.propiedades_marcadas.length > 0) {
        var res = _.find(window.propiedades_marcadas,function(m){
          return (m == self.model.id)
        });
        if (typeof res != "undefined") {
          $(this.el).addClass("seleccionado");
          $(this.el).find(".check-row").prop("checked",true);
        }
      }
      this.$('[data-toggle="tooltip"]').tooltip(); 
      return this;
    },

    ver_lightbox: function() {
      var self = this;
      $.ajax({
        "url":"propiedades/function/ver_propiedad/"+self.model.id+"/"+self.model.get("id_empresa"),
        "dataType":"json",
        "success":function(r) {
          var propiedad = new app.models.Propiedades(r);
          var view = new app.views.PropiedadPreview({
            model: propiedad,
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

    buscar_interesados: function() {
      var self = this;
      var view = new app.views.PropiedadBuscarInteresadosView({
        model: self.model,
      });
      crearLightboxHTML({
        "html":view.el,
        "width":900,
        "height":500,
      });
    },
    ver_interesados: function() {
      var self = this;
      var view = new app.views.PropiedadEstadisticaDetalleView({
        model: new app.models.AbstractModel({
          "id_propiedad": self.model.id,
          "nombre": self.model.get("nombre"),
          "codigo": self.model.get("codigo"),
        }),
      });
      crearLightboxHTML({
        "html":view.el,
        "width":670,
        "height":370,
      });
    },

    compartir_meli: function() {
      if (isEmpty(ML_ACCESS_TOKEN)) {
        alert("La sincronizacion con MercadoLibre no esta habilitada. Puede hacerlo desde la configuracion avanzada.");
        location.href="app/#web_seo";
        return;
      }
      var that = this;
      var propiedad = new app.models.Propiedades({
        "id":that.model.id
      });
      propiedad.fetch({
        "success":function(){

          // La propiedad no esta activo
          if (propiedad.get("activo") == 0) {
            alert("La propiedad se encuentra desactivada, por favor activela antes de publicar.")
            return;
          }

          if (propiedad.get("id_localidad") == 0) {
            alert("La propiedad no tiene asignada una localidad. Por favor ingrese una e intente nuevamente.");
            return;
          }

          // Si es Galpon, tiene que tener una superficie si o si
          if (propiedad.get("id_tipo_inmueble") == 8 && propiedad.get("superficie_cubierta") == 0) {
            alert("Error: debe ingresar una superficie cubierta para poder compartir.");
            return;            
          }

          // Si es un terreno, tenemos que tener cargado el tipo de calle
          if (propiedad.get("id_tipo_inmueble") == 7 && propiedad.get("tipo_calle") == 0) {
            alert("Error: ingrese el tipo de acceso (asfalto, tierra, etc.) al terreno.");
            return;            
          }

          var view = new app.views.PropiedadMercadoLibreView({
            model: propiedad,
          });
          crearLightboxHTML({
            "html":view.el,
            "width":900,
            "height":500,
            "escapable":false,
          });          
        }
      });
    },

    meli_reactivar: function() {
      var id_meli = this.model.get("id_meli");
      var self = this;
      $.ajax({
        "url":"/admin/propiedades_meli/function/reactivar/",
        "dataType":"json",
        "type":"post",
        "data":{
          "id_meli":id_meli,
        },
        "success":function(r) {
          if (r.error == 0) location.reload();
          else alert(r.mensaje);
        },
      });
    },

    meli_pausar: function() {
      var id_meli = this.model.get("id_meli");
      var self = this;
      $.ajax({
        "url":"/admin/propiedades_meli/function/pausar/",
        "dataType":"json",
        "type":"post",
        "data":{
          "id_meli":id_meli,
        },
        "success":function(r) {
          if (r.error == 0) location.reload();
          else alert(r.mensaje);
        },
      });
    },

    meli_finalizar: function() {
      var id_meli = this.model.get("id_meli");
      var self = this;
      $.ajax({
        "url":"/admin/propiedades_meli/function/finalizar/",
        "dataType":"json",
        "type":"post",
        "data":{
          "id_meli":id_meli,
        },
        "success":function(r) {
          if (r.error == 0) location.reload();
          else alert(r.mensaje);
        },
      });
    },

    meli_eliminar: function() {
      var id_meli = this.model.get("id_meli");
      var self = this;
      $.ajax({
        "url":"/admin/propiedades_meli/function/eliminar/",
        "dataType":"json",
        "type":"post",
        "data":{
          "id_meli":id_meli,
        },
        "success":function(r) {
          if (r.error == 0) location.reload();
          else alert(r.mensaje);
        },
      });
    },

  });
})(app);



// -----------------------------------------
//   DETALLE DEL ARTICULO
// -----------------------------------------
(function ( app ) {

  app.views.PropiedadesEditView = app.mixins.View.extend({

    template: _.template($("#propiedad_template").html()),
            
    myEvents: {
      "click .guardar": "guardar",
      "click #cargar_mapa":"get_coords_by_address",
      "click #expand_mapa":"expand_mapa",
      "click #propiedad_acepta_permuta":function(){
        $(".permutas_div").toggleClass("dn");
      },

      "change #propiedad_tipo_ubicacion":function(){
        var tipo_ubicacion = this.$("#propiedad_tipo_ubicacion").val();
        if (tipo_ubicacion == 0) this.$("#propiedad_detalle_calle").show();
        else this.$("#propiedad_detalle_calle").hide();
      },

      "click #propiedad_sincronizar_calendario":"sincronizar_calendario",

      "change #propiedad_paises":function(){
        var id_provincia = this.$("#propiedad_provincias").val();
        this.cambiar_paises(id_provincia);
      },
      "change #propiedad_provincias":function(){
        var id_departamento = this.$("#propiedad_departamentos").val();
        this.cambiar_provincias(id_departamento);
      },
      "change #propiedad_departamentos":function(){
        var id_localidad = this.$("#propiedad_localidades").val();
        this.cambiar_departamentos(id_localidad);
      },
      "change #propiedad_localidades":function(){
        var id_localidad = this.$("#propiedad_localidades").val();
        this.cargar_barrios(id_localidad);
      },

      "click #propiedad_temporada_nuevo":function() {
        var self = this;
        var modelo = new app.models.AbstractModel({
          "desde":"",
          "hasta":"",
          "precio":0,
          "precio_finde":0,
          "precio_semana":0,
          "precio_mes":0,
          "nombre":"",
          "minimo_dias_reserva":1,
        });
        var v = new app.views.PropiedadTemporadaEditView({
          model: modelo,
        });
        crearLightboxHTML({
          "html":v.el,
          "width":600,
          "height":140,
          "escapable":false,
          "callback":function() {
            self.agregar_precio(modelo);
          }
        });
      },
      "click .editar_precio":function(e){
        var self = this;
        self.item_temporada = $(e.currentTarget).parents("tr");
        var modelo = new app.models.AbstractModel({
          "desde":$(self.item_temporada).find(".desde").text(),
          "hasta":$(self.item_temporada).find(".hasta").text(),
          "precio":$(self.item_temporada).find(".precio").text(),
          "precio_finde":$(self.item_temporada).find(".precio_finde").text(),
          "precio_semana":$(self.item_temporada).find(".precio_semana").text(),
          "precio_mes":$(self.item_temporada).find(".precio_mes").text(),
          "nombre":$(self.item_temporada).find(".nombre").text(),
          "minimo_dias_reserva":$(self.item_temporada).find(".minimo_dias_reserva").text(),
        });
        var v = new app.views.PropiedadTemporadaEditView({
          model: modelo,
        });
        crearLightboxHTML({
          "html":v.el,
          "width":600,
          "height":140,
          "escapable":false,
          "callback":function() {
            self.agregar_precio(modelo);
          }
        });
      },
      "click .eliminar_precio":function(e){
        $(e.currentTarget).parents("tr").remove();
      },


      "click #propiedad_impuesto_nuevo":function() {
        var self = this;
        var modelo = new app.models.AbstractModel({
          "tipo":1,
          "monto":0,
          "nombre":"",
        });
        var v = new app.views.PropiedadImpuestoEditView({
          model: modelo,
        });
        crearLightboxHTML({
          "html":v.el,
          "width":600,
          "height":140,
          "escapable":false,
          "callback":function() {
            self.agregar_impuesto(modelo);
          }
        });
      },
      "click .editar_impuesto":function(e){
        var self = this;
        self.item_impuesto = $(e.currentTarget).parents("tr");
        var modelo = new app.models.AbstractModel({
          "tipo":$(self.item_impuesto).find(".tipo").text(),
          "monto":$(self.item_impuesto).find(".monto").text(),
          "nombre":$(self.item_impuesto).find(".nombre").text(),
        });
        var v = new app.views.PropiedadImpuestoEditView({
          model: modelo,
        });
        crearLightboxHTML({
          "html":v.el,
          "width":600,
          "height":140,
          "escapable":false,
          "callback":function() {
            self.agregar_impuesto(modelo);
          }
        });
      },
      "click .eliminar_impuesto":function(e){
        $(e.currentTarget).parents("tr").remove();
      },


      "click .nuevo_departamento":function(){
        var self = this;
        var v = new app.views.PropiedadDepartamentoEditView({
          model: new app.models.PropiedadDepartamento({
            images_dptos: [],
          }),
          collection: self.departamentos,
        });
        crearLightboxHTML({
          "html":v.el,
          "width":600,
          "height":140,
          "callback":function() {
            console.log(self.departamentos);
          }
        });
        workspace.crear_editor('departamento_texto',{
          "toolbar":"Basic"
        });
      },

      "click .nuevo_gasto":function(){
        var self = this;
        var v = new app.views.PropiedadGastoEditView({
          model: new app.models.PropiedadGastos({}),
          collection: self.gastos,
        });
        crearLightboxHTML({
          "html":v.el,
          "width":600,
          "height":140,
          "callback":function() {
            console.log(self.gastos);
          }
        });
      },

      "click .nueva_permuta":function(){
        var self = this;
        var v = new app.views.PropiedadPermutasEditView({
          model: new app.models.PropiedadPermutas({}),
          collection: self.permutas,
        });
        crearLightboxHTML({
          "html":v.el,
          "width":600,
          "height":140,
          "callback":function() {
            console.log(self.permutas);
          }
        });
      },

      // ABRIMOS MODAL PARA UPLOAD MULTIPLE
      "click .upload_multiple":function(e) {
        var self = this;
        this.open_multiple_upload({
          "model": self.model,
          "url": "propiedades/function/upload_images/",
          "view": self,
        });
      },
            
      "change #propiedad_tipos_operacion":function(e) {
        var id = $(e.currentTarget).val();
        // Si es un Alquiler Temporario
        if (id == 3) {
          this.$("#propiedad_precios").hide();
          this.$("#propiedad_precios_temporal").show();
          this.$("#propiedad_capacidad").show();
        } else {
          this.$("#propiedad_precios_temporal").hide();
          this.$("#propiedad_capacidad").hide();
          this.$("#propiedad_precios").show();
        }
      },

      "focusout .superficie":"calcular_superficie",
      "change .superficie":"calcular_superficie",

      "change #propiedad_calle":"get_coords_by_address",
      "change #propiedad_altura":"get_coords_by_address",

      "click .nuevo_propietario":function(e){
        var self = this;
        if ($(".propietario_edit_mini").length > 0) return;
        var form = new app.views.PropietarioEditViewMini({
          "model": new app.models.Propietario(),
          "callback":self.cargar_propietarios,
        });
        var width = 350;
        var position = $(e.currentTarget).offset();
        var top = position.top + $(e.currentTarget).outerHeight();
        var container = $("<div class='customcomplete propietario_edit_mini'/>");
        $(container).css({
          "top":top+"px",
          "left":(position.left - width + $(e.currentTarget).outerWidth())+"px",
          "display":"block",
          "width":width+"px",
        });
        $(container).append("<div class='new-container'></div>");
        $(container).find(".new-container").append(form.el);
        $("body").append(container);
        $("#propietarios_mini_nombre").focus();
      },      
      
      // TODO: MODIFICAR ESTO
      /*"click .eliminar_imagen":function(e) {
          self.$("#hidden_path").val("");
      },*/
    },    
                
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      
      var edicion = false;
      this.options = control.check("propiedades");
      if (control.check("propiedades") > 1) edicion = true;
      var obj = { "edicion": edicion,"id":this.model.id }
      _.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));

      this.expand_mapa_key = 0;
      this.item_temporada = null;
      this.item_impuesto = null;
      
      this.$("#propiedad_tipos_operacion").select2({});
      this.$("#propiedad_tipos_inmueble").select2({});

      this.cambiar_paises(this.model.get("id_provincia"));
      if (this.model.get("id_localidad") != 0) {
        this.cambiar_provincias(this.model.get("id_departamento"));
        this.cargar_barrios(this.model.get("id_localidad"));
      }
      this.$("#propiedad_paises").select2({});
      this.$("#propiedad_provincias").select2({});

      this.cargar_propietarios();

      //if (CONFIGURACION_AUTOGENERAR_CODIGOS == 1) {
        // Estamos creando un cliente nuevo
        if (this.model.id == undefined) {
          $.ajax({
            "url":"propiedades/function/next/",
            "dataType":"json",
            "success":function(r) {
              self.$("#propiedad_codigo").val(r.codigo);
            }
          });
        }                
      //}      

      if (this.model.isNew()) this.model.set({"images":[]});
      
      // Cuando cambian las imagens, renderizamos la tabla
      this.listenTo(this.model, 'change_table', self.render_tabla_fotos);
      this.listenTo(this.model, 'change_table', self.render_tabla_planos);
      this.render_tabla_fotos();
      this.render_tabla_planos();
      
      this.$("#images_tabla").sortable({
        update:function(event,ui){
          self.reordenar_tabla_fotos();
        }
      });
      this.$("#planos_tabla").sortable({
        update:function(event,ui){
          self.reordenar_tabla_planos();
        }        
      });

      self.departamentos = new app.collections.PropiedadesDepartamentos();
      var dep = this.model.get("departamentos");
      for(var i=0;i<dep.length;i++) {
        var dd = dep[i];
        var ddo = new app.models.PropiedadDepartamento(dd);
        self.departamentos.add(ddo);
      }
      this.departamentosTable = new app.views.PropiedadesDepartamentosTableView({
        collection: self.departamentos
      });
      this.$("#propiedad_departamentos").html(this.departamentosTable.el);

      self.permutas = new app.collections.PropiedadesPermutas();
      var dep = this.model.get("permutas");
      for(var i=0;i<dep.length;i++) {
        var dd = dep[i];
        var ddo = new app.models.PropiedadPermutas(dd);
        self.permutas.add(ddo);
      }
      this.permutasTable = new app.views.PropiedadesPermutasTableView({
        collection: self.permutas
      });
      this.$("#propiedades_permutas").html(this.permutasTable.el);


      self.gastos = new app.collections.PropiedadesGastos();
      var dep = this.model.get("gastos");
      for(var i=0;i<dep.length;i++) {
        var dd = dep[i];
        var ddo = new app.models.PropiedadGastos(dd);
        self.gastos.add(ddo);
      }
      this.gastosTable = new app.views.PropiedadesGastosTableView({
        collection: self.gastos
      });
      this.$("#propiedad_gastos").html(this.gastosTable.el);


    },

    cargar_propietarios: function(id_propietario) {
      var self = this;
      // Si se manda por parametro un ID, hay que poner ese nuevo en el modelo
      if (id_propietario != undefined) {
        this.model.set({ "id_propietario": id_propietario });
      }      
      // Creamos el select
      new app.mixins.Select({
        modelClass: app.models.Propietario,
        url: "propietarios/",
        firstOptions: ["<option value='0'>Sin Definir</option>"],
        render: "#propiedad_propietarios",
        selected: self.model.get("id_propietario"),
        onComplete:function(c) {
          crear_select2("propiedad_propietarios");
        }                    
      });
    },

    sincronizar_calendario: function() {
      var self = this;
      $.ajax({
        "url":"propiedades/function/sincronizar_calendario/",
        "dataType":"json",
        "type":"get",
        "data":{
          "id":self.model.id,
          "id_empresa":ID_EMPRESA,
        },
        "success":function(r) {
          if (r.error == 0) alert("Se sincronizo correctamente el calendario.");
        }
      })
    },

    agregar_precio: function(modelo) {
      if (modelo.get("cancelo") == 1) return;
      var tr = "<tr>";
      tr+='<td>';
      tr+='<span class="nombre text-info">'+modelo.get("nombre")+'</span><br/>';
      tr+='<span class="desde">'+modelo.get("desde")+'</span> -';
      tr+='<span class="hasta">'+modelo.get("hasta")+'</span>';
      tr+='</td>';
      tr+='<td><span class="minimo_dias_reserva">'+modelo.get("minimo_dias_reserva")+'</span> noches</td>';
      tr+='<td><span class="precio">'+Number(modelo.get("precio")).toFixed(2)+'</span></td>';
      tr+='<td><span class="precio_finde">'+Number(modelo.get("precio_finde")).toFixed(2)+'</span></td>';
      tr+='<td><span class="precio_semana">'+Number(modelo.get("precio_semana")).toFixed(2)+'</span></td>';
      tr+='<td><span class="precio_mes">'+Number(modelo.get("precio_mes")).toFixed(2)+'</span></td>';
      tr+='<td><button class="btn btn-white editar_precio mr5"><i class="fa fa-pencil"></i></button><button class="btn btn-white eliminar_precio"><i class="fa fa-trash"></i></button></td>';
      tr+='</tr>';
      if (this.item_temporada == null) {
        this.$("#propiedad_temporada_tabla tbody").append(tr);
      } else {
        $(this.item_temporada).replaceWith(tr);
        this.item_temporada = null;
      }
    },    

    agregar_impuesto: function(modelo) {
      if (modelo.get("cancelo") == 1) return;
      var tr = "<tr>";
      tr+='<td>';
      tr+='<span class="nombre text-info">'+modelo.get("nombre")+'</span>';
      tr+='</td>';
      tr+='<td>';
      tr+= (modelo.get("tipo")==1)?"Porcentaje por reserva":"";
      tr+= (modelo.get("tipo")==2)?"Tarifa por viajero":"";
      tr+= (modelo.get("tipo")==3)?"Tarifa por persona y noche":"";
      tr+= (modelo.get("tipo")==4)?"Tarifa por noche":"";
      tr+= '<span class="tipo dn">'+modelo.get("tipo")+'</span>';
      tr+='</td>';
      tr+='<td><span class="monto">'+Number(modelo.get("monto")).toFixed(2)+'</span></td>';
      tr+='<td><button class="btn btn-white editar_impuesto mr5"><i class="fa fa-pencil"></i></button><button class="btn btn-white eliminar_impuesto"><i class="fa fa-trash"></i></button></td>';
      tr+='</tr>';
      if (this.item_impuesto == null) {
        this.$("#propiedad_impuestos_tabla tbody").append(tr);
      } else {
        $(this.item_impuesto).replaceWith(tr);
        this.item_impuesto = null;
      }
    },  

    cambiar_paises: function(id_provincia) {
      var id_pais = this.$("#propiedad_paises").val();
      this.$("#propiedad_provincias").empty();
      for(var i=0;i< window.provincias.length;i++) { 
        var p = provincias[i];
        if (p.id_pais == id_pais) {
          var s = '<option data-id_pais="'+p.id_pais+'" '+((id_provincia == p.id)?"selected":"")+' value="'+p.id+'">'+p.nombre+'</option>';
          this.$("#propiedad_provincias").append(s);
        }
      }
      this.$("#propiedad_provincias").val(id_provincia);
      crear_select2("propiedad_provincias");
      this.$("#propiedad_provincias").trigger("change");
    },
    cambiar_provincias: function(id_departamento){
      var self = this;
      var id_provincia = this.$("#propiedad_provincias").val();
      this.$("#propiedad_departamentos").val(id_departamento);
      new app.mixins.Select({
        modelClass: app.models.ComDepartamento,
        url: "com_departamentos/function/get_select/?id_provincia="+id_provincia,
        //firstOptions: ["<option value='0'>Sin Definir</option>"],
        render: "#propiedad_departamentos",
        selected: self.model.get("id_departamento"),
        onComplete:function(c) {
          crear_select2("propiedad_departamentos");
          self.$("#propiedad_departamentos").trigger("change");
        }
      });
    },
    cambiar_departamentos: function(id_localidad){
      var self = this;
      var id_departamento = this.$("#propiedad_departamentos").val();
      this.$("#propiedad_localidades").val(id_localidad);
      new app.mixins.Select({
        modelClass: app.models.Localidad,
        url: "localidades/function/get_select/?id_departamento="+id_departamento,
        //firstOptions: ["<option value='0'>Sin Definir</option>"],
        render: "#propiedad_localidades",
        selected: self.model.get("id_localidad"),
        onComplete:function(c) {
          crear_select2("propiedad_localidades");
          self.$("#propiedad_localidades").trigger("change");
        }
      });
    },

    cargar_barrios: function(id_localidad) {
      var self = this;
      new app.mixins.Select({
        modelClass: app.models.Barrio,
        url: "barrios/function/buscar_por_localidad/?id_localidad="+id_localidad,
        firstOptions: ["<option value='0'>Sin Definir</option>"],
        render: "#propiedad_barrio",
        selected: self.model.get("id_barrio"),
        onComplete:function(c) {
          crear_select2("propiedad_barrio");
        }                    
      });
    },   

    // Cuando expandimos por primera vez el panel de ubicacion
    expand_mapa: function() {

      var self = this;
      if (this.expand_mapa_key == 1) return;
      this.expand_mapa_key = 1;

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

    reordenar_tabla_planos: function() {
      var images = new Array();
      this.$("#planos_tabla li .img_preview").each(function(i,e){
        images.push($(e).attr("src"));
      });
      this.model.set({
        "planos":images,
      });
    }, 

    render_tabla_planos: function() {
      var planos = this.model.get("planos");
      this.$("#planos_tabla").empty();
      if (planos.length == 0) {
        this.$("#planos_container").removeClass('tiene');
      } else {
        this.$("#planos_container").addClass('tiene');
        for(var i=0;i<planos.length;i++) {
          var path = planos[i];
          var pth = path+"?t="+parseInt(Math.random()*100000);
          var li = "";
          li+="<li class='list-group-item'>";
          li+=" <span><i class='fa fa-sort text-muted fa m-r-sm'></i> </span>";
          li+=" <img style='margin-left: 10px; margin-right:10px; max-height:50px' class='img_preview' src='"+pth+"'/>";
          li+=" <span class='dn filename'>"+path+"</span>";
          li+=" <span class='cp pull-right m-t eliminar_foto' data-property='planos'><i class='fa fa-fw fa-times'></i> </span>";
          li+=" <span data-id='planos' class='cp m-r pull-right m-t editar_foto_multiple'><i class='fa fa-pencil'></i> </span>";
          li+="</li>";
          this.$("#planos_tabla").append(li);
        }
        this.$("#planos_container").show();
      }
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
        
    calcular_superficie: function() {
      var total = 0;
      $(".superficie").each(function(i,e){
        var v = parseInt($(e).val());
        if (isNaN(v)) v = 0;
        total += v;
      });
      $("#propiedad_superficie_total").val(total);
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
      self.map = new google.maps.Map(document.getElementById("mapa"), mapOptions);

      // Inicializamos el street view
      var heading = parseFloat(this.model.get("heading"));
      var pitch = parseFloat(this.model.get("pitch"));
      if (heading != 0 && pitch != 0) {
        panorama = self.map.getStreetView();
        panorama.setPosition(self.coor);
        panorama.setPov({
          "heading": heading,
          "pitch": pitch
        });
        panorama.setVisible(true);
      }
      
      // Place a draggable marker on the map
      self.marker = new google.maps.Marker({
        position: self.coor,
        map: self.map,
        draggable:true,
        title:"Arrastralo a la direccion correcta"
      });
      google.maps.event.addListener(self.marker,"dragend",function(event) {
        var lat = event.latLng.lat(); 
        var lng = event.latLng.lng();
        self.model.set({
          "latitud":lat,
          "longitud":lng
        });
      });             
    },
        
    get_coords_by_address: function() {
      var self = this;
      if (self.map == undefined) return;
      var calle = $("#propiedad_calle").val();
      if (isEmpty(calle)) {
        alert("Por favor ingrese una calle");
        $("#propiedad_calle").focus();
        return;
      }
      var altura = $("#propiedad_altura").val();
      if (isEmpty(altura)) return;
      var localidad = $("#propiedad_localidades option:selected").text();
      if (isEmpty(localidad)) {
        alert("Por favor ingrese una localidad");
        $("#propiedad_localidades").focus();
        return;
      }
      localidad = localidad.replace("Casco Urbano","");
      var provincia = this.$("#propiedad_provincias option:selected").text();
      localidad = localidad + ", " + provincia;
      var pais = this.$("#propiedad_paises option:selected").text();

      var address = calle+" "+altura+", "+localidad+", "+pais;
      self.geocoder.geocode( { 'address': address}, function(results, status) {
        console.log(results);
        if (status == google.maps.GeocoderStatus.OK) {
          var location = results[0].geometry.location;
          var latitud = location.lat();
          var longitud = location.lng();
          self.coor = new google.maps.LatLng(latitud,longitud);
          self.map.setCenter(self.coor);
          self.map.setZoom(18);
          self.marker.setPosition(self.coor);
        } else {
          alert("Geocode was not successful for the following reason: " + status);
        }
      });
    },
        
    validar: function() {
      try {
        var self = this;
        
        var codigo = self.$("#propiedad_codigo").val();
        if (isEmpty(codigo)) {
          alert("Por favor ingrese un codigo para la propiedad.");
          self.$("#propiedad_codigo").focus();
          return false;
        }
        if (!isInteger(codigo)) {
          alert("El codigo debe ser numerico.");
          self.$("#propiedad_codigo").focus();
          return false;          
        }
        
        var id_tipo_operacion = self.$("#propiedad_tipos_operacion").val();
        var permuta = self.$("#propiedad_acepta_permuta").is(":checked") ? 1 : 0;

        if (permuta == 1 && self.permutas.length == 0) {
          alert ("Por favor ingrese una opcion de permuta o desactive la opcion");
          return false;
        }

        this.model.set({
          //"destacado":(self.$("#propiedad_destacado").is(":checked")?1:0),
          "codigo":codigo,
          "moneda":self.$("#propiedad_monedas").val(),
          "nuevo":((self.$("#propiedad_antiguedad").length>0) ? self.$("#propiedad_antiguedad").val() : 0),
          "patio":((self.$("#propiedad_patio").length>0) ? (self.$("#propiedad_patio").is(":checked")?1:0) : 0),
          "balcon":((self.$("#propiedad_balcon").length>0) ? (self.$("#propiedad_balcon").is(":checked")?1:0) : 0),
          "ubicacion_departamento":((self.$("#propiedad_ubicacion_departamento").length>0) ? self.$("#propiedad_ubicacion_departamento").val() : 0),
          "codigo_seguimiento":((self.$("#propiedad_codigo_seguimiento").length>0) ? self.$("#propiedad_codigo_seguimiento").val() : ""),
          "id_tipo_inmueble":self.$("#propiedad_tipos_inmueble").val(),
          "id_tipo_operacion":id_tipo_operacion,
          "id_tipo_estado":self.$("#propiedad_tipos_estado").val(),
          "precio_final":self.$("#propiedad_precio_final").val(),
          "publica_precio":(self.$("#propiedad_publica_precio").val()),
          "fecha_publicacion":((self.$("#propiedad_fecha_publicacion").length > 0) ? self.$("#propiedad_fecha_publicacion").val() : ""),
          "apto_banco":(self.$("#propiedad_apto_banco").is(":checked") ? 1 : 0),
          "acepta_permuta":permuta,
          "publica_altura":((self.$("#propiedad_publica_altura").length > 0) ? (self.$("#propiedad_publica_altura").is(":checked")?1:0) : 0),
          "superficie_total":self.$("#propiedad_superficie_total").val(),
          "archivo": (self.$("#hidden_archivo").length > 0) ? $(self.el).find("#hidden_archivo").val() : "",
          "audio": (self.$("#hidden_audio").length > 0) ? $(self.el).find("#hidden_audio").val() : "",
          "id_barrio": (self.$("#propiedad_barrio").length > 0) ? $(self.el).find("#propiedad_barrio").val() : 0,
          "tipo_calle": (self.$("#propiedad_tipo_calle").length > 0) ? $(self.el).find("#propiedad_tipo_calle").val() : 0,
          "id_propietario":self.$("#propiedad_propietarios").val(),

          "id_localidad": (self.$("#propiedad_localidades").length > 0) ? ($(self.el).find("#propiedad_localidades").val() == null ? 0 : $(self.el).find("#propiedad_localidades").val()) : 0,
          "id_departamento": (self.$("#propiedad_departamentos").length > 0) ? ($(self.el).find("#propiedad_departamentos").val() == null ? 0 : $(self.el).find("#propiedad_departamentos").val()) : 0,
          "id_provincia": (self.$("#propiedad_provincias").length > 0) ? ($(self.el).find("#propiedad_provincias").val() == null ? 0 : $(self.el).find("#propiedad_provincias").val()) : 0,
          "id_pais": (self.$("#propiedad_paises").length > 0) ? ($(self.el).find("#propiedad_paises").val() == null ? 0 : $(self.el).find("#propiedad_paises").val()) : 0,

          "servicios_gas":((self.$("#propiedad_servicios_gas").length>0) ? (self.$("#propiedad_servicios_gas").is(":checked")?1:0) : 0),
          "servicios_cloacas":((self.$("#propiedad_servicios_cloacas").length>0) ? (self.$("#propiedad_servicios_cloacas").is(":checked")?1:0) : 0),
          "servicios_agua_corriente":((self.$("#propiedad_servicios_agua_corriente").length>0) ? (self.$("#propiedad_servicios_agua_corriente").is(":checked")?1:0) : 0),
          "servicios_asfalto":((self.$("#propiedad_servicios_asfalto").length>0) ? (self.$("#propiedad_servicios_asfalto").is(":checked")?1:0) : 0),
          "servicios_electricidad":((self.$("#propiedad_servicios_electricidad").length>0) ? (self.$("#propiedad_servicios_electricidad").is(":checked")?1:0) : 0),
          "servicios_telefono":((self.$("#propiedad_servicios_telefono").length>0) ? (self.$("#propiedad_servicios_telefono").is(":checked")?1:0) : 0),
          "servicios_cable":((self.$("#propiedad_servicios_cable").length>0) ? (self.$("#propiedad_servicios_cable").is(":checked")?1:0) : 0),
          "apto_profesional":((self.$("#propiedad_apto_profesional").length>0) ? (self.$("#propiedad_apto_profesional").is(":checked")?1:0) : 0),
        


          //Documentacion
          "servicios_fecha_chequeado":((self.$("#propiedad_servicios_fecha_chequeado").length > 0) ? self.$("#propiedad_servicios_fecha_chequeado").val() : ""),
          "servicios_escritura":((self.$("#propiedades_servicios_escritura").length>0) ? (self.$("#propiedades_servicios_escritura").is(":checked")?1:0) : 0),
          "servicios_reglamento":((self.$("#propiedad_servicios_reglamento").length>0) ? (self.$("#propiedad_servicios_reglamento").is(":checked")?1:0) : 0),
          "servicios_plano_obra":((self.$("#propiedad_servicios_plano_obra").length>0) ? (self.$("#propiedad_servicios_plano_obra").is(":checked")?1:0) : 0),
          "servicios_plano_ph":((self.$("#propiedad_servicios_plano_ph").length>0) ? (self.$("#propiedad_servicios_plano_ph").is(":checked")?1:0) : 0),
          "servicios_reservas":((self.$("#propiedad_servicios_reservas").length>0) ? (self.$("#propiedad_servicios_reservas").is(":checked")?1:0) : 0),
          "servicios_boleto":((self.$("#propiedad_servicios_boleto").length>0) ? (self.$("#propiedad_servicios_boleto").is(":checked")?1:0) : 0),
          "servicios_escri_plazo":((self.$("#propiedad_servicios_escri_plazo").length>0) ? (self.$("#propiedad_servicios_escri_plazo").is(":checked")?1:0) : 0),

        });

        if (this.$("#propiedad_usuarios").length > 0) {
          this.model.set({
            "id_usuario":self.$("#propiedad_usuarios").val(),
          })
        }

        if (id_tipo_operacion == 3) {
          // Es un alquiler temporario, tenemos que guardar ademas otras cosas
          this.model.set({
            "moneda":self.$("#propiedad_precios_temporal_monedas").val(),
            //"publica_precio":(self.$("#propiedad_precios_temporal_publica_precio").is(":checked")?1:0),
            "precio_final":self.$("#propiedad_precios_temporal_precio_final").val(),
            "propiedad_capacidad_maxima":self.$("#propiedad_capacidad_maxima").val(),
            "capacidad_maxima_menores":self.$("#propiedad_capacidad_maxima_menores").val(),
            "habitacion_compartida":(self.$("#propiedad_habitacion_compartida").is(":checked")?1:0),
          });

          // Guardamos los precios
          var precios = new Array();
          $("#propiedad_temporada_tabla tbody tr").each(function(i,e){
            precios.push({
              "fecha_desde": $(e).find(".desde").text(),
              "fecha_hasta": $(e).find(".hasta").text(),
              "nombre": $(e).find(".nombre").text(),
              "precio": $(e).find(".precio").text(),
              "precio_finde": $(e).find(".precio_finde").text(),
              "precio_semana": $(e).find(".precio_semana").text(),
              "precio_mes": $(e).find(".precio_mes").text(),
              "minimo_dias_reserva": $(e).find(".minimo_dias_reserva").text(),
            });
          });
          this.model.set({"temporada":precios});

          // Guardamos los impuestos
          var impuestos = new Array();
          $("#propiedad_impuestos_tabla tbody tr").each(function(i,e){
            impuestos.push({
              "nombre": $(e).find(".nombre").text(),
              "monto": $(e).find(".monto").text(),
              "tipo": $(e).find(".tipo").text(),
            });
          });
          this.model.set({"impuestos":impuestos});
        }
        
        // Listado de Imagenes
        var images = new Array();
        this.$("#images_tabla .list-group-item .filename").each(function(i,e){
          images.push($(e).text());
        });
        self.model.set({"images":images});

        if (this.$("#planos_tabla").length > 0) {
          var planos = new Array();
          this.$("#planos_tabla .list-group-item .filename").each(function(i,e){
            planos.push($(e).text());
          });
          self.model.set({"planos":planos});
        }

        // Listado de departamentos
        var departamentos = new Array();
        self.departamentos.each(function(dpto){
          departamentos.push(dpto.toJSON());
        });
        self.model.set({"departamentos":departamentos});

        // Listado de departamentos
        var gastos = new Array();
        self.gastos.each(function(gsts){
          gastos.push(gsts.toJSON());
        });
        self.model.set({"gastos":gastos});

        var permutas = new Array();
        self.permutas.each(function(gsts){
          permutas.push(gsts.toJSON());
        });
        self.model.set({"permutas":permutas});

        // Si los custom llegan a ser fileuploaders, hay que setearlos en el modelo
        for(var i=1;i<=10;i++) {
          if ((self.$("#hidden_custom_"+i).length > 0)) {
            var cus = $(self.el).find("#hidden_custom_"+i).val();
            var key = "custom_"+i;
            var obj = {};
            obj[key] = cus;
            self.model.set(obj);
          }          
        }
        
        // Listado de Propiedades Relacionados
        /*
        var relacionados = new Array();
        this.$("#propiedades_tabla_relacionados .list-group-item").each(function(i,e){
            relacionados.push({
                "id":$(e).find(".id").text(),
                "destacado":0,
            });
        });
        self.model.set({"relacionados":relacionados});
        */
          
        // Texto del propiedad
        var cktext = CKEDITOR.instances['propiedad_texto'].getData();
        self.model.set({"texto":cktext});

        // Coordenadas
        if (self.marker != undefined) {
          var pos = self.marker.getPosition();
          var zoom = self.map.getZoom();

          // Controlamos el casco urbano de La Plata
          /*
          if (self.model.get("id_localidad") == 513) {
            var laplatacasocoord = [
              {lat: -34.923092, lng: -57.993672},
              {lat: -34.953664, lng: -57.952602},
              {lat: -34.917602, lng: -57.913034},
              {lat: -34.887017, lng: -57.954447}
            ];
            var laplatacasco = new google.maps.Polygon({paths: laplatacasocoord});
            if (!google.maps.geometry.poly.containsLocation(pos, laplatacasco)) {
              alert("La propiedad no se encuentra dentro del casco urbano de La Plata.");
              return false;
            }
          }*/

          // Controlamos si el Street View esta abierto
          var panorama = self.map.getStreetView();
          if (panorama != undefined && panorama.getVisible()) {
            // pov = Point Of View
            // Es un objeto con dos parametros:
            // heading = angulo con respecto al norte
            // pitch = angulo con respecto a la camara de street view
            var pov = panorama.getPov();
            this.model.set({
              "heading": pov.heading,
              "pitch": pov.pitch,
            });
          }     

          this.model.set({
            "latitud":(isNaN(pos.lat())) ? 0 : pos.lat(),
            "longitud":(isNaN(pos.lng())) ? 0 : pos.lng(),
            "zoom":zoom,
          });
        }

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
              // Si se guardo una propiedad nueva, activamos una bandera para mostrar el lightbox de buscar interesados
              if (nuevo) window.propiedades_guardo_nueva_propiedad = model.id;
              history.back();
            }
          }
        });
      }      
    },
          
  });
})(app);







// -----------
//   MODELO
// -----------

(function ( models ) {

  models.PropiedadDepartamento = Backbone.Model.extend({
    urlRoot: "departamentos",
    defaults: {
      images_dptos: [],
      nombre: "",
      piso: "",
      texto: "",
      id_empresa: ID_EMPRESA,
      disponible: 1,
      id_propiedad: 0,
      orden: 0,
    },
  });
      
})( app.models );



// ----------------------
//   COLECCION PAGINADA
// ----------------------

(function (collections, model) {

  collections.PropiedadesDepartamentos = Backbone.Collection.extend({
    model: model,
  });

})( app.collections, app.models.PropiedadDepartamento);



// -----------------------------------------
//   TABLA DE RESULTADOS
// -----------------------------------------
(function ( app ) {

  app.views.PropiedadesDepartamentosTableView = app.mixins.View.extend({

    template: _.template($("#propiedades_departamentos_resultados_template").html()),
        
    myEvents: {
      "change #departamentos_buscar":"buscar",
      "click .buscar":"buscar",
    },
        
    initialize : function (options) {
      var self = this;
      _.bindAll(this); // Para que this pueda ser utilizado en las funciones
      this.options = options;
      this.id_propiedad = (typeof this.options.id_propiedad != "undefined") ? this.options.id_propiedad : 0;
      this.render();
      this.collection.on('all', this.addAll, this);
      this.addAll();
    },

    render: function() {
      $(this.el).html(this.template());
      return this;
    },
        
    addAll : function () {
      $(this.el).find(".tbody").empty();
      if (this.collection.length > 0) this.collection.each(this.addOne);
    },
        
    addOne : function ( item ) {
      var self = this;
      var view = new app.views.PropiedadesDepartamentosItemResultados({
        model: item,
        collection: self.collection,
      });
      this.$(".tbody").append(view.render().el);
    },
            
  });

})(app);




// -----------------------------------------
//   ITEM DE LA TABLA DE RESULTADOS
// -----------------------------------------
(function ( app ) {
  app.views.PropiedadesDepartamentosItemResultados = app.mixins.View.extend({
        
    template: _.template($("#propiedades_departamentos_item_resultados_template").html()),
    tagName: "tr",
    myEvents: {
      "click .data":"seleccionar",
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
      var self = this;
      var v = new app.views.PropiedadDepartamentoEditView({
        model:self.model,
        collection:self.collection,
      });
      crearLightboxHTML({
        "html":v.el,
        "width":600,
        "height":140,
      });
      workspace.crear_editor('departamento_texto',{
        "toolbar":"Basic"
      });
    },
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      this.options = options;
      this.render();
    },
    render: function() {
      $(this.el).html(this.template(this.model.toJSON()));
      return this;
    },
  });
})(app);



(function ( app ) {

  app.views.PropiedadDepartamentoEditView = app.mixins.View.extend({

    template: _.template($("#propiedad_departamento_template").html()),
            
    myEvents: {
      "click .guardar": "guardar",
    },    
                
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      
      var edicion = false;
      var obj = { "id":this.model.id }
      _.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));

      // Cuando cambian las imagens, renderizamos la tabla
      this.listenTo(this.model, 'change_table', self.render_tabla_fotos);
      this.render_tabla_fotos();
      this.$("#images_dptos_tabla").sortable();
    },

    render_tabla_fotos: function() {
      var images = this.model.get("images_dptos");
      this.$("#images_dptos_tabla").empty();
      if (images.length == 0) {
        this.$("#images_dptos_container").removeClass('tiene');
      } else {
        this.$("#images_dptos_container").addClass('tiene');
        for(var i=0;i<images.length;i++) {
          var path = images[i];
          var pth = path+"?t="+parseInt(Math.random()*100000);
          var li = "";
          li+="<li class='list-group-item'>";
          li+=" <span><i class='fa fa-sort text-muted fa m-r-sm'></i> </span>";
          li+=" <img style='margin-left: 10px; margin-right:10px; max-height:50px' class='img_preview' src='"+pth+"'/>";
          li+=" <span class='dn filename'>"+path+"</span>";
          li+=" <span class='cp pull-right m-t eliminar_foto' data-property='images_dptos'><i class='fa fa-fw fa-times'></i> </span>";
          li+=" <span data-id='images_dptos' class='cp m-r pull-right m-t editar_foto_multiple'><i class='fa fa-pencil'></i> </span>";
          li+="</li>";
          this.$("#images_dptos_tabla").append(li);
        }
        this.$("#images_dptos_container").show();
      }
    },
        
    validar: function() {
      try {
        var self = this;
        
        validate_input("departamento_nombre",IS_EMPTY,"Por favor, ingrese un titulo.");
        
        this.model.set({
          "nombre":self.$("#departamento_nombre").val(),
          "orden":self.$("#departamento_orden").val(),
          "disponible":(self.$("#departamento_disponible").is(":checked")?1:0),
        });
        
        // Listado de Imagenes
        var images = new Array();
        this.$("#images_dptos_tabla .list-group-item .filename").each(function(i,e){
          images.push($(e).text());
        });
        self.model.set({"images_dptos":images});

        // Texto del departamento
        var cktext = CKEDITOR.instances['departamento_texto'].getData();
        self.model.set({"texto":cktext});
        
        $(".error").removeClass("error");
        return true;
      } catch(e) {
        console.log(e);
        return false;
      }
    },  

    guardar:function() {
      var self = this;
      if (this.validar()) {
        if (this.model.id == null) {
          // NO PONEMOS ID = 0, PORQUE SINO NO AGREGA DOS ELEMENTOS CON EL MISMO ID
          var maxId = 0;
          this.collection.each(function(item){
            if (item.id > maxId) maxId = item.id;
          });
          maxId++;
          this.model.set({id:maxId});
        }
        this.collection.add(this.model);
        $('.modal:last').modal('hide');
      }      
    },
          
  });
})(app);


(function ( views, models ) {
  views.PropiedadMercadoLibreView = app.mixins.View.extend({
    template: _.template($("#propiedad_mercado_libre_template").html()),
    myEvents: {
      "click .cerrar":function() {
        $('.modal:last').modal('hide');
      },
      "click .predecir_categoria":"predecir_categoria",
      "click .ir_paso_1":"ir_paso_1",
      "click .ir_paso_2":"ir_paso_2",
      "click .publicar":"publicar",
      "click #propiedad_mercado_libre_paso_1_link":function(e) {
        e.preventDefault();
        e.stopPropagation();
        return false;
      },
      "click #propiedad_mercado_libre_paso_2_link":function(e) {
        e.preventDefault();
        e.stopPropagation();
        return false;
      },
    },
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      this.multiple = (typeof options.multiple != "undefined") ? options.multiple : false;
      this.render();
      this.predijo_categoria = false;
      this.listenTo(this.model, 'change_table', self.render_tabla_fotos);
      this.render_tabla_fotos();            
      $(this.el).find("#images_meli_tabla").sortable();
    },
    render: function() {
      var self = this;
      var obj = this.model.toJSON();
      obj.multiple = this.multiple;
      $(this.el).html(this.template(obj));

      $.ajax({
        "url":"propiedades_meli/function/get_paquetes_publicacion_usuario/",
        "dataType":"json",
        "success":function(res){
          self.$("#propiedad_mercado_libre_tipo_publicacion").empty();
          self.$("#propiedad_mercado_libre_tipo_publicacion").append('<option value="0">Seleccione</option>');
          self.$("#propiedad_mercado_libre_tipo_publicacion").append('<option value="free">Gratuita</option>');
          for(var i = 0; i < res.length; i++) {
            var opt = res[i];
            self.$("#propiedad_mercado_libre_tipo_publicacion").append('<option value="'+opt.id+'">'+opt.nombre+'</option>');
          }
        }
      });

      return this;
    },
    ir_paso_1: function() {
      this.$(".nav-tabs li").removeClass('active');
      this.$("#propiedad_mercado_libre_paso_1_link").parent().addClass("active");
      this.$(".tab-pane.active").removeClass('active');
      this.$("#propiedad_mercado_libre_tab1").addClass('active');
    },
    ir_paso_2: function() {
      var self = this;
      var list_type_id = $("#propiedad_mercado_libre_tipo_publicacion").val();
      if (list_type_id == 0) {
        alert("Seleccione un tipo de publicacion");
        return false;
      }
      this.model.set({
        "list_type_id":list_type_id,
      });
      
      if (this.multiple) {
        $.ajax({
          "url":"https://api.mercadolibre.com/sites/MLA/",
          "dataType":"json",
          "type":"get",
          "data":{
            "access_token":ML_ACCESS_TOKEN,
          },
          "success":function(r) {
            var modelo = new app.models.AbstractModel({
              "categories":r.categories,
              "nivel":0,
              "selected":0,
            });
            var v = new app.views.PropiedadMercadoLibreCategoriaView({
              container: self,
              model: modelo,
            });
            self.$(".loading_grande").hide();
            self.agregar_categoria_contenedor(v.el);

            self.$(".nav-tabs li").removeClass('active');
            self.$("#propiedad_mercado_libre_paso_2_link").parent().addClass("active");
            self.$(".tab-pane.active").removeClass('active');
            self.$("#propiedad_mercado_libre_tab2").addClass('active');

          },
        });
      } else {

        // Controlamos que haya ingresado los valores
        var titulo = this.$("#propiedad_mercado_libre_titulo_meli").val();
        if (isEmpty(titulo)) {
          alert("Por favor ingrese un titulo");
          this.$("#propiedad_mercado_libre_titulo_meli").focus();
          return;
        }
        var precio = this.$("#propiedad_mercado_libre_precio_meli").val();
        if (isEmpty(precio) || precio == 0) {
          alert("Por favor ingrese un precio");
          this.$("#propiedad_mercado_libre_precio_meli").focus();
          return;
        }
        var texto = this.$("#propiedad_mercado_libre_texto_meli").val();
        if (isEmpty(texto)) {
          alert("Por favor ingrese un texto");
          this.$("#propiedad_mercado_libre_texto_meli").focus();
          return;
        }

        this.$(".nav-tabs li").removeClass('active');
        this.$("#propiedad_mercado_libre_paso_2_link").parent().addClass("active");
        this.$(".tab-pane.active").removeClass('active');
        this.$("#propiedad_mercado_libre_tab2").addClass('active');

        // Si no esta definida una categoria, intentamos predecirla primero
        if (isEmpty(this.model.get("categoria_meli"))) {
          if (!this.predijo_categoria) this.predecir_categoria();
        } else {
          // TODO: Poner el arbol de categorias desde la categoria actual
          $.ajax({
            "url":"/admin/propiedades_meli/function/get_categorias/"+self.model.get("categoria_meli"),
            "dataType":"json",
            "success":function(r) {
              self.$("#propiedad_mercado_libre_categorias").empty();
              if (typeof r.categorias != "undefined") {
                for(var i=0; i<r.categorias.length; i++) {
                  var cat = r.categorias[i];
                  var v = new app.views.PropiedadMercadoLibreCategoriaView({
                    model: new app.models.AbstractModel({
                      "categories":cat.children,
                      "selected":cat.selected,
                      "nivel":i,
                    }),
                    container: self,
                  });
                  self.agregar_categoria_contenedor(v.el);
                }
                self.agregar_final(r.id);
                self.$(".loading_grande").hide();
              }
            },
          });

        }        
      }
    },

    render_tabla_fotos: function() {
      var images_meli = this.model.get("images_meli");
      this.$("#images_meli_tabla").empty();
      if (images_meli.length == 0) {
        this.$("#images_meli_container").removeClass('tiene');
      } else {
        this.$("#images_meli_container").addClass('tiene');
        for(var i=0;i<images_meli.length;i++) {
          var path = images_meli[i];
          var pth = path+"?t="+parseInt(Math.random()*100000);
          var li = "";
          li+="<li class='list-group-item'>";
          li+=" <span><i class='fa fa-sort text-muted fa m-r-sm'></i> </span>";
          li+=" <img style='margin-left: 10px; margin-right:10px; max-height:50px' class='img_preview' src='"+pth+"'/>";
          li+=" <span class='filename'>"+path+"</span>";
          li+=" <span class='cp pull-right m-t eliminar_foto' data-property='images_meli'><i class='fa fa-fw fa-times'></i> </span>";
          li+=" <span data-id='images_meli' class='cp m-r pull-right m-t editar_foto_multiple'><i class='fa fa-pencil'></i> </span>";
          li+="</li>";
          this.$("#images_meli_tabla").append(li);
        }                
      }
    },

    cargar_tipos_publicaciones: function() {
      $.ajax({
        "url":"https://api.mercadolibre.com/sites/MLA/listing_types/",
        "dataType":"json",
        "success":function(res) {
          $("#propiedad_mercado_libre_tipo_publicacion").empty();
          for(var i=0; i<res.length; i++) {
            var r = res[i];
            var option = "<option value='"+r.id+"'>";
            option+=r.name;
            option+="</option>";
            $("#propiedad_mercado_libre_tipo_publicacion").append(option);
          }
        }
      })
    },
    cambiar_categoria: function(view,model) {

      var self = this;
      var nivel = $(view.el).find("select").data("nivel");
      var id_categoria = $(view.el).find("select").val();
      
      // Eliminamos los selects que se encuentran a la derecha
      $(view.el).nextAll().remove();

      // Vamos a buscar los hijos de la nueva categoria seleccionada
      $.ajax({
        "url":"/admin/propiedades_meli/function/get_categorias_hijas/",
        "dataType":"json",
        "type":"post",
        "data":{
          "id_categoria":id_categoria,
        },
        "success":function(r) {
          // Si tiene categorias hijas
          if (r.children.length > 0) {
            var modelo = new app.models.AbstractModel({
              "categories":r.children,
              "nivel":nivel+1,
              "selected":"",
            });
            var v = new app.views.PropiedadMercadoLibreCategoriaView({
              container: self,
              model: modelo,
            });
            self.agregar_categoria_contenedor(v.el);
          } else {
            self.agregar_final(id_categoria);
          }
        },
      });
    },
    predecir_categoria: function() {
      var self = this;
      var titulo = this.$("#propiedad_mercado_libre_titulo_meli").val();
      if (isEmpty(titulo)) {
        alert("Por favor escriba un titulo para poder predecir la categoria");
        this.$("#propiedad_mercado_libre_titulo_meli").select();
        return;
      }
      self.$("#propiedad_mercado_libre_categorias").empty();
      $.ajax({
        "url":"/admin/propiedades_meli/function/predecir_categoria/",
        "dataType":"json",
        "type":"post",
        "data":{
          "titulo":titulo,
        },
        "success":function(r) {
          if (typeof r.categorias != "undefined") {
            for(var i=0; i<r.categorias.length; i++) {
              var cat = r.categorias[i];
              var v = new app.views.PropiedadMercadoLibreCategoriaView({
                model: new app.models.AbstractModel({
                  "categories":cat.children,
                  "selected":cat.selected,
                  "nivel":i,
                }),
                container: self,
              });
              self.agregar_categoria_contenedor(v.el);
            }
            self.agregar_final(r.id);
            self.$(".loading_grande").hide();
            self.predijo_categoria = true;
          }
        }
      })
    },
    agregar_final: function(id_categoria) {
      // Si no tiene categorias hijas, es la ultima seleccionada
      var sig = "<div class='categoria_meli categoria_meli_ok'>";
      sig+= "<div>";
      sig+= "<div class='categoria_meli_ok_icon'><i class='fa fa-check'></i></div>";
      sig+= "<div class='h3'>¡Listo!</div>";
      sig+= "<div><button data-id_categoria="+id_categoria+" class='btn btn-success mt20 mb20 publicar'>Publicar</button></div>";
      sig+= "</div>";
      sig+= "</div>";
      this.agregar_categoria_contenedor(sig);
    },
    agregar_categoria_contenedor: function(v) {
      this.$("#propiedad_mercado_libre_categorias").append(v);
      var ancho = 200;
      this.$("#propiedad_mercado_libre_categorias > div").each(function(index, el) {
        ancho += $(el).outerWidth();
      });
      this.$("#propiedad_mercado_libre_categorias").css("width",ancho);
      this.$("#propiedad_mercado_libre_categorias").parent()[0].scrollLeft = ancho;
    },
    validar: function() {
      // Listado de Imagenes
      if ($(this.el).find("#images_meli_tabla").length > 0) {
        var images_meli = new Array();
        $(this.el).find("#images_meli_tabla .list-group-item .filename").each(function(i,e){
          images_meli.push($(e).text());
        });
        this.model.set({
          "images_meli":images_meli,  
        });        
      }
      return true;
    }, 
    publicar: function(e) {
      // Primero guardamos el modelo, y luego llamamos a publicar el producto
      var self = this;
      var id_categoria = $(e.currentTarget).data("id_categoria");
      this.model.set({
        "categoria_meli":id_categoria,
      });
      if (!this.validar()) return;
      if (this.multiple) {
        if (window.propiedades_marcadas.length == 0) return;
        var art_marcados = window.propiedades_marcadas.join(",");
        var images_meli = self.model.get("images_meli").join(";;;");
        // Si estamos publicando multiples productos
        $.ajax({
          "url":"propiedades_meli/function/publicar_multiple/",
          "type":"post",
          "data":{
            "ids":art_marcados,
            "categoria_meli":self.model.get("categoria_meli"),
            "list_type_id":self.model.get("list_type_id"),
            "images_meli":images_meli,
          },
          "dataType":"json",
          "success":function(r) {
            if (r.error == 0) {
              location.reload();
            } else if (r.error == 1) {
              alert(r.mensaje);
            }
          },
        });
      } else {
        // Estamos publicando un producto en particular
        this.model.save({},{
          "success":function(){
            var that = self;
            $.ajax({
              "url":"propiedades_meli/function/publicar/",
              "type":"post",
              "data":{
                "id_propiedad":self.model.id,
              },
              "dataType":"json",
              "success":function(r) {
                if (r.error == 0) {
                  window.open(r.link,"_blank");
                  location.reload();
                } else if (r.error == 1) {
                  alert(r.mensaje);
                }
              },
            })
          }
        });
      }
    },
  });
})(app.views, app.models);

(function ( views, models ) {
  views.PropiedadMercadoLibreCategoriaView = app.mixins.View.extend({
    template: _.template($("#propiedad_mercado_libre_categoria_template").html()),
    myEvents: {
      "change .categoria_mercado_libre":function(){
        this.container.cambiar_categoria(this,this.model);
      },
    },
    className: "categoria_meli",
    initialize: function(options) {
      _.bindAll(this);
      this.container = options.container;
      this.render();
    },
    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));
      return this;
    },
  });
})(app.views, app.models);




(function ( views, models ) {
  views.PropiedadBuscarInteresadosView = app.mixins.View.extend({
    template: _.template($("#propiedad_buscar_interesados_template").html()),
    myEvents: {
      "click .cerrar":function() {
        $('.modal:last').modal('hide');
      },
      "click .enviar_emails":function() {
        var self = this;
        var ids = new Array();
        $(".propiedad_buscar_interesados_checkbox:checked").each(function(i,e){
          ids.push($(e).data("id"));
        });
        $.ajax({
          "url":"contactos/function/enviar_email_interesados/",
          "dataType":"json",
          "type":"post",
          "data":{
            "id_clientes":ids.join("-"),
            "id_propiedad":self.model.id,
          },
          "success":function(r) {
            if (r.error == 1) alert(r.mensaje);
            else {
              alert("Los emails han sido enviados con exito.")
            }
          }
        })
      },
    },
    initialize: function(options) {
      _.bindAll(this);
      this.render();
      this.buscar();
    },
    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));
      return this;
    },
    buscar: function() {
      var self = this;
      $.ajax({
        "url":"contactos/function/buscar_interesados_por_propiedad/",
        "dataType":"json",
        "type":"get",
        "data":{
          "id_propiedad":self.model.id,
        },
        "success":function(res) {
          self.$("#propiedad_buscar_interesados_tabla tbody").empty();
          if (res.length == 0) {
            var no = "<tr><td colspan='5'>No se encuentran contactos interesados para esta propiedad.</td></tr>";
            self.$("#propiedad_buscar_interesados_tabla tbody").append(no);
          } else {
            for(var i=0;i<res.length;i++) {
              var o = res[i];
              var n = new app.views.PropiedadBuscarInteresadosItemView({
                model: new app.models.AbstractModel(o)
              });
              self.$("#propiedad_buscar_interesados_tabla tbody").append(n.el);
            }
          }
        }
      })
    }
  });
})(app.views, app.models);

(function ( views, models ) {
  views.PropiedadBuscarInteresadosItemView = app.mixins.View.extend({
    template: _.template($("#propiedad_buscar_interesados_item_template").html()),
    tagName: "tr",
    myEvents: {
      "click .enviar_whatsapp_interesado":function(e) {
        var link_completo = $(e.currentTarget).data("link_completo");
        var salida = "https://wa.me/"+this.model.get("telefono")+"?text="+encodeURIComponent(link_completo);
        window.open(salida,"_blank");
      },
    },
    initialize: function(options) {
      _.bindAll(this);
      this.render();
    },
    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));
      return this;
    },
  });
})(app.views, app.models);




(function ( app ) {

  app.views.PropiedadEstadisticaDetalleView = app.mixins.View.extend({

    template: _.template($("#propiedad_estadistica_detalle_template").html()),
    
    events: {
      "click .cerrar": "cerrar",
      "click .buscar":"buscar",
      "click .ver_contacto":function(e) {
        window.open("app/#contacto_acciones/"+$(e.currentTarget).data("id"),"_blank");
      },
    },
  
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      this.articulo = null;
      this.options = options;
      this.tab_default = (typeof options.tab_default != "undefined") ? options.tab_default : "tabla";
      var obj = this.model.toJSON();
      obj.tab_default = this.tab_default;
      $(this.el).html(this.template(obj));
      this.render();
    },

    render : function() {
      var self = this;
      var desde = (typeof this.model.get("desde") == "undefined") ? moment().subtract(3,'months').toDate() : this.model.get("desde");
      var hasta = (typeof this.model.get("hasta") == "undefined") ? moment().toDate() : this.model.get("hasta");
      createdatepicker($(this.el).find("#propiedad_estadistica_fecha_desde"),desde);
      createdatepicker($(this.el).find("#propiedad_estadistica_fecha_hasta"),hasta);
      this.buscar();
    },
    
    cerrar: function() {
      $('.modal:last').modal('hide');
    },    

    buscar: function() {
      var self = this;
      var params = {
        "id_propiedad":self.model.get("id_propiedad"),
        "desde":self.$("#propiedad_estadistica_fecha_desde").val(),
        "hasta":self.$("#propiedad_estadistica_fecha_hasta").val(),
      };
      $.ajax({
        "url":"estadisticas/function/ver_detalle_propiedad/",
        "dataType":"json",
        "data":params,
        "type":"post",
        "success":function(r){
          self.render_tabla(r.tabla);
          self.render_grafico(r.grafico);
        }
      });
    }, 
  
    render_tabla : function(results) {
      var self = this;
      this.$("#propiedad_estadistica_tabla tbody").empty();
      for(var i=0;i<results.length;i++ ) {
        var item = results[i];
        var tr = "<tr>";
        tr+="<td>"+item.fecha+"</td>";
        tr+="<td><a href='javascript:void(0)' data-id='"+item.id_contacto+"' class='text-info ver_contacto'>"+item.nombre+"</a></td>";
        tr+="</tr>";
        self.$("#propiedad_estadistica_tabla tbody").append(tr);
      }
    },

    render_grafico: function(results) {

      var desde = self.$("#propiedad_estadistica_fecha_desde").val();
      var desde_anio = desde.substr(6);
      var desde_mes = desde.substr(3,2)-1;
      var desde_dia = desde.substr(0,2);
      var plotOptionsSeries = {
        pointStart: Date.UTC(desde_anio,desde_mes,desde_dia),
        pointInterval: 24 * 3600 * 1000,
      };

      self.$('#propiedad_estadistica_grafico').highcharts({
        title: { text: null },
        xAxis: {
          type: 'datetime'
        },
        chart: {
          type: 'area',
        },
        legend: {
          floating: true,
          align: "right",
          verticalAlign: "top",
        },
        colors: ['#28b492','#19a9d5'],
        yAxis: {
          allowDecimals: false,
          gridLineColor: '#f9f9f9',
          title: {
            text: 'Intereses'
          }
        },
        tooltip: {
          dateTimeLabelFormats: {
            day: '%e/%m/%Y',
            week: '%e/%m/%Y',
          }
        },
        plotOptions: {
          area: {
            marker: {
              enabled: false,
              symbol: 'circle',
              radius: 2,
              states: {
                hover: { enabled: true }
              }
            }
          },
          series: plotOptionsSeries
        },
        series: [{
          type: "area",
          name: "Grafico",
          data: results,
        }]
      });

    },
  });
})(app);



(function ( views, models ) {
  views.PropiedadPreview = app.mixins.View.extend({
    template: _.template($("#propiedad_preview_template").html()),
    className: "propiedad_preview",
    myEvents: {
      "click .editar":function() {
        $('.modal:last').modal('hide');
        location.href="app/#propiedades/"+this.model.id;
      },
      "click #cerrar_preview":function(){
        $('.modal:last').modal('hide');
      },
      "click .enviar":"enviar",
      "click .enviar_whatsapp":"enviar_whatsapp",
      "click .ver_ficha":function(e) {
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        //window.open("propiedades/function/ver_ficha/"+this.model.get("id_empresa")+"/"+this.model.id+"/"+ID_EMPRESA,"_blank");
        window.open("https://app.inmovar.com/ficha/"+ID_EMPRESA+"/"+this.model.get("hash"),"_blank");
        return false;
      },
      "click .ver_ficha_web":function(e){
        var self = this;
        e.stopPropagation();
        e.preventDefault();
        if($(e.currentTarget).attr("disabled") == "disabled") return;
        window.open("https://app.inmovar.com/ficha/"+ID_EMPRESA+"/"+this.model.get("hash"),"_blank");
        return false;
      },
      "click .marcar_interes":"marcar_interes",
      "click #propiedad_preview_2_link":function() {
        var self = this;
        try {
          loadGoogleMaps('3',API_KEY_GOOGLE_MAPS).done(self.render_map);
        } catch(e) {
          setTimeout(function(){
            self.render_map();
          },1000);
        }
      },
      "click #propiedad_preview_3_link":function() {
        console.log("llega");
        var self = this;
        if (ID_EMPRESA != self.model.get("id_empresa")) {
          workspace.enviar_visita({
            "id_empresa": ID_EMPRESA,
            "id_inmobiliaria": self.model.get("id_empresa"),
            "id_propiedad": self.model.id,
            //TIPO = 0 VISITA EN EL PANEL
            //TIPO = 1 CONSULTA EN EL PANEL
            "tipo": 1,
          });
        }
      },
      "click #propiedad_preview_6_link":function() {
        console.log("llega");
        var self = this;
        self.cargar_grafico_precios();
      },
      "click .imprimir_reporte":function() {
        var url = "propiedades/function/imprimir_pdf/"+this.model.id;
        url += "?fd="+encodeURI(moment($("#propiedad_preview_fecha_desde").val(),"DD/MM/YYYY").format("YYYY-MM-DD"));
        url += "&fh="+encodeURI(moment($("#propiedad_preview_fecha_hasta").val(),"DD/MM/YYYY").format("YYYY-MM-DD"));
        //console.log(url);
        workspace.imprimir_reporte(url);
      },
      "change #propiedad_preview_fecha_desde": "calcular_grafico",
      "change #propiedad_preview_fecha_hasta": "calcular_grafico",
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
      if (ID_EMPRESA != self.model.get("id_empresa")) {
        workspace.enviar_visita({
          "id_empresa": ID_EMPRESA,
          "id_inmobiliaria": self.model.get("id_empresa"),
          "id_propiedad": self.model.id,
          //TIPO = 0 VISITA EN EL PANEL
          //TIPO = 1 CONSULTA EN EL PANEL
          "tipo": 0,
        });
      }

      console.log(this.model);
      var fecha_desde = moment().subtract(1, 'month').format('YYYY-MM-DD');
      var fecha_desde_anio = moment().subtract(1, 'year').format('YYYY-MM-DD');
      createdatepicker($(this.el).find("#propiedad_preview_fecha_desde"),fecha_desde);
      var fecha_hasta = moment().format('YYYY-MM-DD');
      createdatepicker($(this.el).find("#propiedad_preview_fecha_hasta"),fecha_hasta);
      createdatepicker($(this.el).find("#propiedad_graficos_fecha_desde"),fecha_desde_anio);
      createdatepicker($(this.el).find("#propiedad_graficos_fecha_hasta"),fecha_hasta);

      
      window.desde_anio = fecha_desde.substr(0,4);
      window.desde_mes = fecha_desde.substr(5,5);
      window.desde_dia = fecha_desde.substr(8,11);

      self.$('#vision_general_bar').highcharts({
        chart: {
          type: 'area',
          zoomType: 'x'
        },
        title: { text: null },
        legend: {
          floating: true,
          align: "right",
          verticalAlign: "top",
        },
        colors: ['#28b492','#19a9d5','#e7953e'],
        xAxis: {
          type: 'datetime',
          dateTimeLabelFormats: {
            day: '%b %e',
            week: '%b %e'
          }      
        },
        yAxis: {
          allowDecimals: false,
          gridLineColor: '#f9f9f9',
          title: {
            text: null
          }
        },
        tooltip: {
          dateTimeLabelFormats: {
            day: '%e/%m/%Y',
            week: '%e/%m/%Y',
          }
        },
        plotOptions: {
          area: {
            marker: {
              enabled: false,
              symbol: 'circle',
              radius: 2,
              states: {
                hover: { enabled: true }
              }
            }
          },
          series: {
            pointStart: Date.UTC(window.desde_anio,window.desde_mes.substr(0,2),window.desde_dia),
            pointInterval: 24 * 3600 * 1000,
          }
        },
        series: [{
          name: 'Vistas Web ('+self.model.get("data_graficos").total_web+')',
          data: self.model.get("data_graficos").visitas_web,
        },{
          name: 'Vistas Panel ('+self.model.get("data_graficos").total_panel+')',
          data: self.model.get("data_graficos").visitas_panel,
        },{
          name: 'Consultas Web ('+self.model.get("data_graficos").total_consultas+')',
          data: self.model.get("data_graficos").consultas,
        }]
      }); 
      self.$(".total_visitas").html(self.model.get("data_graficos").total_web+self.model.get("data_graficos").total_panel);
      self.$(".total_web").html(self.model.get("data_graficos").total_web);
      self.$(".total_panel").html(self.model.get("data_graficos").total_panel);
      self.$(".total_consultas").html(self.model.get("data_graficos").total_consultas_web+self.model.get("data_graficos").total_consultas_panel);
      self.$(".consultas_web").html(self.model.get("data_graficos").total_consultas_web);
      self.$(".consultas_panel").html(self.model.get("data_graficos").total_consultas_panel);
      return this;
    },


    calcular_grafico: function() {
      
      var f_desde = $("#propiedad_preview_fecha_desde").val();
      var f_hasta = $("#propiedad_preview_fecha_hasta").val();

      console.log(f_desde);
      console.log(f_hasta);
      
      var self = this;
      $.ajax({
        "url":"propiedades/function/ver_propiedad/"+self.model.id+"/"+self.model.get("id_empresa"),
        "dataType":"json",
        "type":"get",
        "data":{
          "fecha_desde":moment(f_desde,"DD/MM/YYYY").format("YYYY-MM-DD"),
          "fecha_hasta":moment(f_hasta,"DD/MM/YYYY").format("YYYY-MM-DD"),
        },
        "success":function(r) {
          
          self.$('#vision_general_bar').highcharts({
            chart: {
              type: 'area',
              zoomType: 'x'
            },
            title: { text: null },
            legend: {
              floating: true,
              align: "right",
              verticalAlign: "top",
            },
            colors: ['#28b492','#19a9d5','#e7953e'],
            xAxis: {
              type: 'datetime',
              dateTimeLabelFormats: {
                day: '%b %e',
                week: '%b %e'
              }      
            },
            yAxis: {
              allowDecimals: false,
              gridLineColor: '#f9f9f9',
              title: {
                text: null
              }
            },
            tooltip: {
              dateTimeLabelFormats: {
                day: '%e/%m/%Y',
                week: '%e/%m/%Y',
              }
            },
            plotOptions: {
              area: {
                marker: {
                  enabled: false,
                  symbol: 'circle',
                  radius: 2,
                  states: {
                    hover: { enabled: true }
                  }
                }
              },
              series: {
                pointStart: Date.UTC(window.desde_anio,window.desde_mes.substr(0,2),window.desde_dia),
                pointInterval: 24 * 3600 * 1000,
              }
            },
            series: [{
              name: 'Vistas Web ('+r.data_graficos.total_web+')',
              data: r.data_graficos.visitas_web,
            },{
              name: 'Vistas Panel ('+r.data_graficos.total_panel+')',
              data: r.data_graficos.visitas_panel,
            },{
              name: 'Consultas Web('+r.data_graficos.total_consultas+')',
              data: r.data_graficos.consultas,
            }]
          }); 


          self.$(".total_visitas").html(r.data_graficos.total_web+r.data_graficos.total_panel);
          self.$(".total_web").html(r.data_graficos.total_web);
          self.$(".total_panel").html(r.data_graficos.total_panel);
          self.$(".total_consultas").html(r.data_graficos.total_consultas_web+total_consultas_panel);
          self.$(".consultas_web").html(r.data_graficos.total_consultas_web);
          self.$(".consultas_panel").html(r.data_graficos.total_consultas_panel);

          self.$('.consultas .consul').empty();
          if (r.data_graficos.clientes_consultas !== undefined) {
            for (var i=0;i< r.data_graficos.clientes_consultas.length;i++) {
              var c = r.data_graficos.clientes_consultas[i];
              if (c.tipo == 1) tipo = 'A contactar';
              if (c.tipo == 2) tipo = 'Contactado';
              if (c.tipo == 3) tipo = 'Con actividad';
              if (c.tipo == 4) tipo = 'En negociacion';
              var p = '<p><span class="text-info">'+c.cliente_nombre+'</span> | '+ moment(c.fecha,"YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY HH:mm:ss")+' | '+tipo+'</p>';
              self.$('.consultas .consul').append(p);
            }
          }

        },
      });
    },

    cargar_grafico_precios: function() {
      
      var f_desde = $("#propiedad_graficos_fecha_desde").val();
      var f_hasta = $("#propiedad_graficos_fecha_hasta").val();

      f_desde = moment(f_desde,"DD/MM/YYYY").format("YYYY-MM-DD");
      f_hasta = moment(f_hasta,"DD/MM/YYYY").format("YYYY-MM-DD");
      
      var desde_anio = f_desde.substr(0,4);
      var desde_mes = f_desde.substr(5,5);
      var desde_dia = f_desde.substr(8,11);

      var self = this;
      $.ajax({
        "url":"propiedades/function/get_precios_propiedades/",
        "dataType":"json",
        "type":"post",
        "data":{
          "fecha_desde":f_desde,
          "fecha_hasta":f_hasta,
          "id":self.model.id,
          "id_empresa":self.model.get("id_empresa"),
        },
        "success":function(r) {
          self.$('#historial_precios_bar').highcharts({
            chart: {
              type: 'area',
              zoomType: 'x'
            },
            title: { text: null },
            legend: {
              floating: true,
              align: "right",
              verticalAlign: "top",
            },
            colors: ['#28b492','#19a9d5','#e7953e'],
            xAxis: {
              type: 'datetime',
              dateTimeLabelFormats: {
                day: '%b %e',
                week: '%b %e'
              }      
            },
            yAxis: {
              allowDecimals: false,
              gridLineColor: '#f9f9f9',
              title: {
                text: null
              },
            },
            tooltip: {
              dateTimeLabelFormats: {
                day: '%e/%m/%Y',
                week: '%e/%m/%Y',
              }
            },
            plotOptions: {
              area: {
                marker: {
                  enabled: false,
                  symbol: 'circle',
                  radius: 2,
                  states: {
                    hover: { enabled: true }
                  }
                }
              },
              series: {
                pointStart: Date.UTC(desde_anio,desde_mes.substr(0,2),desde_dia),
                pointInterval: 24 * 3600 * 1000,
              }
            },
            series: [{
              name: 'Historial de Precios',
              data: r.salida.precios,
            }]
          }); 
        },
      });
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
        "url":"contactos/function/guardar_propiedades_interesadas/",
        "type":"post",
        "dataType":"json",
        "data":{
          "ids":new Array(self.model.id),
          "id_empresa_propiedad":self.model.get("id_empresa"),
          "id_cliente":self.id_cliente,
        },
        "success":function(r) {
          if (r.error == 1) alert("Ocurrio un error al guardar los intereses de las propiedades seleccionadas.");
          else {
            $('#contacto_propiedades_interesadas').owlCarousel('destroy'); 
            if (self.ficha_contacto != null) {
              self.ficha_contacto.render_propiedades_interesadas();
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
        asunto:"Fichas de Propiedades",
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
      self.map = new google.maps.Map(document.getElementById("propiedad_preview_mapa"), mapOptions);
      self.marker = new google.maps.Marker({
        position: self.coor,
        map: self.map,
      });
    },
    render_galeria: function() {
      // The slider being synced must be initialized first
      this.$('#propiedades_preview_carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 120,
        asNavFor: '#propiedades_preview_slider',
        prevText: "",
        nextText: "",
      });
      this.$('#propiedades_preview_slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#propiedades_preview_carousel",
        prevText: "",
        nextText: "",
      });
    }
  });
})(app.views, app.models);


(function ( app ) {

  app.views.PropiedadTemporadaEditView = app.mixins.View.extend({

    template: _.template($("#propiedad_temporada_panel_template").html()),
            
    myEvents: {
      "click .guardar": "guardar",
      "click .cancelar": "cancelar",
    },
                
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      $(this.el).html(this.template(this.model.toJSON()));
      createdatepicker(this.$("#propiedad_temporada_fecha_desde"),this.model.get("desde"));
      createdatepicker(this.$("#propiedad_temporada_fecha_hasta"),this.model.get("hasta"));
    },

    validar: function() {
      try {
        var self = this;
        
        validate_input("propiedad_temporada_nombre",IS_EMPTY,"Por favor, ingrese un nombre.");
        validate_input("propiedad_temporada_fecha_desde",IS_EMPTY,"Por favor seleccione una fecha.");
        validate_input("propiedad_temporada_fecha_hasta",IS_EMPTY,"Por favor seleccione una fecha.");
        validate_input("propiedad_temporada_minimo_dias_reserva",IS_EMPTY,"Por favor seleccione una estadia.");
        
        this.model.set({
          "nombre":self.$("#propiedad_temporada_nombre").val(),
          "precio":self.$("#propiedad_temporada_precio").val(),
          "precio_finde":self.$("#propiedad_temporada_precio_finde").val(),
          "precio_semana":self.$("#propiedad_temporada_precio_semana").val(),
          "precio_mes":self.$("#propiedad_temporada_precio_mes").val(),
          "minimo_dias_reserva":self.$("#propiedad_temporada_minimo_dias_reserva").val(),
          "desde":self.$("#propiedad_temporada_fecha_desde").val(),
          "hasta":self.$("#propiedad_temporada_fecha_hasta").val(),
        });
        
        $(".error").removeClass("error");
        return true;
      } catch(e) {
        console.log(e);
        return false;
      }
    },  

    guardar:function() {
      var self = this;
      if (this.validar()) {
        this.model.set({"cancelo":0});
        $('.modal:last').modal('hide');
      }      
    },

    cancelar: function() {
      this.model.set({"cancelo":1});
      $('.modal:last').modal('hide');
    },
          
  });
})(app);



(function ( app ) {

  app.views.PropiedadImpuestoEditView = app.mixins.View.extend({

    template: _.template($("#propiedad_impuesto_panel_template").html()),
            
    myEvents: {
      "click .guardar": "guardar",
      "click .cancelar": "cancelar",
    },
                
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      $(this.el).html(this.template(this.model.toJSON()));
    },

    validar: function() {
      try {
        var self = this;
        
        validate_input("propiedad_impuesto_nombre",IS_EMPTY,"Por favor, ingrese un nombre.");
        validate_input("propiedad_impuesto_monto",IS_EMPTY,"Por favor ingrese un valor.");
        
        this.model.set({
          "nombre":self.$("#propiedad_impuesto_nombre").val(),
          "monto":self.$("#propiedad_impuesto_monto").val(),
          "tipo":self.$("#propiedad_impuesto_tipo").val(),
        });
        
        $(".error").removeClass("error");
        return true;
      } catch(e) {
        console.log(e);
        return false;
      }
    },  

    guardar:function() {
      var self = this;
      if (this.validar()) {
        this.model.set({"cancelo":0});
        $('.modal:last').modal('hide');
      }      
    },

    cancelar: function() {
      this.model.set({"cancelo":1});
      $('.modal:last').modal('hide');
    },
          
  });
})(app);


// -----------
//   MODELO
// -----------

(function ( models ) {

  models.Propietario = Backbone.Model.extend({
    urlRoot: "propietarios/",
    defaults: {
      nombre: "",
      email: "",
      telefono: "",
      celular: "",
      direccion: "",
      observaciones: "",
      custom_5: "1", // Indica que el cliente es un propietario
      id_tipo_iva: 4,
      forma_pago: "C",
      id_tipo_documento: 96,
      activo: 1,
    }
  });
    
})( app.models );


// ----------------------
//   COLECCION PAGINADA
// ----------------------

(function (collections, model, paginator) {

  collections.Propietarios = paginator.requestPager.extend({

    model: model,

    paginator_core: {
      url: "propietarios/"
    }
    
  });

})( app.collections, app.models.Propietario, Backbone.Paginator);



// ------------------------------
//   VISTA DE ITEM DE LA TABLA
// ------------------------------

(function ( app ) {

  app.views.PropietarioItem = Backbone.View.extend({
    tagName: "tr",
    template: _.template($('#propietarios_item').html()),
      events: {
      "click": "editar",
      "click .ver": "editar",
      "click .delete": "borrar",
      "click .duplicar": "duplicar"
    },
    initialize: function(options) {
      this.model.bind("change",this.render,this);
      this.model.bind("destroy",this.render,this);
      this.options = options;
      this.permiso = this.options.permiso;
      _.bindAll(this);
    },
    render: function()
    {
      // Creamos un objeto para agregarle las otras propiedades que no son el modelo
      var obj = { permiso: this.permiso };
      // Extendemos el objeto creado con el modelo de datos
      $.extend(obj,this.model.toJSON());

      $(this.el).html(this.template(obj));
      return this;
    },
    editar: function() {
      // Cuando editamos un elemento, indicamos a la vista que lo cargue en los campos
      location.href="app/#propietario/"+this.model.id;
    },
    borrar: function(e) {
      if (confirmar("Realmente desea eliminar este elemento?")) {
        this.model.destroy(); // Eliminamos el modelo
        $(this.el).remove();  // Lo eliminamos de la vista
      }
      e.stopPropagation();
    },
    duplicar: function(e) {
      var clonado = this.model.clone();
      clonado.set({id:null}); // Ponemos el ID como NULL para que se cree un nuevo elemento
      clonado.save({},{
        success: function(model,response) {
          model.set({id:response.id});
        }
      });
      this.model.collection.add(clonado);
      e.stopPropagation();
    }
  });

})( app );



// ----------------------
//   VISTA DE LA TABLA
// ----------------------

(function ( app ) {

  app.views.PropietariosTableView = app.mixins.View.extend({

    template: _.template($("#propietarios_panel_template").html()),

    initialize : function (options) {

      _.bindAll(this); // Para que this pueda ser utilizado en las funciones

      var lista = this.collection;
      this.options = options;
      this.permiso = this.options.permiso;

      // Creamos la lista de paginacion
      var pagination = new app.mixins.PaginationView({
        collection: lista
      });

      // Creamos el buscador
      var search = new app.mixins.SearchView({
        collection: lista
      });

      lista.on('add', this.addOne, this);
      lista.on('all', this.addAll, this);
      
      // Renderizamos por primera vez la tabla:
      // ----------------------------------------
      var obj = { permiso: this.permiso };
      
      // Cargamos el template
      $(this.el).html(this.template(obj));
      // Cargamos el paginador
      $(this.el).find(".pagination_container").html(pagination.el);
      // Cargamos el buscador
      $(this.el).find(".search_container").html(search.el);

      // Vamos a buscar los elementos y lo paginamos
      lista.pager();
    },

    addAll : function () {
      $(this.el).find("tbody").empty();
      this.collection.each(this.addOne);
    },

    addOne : function ( item ) {
      var view = new app.views.PropietarioItem({
        model: item,
        permiso: this.permiso,
      });
      $(this.el).find("tbody").append(view.render().el);
    }

  });
})(app);



// -------------------------------
//   VISTA DEL PANEL DE EDICION
// -------------------------------
(function ( views, models ) {

  views.PropietarioEditView = app.mixins.View.extend({

    template: _.template($("#propietarios_edit_panel_template").html()),

    myEvents: {
      "click .guardar": "guardar",
      "click .nuevo": "limpiar",
    },

    initialize: function(options) {
      this.model.bind("destroy",this.render,this);
      _.bindAll(this);
      this.options = options;
      this.render();
    },

    render: function()
    {
      // Creamos un objeto para agregarle las otras propiedades que no son el modelo
      var edicion = false;
      if (this.options.permiso > 1) edicion = true;
      var obj = { edicion: edicion, id:this.model.id };
      // Extendemos el objeto creado con el modelo de datos
      $.extend(obj,this.model.toJSON());

      $(this.el).html(this.template(obj));

      return this;
    },

    validar: function() {
      try {
        // Validamos los campos que sean necesarios
        validate_input("propietarios_nombre",IS_EMPTY,"Por favor, ingrese un nombre.");
        // No hay ningun error
        $(".error").removeClass("error");
        return true;
      } catch(e) {
        return false;
      }
    },
    

    guardar: function() 
    {
      var self = this;
      if (this.validar()) {
        if (this.model.id == null) {
          this.model.set({id:0});
        }
        this.model.save({
            "id_empresa":ID_EMPRESA,
          },{
          success: function(model,response) {
            window.history.back();
          }
        });
      }
    },
    
    limpiar : function() {
      this.model = new app.models.Propietario()
      this.render();
    },
    
  });

})(app.views, app.models);




(function ( views, models ) {

  views.PropietarioEditViewMini = app.mixins.View.extend({

    template: _.template($("#propietarios_edit_mini_panel_template").html()),

    myEvents: {
      "click .guardar": "guardar",
      "click .cerrar": "cerrar",
      "keyup #clientes_mini_nombre":function() {
        // Tenemos enlazada la referencia, por lo que cada vez que escribimos algo, debemos cambiar el input original
        if (this.input != undefined) {
          $(this.input).val($(this.el).find("#clientes_mini_nombre").val());
        }
      },
      "keypress .tab":function(e) {
        if (e.keyCode == 13) {
          $(e.currentTarget).parent().next().find(".tab").focus();
        }
      },
      "keyup .tab":function(e) {
        if (e.which == 27) this.cerrar();
      }
    },

    initialize: function(options) {
      this.model.bind("destroy",this.render,this);
      _.bindAll(this);
      this.options = options;
      this.input = this.options.input;
      this.render();
    },

    render: function() {
      var self = this;
      $(this.el).html(this.template(this.model.toJSON()));
      if (this.input != undefined) {
        // Seteamos lo que tiene el input de referencia
        $(this.el).find("#clientes_mini_nombre").val($(this.input).val().trim());
      }
      return this;
    },
    
    focus: function() {
      $(this.el).find("#clientes_mini_nombre").focus();
    },

    validar: function() {
      try {
        validate_input("propietarios_mini_nombre",IS_EMPTY,"Por favor, ingrese un nombre.");
        $(".error").removeClass("error");
        return true;
      } catch(e) {
        return false;
      }
    },

    guardar: function() 
    {
      var self = this;
      if (this.validar()) {
        if (this.model.id == null) {
          this.model.set({id:0});
        }
        this.model.save({
            "nombre":$("#propietarios_mini_nombre").val(),
            "telefono":$("#propietarios_mini_telefono").val(),
            "celular":$("#propietarios_mini_celular").val(),
            "email":$("#propietarios_mini_email").val(),
            "direccion":$("#propietarios_mini_direccion").val(),
            "observaciones":$("#propietarios_mini_observaciones").val(),
            "id_empresa":ID_EMPRESA,
          },{
          success: function(model,response) {
            if (response.error == 1) {
              show(response.mensaje);
            } else {
              self.cerrar();
              if (self.options.callback != undefined) self.options.callback(self.model.id);
            }
          }
        });
      }
    },
    
    cerrar: function() {
      $(this.el).parents(".customcomplete").remove();
    },
    
    limpiar : function() {
      this.model = new app.models.Propietario()
      this.render();
    },    
    
  });

})(app.views, app.models);

// -----------
//   MODELO
// -----------

(function ( models ) {

  models.PropiedadGastos = Backbone.Model.extend({
    urlRoot: "gastos",
    defaults: {
      descripcion: "",
      path: "",
      monto: "",
      fecha: "",
      id_empresa: ID_EMPRESA,
      id_propiedad: 0,
      concepto: "",
    },
  });
      
})( app.models );



// ----------------------
//   COLECCION PAGINADA
// ----------------------

(function (collections, model) {

  collections.PropiedadesGastos = Backbone.Collection.extend({
    model: model,
  });

})( app.collections, app.models.PropiedadGastos);

// -----------------------------------------
//   TABLA DE RESULTADOS
// -----------------------------------------
(function ( app ) {

  app.views.PropiedadesGastosTableView = app.mixins.View.extend({

    template: _.template($("#propiedades_gasto_table").html()),
        
    myEvents: {
      "click .buscar":"buscar",
    },
        
    initialize : function (options) {
      var self = this;
      _.bindAll(this); // Para que this pueda ser utilizado en las funciones
      this.options = options;
      this.id_propiedad = (typeof this.options.id_propiedad != "undefined") ? this.options.id_propiedad : 0;
      this.render();
      this.collection.on('all', this.addAll, this);
      this.addAll();
    },

    render: function() {
      $(this.el).html(this.template());
      return this;
    },
        
    addAll : function () {
      window.total_gastos = 0;
      $(this.el).find(".tbody").empty();
      if (this.collection.length > 0) this.collection.each(this.addOne);
      this.$(".total_gastos").html("$ "+Number(window.total_gastos).format(2));
    },
        
    addOne : function ( item ) {
      var self = this;
      var view = new app.views.PropiedadesGastoItemResultados({
        model: item,
        collection: self.collection,
      });
      window.total_gastos += parseFloat(item.get("monto"));
      console.log(window.total_gastos);
      this.$(".tbody").append(view.render().el);
    },
            
  });

})(app);




// -----------------------------------------
//   ITEM DE LA TABLA DE RESULTADOS
// -----------------------------------------
(function ( app ) {
  app.views.PropiedadesGastoItemResultados = app.mixins.View.extend({
        
    template: _.template($("#propiedades_gasto_item").html()),
    tagName: "tr",
    myEvents: {
      "click .data":"seleccionar",
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
      var self = this;
      var v = new app.views.PropiedadGastoEditView({
        model:self.model,
        collection:self.collection,
      });
      crearLightboxHTML({
        "html":v.el,
        "width":600,
        "height":140,
      });
    },
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      this.options = options;
      this.render();
    },
    render: function() {
      $(this.el).html(this.template(this.model.toJSON()));
      return this;
    },
  });
})(app);



(function ( app ) {

  app.views.PropiedadGastoEditView = app.mixins.View.extend({

    template: _.template($("#propiedades_gasto_edit").html()),
            
    myEvents: {
      "click .guardar": "guardar",
      "click .cerrar":function() {
        $('.modal:last').modal('hide');
      },
    },    
                
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      

      var edicion = false;
      var obj = { "id":this.model.id }
      _.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));
    },
        
    validar: function() {
      try {
        var self = this;
        propiedad_gastos
        var fecha = self.$("#propiedades_gastos_fecha").val();
        this.model.set({
          "path": ((self.$("#hidden_path").length > 0) ? self.$("#hidden_path").val() : ""),
          "fecha":fecha,
          "concepto":self.$("#propiedades_gastos_concepto").val(),
        });
         
        $(".error").removeClass("error");
        return true;
      } catch(e) {
        console.log(e);
        return false;
      }
    },  

    guardar:function() {
      var self = this;
      if (this.validar()) {
        if (this.model.id == null) {
          // NO PONEMOS ID = 0, PORQUE SINO NO AGREGA DOS ELEMENTOS CON EL MISMO ID
          var maxId = 0;
          this.collection.each(function(item){
            if (item.id > maxId) maxId = item.id;
          });
          maxId++;
          this.model.set({id:maxId});
        }
        this.collection.add(this.model);
        $('.modal:last').modal('hide');
      }      
    },
          
  });
})(app);

// -----------
//   MODELO
// -----------

(function ( models ) {

  models.PropiedadPermutas = Backbone.Model.extend({
    urlRoot: "permutas",
    defaults: {
      id_empresa: ID_EMPRESA,
      id_propiedad: 0,
      id_tipo_inmueble: 0,
      id_localidad: 0,
      banios: 0,
      cocheras: 0,
      dormitorios: 0,
      precio_maximo: 0,
      inmueble_nombre: "",
      localidad_nombre: "",
    },
  });
      
})( app.models );



// ----------------------
//   COLECCION PAGINADA
// ----------------------

(function (collections, model) {

  collections.PropiedadesPermutas = Backbone.Collection.extend({
    model: model,
  });

})( app.collections, app.models.PropiedadPermutas);

// -----------------------------------------
//   TABLA DE RESULTADOS
// -----------------------------------------
(function ( app ) {

  app.views.PropiedadesPermutasTableView = app.mixins.View.extend({

    template: _.template($("#propiedades_permutas_table").html()),
        
    myEvents: {
      "click .buscar":"buscar",
    },
        
    initialize : function (options) {
      var self = this;
      _.bindAll(this); // Para que this pueda ser utilizado en las funciones
      this.options = options;
      this.id_propiedad = (typeof this.options.id_propiedad != "undefined") ? this.options.id_propiedad : 0;
      this.render();
      this.collection.on('all', this.addAll, this);
      this.addAll();
    },

    render: function() {
      $(this.el).html(this.template());
      return this;
    },
        
    addAll : function () {
      window.total_gastos = 0;
      $(this.el).find(".tbody").empty();
      if (this.collection.length > 0) this.collection.each(this.addOne);
      this.$(".total_gastos").html("$ "+Number(window.total_gastos).format(2));
    },
        
    addOne : function ( item ) {
      var self = this;
      var view = new app.views.PropiedadesPermutasItemResultados({
        model: item,
        collection: self.collection,
      });
      this.$(".tbody").append(view.render().el);
    },
            
  });

})(app);




// -----------------------------------------
//   ITEM DE LA TABLA DE RESULTADOS
// -----------------------------------------
(function ( app ) {
  app.views.PropiedadesPermutasItemResultados = app.mixins.View.extend({
        
    template: _.template($("#propiedades_permutas_item").html()),
    tagName: "tr",
    myEvents: {
      "click .data":"seleccionar",
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
      var self = this;
      var v = new app.views.PropiedadPermutasEditView({
        model:self.model,
        collection:self.collection,
      });
      crearLightboxHTML({
        "html":v.el,
        "width":600,
        "height":140,
      });
    },
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      this.options = options;
      this.render();
    },
    render: function() {
      $(this.el).html(this.template(this.model.toJSON()));
      return this;
    },
  });
})(app);



(function ( app ) {

  app.views.PropiedadPermutasEditView = app.mixins.View.extend({

    template: _.template($("#propiedades_permutas_edit").html()),
            
    myEvents: {
      "click .guardar": "guardar",
      "click .cerrar":function() {
        $('.modal:last').modal('hide');
      },
    },    
                
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      

      var edicion = false;
      var obj = { "id":this.model.id }
      _.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));

      new app.mixins.Select({
        modelClass: app.models.Localidad,
        url: "localidades/function/utilizadas/?id_empresa="+ID_EMPRESA+"&id_proyecto="+ID_PROYECTO,
        render: "#propiedades_buscar_localidades",
        firstOptions: ["<option value='0'>Localidad</option>"],
        selected: self.model.get("id_localidad"),
        onComplete:function(c) {
          crear_select2("propiedades_buscar_localidades");
        }
      });  


      new app.mixins.Select({
        modelClass: app.models.TipoInmueble,
        url: "tipos_inmueble/",
        render: "#propiedades_buscar_tipos_inmueble",
        firstOptions: ["<option value='0'>Tipo de Inmueble</option>"],
        selected: self.model.get("id_tipo_inmueble"),
        onComplete:function(c) {
          crear_select2("propiedades_buscar_tipos_inmueble");
        }
      });  


    },
        
    validar: function() {
      try {
        var self = this;
  
        var id_localidad = self.$("#propiedades_buscar_localidades").val();
        var id_tipo_inmueble = self.$("#propiedades_buscar_tipos_inmueble").val();

        if (id_localidad == 0) {
          alert ("Por favor ingrese una localidad");
          return false;
        }

        if (id_tipo_inmueble == 0) {
          alert ("Por favor ingrese un tipo de inmueble");
          return false;
        }

        this.model.set({
          "id_localidad":id_localidad,
          "id_tipo_inmueble":id_tipo_inmueble,
          "inmueble_nombre": self.$("#propiedades_buscar_localidades option:selected").text(),
          "localidad_nombre": self.$("#propiedades_buscar_tipos_inmueble option:selected").text(),
        });
         
        $(".error").removeClass("error");
        return true;
      } catch(e) {
        console.log(e);
        return false;
      }
    },  

    guardar:function() {
      var self = this;
      if (this.validar()) {
        if (this.model.id == null) {
          // NO PONEMOS ID = 0, PORQUE SINO NO AGREGA DOS ELEMENTOS CON EL MISMO ID
          var maxId = 0;
          this.collection.each(function(item){
            if (item.id > maxId) maxId = item.id;
          });
          maxId++;
          this.model.set({id:maxId});
        }
        this.collection.add(this.model);
        $('.modal:last').modal('hide');
      }      
    },
          
  });
})(app);



(function ( models ) {

  models.PropiedadDesactivar = Backbone.Model.extend({
    urlRoot: "propiedad_desactivar",
    defaults: {
      id_empresa: ID_EMPRESA,
      id_propiedad: 0,
      id_usuario: 0,
      fecha: moment().format("YYYY-MM-DD HH:ii:ss"),
      motivo: 0,
      observacion: "",
      id_empresa_colega: 0,
      precio_vendido: 0,
    },
  });
      
})( app.models );



(function ( app ) {

  app.views.PropiedadDesactivar = app.mixins.View.extend({

    template: _.template($("#propiedades_desactivar").html()),
            
    myEvents: {
      "click .guardar": "guardar",
      "click .cerrar_lightbox":function() {
        $('.modal:last').modal('hide');
      },
      "change #propiedades_desactivar_motivo":function(){
        var self = this;
        var motivo = $("#propiedades_desactivar_motivo").val();
        if (motivo == 1 || motivo == 2) {
            $(".precio").removeClass("dn");
          if (motivo == 2) {
            $(".red").removeClass("dn");
          } else {
            $(".red").addClass("dn");
          }
        } else {
          $(".precio").addClass("dn");
          $(".red").addClass("dn");
        }
      },
    },    
                
    initialize: function(options) {
      var self = this;
      _.bindAll(this);
      

      var edicion = false;
      var obj = { "id":this.model.id }
      _.extend(obj,this.model.toJSON());
      $(this.el).html(this.template(obj));

      this.$("#propiedades_buscar_inmobiliarias").select2();
    },
        
    validar: function() {
      try {
        var self = this;

        var motivo = $("#propiedades_desactivar_motivo").val();
        if (motivo == 0) {
          alert ("Por favor ingrese un motivo");
          return false;
        }

        var precio_venta = $("#propiedades_precio_venta").val();
        if ((motivo == 1 || motivo == 2) && precio_venta == 0) {
          alert ("Por favor ingrese un precio de venta");
          return false;          
        }

        var buscar_inmobiliaria = self.$("#propiedades_buscar_inmobiliarias").val();
        if (motivo == 2 && buscar_inmobiliaria == 0) {
          alert ("Por favor ingrese un colega de la red");
          return false;          
        }

        var observacion = $("#propiedades_desactivar_observacion").val();

        var id_empresa_colega = 0;
        var precio_vendido = 0;

        if (motivo == 1 || motivo == 2) {
          precio_vendido = $("#propiedades_precio_venta").val();
          if (motivo == 2) {
            id_empresa_colega = self.$("#propiedades_buscar_inmobiliarias").val();
          } 
        }

        this.model.set({
          "observacion": observacion,
          "motivo": motivo,
          "id_empresa_colega": id_empresa_colega,
          "precio_vendido": precio_vendido,
        });


        $(".error").removeClass("error");
        return true;
      } catch(e) {
        console.log(e);
        return false;
      }
    },  

    guardar:function() {
      var self = this;
      if (this.validar()) {
        this.model.save({
            "id_empresa":ID_EMPRESA,
          },{
          success: function(model,response) {
            if (response.error == 1) {
              show(response.mensaje);
            } else {
              $('.modal:last').modal('hide');
            }
          }
        });
      }      
    },
          
  });
})(app);