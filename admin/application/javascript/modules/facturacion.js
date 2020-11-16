// -----------
//   MODELO
// -----------

(function ( models ) {

  models.Factura = Backbone.Model.extend({
    urlRoot: "facturas/",
    defaults: {
      fecha: "",
      fecha_vto: "",
      tipo: "", // TODO: Indica si es Comprobante o Pago
      id_punto_venta: 0,
      punto_venta: 0,
      id_cliente: 0,
      id_vendedor: 0,
      id_empresa: 0,
      id_caja_diaria: 0,
      estado: 0,
      cliente: "Consumidor Final",
      numero: 0,
      subtotal: 0,
      total: 0,
      neto: 0,
      porc_descuento: 0,
      descuento: 0,
      iva: 0,
      id_tipo_comprobante: 0,
      efectivo: 0,
      cta_cte: 0,
      credito: 0,
      vuelto: 0,
      tarjeta: 0,
      cheque: 0,
      reparto: 1,
      pendiente: 0,
      fecha_reparto: "",
      items: [],
      ivas: [],
      tarjetas: [],
      cheques: [],
      creditos_personales: [],
      ofertas: [],
      bonificaciones: [],
      total_ofertas: 0,
      observaciones: "",
      gestiona_stock: 0, // TODO: este parametro debe ser configurable
      cotizacion_dolar: 0,
      id_remito: 0,
      numero_remito: 0,
      enviada: 0,
      visto: 0,
      percep_viajes: 0, // Percepcion sobre viajes al exterior 5% sobre pago efectivo
      impuesto_pais: 0, // Nueva percepcion FLAMINGO
      percepcion_ib: 0,
      direccion: "",
      localidad: "",
      id_localidad: 0,
      codigo_postal: "",
      interes: 0,
      id_tipo_estado: ((ID_EMPRESA == 1317) ? 3 : 6), // Por defecto, las ventas que se hacen desde el panel de control se finalizan
      id_sucursal:ID_SUCURSAL,
      sucursal: "",
      vendedor: "",
      usuario: NOMBRE_USUARIO,
      tipo_punto_venta: "",
      tipo_comprobante: "",
      vencimiento: "",
      id_origen: 0, // 0 = LOCAL, 1 = WEB, 2 = ML, 3 = APP
      impresa: 0,
      nueva: 0,
      numero_paso: 0,
      forma_envio: "",
      coordinar_envio: 0,
      costo_neto: 0,
      costo_final: 0,
      tipo_pago: "E",

      custom_5: "", // Utilizado como comentarios privados
      custom_6: "", // Utilizado como "estado de envio"
      // "" = Pendiente
      // "1" = Proceso de armado
      // "2" = Listo para enviar
      // "3" = En transito
      // "4" = Entregado

      es_periodica: 0,
      periodo_cantidad: 1,
      periodo_tipo: 'M',
      periodo_dia: 1,
      dias_vencimiento: 10,

      id_concepto: 0,
    }
  });
    
})( app.models );



(function ( models ) {

  models.FacturaItem = Backbone.Model.extend({
    urlRoot: "facturas_items/",
    defaults: {
      id_factura: 0,
      id_articulo: 0,
      tipo_cantidad: "",
      cantidad: 0,
      porc_iva: 0,
      id_tipo_alicuota_iva: 0,
      neto: 0,  // Unitario
      precio: 0,  // Unitario
      nombre: "",
      descripcion: "",
      orden: 0,
      id_rubro: 0,
      iva: 0,
      total_sin_iva: 0, // Totales (unitario * cantidad)
      total_con_iva: 0,
      anulado: 0,
      costo_final: 0,
      id_variante: 0,
      variante: "",
    }
  });
    
})( app.models );





// -------------------------------
//   VISTA DEL PANEL DE EDICION
// -------------------------------
(function ( views, models ) {

  views.FacturaEditView = app.mixins.View.extend({

  template: _.template($("#facturacion_edit_panel_template").html()),

  myEvents: {
    "click .aceptar": "aceptar",
    "click .anular": "anular",
    "click #facturacion_nuevo_cliente":"nuevo_cliente",
    "click .imprimir": function(){
      this.imprimir(this.model.id,this.model.get("id_punto_venta"),null,false);
    },
    "click .enviar":function() {
      var id = this.model.id;
      var links_adjuntos = new Array();
      links_adjuntos.push({
        tipo: 0,
        id_objeto: id,
        nombre: this.model.get("comprobante"),
      });
      var email = new app.models.Consulta({
        links_adjuntos:links_adjuntos,
        asunto:"Factura Electronica",
        texto: "",
      });
      workspace.nuevo_email(email);        
    },
    "click #facturacion_sincronizar_numero":"sincronizar_numero", 
    "click #facturacion_buscar_articulo":"ver_buscar_articulo",
    "click #facturacion_consultar_articulo":"ver_consultar_articulo",
    "click #agregar_item": "agregar_item",
    "change #facturacion_fecha_reparto":"cambiar_numero_reparto",

    "click .convertir_factura":function() {
      var self = this;
      var id = self.model.id;
      var id_punto_venta = self.model.get("id_punto_venta");
      $.ajax({
        "url":"facturas/function/convertir_factura/",
        "type":"post",
        "data":{
          "id_punto_venta":id_punto_venta,
          "id_factura":id,
        },
        "dataType":"json",
        "success":function(r) {
          if (r.error == 0) {
            workspace.imprimir_factura(id,id_punto_venta,"E",function(){
              location.reload();
            });
          } else alert(r.mensaje);
        }
      });
    },

    "change #facturacion_tipo_pago":function(e){
      if (this.$("#facturacion_tipo_pago").val() == "E") {
        this.$("#facturacion_forma_pago_factura").html("Efectivo");
        this.model.set({"tipo_pago":"E"});
      } else if (this.$("#facturacion_tipo_pago").val() == "C") {
        this.$("#facturacion_forma_pago_factura").html("Cuenta Corriente");
        this.model.set({"tipo_pago":"C"});
      } else if (this.$("#facturacion_tipo_pago").val() == "T") {
        this.$("#facturacion_forma_pago_factura").html("Tarjeta");
        this.model.set({"tipo_pago":"T"});
      } else if (this.$("#facturacion_tipo_pago").val() == "H") {
        this.$("#facturacion_forma_pago_factura").html("Cheque");
        this.model.set({"tipo_pago":"H"});
      } else if (this.$("#facturacion_tipo_pago").val() == "B") {
        this.$("#facturacion_forma_pago_factura").html("Banco");
        this.model.set({"tipo_pago":"B"});
      } else if (this.$("#facturacion_tipo_pago").val() == "O") {
        this.$("#facturacion_forma_pago_factura").html("Otro");
        this.model.set({"tipo_pago":"O"});
      }
    },

    "change .eliminar":function(e) {
      // Marca la fila completa cuando el radio esta seleccionado
      $(e.currentTarget).parents("tbody").find("tr").removeClass("seleccionado");
      if ($(e.currentTarget).is(":checked")) {
        $(e.currentTarget).parents("tr").addClass("seleccionado"); 
      }
    },

    "change #facturacion_es_periodica":function(e) {
      if ($(e.currentTarget).is(":checked")) {
        this.$("#facturacion_periodica_opciones").slideDown();
      } else {
        this.$("#facturacion_periodica_opciones").slideUp();
      }
    },

    "change #facturacion_tipo":function() {
      this.set_numero_comprobante();
    },


      // PARA ELIMINAR LOS PRODUCTOS
      /*
      "click .eliminar_item":function(e) {
        // Cuando presiona ENTER, elimina la fila
        if (FACTURACION_CONSULTAR_ELIMINAR_ITEM == 1) {
          if (confirm("Realmente desea eliminar el elemento?")) {
            this.eliminar_item($(e.currentTarget).data("orden"));
          }
        } else this.eliminar_item($(e.currentTarget).data("orden"));
      },
      "focus .eliminar_item":function(e) {
        $(e.currentTarget).parents("tbody").find("tr").removeClass("fila_roja");
    $(e.currentTarget).parents("tr").addClass("fila_roja");
    $(e.currentTarget).prop("checked",true);
    $("#tabla_items").parent().scrollTo($('.eliminar_item:checked').parent(),0);
      },
    "blur .eliminar_item":function(e) {
    $(e.currentTarget).parents("tbody").find("tr").removeClass("fila_roja");
    $(".eliminar_item").prop("checked",false);
    },
    */

    "change #facturacion_item_cantidad": function() {
      this.calcular_item();
    },
    "change #facturacion_item_neto": "calcular_item",
    "change #facturacion_item_precio": "calcular_item",
    "change #facturacion_alicuotas_iva": "calcular_item",
    "change #facturacion_item_bonificado": "calcular_item",
    "click #facturacion_agregar_item": "agregar_item",
    "change #facturacion_porc_percepcion_ib": function(){
      var porc_ib = this.$("#facturacion_porc_percepcion_ib").val();
      this.cliente.set({"percepcion_ib":porc_ib});
      this.calcular_totales();
    },
    
    "click .importar_factura": "ver_buscar_comprobantes",
    "click .importar_presupuesto": "ver_buscar_presupuestos",

    "focusin #facturacion_codigo_articulo":function() {
      $("#tabla_items tbody tr.seleccionado").removeClass('seleccionado');
      $("#tabla_items tbody tr .radio").prop("checked",false);
    },

    "keypress #facturacion_codigo_cliente":function(e) {
      if (e.which == 13) { this.buscar_cliente(); $("#facturacion_codigo_articulo").select(); }
    },
    "focusout #facturacion_codigo_cliente":function(e){
      if (typeof this.cliente != "undefined") {
        var nombre = this.cliente.get("nombre");
        var texto = $(e.currentTarget).val();
        if (nombre != texto) {
        // Blanqueamos el cliente para que no haya confusion
        $(e.currentTarget).val("");
        }
      }
    },
    
    "click #facturacion_buscar_cliente": "ver_buscar_cliente",
    "click #facturacion_agregar_cliente": "nuevo_cliente",

    "keyup #facturacion_reparto":function(e) {
      if (e.which == 13) { this.$("#facturacion_codigo_articulo").select(); }
    },
    
    "keypress #facturacion_codigo_articulo": function(e) {
      if (e.which == 13)  { this.buscar_articulo(); }
    },
    "keyup #facturacion_codigo_articulo": function(e) {
      if (e.which == 107 && controlador_fiscal != "") {
        this.aceptar(); this.$("#facturacion_codigo_articulo").val("");
      }
    },
    "keypress #facturacion_item_descripcion":function(e) {
      if (e.which == 13)  {
        $("#facturacion_item_cantidad").select();
      }
    },
    "keypress #facturacion_costo_final":function(e) {
      if (e.which == 13)  {
        $("#facturacion_item_precio").select();
      }
    },
    "keypress #facturacion_item_cantidad":function(e) {
      if (e.which == 13)  {
        if (this.$("#facturacion_variantes option").length > 0) {
          this.$("#facturacion_variantes").focus();
        } else {
          if (this.discrimina_iva()) {
            $("#facturacion_item_neto").select();
          } else {
            $("#facturacion_item_precio").select();
          }
        }
      }        
    },
    "keydown #facturacion_variantes":function(e) {
      if (e.which == 13) {
        e.preventDefault();
        if (this.discrimina_iva()) {
          $("#facturacion_item_neto").select();
        } else {
          $("#facturacion_item_precio").select();
        }
      }
    },
      
    // CARTELES DE AYUDA
    "click .buscar_clientes_ayuda":function() {
      var ayuda = new app.views.AyudaView({
        model: new app.models.AbstractModel()
      });
      var html = "Es posible asignar un cliente a un comprobante de diferentes maneras: <br/>";
      html+= "<ul style='padding-left: 30px'>";
      html+= "<li>A trav&eacute;s de su c&oacute;digo interno, y luego presionar la tecla Enter.</li>";
      html+= "<li>Escribiendo parte de su nombre y seleccion&aacute;ndolo luego en la lista de sugerencias.</li>";
      html+= "<li>Si es un cliente nuevo, que a&uacute;n no esta cargado en su lista de contactos, puede escribir parte de su nombre y luego hacer click en el bot&oacute;n Nuevo que aparece en la lista de sugerencias. De esta manera podr&aacute; cargar r&aacute;pidamente un nuevo cliente sin tener que salir de la pantalla del comprobante.</li>";
      html+= "</ul>";
      ayuda.setText(html);
      crearLightboxHTML({
        "html":ayuda.el,
        "width":600,
        "height":300,
      });
    },
      
    "click .observaciones_ayuda":function() {
      var ayuda = new app.views.AyudaView({
        model: new app.models.AbstractModel()
      });
      var html = "Escriba aqu&iacute; la nota al pie de p&aacute;gina para sus comprobantes. Puede utilizar las siguientes variables que se reemplazar&aacute;n con los valores correspondientes: <br/>";
      html+= "<ul style='padding-left: 30px'>";
      html+= "<li>{{TOTAL_EN_LETRAS}} = Total de la factura expresado en letras.</li>";
      html+= "<li>{{TOTAL_EN_DOLARES}} = Valor correspondiente en dolares del total del comprobante.</li>";
      html+= "<li>{{TOTAL_EN_DOLARES_EN_LETRAS}} = Valor correspondiente en dolares del total del comprobante, pero expresado en letras.</li>";
      html+= "</ul>";
      ayuda.setText(html);
      crearLightboxHTML({
        "html":ayuda.el,
        "width":600,
        "height":300,
      });
    },
    
    // ACCIONES SOBRE EL FORMULARIO
    "keyup .action":function(e) {
      if (e.which == 120) { e.preventDefault(); e.stopPropagation(); this.ver_buscar_articulo(); return false; } // F9
      //if (e.which == 118) { this.anular(); } // F7
    },
    "keydown .action":function(e) {
      if (e.which == 113) { e.preventDefault(); e.stopPropagation(); workspace.cambiar_estado(); return false; } // F2
      if (e.which == 115) { e.preventDefault(); e.stopPropagation(); this.ver_buscar_cliente(); return false; } // F4
      if (e.which == 119) { e.preventDefault(); e.stopPropagation(); this.ver_mostrar_precio_articulo(); return false; } // F8
    },
      
    "keypress #facturacion_item_precio": function(e) {
      if (e.keyCode == 13) { this.$("#facturacion_item_bonificado").select(); }
    },
    "keypress #facturacion_item_neto": function(e) {
      if (e.keyCode == 13) { this.$("#facturacion_item_bonificado").select(); }
    },
    "keypress #facturacion_item_bonificado": function(e) {
      if (e.keyCode == 13) { this.agregar_item(); }
    },
    
    //"focusout #facturacion_porc_descuento": "controlar_descuento",
    "change #facturacion_porc_descuento": "controlar_descuento",
    
    "change #facturacion_puntos_venta":function(e) {
      this.$("#nombre_punto_venta").html($(e.currentTarget).find("option:selected").data("nombre"));
      this.buscar_numeros();
    },    

    "click .descuento_efectivo_mega":"descuento_efectivo_mega",
    "click .oferta_cubiertos_mega":"oferta_cubiertos_mega",
    "click .oferta_cubiertero_mega":"oferta_cubiertero_mega",
    "click .oferta_platos_mega":"oferta_platos_mega",
  },

  controlar_descuento: function() {
    this.calcular_totales();
  },
    
  imprimir: function(id,id_punto_venta,tipo_impresion,limpiar_despues) {
    var self = this;
    var lim = limpiar_despues;
    if (tipo_impresion == undefined) tipo_impresion = "E";
    tipo_impresion = "P";
    if (lim == undefined) lim = false;
    workspace.imprimir_factura(id,id_punto_venta,tipo_impresion,function(){
      if (lim == true) {
        self.do_limpiar();
      }
    });
  },

  do_limpiar: function() {
    var self = this;
    self.limpiar();
    $("#facturacion_codigo_articulo").val("");
    $("#facturacion_codigo_cliente").select();  
  },
    
  ver_buscar_cliente: function() {
    var self = this;
    var clientes = new app.collections.Clientes();
      app.views.buscarClientes = new app.views.ClientesTableView({
      collection: clientes,
      habilitar_seleccion: true,
    });
    delete window.codigo_cliente_seleccionado;
    var d = $("<div/>").append(app.views.buscarClientes.el);
    crearLightboxHTML({
      "html":d,
      "width":860,
      "height":500,
      "callback":function() {
        if (window.codigo_cliente_seleccionado != undefined && window.codigo_cliente_seleccionado != -1) {
          var that = self;
          var cliente = new app.models.Clientes({"id":window.cliente_seleccionado.id});
          cliente.fetch({
            "success":function(){
              that.seleccionar_cliente(cliente);
            },
          });
        }
        $("#facturacion_codigo_articulo").select();          
      }
    });
    $("#clientes_buscar").focus();
  },

  nuevo_cliente: function() {
    var self = this;
    var c = new app.views.ClienteEditViewMini({
      model: new app.models.Clientes({
        id_tipo_documento: (ID_EMPRESA == 1354 ? 99 : 80),
        id_tipo_iva: (ID_EMPRESA == 1354 ? 4 : 1),
        id_sucursal: ID_SUCURSAL,
      }),
      onSave: function(cli){
        self.seleccionar_cliente(cli);
        $('.modal:last').modal('hide');
      }
    });
    crearLightboxHTML({
      "html":c.el,
      "width":600,
      "height":500,
    });
    $("#clientes_mini_nombre").focus();
  },
    
  ver_buscar_comprobantes: function() {
    var self = this;
    window.factura_seleccionada = null;
    app.views.ventasTableView = new app.views.VentasTableView({
      collection: new app.collections.Ventas(),
      habilitar_seleccion: true,
      parent: self,
    });
    var d = $("<div/>").append(app.views.ventasTableView.el);
    crearLightboxHTML({
      "html":d,
      "width":860,
      "height":500,
      "callback":function() {
        if (window.factura_seleccionada == null) return;
        self.importar(window.factura_seleccionada);
      }
    });
    $("#ventas_listado_buscar").focus();
  },

  ver_buscar_presupuestos: function() {
    var self = this;
    window.presupuesto_seleccionado = null;
    app.views.presupuestosTableView = new app.views.PresupuestosTableView({
      collection: new app.collections.Presupuestos(),
      habilitar_seleccion: true,
      parent: self,
    });
    var d = $("<div/>").append(app.views.presupuestosTableView.el);
    crearLightboxHTML({
      "html":d,
      "width":860,
      "height":500,
      "callback":function() {
        if (window.presupuesto_seleccionado == null) return;
        self.importar_presupuesto(window.presupuesto_seleccionado);
      }
    });
    $("#ventas_listado_buscar").focus();
  },  
    
  importar: function(model) {
    var self = this;
    var factura = new app.models.Factura({
      "id": model.id,
    });
    factura.fetch({
      "success":function(){

        var that = self;

        if (factura.get("id_cliente") != 0) {
          var cliente = new app.models.Clientes({"id":factura.get("id_cliente")});
          cliente.fetch({
            "success":function() {
              self.seleccionar_cliente(cliente);
            },
          });          
        }

        // Creamos una nueva coleccion de items
        var ItemsCollection = Backbone.Collection.extend({
          model: app.models.FacturaItem
        });
        var productos = factura.get("items");
        self.items = new ItemsCollection();
        for(var i=0;i<productos.length;i++) {
          var p = productos[i];
          p.discrimina_iva = self.discrimina_iva();
          p.id_factura = 0;
          var fi = new app.models.FacturaItem(p);
          self.items.add(fi);
        }
        self.items.on('all', self.render_tabla_items, self);
        self.items.on('add', self.addItem, self);
        
        self.render();
        self.render_view();
        self.render_tabla_items();

        if (factura.get("id_cliente") == 0) {
          self.setear_consumidor_final();
        }
        //self.set_numero_comprobante();
      }
    });
    
    /*
    this.model = model.clone();
    this.model.set({
      "ivas":[],
    });
    this.listenTo(this.model,"change",this.render_view); // Si el modelo cambia, renderizamos la vista
    window.factura = this.model; // TODO: borrar esto desp
    
    // Creamos una nueva coleccion de items
    var ItemsCollection = Backbone.Collection.extend({
      model: app.models.FacturaItem,
    });
    this.items = new ItemsCollection();
    this.items.on('all', this.render_tabla_items, this);
    this.items.on('add', this.addItem, this);
    window.items = this.items;
    
    // Renderizamos y limpiamos
    this.render();
    if (control.check("repartos")>0 == 1) this.cambiar_numero_reparto();
    this.buscar_cliente();
    */
  },

  importar_presupuesto: function(model) {
    var self = this;
    var presupuesto = new app.models.Presupuesto({
      "id": model.id,
    });
    presupuesto.fetch({
      "success":function(){

        var that = self;
        if (factura.get("id_cliente") != 0) {
          var cliente = new app.models.Clientes({"id":presupuesto.get("id_cliente")});
          cliente.fetch({
            "success":function() {
              cliente.set({"descuento":presupuesto.get("porc_descuento")});
              self.seleccionar_cliente(cliente);
            },
          });
        }

        // Creamos una nueva coleccion de items
        var ItemsCollection = Backbone.Collection.extend({
          model: app.models.FacturaItem
        });
        var productos = presupuesto.get("items");
        self.items = new ItemsCollection();
        for(var i=0;i<productos.length;i++) {
          var p = productos[i];
          p.id_departamento = 0;
          p.tipo = "";
          p.percep_viajes = 0;
          p.custom_1 = "";
          p.custom_2 = "";
          p.custom_3 = "";
          p.custom_4 = "";
          p.id_proveedor = 0;
          p.id_factura = 0;
          p.variantes = [];
          p.discrimina_iva = self.discrimina_iva();
          p.total_sin_iva = p.precio * p.cantidad;
          p.total_con_iva = p.neto * p.cantidad;
          var fi = new app.models.FacturaItem(p);
          self.items.add(fi);
        }
        self.items.on('all', self.render_tabla_items, self);
        self.items.on('add', self.addItem, self);

        var porc_descuento = parseFloat(presupuesto.get("porc_descuento"));
        self.model.set({"porc_descuento":porc_descuento});

        self.render();
        self.render_view();
        self.render_tabla_items();

        if (factura.get("id_cliente") == 0) {
          self.setear_consumidor_final();
        }
      }
    });
  },

  buscar_cliente : function() {
    var self = this;
    
    var codigo = this.$("#facturacion_codigo_cliente").val();
    if (isEmpty(codigo)) {
      codigo = 0;
      this.$("#facturacion_codigo_cliente").val(codigo);
    }
    // Es consumidor final, creamos el cliente directamente
    if (codigo == 0) {
      this.setear_consumidor_final();
    } else {
      // Buscamos el cliente por al codigo (EL CODIGO DEBE SER SOLO NUMERICO)
      codigo = parseInt(codigo);
      if (!isNaN(codigo)) {
        $.ajax({
          "url":"clientes/function/get_by_codigo/",
          "data":{
            "codigo":codigo,
          },
          "dataType":"json",
          "success":function(r) {
            if (r.length == 0) {
              show("No existe un cliente con el codigo: '"+codigo+"'");
              self.$("#facturacion_codigo_cliente").select();
              self.$("#facturacion_codigo_cliente").focus();
              return;
            }
            var cliente = new app.models.Clientes(r);
            self.seleccionar_cliente(cliente);
          }
        });
      }
    }
    this.$("#facturacion_codigo_articulo").focus();  
  },
    
  setear_consumidor_final: function() {
    var cf = new app.models.Clientes({
      "id_tipo_iva":4,
      "nombre":"Consumidor Final",
      "cuit":"",
      "saldo":0,
      "email":"",
      "direccion":"",
      "percibe_ib":0,
      "descuento":0,
      "error":0,
      "id_vendedor":0,
      "lista":0,
      "tipo_pago":"E",
      "etiquetas":[],
    });      
    this.seleccionar_cliente(cf);
  },
    
  seleccionar_cliente: function(r) {
    var self = this;
    self.cliente = r; // Seteamos el cliente
    self.chequear_comprobantes();
    if (this.model.id == undefined || this.model.id == 0) self.set_numero_comprobante();
    
    // Recorremos los elementos de la coleccion
    if (this.items.size() > 0) {
      var discrimina_iva = this.discrimina_iva();
      this.items.each(function(e){
        e.set({ "discrimina_iva":discrimina_iva });
      });        
    }
    
    if (self.model.isNew()) {
      // Si es un comprobante nuevo, tomamos el descuento del cliente
      self.$("#facturacion_porc_descuento").val(self.cliente.get("descuento"));
      if (self.$("#facturacion_lista").length > 0) self.$("#facturacion_lista").val(self.cliente.get("lista"));
      if (self.cliente.get("id_vendedor") != 0) self.$("#facturacion_vendedores").val(self.cliente.get("id_vendedor"));
      // Seteamos el tipo de pago de acuerdo al configurado en el cliente
      var forma_pago = self.cliente.get("forma_pago");
      if (ID_EMPRESA == 1317) forma_pago = "C";
      if (isEmpty(forma_pago)) forma_pago = "C";
      self.model.set({ "tipo_pago": forma_pago });
    } else {
      // Sino tomamos el descuento del comprobante, ya que puede haber sido cambiado
      self.$("#facturacion_porc_descuento").val(self.model.get("porc_descuento"));
    }

    if (isEmpty(self.model.get("localidad"))) {
      self.$("#facturacion_cliente_localidad").html(self.cliente.get("localidad"));
      self.$("#facturacion_localidad").val(self.cliente.get("localidad"));
      self.$("#facturacion_codigo_postal").val(self.cliente.get("codigo_postal"));
    }

    self.render_view();
    self.$("#facturacion_codigo_articulo").focus();

    // Por si el cliente tiene descuento, hay que llamar al calcular totales
    self.calcular_totales();

    // Para cerrar el customcomplete que se abre
    setTimeout(function(){
    self.$('#facturacion_codigo_cliente').trigger(jQuery.Event('keyup', {which: 27}));
    },500);
  },
    
  // Actualizamos la vista con los datos del modelo
  render_view: function() {

    var self = this;
    
    // Mostramos el nombre de comprobante que corresponde
    var id_tipo_comprobante = parseInt(this.model.get("id_tipo_comprobante"));
    switch (id_tipo_comprobante) {
      case 1:
        this.$(".invoice-type").html("Factura"); this.$(".letter").html("A"); break;
      case 2:
        this.$(".invoice-type").html("Nota de D&eacute;bito"); this.$(".letter").html("A"); break;
      case 3:
        this.$(".invoice-type").html("Nota de Cr&eacute;dito"); this.$(".letter").html("A"); break;
      case 4:
        this.$(".invoice-type").html("Recibo"); this.$(".letter").html("A"); break;
      case 6:
        this.$(".invoice-type").html("Factura"); this.$(".letter").html("B"); break;
      case 7:
        this.$(".invoice-type").html("Nota de D&eacute;bito"); this.$(".letter").html("B"); break;
      case 8:
        this.$(".invoice-type").html("Nota de Cr&eacute;dito"); this.$(".letter").html("B"); break;
      case 9:
        this.$(".invoice-type").html("Recibo"); this.$(".letter").html("B"); break;
      case 11:
        this.$(".invoice-type").html("Factura"); this.$(".letter").html("C"); break;
      case 12:
        this.$(".invoice-type").html("Nota de D&eacute;bito"); this.$(".letter").html("C"); break;
      case 13:
        this.$(".invoice-type").html("Nota de Cr&eacute;dito"); this.$(".letter").html("C"); break;
      case 15:
        this.$(".invoice-type").html("Recibo"); this.$(".letter").html("C"); break;
      case 19:
        this.$(".invoice-type").html("Factura"); this.$(".letter").html("E"); break;
      case 20:
        this.$(".invoice-type").html("Nota de D&eacute;bito"); this.$(".letter").html("E"); break;
      case 21:
        this.$(".invoice-type").html("Nota de Cr&eacute;dito"); this.$(".letter").html("E"); break;
      case 51:
        this.$(".invoice-type").html("Factura"); this.$(".letter").html("M"); break;
      case 52:
        this.$(".invoice-type").html("Nota de D&eacute;bito"); this.$(".letter").html("M"); break;
      case 53:
        this.$(".invoice-type").html("Nota de Cr&eacute;dito"); this.$(".letter").html("M"); break;
      case 201:
        this.$(".invoice-type").html("Factura MiPyme"); this.$(".letter").html("A"); break;
      case 202:
        this.$(".invoice-type").html("Nota de D&eacute;bito MiPyme"); this.$(".letter").html("A"); break;
      case 203:
        this.$(".invoice-type").html("Nota de Cr&eacute;dito MiPyme"); this.$(".letter").html("A"); break;
      case 206:
        this.$(".invoice-type").html("Factura MiPyme"); this.$(".letter").html("B"); break;
      case 207:
        this.$(".invoice-type").html("Nota de D&eacute;bito MiPyme"); this.$(".letter").html("B"); break;
      case 208:
        this.$(".invoice-type").html("Nota de Cr&eacute;dito MiPyme"); this.$(".letter").html("B"); break;
      case 998:
        this.$(".invoice-type").html("Presupuesto"); this.$(".letter").html("X"); break;
      case 999:
        this.$(".invoice-type").html("Remito"); this.$(".letter").html("X"); break;
    }

    // Si es una nota de debito, se podria cambiar el % de perc IIBB
    if (id_tipo_comprobante == 2 || id_tipo_comprobante == 7 || id_tipo_comprobante == 12 || id_tipo_comprobante == 52 || id_tipo_comprobante == 202 || id_tipo_comprobante == 207) {
      this.$("#facturacion_porc_percepcion_ib").removeAttr("disabled");
    } else {
      this.$("#facturacion_porc_percepcion_ib").attr("disabled","disabled");
    }
    
    self.$("#facturacion_numero").val(self.model.get("numero"));

    // Forma de Pago
    self.$("#facturacion_tipo_pago").val(self.model.get("tipo_pago"));
    
    // Mostamos los datos del cliente
    if (self.cliente != null && ID_EMPRESA != 228) {
      
      self.$("#facturacion_id_cliente").val(self.cliente.id);
      
      var id_tipo_iva = self.cliente.get("id_tipo_iva");
      if (id_tipo_iva == 1) self.$("#facturacion_cliente_iva").html("Responsable Inscripto");
      else if (id_tipo_iva == 2) self.$("#facturacion_cliente_iva").html("Monotributo");
      else if (id_tipo_iva == 3) self.$("#facturacion_cliente_iva").html("Exento");
      else if (id_tipo_iva == 4) self.$("#facturacion_cliente_iva").html("Consumidor Final");
      self.$("#facturacion_codigo_cliente").val(self.cliente.get("nombre"));
      self.$("#facturacion_cliente_factura").html(self.cliente.get("nombre"));
      self.$("#facturacion_cliente_cuit").html(self.cliente.get("cuit"));
      self.$("#facturacion_cliente_direccion").html(self.cliente.get("direccion"));
      self.$("#facturacion_cliente_localidad").html(self.cliente.get("localidad"));
      
      self.$("#facturacion_porc_percepcion_ib").val(self.cliente.get("percepcion_ib"));
      self.$("#facturacion_saldo_anterior").val(Number(self.cliente.get("saldo")).toFixed(2));
    }      
    
    // Fecha
    self.$("#facturacion_fecha_factura").html(self.model.get("fecha"));
          
    self.$("#tabla_impuestos tbody").empty();
    var ivas = this.model.get("ivas");
    for(var i=0;i<ivas.length;i++) {
      var ii = ivas[i];
      if (ii.neto > 0) {
        var tr = ""; var nombre_iva = "";
        switch(i) {
          case 3: nombre_iva = "Exento"; break;
          case 4: nombre_iva = "IVA 10.50 %"; break;
          case 5: nombre_iva = "IVA 21.00 %"; break;
          case 6: nombre_iva = "IVA 27.00 %"; break;
          case 8: nombre_iva = "IVA 5.00 %"; break;
          case 9: nombre_iva = "IVA 2.50 %"; break;
        }
        tr+='<tr>';
        tr+='<td>'+nombre_iva+'</td>';
        tr+='<td>'+Number(ii.neto).toFixed(2)+'</td>';
        tr+='<td>'+Number(ii.iva).toFixed(2)+'</td>';
        tr+='</tr>';
        self.$("#tabla_impuestos tbody").append(tr);
      }
    }

    var descuento = parseFloat(self.model.get("descuento"));
    self.$("#facturacion_subtotal_sin_dto_div").addClass("dn");
    
    // Si discrimina IVA
    if (this.discrimina_iva()) {
      self.$(".iva_container").show();
      var neto = parseFloat(self.model.get("neto"));
      // El subtotal es sin descuento
      self.$("#facturacion_subtotal").val(Number(neto).toFixed(2));
      // El otro subtotal visible se le suma el descuento
      //self.$("#facturacion_subtotal_sin_dto").val(Number(neto).toFixed(2));

    } else {
      self.$(".iva_container").hide();
      var sub = self.model.get("subtotal");
      // El subtotal es sin descuento
      self.$("#facturacion_subtotal").val(Number(sub).toFixed(2));
      // El otro subtotal visible se le suma el descuento
      //self.$("#facturacion_subtotal_sin_dto").val(Number(sub + descuento).toFixed(2));
      //self.$("#facturacion_subtotal_sin_dto_div").removeClass("dn");
    }
    
    // Totales
    self.$("#facturacion_descuento").val(Number(descuento).toFixed(2));  
    self.$("#facturacion_iva").val(Number(self.model.get("iva")).toFixed(2));  
    self.$("#facturacion_percepcion_ib").val(Number(self.model.get("percepcion_ib")).toFixed(2));  

    var t = parseFloat(self.model.get("total")) + parseFloat(self.model.get("total_ofertas"));
    self.$("#facturacion_total").val(Number(t).toFixed(2));

    //var total_visible = t - parseFloat(self.model.get("descuento"));
    self.$("#facturacion_total_visible").val(Number(t).toFixed(2));

    self.$("#facturacion_tipo_pago").change();
  },
    
  set_numero_comprobante: function() {
    var self = this;
    var tipo_comprobante = parseInt(self.$("#facturacion_tipo").val());
    if (self.model.id == undefined && self.numeros != undefined) {
      self.model.set({ "numero":self.numeros[tipo_comprobante] });
    }
  },

  // Controla los comprobantes que puede realizar
  chequear_comprobantes: function() {
      
    var self = this;
    if (self.cliente == null || self.cliente == undefined) return;
    var iva_cliente = self.cliente.get("id_tipo_iva");
    if (iva_cliente == 0) iva_cliente = 4;
    var habilitados = [];
    this.$("#facturacion_tipo").empty();
    
    // Habilitamos el Remito y el Presupuesto
    habilitados.push(999);
    
    // Si la empresa es Responsable Inscripta
    /*
    if (ID_TIPO_CONTRIBUYENTE == 1) {
      
      // Y el cliente Monotributo o Exento o Consumidor Final
      if (iva_cliente == 2 || iva_cliente == 3 || iva_cliente == 4) {
        habilitados.push(6);
        habilitados.push(7);
        habilitados.push(8);
        habilitados.push(9);
        habilitados.push(206);
        habilitados.push(207);
        habilitados.push(208);
      
      // Y el cliente Responsable Inscripto 
      } else if (iva_cliente == 1) {
        habilitados.push(1);
        habilitados.push(2);
        habilitados.push(3);
        habilitados.push(4);
        habilitados.push(201);
        habilitados.push(202);
        habilitados.push(203);
      }
      
    // Si la empresa es Monotributista
    } else if (ID_TIPO_CONTRIBUYENTE == 2) {
      */
      habilitados.push(11);
      habilitados.push(12);
      habilitados.push(13);
      habilitados.push(15);
    //}

    for (j=0;j<habilitados.length;j++) {
      var o = habilitados[j];
      var comprobante = null;
      for(var i=0;i<comprobantes.length;i++) {
        comprobante = comprobantes[i];
        if (comprobante.id == o) break;
      }
      var option = "<option ";
      option+="value='"+comprobante.id+"' ";
      if (this.model.id != undefined && this.model.id != 0) option+=( comprobante.id == this.model.get("id_tipo_comprobante") )?"selected ":"";
      option+= ">"+comprobante.nombre;
      option+="</option>";
      this.$("#facturacion_tipo").append(option);
    }
          
    // Si es una factura nueva, seteamos el primero
    if (this.model.id == undefined || this.model.id == 0) {
      this.model.set("id_tipo_comprobante",this.$("#facturacion_tipo").val());
    }
  },
    
  buscar_numeros: function() {
    var self = this;
    var id_punto_venta = this.$("#facturacion_puntos_venta").val();
    $.ajax({
      "url":"facturas/function/next/"+id_punto_venta,
      "dataType":"json",
      "success":function(r) {
        self.numeros = r;
        self.set_numero_comprobante();
      }
    });      
  },    
    
    buscar_articulo : function() {
      
      var self = this;
      var codigo = $("#facturacion_codigo_articulo").val();
      codigo = codigo.trim();

      // Limpiamos el codigo para que no tenga ningun ' o "
      codigo = codigo.replace(/\'/g,"");
      codigo = codigo.replace(/\"/g,"");
      
      var modif = codigo;
      var lista_precios = ((this.$("#facturacion_lista").length > 0) ? this.$("#facturacion_lista").val() : 0);
      
      // Si el codigo del articulo esta vacio, simplemente saltamos a que escriba la descripcion
      if (isEmpty(codigo)) {
        //$("#facturacion_item_descripcion").select();
        return;
      }

      // No lo buscamos, porque no es un codigo, esta escribiendo una descripcion
      if (codigo.length > 15) {
        self.articulo = null;
        self.$("#facturacion_item_cantidad").select();  
        return;
      }

      this.codigo_leido = codigo;

      codigo = encodeURIComponent(codigo);
      $.ajax({
        "url":"articulos/function/get_by_codigo/"+codigo,
        "dataType":"json",
        "type":"post",
        "data":{
          "id_sucursal":ID_SUCURSAL,
          "lista_precios":lista_precios,
          "consultar_stock":0,
        },
        "success":function(result) {
          if (result.error == 1) {
            self.articulo = null;
            self.$("#facturacion_item_cantidad").select();  
          } else {
            var art = new app.models.Articulo(result.articulo);
            self.seleccionar_articulo(art);
          }
        }
      });
    },
    
    seleccionar_articulo : function(r) {
      var self = this;
      self.articulo = r;
      self.mostrar_articulo();
      self.calcular_item();
      this.$("#facturacion_item_cantidad").select();
    },
    
    editar_articulo: function(r) {
      var self = this;
      self.item = r;
      $("#facturacion_id_articulo").val(this.item.get("id_articulo"));
      $("#facturacion_codigo_articulo").val(this.item.get("nombre"));
      var cantidad = parseFloat(this.item.get("cantidad"))
      $("#facturacion_item_cantidad").val(cantidad);
      $("#facturacion_alicuotas_iva").val(this.item.get("id_tipo_alicuota_iva"));
      var costo_final = ((cantidad > 0) ? (parseFloat(this.item.get("costo_final")) / cantidad) : 0);
      $("#facturacion_costo_final").val(costo_final);
      $("#facturacion_tipo_item").val(this.item.get("tipo"));
      $("#facturacion_item_neto").val(this.item.get("neto"));
      $("#facturacion_item_precio").val(this.item.get("precio"));
      $("#facturacion_item_bonificado").val(this.item.get("bonificacion"));
      $("#facturacion_item_descripcion").val(this.item.get("descripcion"));
      if ($("#facturacion_item_percep_viajes").length > 0) $("#facturacion_item_percep_viajes").val(this.item.get("percep_viajes"));
      if ($("#facturacion_item_custom_2").length > 0) $("#facturacion_item_custom_2").val(this.item.get("custom_2"));
      if ($("#facturacion_item_custom_4").length > 0) $("#facturacion_item_custom_4").val(this.item.get("custom_4"));
      if ($("#facturacion_item_id_proveedor").length > 0) $("#facturacion_item_id_proveedor").val(this.item.get("id_proveedor"));
      if ($("#facturacion_variantes").length > 0) $("#facturacion_variantes").val(this.item.get("id_variante"));
      self.calcular_item();
      self.render_variantes(this.item.get("variantes"),this.item.get("id_variante"));
      this.$("#facturacion_item_cantidad").select();      
    },

    ver_mostrar_precio_articulo: function() {
      var self = this;
    },
    
    ver_buscar_articulo : function() {
      var self = this;
      window.articulos_buscar_activo = 1;
      var buscar = new app.views.ArticulosBuscarTableView({
        collection: new app.collections.Articulos(),
        habilitar_seleccion: true,
      });
      delete window.codigo_articulo_seleccionado;
      var d = $("<div/>").append(buscar.el);
      crearLightboxHTML({
        "html":d,
        "width":((ID_EMPRESA == 342)?1100:860),
        "height":500,
        "callback":function() {
          if (window.codigo_articulo_seleccionado != undefined && window.codigo_articulo_seleccionado != -1) {
            // Si el formulario es tipo factura, se reemplaza el codigo del articulo seleccionado
            $("#facturacion_codigo_articulo").val(window.codigo_articulo_seleccionado);
            self.buscar_articulo();
            $("#facturacion_codigo_articulo").focus();
          } else {
            $("#facturacion_codigo_articulo").focus();
          }          
        }
      });
      $("#articulos_buscar").focus();
    },
    
    ver_consultar_articulo : function() {
      var self = this;
      var view = new app.views.ArticulosMostrarPrecioView({
        collection: new app.collections.Articulos(),
        habilitar_seleccion: true,
      });   
      var d = $("<div/>").append(view.el);
      crearLightboxHTML({
        "html":d,
        "width":500,
        "height":500,
        "callback":function() {
          $("#articulos_mostrar_precio_buscar").select();
        }
      });
      $("#articulos_mostrar_precio_buscar").select();
    },

    mostrar_articulo : function() {

      // Mostramos el nombre
      this.$("#facturacion_codigo_articulo").val(this.articulo.get("nombre"));
      this.$("#facturacion_tipo_item").val(this.articulo.get("tipo"));

      // Si el articulo esta marcado como de CANASTA BASICA
      var disc_iva = this.discrimina_iva();
      /*
      if (this.articulo.get("custom_5") == "1" && this.cliente_canasta_basica && ID_EMPRESA != 249) {
        // Ponemos el IVA Alicuota 0%
        this.articulo.set({
          "id_tipo_alicuota_iva":3,
          "porc_iva":0,
          "costo_iva":0,
        });
      }*/
      this.$("#facturacion_alicuotas_iva").val(this.articulo.get("id_tipo_alicuota_iva"));
      this.$("#facturacion_id_articulo").val(this.articulo.id);
      this.$("#facturacion_costo_final").val(this.articulo.get("costo_final"));
      if (this.$("#facturacion_moneda").length > 0 && typeof this.articulo.get("moneda") != "undefined") this.$("#facturacion_moneda").val(this.articulo.get("moneda"));
      if (this.$("#facturacion_rubro").length > 0) this.$("#facturacion_rubro").val(this.articulo.get("id_rubro"));
      if (this.$("#facturacion_departamento").length > 0) this.$("#facturacion_departamento").val(this.articulo.get("id_departamento"));
      if (this.$("#facturacion_item_percep_viajes").length > 0) this.$("#facturacion_item_percep_viajes").val(this.articulo.get("percep_viajes"));
      if (this.$("#facturacion_item_custom_2").length > 0) {
        if (!isEmpty(this.articulo.get("custom_2"))) this.$("#facturacion_item_custom_2").val(this.articulo.get("custom_2"));
        else this.$("#facturacion_item_custom_2").val((this.articulo.get("porc_bonif") > 0)?"1":"");
      }

      // Guardamos el ID del primer proveedor
      if (this.$("#facturacion_item_id_proveedor").length > 0) {
        var proveedores = this.articulo.get("proveedores");
        if (typeof proveedores != undefined && proveedores.length > 0) {
          var prov = proveedores[0];
          this.$("#facturacion_item_id_proveedor").val(prov.id_proveedor);
        }
      }
      
      var lista = (this.$("#facturacion_lista").length > 0) ? this.$("#facturacion_lista").val() : 0;

      // Si estamos usando un numero de PLU, el precio es el de la etiqueta
      if (typeof this.precio_fijo != "undefined") {
        // El precio es final, le sacamos el iva
        var neto = Number(this.precio_fijo) / (1+(Number(this.articulo.get("porc_iva"))/100));
        this.$("#facturacion_item_neto").val(neto);
        this.$("#facturacion_item_precio").val(Number(this.precio_fijo));
      } else {
        // Dependiendo de la lista que estamos usando
        if (lista == 0) {
          this.$("#facturacion_item_neto").val(this.articulo.get("precio_neto"));
          this.$("#facturacion_item_precio").val(this.articulo.get("precio_final_dto"));  
        } else if (lista == 1) {
          this.$("#facturacion_item_neto").val(this.articulo.get("precio_neto_2"));
          this.$("#facturacion_item_precio").val(this.articulo.get("precio_final_dto_2"));
        } else if (lista == 2) {
          this.$("#facturacion_item_neto").val(this.articulo.get("precio_neto_3"));
          this.$("#facturacion_item_precio").val(this.articulo.get("precio_final_dto_3"));
        } else if (lista == 3) {
          this.$("#facturacion_item_neto").val(this.articulo.get("precio_neto_4"));
          this.$("#facturacion_item_precio").val(this.articulo.get("precio_final_dto_4"));
        } else if (lista == 4) {
          this.$("#facturacion_item_neto").val(this.articulo.get("precio_neto_5"));
          this.$("#facturacion_item_precio").val(this.articulo.get("precio_final_dto_5"));
        } else if (lista == 5) {
          this.$("#facturacion_item_neto").val(this.articulo.get("precio_neto_6"));
          this.$("#facturacion_item_precio").val(this.articulo.get("precio_final_dto_6"));
        }
      }

      // Si es un articulo de la CANASTA BASICA
      /*
      if (this.articulo.get("custom_5") == "1" && this.cliente_canasta_basica) {
        // El precio que tenemos que vender es SIN IVA
        this.$("#facturacion_item_precio").val(this.$("#facturacion_item_neto").val());
      }
      */
      this.render_variantes(this.articulo.get("variantes"),0);
    },

    limpiar_variantes: function() {
      this.$("#facturacion_variantes").empty();
      this.$("#facturacion_variantes").attr("disabled","disabled");
    },

    render_variantes: function(variantes,id_seleccionado) {
      this.limpiar_variantes();
      if (typeof variantes == undefined || variantes == null) return;
      if (typeof id_seleccionado == undefined || id_seleccionado == null) id_seleccionado = 0;
      if (variantes.length > 0) {
        this.$("#facturacion_variantes").removeAttr("disabled");
        for(var i=0; i<variantes.length; i++) {
          var v = variantes[i];
          var option = "<option "+((id_seleccionado == v.id)?"selected":"")+" value='"+v.id+"'>"+v.nombre+"</option>";
          this.$("#facturacion_variantes").append(option);
        }
      }
    },

    // Corrobora si en el cliente hay una etiqueta que sea REMITO
    check_etiqueta_remito: function() {
      return this.check_etiqueta("remito");
    },

    check_etiqueta: function(tag) {
      var self = this;
      tag = tag.toLowerCase();
      var salida = false;
      if (typeof self.cliente != undefined) {
        var etiquetas = self.cliente.get("etiquetas");
        if (typeof etiquetas != undefined) {
          if (etiquetas.length > 0) {
            for(var pp=0;pp<etiquetas.length;pp++) {
              var etiqueta = etiquetas[pp];
              etiqueta = etiqueta.toLowerCase()
              if (tag == etiqueta) {
                salida = true;
                break;
              }
            }
          }
        }
      }
      return salida;
    },
    
    // Agrega el item a la lista
    agregar_item : function() {
      var self = this;
      var codigo = this.$("#facturacion_codigo_articulo").val();
      if (isEmpty(codigo)) {
        alert("Por favor escriba o seleccione un articulo.");
        this.$("#facturacion_codigo_articulo").focus();
        return;
      }        
      
      var id_rubro = (this.$("#facturacion_rubro").length > 0) ? this.$("#facturacion_rubro").val() : 0;
      var id_departamento = (this.$("#facturacion_departamento").length > 0) ? this.$("#facturacion_departamento").val() : 0;
      var id_tipo_alicuota_iva = this.$("#facturacion_alicuotas_iva").val();
      var tipo_item = this.$("#facturacion_tipo_item").val();
      var costo_final = (this.$("#facturacion_costo_final").length > 0) ? this.$("#facturacion_costo_final").val() : 0;
      var id_tipo_comprobante = this.$("#facturacion_tipo").val();
      var porc_iva = parseFloat(this.$("#facturacion_alicuotas_iva option:selected").data("porcentaje"));
      var id_articulo = this.$("#facturacion_id_articulo").val();

      // Si estamos editando una factura, no podemos agregar nuevos articulos
      if (id_articulo != 0 && id_tipo_comprobante < 900 && !(this.model.id == undefined || this.model.id == 0)) {
        alert("No se puede editar un comprobante ya emitido.");
        return;
      }

      var descripcion = this.$("#facturacion_item_descripcion").val();
      var percep_viajes = (this.$("#facturacion_item_percep_viajes").length > 0) ? this.$("#facturacion_item_percep_viajes").val() : 0;
      var custom_2 = (this.$("#facturacion_item_custom_2").length > 0) ? this.$("#facturacion_item_custom_2").val() : "";
      var custom_3 = (this.$("#facturacion_item_custom_3").length > 0) ? this.$("#facturacion_item_custom_3").val() : "";
      var custom_4 = (this.$("#facturacion_item_custom_4").length > 0) ? this.$("#facturacion_item_custom_4").val() : "";
      var id_proveedor = (this.$("#facturacion_item_id_proveedor").length > 0) ? this.$("#facturacion_item_id_proveedor").val() : 0;
      var id_variante = (this.$("#facturacion_variantes").length > 0) ? this.$("#facturacion_variantes").val() : 0;
      var variante = (this.$("#facturacion_variantes option").length > 0) ? this.$("#facturacion_variantes option:selected").text() : "";
      
      var cantidad = this.$("#facturacion_item_cantidad").val();
      cantidad = cantidad.replace(",",".");  
      cantidad = parseFloat(cantidad);
      if (isNaN(cantidad)) { cantidad = Number(1).toFixed(2); }

      var bonificacion = this.$("#facturacion_item_bonificado").val();
      if (bonificacion > 100) {
        alert("ERROR: La bonificacion no puede ser mayor a 100.");
        this.$("#facturacion_item_bonificado").select();
        self.agregando = 0;
        return;
      } else if (bonificacion < 0 && ID_EMPRESA != 574 && ID_EMPRESA != 1326) {
        alert("ERROR: La bonificacion no puede ser menor a 0.")
        this.$("#facturacion_item_bonificado").select();
        self.agregando = 0;
        return;
      }
      
      if (this.discrimina_iva()) {
        var neto = parseFloat(this.$("#facturacion_item_neto").val());
        var precio = neto * (1+(porc_iva / 100));
      } else {
        // El precio que figura es el FINAL
        var precio = parseFloat(this.$("#facturacion_item_precio").val());
        var neto = precio / (1+(porc_iva / 100));
      }

      var iva = Math.round(neto * ((100-bonificacion)/100) * (porc_iva / 100) * cantidad * 100) / 100;
      var total_sin_iva = neto * ((100-bonificacion)/100) * cantidad;
      var total_con_iva = precio * ((100-bonificacion)/100) * cantidad;
      var costo_final = parseFloat(costo_final) * cantidad;
      
      var values = {
        "id_articulo":id_articulo,
        "neto":neto,
        "precio":precio,
        "nombre":codigo,
        "descripcion":descripcion,
        "id_rubro":id_rubro,
        "id_departamento":id_departamento,
        "id_tipo_alicuota_iva":id_tipo_alicuota_iva,
        "cantidad":cantidad,
        "bonificacion":bonificacion,
        "tipo":tipo_item,
        "iva":iva,
        "porc_iva":porc_iva,
        "percep_viajes":percep_viajes,
        "total_sin_iva":total_sin_iva,
        "total_con_iva":total_con_iva,
        "discrimina_iva":self.discrimina_iva(),
        "costo_final":costo_final,
        "custom_1":self.codigo_leido,
        "custom_2":custom_2, // Si tiene promocion
        "custom_3":custom_3, // Si reservo stock
        "custom_4":custom_4,
        "id_proveedor":id_proveedor,
        "id_variante":id_variante,
        "variante":variante,
        "variantes":((typeof self.articulo != "undefined" && self.articulo != null) ? self.articulo.get("variantes") : new Array()),
      };

      var etiqueta_remito = self.check_etiqueta_remito();

      // Actualizamos o agregamos el item
      if (this.item != undefined) {
        this.item.set(values);
      } else {
        var item = new app.models.FacturaItem(values);
        this.items.add(item);
      }

      // PROMOCION PARA MORENO
      /*
        var total_dto = values.total_con_iva * 0.22 * -1;
        var values = {
          "id_articulo":0,
          "neto":total_dto,
          "precio":total_dto,
          "nombre":"DESCUENTO -22%",
          "descripcion":"",
          "id_rubro":0,
          "id_tipo_alicuota_iva":3,
          "cantidad":1,
          "bonificacion":0,
          "tipo":tipo_item,
          "iva":0,
          "porc_iva":0,
          "percep_viajes":0,
          "total_sin_iva":total_dto,
          "total_con_iva":total_dto,
          "discrimina_iva":false,
          "costo_final":total_dto,
          "custom_1":"",
          "custom_2":"",
          "custom_3":"",
          "id_proveedor":0,
          "id_variante":0,
          "variante":"",
          "variantes":new Array(),
        };
        var item = new app.models.FacturaItem(values);
        this.items.add(item);
      }
      */
      
      delete this.precio_fijo;
      this.item = undefined;
      this.limpiar_item();
      this.agregando = 0;
      this.$("#facturacion_codigo_articulo").select();        

      this.calcular_ofertas();
    },

    descuento_efectivo_mega: function() {
      this.$("#facturacion_codigo_articulo").val("1111");
      var e = jQuery.Event("keypress");
      e.which = 13;
      this.$("#facturacion_codigo_articulo").trigger(e);
    },

    oferta_cubiertos_mega: function() {
      var self = this;

      // Primero corroboramos que no este aplicada ya
      for(var i=0; i< self.items.models.length; i++) {
        var item = self.items.models[i];
        if (item.get("id_articulo") == "10294937") {
          return;
        }
      }

      // Limpiamos todos los precios de los siguientes articulos
      var encontro = false;
      for(var i=0; i< self.items.models.length; i++) {
        var item = self.items.models[i];
        var codigo = item.get("id_articulo");
        if (codigo == "10272264" || codigo == "10272263" || codigo == "159345" || codigo == "10200874" || codigo == "10266873"
           || codigo == "300070" || codigo == "304945" || codigo == "153269" || codigo == "301411" || codigo == "304954" || codigo == "300071" || codigo == "153270" || codigo == "206641" || codigo == "300072" || codigo == "300073"
           || codigo == "300074" || codigo == "304944" || codigo == "153267" || codigo == "301412" || codigo == "304953" || codigo == "300075" || codigo == "153268" || codigo == "206640" || codigo == "300076" || codigo == "300077"
           || codigo == "300066" || codigo == "304943" || codigo == "153265" || codigo == "301410" || codigo == "304952" || codigo == "300067" || codigo == "153266" || codigo == "206639" || codigo == "300068" || codigo == "300069"
           || codigo == "300062" || codigo == "304942" || codigo == "153263" || codigo == "304950" || codigo == "304951" || codigo == "300063" || codigo == "153264" || codigo == "206638" || codigo == "300064" || codigo == "300065"
           || codigo == "10242298" || codigo == "10242299" || codigo == "10242300" || codigo == "10242301" || codigo == "10242302" || codigo == "10242303"
           || codigo == "10242292" || codigo == "10242293" || codigo == "10242294" || codigo == "10242295" || codigo == "10242296" || codigo == "10242297"
           || codigo == "10242286" || codigo == "10242287" || codigo == "10242288" || codigo == "10242289" || codigo == "10242290" || codigo == "10242291"
           || codigo == "10242280" || codigo == "10242281" || codigo == "10242282" || codigo == "10242283" || codigo == "10242284" || codigo == "10242285"
           || codigo == "10272266" || codigo == "159345" || codigo == "297336" || codigo == "10272266"
           || codigo == "10198043" || codigo == "297336" || codigo == "10272262" || codigo == "10272266"
           || codigo == "10226299" || codigo == "10226300"
        ) {
          item.set({
            "precio":0,
            "neto":0,
            "total_sin_iva":0,
            "total_con_iva":0,
            "tipo_cantidad":"X", // Marca para ver que el usuario cambio de precio
          });
          encontro = true;
        }
      };

      if (encontro) {
        this.$("#facturacion_codigo_articulo").val("11111");
        var e = jQuery.Event("keypress");
        e.which = 13;
        this.$("#facturacion_codigo_articulo").trigger(e);
      }
    },

    oferta_platos_mega: function() {
      var self = this;

      // Primero corroboramos que no este aplicada ya
      for(var i=0; i< self.items.models.length; i++) {
        var item = self.items.models[i];
        if (item.get("id_articulo") == "10295784") {
          return;
        }
      }

      // Limpiamos todos los precios de los siguientes articulos
      var encontro = false;
      for(var i=0; i< self.items.models.length; i++) {
        var item = self.items.models[i];
        var codigo = item.get("id_articulo");
        if (codigo == "306511" || codigo == "306516" || codigo == "306522" || codigo == "306528" || codigo == "306593" || codigo == "306594" || codigo == "306595"
          || codigo == "306512" || codigo == "306517" || codigo == "306523" || codigo == "306529" || codigo == "306596" || codigo == "306597" || codigo == "306598"
          || codigo == "306513" || codigo == "306518" || codigo == "306524" || codigo == "306530" || codigo == "306599" || codigo == "306600" || codigo == "306601"
          || codigo == "306514" || codigo == "306519" || codigo == "306525" || codigo == "306531" || codigo == "306602" || codigo == "306603" || codigo == "306604" || codigo == "10268239" || codigo == "10267537"
          || codigo == "306521" || codigo == "306520" || codigo == "306527" || codigo == "306533" || codigo == "306609" || codigo == "306611" || codigo == "306610"
        ) {
          item.set({
            "precio":0,
            "neto":0,
            "total_sin_iva":0,
            "total_con_iva":0,
            "tipo_cantidad":"X", // Marca para ver que el usuario cambio de precio
          });
          encontro = true;
        }
      };

      if (encontro) {
        this.$("#facturacion_codigo_articulo").val("11112");
        var e = jQuery.Event("keypress");
        e.which = 13;
        this.$("#facturacion_codigo_articulo").trigger(e);
      }
    },

    oferta_cubiertero_mega: function() {
      var self = this;

      // Primero corroboramos que no este aplicada ya
      for(var i=0; i< self.items.models.length; i++) {
        var item = self.items.models[i];
        if (item.get("id_articulo") == "10295784") {
          return;
        }
      }

      // Limpiamos todos los precios de los siguientes articulos
      var encontro = false;
      for(var i=0; i< self.items.models.length; i++) {
        var item = self.items.models[i];
        var codigo = item.get("id_articulo");
        if (codigo == "109933"
           || codigo == "300070" || codigo == "304945" || codigo == "153269" || codigo == "301411" || codigo == "304954" || codigo == "300071" || codigo == "153270" || codigo == "206641" || codigo == "300072" || codigo == "300073"
           || codigo == "300074" || codigo == "304944" || codigo == "153267" || codigo == "301412" || codigo == "304953" || codigo == "300075" || codigo == "153268" || codigo == "206640" || codigo == "300076" || codigo == "300077"
           || codigo == "300066" || codigo == "304943" || codigo == "153265" || codigo == "301410" || codigo == "304952" || codigo == "300067" || codigo == "153266" || codigo == "206639" || codigo == "300068" || codigo == "300069"
           || codigo == "300062" || codigo == "304942" || codigo == "153263" || codigo == "304950" || codigo == "304951" || codigo == "300063" || codigo == "153264" || codigo == "206638" || codigo == "300064" || codigo == "300065"
           || codigo == "10242298" || codigo == "10242299" || codigo == "10242300" || codigo == "10242301" || codigo == "10242302" || codigo == "10242303"
           || codigo == "10242292" || codigo == "10242293" || codigo == "10242294" || codigo == "10242295" || codigo == "10242296" || codigo == "10242297"
           || codigo == "10242286" || codigo == "10242287" || codigo == "10242288" || codigo == "10242289" || codigo == "10242290" || codigo == "10242291"
           || codigo == "10242280" || codigo == "10242281" || codigo == "10242282" || codigo == "10242283" || codigo == "10242284" || codigo == "10242285"
        ) {
          item.set({
            "precio":0,
            "neto":0,
            "total_sin_iva":0,
            "total_con_iva":0,
            "tipo_cantidad":"X", // Marca para ver que el usuario cambio de precio
          });
          encontro = true;
        }
      };

      if (encontro) {
        this.$("#facturacion_codigo_articulo").val("11113");
        var e = jQuery.Event("keypress");
        e.which = 13;
        this.$("#facturacion_codigo_articulo").trigger(e);
      }
    },

    calcular_ofertas: function() {
    },

    render_ofertas: function() {
      this.$("#facturacion_ofertas_cont").empty();
      this.total_ofertas = 0;
      for (var i = 0; i < this.ofertas.length; i++) {
        var o = this.ofertas[i];
        var l = '';
        l+='<div class="form-group cb">';
        l+='<label class="control-label col-xs-6">'+o.nombre+'</label>';
        l+='<div class="col-xs-6"><input type="text" value="'+Number(o.monto).toFixed(2)+'" disabled class="no-input"/></div>';
        l+='</div>';
        this.$("#facturacion_ofertas_cont").append(l);
        this.total_ofertas += parseFloat(o.monto);
      }
      this.$("#facturacion_ofertas_cont").css("display",((this.ofertas.length>0)?"block":"none"));
      this.calcular_totales();
    },

    render_bonificaciones: function() {
      this.$("#facturacion_bonificaciones_container").empty();
      this.total_bonificaciones = 0;
      for (var i = 0; i < this.bonificaciones.length; i++) {
        var o = this.bonificaciones[i];
        var l = '';
        l+='<div class="form-group cb">';
        l+='<label class="control-label col-xs-8 fs14 text-muted">'+o.nombre+'</label>';
        l+='<div class="col-xs-4"><input type="text" value="'+Number(o.monto).toFixed(2)+'" disabled class="fs14 no-input"/></div>';
        l+='</div>';
        this.$("#facturacion_bonificaciones_container").append(l);
        this.total_bonificaciones += parseFloat(o.monto);
      }
      this.$("#facturacion_bonificaciones_cont").css("display",((this.bonificaciones.length>0)?"block":"none"));
      this.calcular_totales();
    },
    
    calcular_item: function() {
      // TODO: Controlar los campos cuando no son numericos
      var self = this;
      var cantidad = this.$("#facturacion_item_cantidad").val();
      if (typeof REMITOS_TOMAR_PRECIO_NETO != "undefined" && REMITOS_TOMAR_PRECIO_NETO == 1) {
        var precio_unit = this.$("#facturacion_item_neto").val();
      } else {
        if (this.discrimina_iva()) {
          var precio_unit = this.$("#facturacion_item_neto").val();
        } else {
          var precio_unit = this.$("#facturacion_item_precio").val();
        }
      }
      var bonificado = this.$("#facturacion_item_bonificado").val();
      var subtotal = Number( (cantidad * precio_unit) * ((100-bonificado)/100) ).toFixed(2);
      this.$("#facturacion_item_subtotal").val(subtotal);
    },

    initialize: function(options) {
      var self = this;
      this.guardando = 0;
      this.agregando = 0;
      this.ofertas = new Array();
      this.bonificaciones = new Array();
      this.total_ofertas = 0;
      this.total_bonificaciones = 0;
      this.options = options;
      _.bindAll(this);
      this.bind("limpiar",this.limpiar);
      this.codigo_leido = "";

      // Estamos creando uno nuevo
      if (this.model.id == undefined || this.model.id == 0) {
        this.limpiar();

      // Estamos editando
      } else {
        
        this.listenTo(this.model,"change",this.render_view); // Si el modelo cambia, renderizamos la vista
        
        this.render();
        
        // Creamos una nueva coleccion de items
        var ItemsCollection = Backbone.Collection.extend({
          model: app.models.FacturaItem
        });
        var productos = this.model.get("items");
        this.items = new ItemsCollection();
        for(var i=0;i<productos.length;i++) {
          var p = productos[i];
          var fi = new app.models.FacturaItem(p);
          this.items.add(fi);
        }
        this.items.on('all', this.render_tabla_items, this);
        this.items.on('add', this.addItem, this);        
        
        // Buscamos el cliente y lo seteamos
        var id_cliente = self.model.get("id_cliente");
        if (id_cliente == 0) {
          this.setear_consumidor_final();
        } else {
          var cliente = new app.models.Clientes({"id":id_cliente});
          cliente.fetch({
            "success":function() {
              self.seleccionar_cliente(cliente);
            },
          });
        }

        // Si la factura estaba marcada como NUEVA, tenemos que ir al servidor y desmarcarla
        if (this.model.get("nueva") == 1) {
          $.ajax({
            "url":"facturas/function/marcar_visto/"+self.model.id+"/"+self.model.get("id_punto_venta")+"/",
            "dataType":"json",
          });
        }
      }
    },

    render: function() {
      
      // Creamos un objeto para agregarle las otras propiedades que no son el modelo
      var self = this;

      // Si la factura fue emitida y estamos editando, no se podria cambiar absolutamente nada
      var edicion = ( ((!(this.model.id == undefined || this.model.id == 0)) && (this.model.get("id_tipo_comprobante") < 900 || (typeof NO_EDITAR_FACTURA != "undefined") )) ? false : true);
      //if (typeof FACTURACION_PERMITIR_EDICION_FACTURA != undefined) edicion = true;

      var obj = { edicion: edicion, id:this.model.id };
      // Extendemos el objeto creado con el modelo de datos
      $.extend(obj,this.model.toJSON());

      $(this.el).html(this.template(obj));
      
      if (isEmpty(this.model.get("fecha"))) {
        this.model.set("fecha",moment().format("DD/MM/YYYY"));
      }
      createdatepicker(this.$("#facturacion_fecha"),this.model.get("fecha"));

      if (this.$("#facturacion_fecha_vto").length > 0) {
        createdatepicker(this.$("#facturacion_fecha_vto"),this.model.get("fecha_vto"));
      }
    
      this.limpiar_item();
      
      // Si esta habilitado el modulo y existe el componente
      if (control.check("vendedores")>0 && this.$("#facturacion_vendedores").length > 0) {

        var selected = ((this.model.id == undefined) ? ((typeof ID_VENDEDOR == undefined)?0:ID_VENDEDOR) : this.model.get("id_vendedor"));
        new app.mixins.Select({
          "modelClass": app.models.Vendedor,
          "url": "vendedores/",
          "render": "#facturacion_vendedores",
          "name" : "id_vendedor",
          "firstOptions": ["<option data-limite_descuento='0' value='0'>Vendedor</option>"],
          "selected": selected,
          "fields":["limite_descuento"],
        });
      }
      
      if (this.$("#facturacion_fecha_reparto").length > 0) {
        createdatepicker(this.$("#facturacion_fecha_reparto"),(isEmpty(this.model.get("fecha_reparto"))) ? new Date() : this.model.get("fecha_reparto"));
      }
      if (this.$("#facturacion_reparto").length > 0) {
        this.$("#facturacion_reparto").TouchSpin({
          verticalbuttons: true,
          min: 0,
        });
      }
      
      if (this.model.id == undefined || this.model.id == 0) {
        self.buscar_numeros();
      }
      
      // AUTOCOMPLETE DE CLIENTES
      // ------------------------
      var input = this.$("#facturacion_codigo_cliente");
      var form = new app.views.ClienteEditViewMini({
        "model": new app.models.Clientes(),
        "input": input,
        "onSave": self.seleccionar_cliente,
      });      
      $(input).customcomplete({
        "url":"clientes/function/get_by_nombre/",
        "form":form,
        "width":"300px",
        "onSelect":function(item){
          var cliente = new app.models.Clientes({"id":item.id});
          cliente.fetch({
            "success":function(){
              self.seleccionar_cliente(cliente);
            },
          });
        }
      });
      var input = this.$("#facturacion_codigo_articulo");
      return this;
    },
    
    cambiar_numero_reparto: function() {
      if (this.$("#facturacion_reparto").length > 0) {
        var fecha = this.$("#facturacion_fecha_reparto").val();
        fecha = fecha.replace(/\//g,"-");
        $.ajax({
          "url":"facturas/function/ultimo_reparto/"+fecha,
          "dataType":"json",
          "success":function(r) {
            $("#facturacion_reparto").val(r.reparto);
          }
        });
      }
    },
    
    // SOLO LOS COMPROBANTES "A" DISCRIMINAN IVA
    discrimina_iva: function() {
      var t = parseInt(this.model.get("id_tipo_comprobante"));
      // Tipos de comprobantes "A" => 1,2,3,4.. y tambien tipo "M".. y tmb MiPyme
      return (t<=4 || t==51 || t==52 || t==53 || t==201 || t==202 || t==203); 
    },
    
    calcular_totales : function() {
      
      var neto = 0; var porc_descuento = 0; var total = 0; var iva = 0; var porc_ib = 0;
      var descuento = 0; var percepcion_ib = 0; var subtotal_neto = 0; var subtotal_final = 0;
      var total_ofertas = 0; var total_bonificaciones = 0;
      var tipo_iva_cliente = this.$("#facturacion_cliente_iva").val();
      var items = this.model.get("items");
      
      // Cada posicion en el array esta definido por id_tipo_alicuota_iva
      var limite_alicuotas = 0;
      _.each(alicuotas_iva,function(ai){
        if (ai.id > limite_alicuotas) limite_alicuotas = ai.id;
      });

      var alicuotas = [];
      for(var i=0;i<limite_alicuotas+1;i++) {
        alicuotas.push({
          "neto":0, "iva": 0,
        });
      }
      var porc_descuento = (this.$("#facturacion_porc_descuento").length > 0) ? parseFloat(this.$("#facturacion_porc_descuento").val()) : 0;
      if (isNaN(porc_descuento)) porc_descuento = 0;
      var pdesc = ((100-porc_descuento) / 100);
      
      // Recorremos los items
      this.items.each(function(item){
        if (item.get("anulado") == 0) {
          var indice = item.get("id_tipo_alicuota_iva");
          try {
            alicuotas[indice].neto += Math.round(item.get("total_sin_iva") * pdesc * 100)/100;
            alicuotas[indice].iva += Math.round(item.get("iva") * pdesc * 100)/100;
          } catch(e) {
            console.log(alicuotas);
            console.log(e);
          }
          neto = neto + item.get("total_sin_iva") * pdesc;
          total = total + item.get("total_con_iva") * pdesc;
          subtotal_neto = subtotal_neto + parseFloat(item.get("total_sin_iva"));
          subtotal_final = subtotal_final + parseFloat(item.get("total_con_iva"));
          iva = iva + item.get("iva") * pdesc;          
        }
      });

      // Recorremos las ofertas
      for (var i = 0; i < this.ofertas.length; i++) {
        var o = this.ofertas[i];
        neto = neto - parseFloat(o.monto);
        total = total - parseFloat(o.monto);
        total_ofertas = parseFloat(o.monto);
        subtotal_neto = subtotal_neto - parseFloat(o.monto);
        subtotal_final = subtotal_final - parseFloat(o.monto);
      }

      // Recorremos las bonificaciones
      for (var i = 0; i < this.bonificaciones.length; i++) {
        var o = this.bonificaciones[i];
        neto = neto - parseFloat(o.monto);
        total = total - parseFloat(o.monto);
        total_bonificaciones = parseFloat(o.monto);
        subtotal_neto = subtotal_neto - parseFloat(o.monto);
        subtotal_final = subtotal_final - parseFloat(o.monto);
      }
      
      // Dependiendo si discrimina IVA o no, es el valor del subtotal
      if (this.discrimina_iva()) {
        subtotal = subtotal_neto;
      } else {
        subtotal = subtotal_final;
      }        
      window.comp = this;

      var descuento = subtotal * parseFloat(porc_descuento / 100);
      if (isNaN(descuento)) descuento = 0;
      if (descuento > 0) {
        if (this.discrimina_iva()) {
          // En el neto ya se calculo el descuento
          subtotal = neto + iva;
        } else {
          total = subtotal - descuento;
          //total = subtotal;
          //subtotal = subtotal - descuento;
        }
      }

      var percepcion_ib = 0;
      this.$("#facturacion_percepcion_ib").val(Number(0).toFixed(2));

      // Si tenemos que sumarle algun interes
      var interes = parseFloat(this.model.get("interes"));
      total = total + interes;

      this.model.set({
        "iva":iva,
        "porc_descuento":porc_descuento,
        "descuento":descuento,
        "percepcion_ib":percepcion_ib,
        "porc_ib":porc_ib,
        "neto":neto,
        "subtotal":subtotal,
        "total":total,
        "ivas":alicuotas,
      });
    },
    
    limpiar_item: function() {
      this.$("#facturacion_id_articulo").val("0");
      this.$("#facturacion_item_descripcion").val("");
      this.$("#facturacion_item_cantidad").val("1");
      this.$("#facturacion_item_bonificado").val("0");
      this.$("#facturacion_item_neto").val("0.00");
      this.$("#facturacion_item_precio").val("0.00");
      this.$("#facturacion_item_subtotal").val("");
      this.$("#facturacion_codigo_articulo").val("");
      if (this.$("#facturacion_item_percep_viajes").length > 0) this.$("#facturacion_item_percep_viajes").val("");
      if (this.$("#facturacion_item_custom_2").length > 0) this.$("#facturacion_item_custom_2").val("");
      if (this.$("#facturacion_item_custom_4").length > 0) this.$("#facturacion_item_custom_4").val("");
      if (this.$("#facturacion_item_id_proveedor").length > 0) this.$("#facturacion_item_id_proveedor").val("");
      this.$("#facturacion_codigo_articulo").focus();
      this.codigo_leido = "";
      this.limpiar_variantes();
    },

    anular_action: function() {
      this.limpiar();
    },
    
    render_tabla_items : function () {
      this.$("#tabla_items tbody").empty();
      this.items.each(this.addItem);
      this.calcular_totales();
    },

    addItem : function ( item ) {
      var self = this;
      item.set({ "discrimina_iva": this.discrimina_iva() });
      var view = new app.views.FacturaItem({
        "model": item,
        "view":this,
        // Puedo editar cuando es una factura nueva, o al editar un remito
        "edicion":(self.model.isNew() || self.model.get("id_tipo_comprobante")>900),
      });
      this.$("#tabla_items tbody").append(view.el);
      this.calcular_totales();
    },
    
    validar: function() {
      var self = this;
      var nombre_cliente = this.$("#facturacion_codigo_cliente").val().trim();
      if (isEmpty(nombre_cliente)) {
        this.$("#facturacion_codigo_cliente").focus();
        throw "ERROR: Ingrese un cliente."; 
      }
      if (this.items.size() == 0) {
        throw "ERROR: Ingrese al menos un item al comprobante antes de guardar.";
      }
      if (this.$("#facturacion_conceptos").length > 0) {
        this.model.set({
          "id_concepto":self.$("#facturacion_conceptos").val()
        });
      }

      // Si es una Factura MiPyME si o si se tiene que poner una fecha de vencimiento
      var tipo_comprobante = this.$("#facturacion_tipo").val();
      if (this.$("#facturacion_fecha_vto").length > 0 && isEmpty(this.$("#facturacion_fecha_vto").val()) && tipo_comprobante ==  201) {
        this.$("#facturacion_fecha_vto").focus();
        throw "ERROR: Por favor ingrese una fecha de vencimiento para el pago de la factura.";
      }

    },
    
    anular: function() {
      if (confirmar("Desea anular el comprobante?")) {
        var self = this;
        this.model.set({
          "anulada":1,
          "tarjetas":[], // Nos aseguramos que no se guarden tarjetas si la venta es anulada
          "cheques":[],
        });
        this.view_to_model();
        this.model.save({},{
          success: function(model,response) {
            location.reload();
          }
        });        
      }
    },
  
    limpiar: function() {
    
      // Guardamos las variables antes de renderizar
      var lista = (this.$("#facturacion_lista").length > 0) ? this.$("#facturacion_lista").val() : 0;
      var id_vendedor = this.model.get("id_vendedor");
      var cotizacion_dolar = 0;
      var id_cliente = 0;

      // Guardamos el ultimo punto de venta utilizado para seguir facturando con ese
      var id_punto_venta = this.model.get("id_punto_venta");
      
      var numero_paso = 0;
      this.model = new app.models.Factura({
        "ivas":[],
        "tarjetas":[],
        "cheques":[],
        "items":[],
        "id_punto_venta":id_punto_venta,
        "id_cliente":id_cliente,
        "id_vendedor":id_vendedor,
        "cotizacion_dolar":cotizacion_dolar,
        "numero_paso":numero_paso,
      });
      this.ofertas = new Array();
      this.listenTo(this.model,"change",this.render_view); // Si el modelo cambia, renderizamos la vista
      window.factura = this.model; // TODO: borrar esto desp
      
      // Creamos una nueva coleccion de items
      var ItemsCollection = Backbone.Collection.extend({
        model: app.models.FacturaItem,
      });
      this.items = new ItemsCollection();
      this.items.on('all', this.render_tabla_items, this);
      this.items.on('add', this.addItem, this);
      
      // Renderizamos y limpiamos
      this.render();
      if (control.check("repartos")>0 == 1) this.cambiar_numero_reparto();
      
      if (id_cliente == 0) this.setear_consumidor_final();
      else this.seleccionar_cliente(this.cliente);
      this.$("#facturacion_lista").val(lista);
    },
    
    sincronizar_numero: function(e) {
      var self = this;
      var id = $("#facturacion_tipo").val();
      var punto_venta = this.$("#facturacion_puntos_venta option:selected").data("numero");
      var tipo_impresion = this.$("#facturacion_puntos_venta option:selected").data("tipo_impresion");
      if (tipo_impresion != "E") { show("El punto de venta no es electronico."); return; }
      $.ajax({
      "url":"facturas/function/sincronizar_numero/"+punto_venta+"/"+id+"/",
      "dataType":"json",
      "success":function(r) {
        if (r.error == 1) {
        show(r.mensaje);
        } else {
          var numero = parseInt(r.numero);
          if (isNaN(numero)) numero = 0;
          numero = numero + 1;
          $("#facturacion_numero").val(numero);
          self.model.set({ "numero":numero });
        }
      }
      });
    }, 

    view_to_model: function() {
      var self = this;
      if (this.model.id == null) {
        this.model.set({id:0});
      }
      this.model.set({
        "items":self.items.toJSON(),
        "id_vendedor":(self.$("#facturacion_vendedores").length > 0) ? self.$("#facturacion_vendedores").val():0,
        "codigo_postal":(self.$("#facturacion_codigo_postal").length > 0) ? self.$("#facturacion_codigo_postal").val() : "",
        "direccion":(self.$("#facturacion_direccion").length > 0) ? self.$("#facturacion_direccion").val() : "",
        "localidad":(self.$("#facturacion_localidad").length > 0) ? self.$("#facturacion_localidad").val() : "",
        "fecha": (self.$("#facturacion_fecha").length > 0) ? self.$("#facturacion_fecha").val() : "",
        "fecha_vto": (self.$("#facturacion_fecha_vto").length > 0) ? self.$("#facturacion_fecha_vto").val() : "",
        "fecha_reparto":(self.$("#facturacion_fecha_reparto").length > 0) ? self.$("#facturacion_fecha_reparto").val() : "",
        "id_punto_venta": (self.$("#facturacion_puntos_venta").length > 0) ? self.$("#facturacion_puntos_venta").val() : 0,
        "punto_venta":self.$("#facturacion_puntos_venta option:selected").data("numero"),
        "numero":self.$("#facturacion_numero").val(),
        "numero_remito": (self.$("#facturacion_numero_remito").length > 0) ? self.$("#facturacion_numero_remito").val() : 0,
        "observaciones": (self.$("#facturacion_observaciones").length > 0) ? self.$("#facturacion_observaciones").val() : "",
        "custom_5": (self.$("#facturacion_custom_5").length > 0) ? self.$("#facturacion_custom_5").val() : "", // Texto privado
        "reparto":(control.check("repartos")>0 == 1)?self.$("#facturacion_reparto").val():0,
        "estado": 0,
        "id_empresa": ID_EMPRESA,
        "id_cliente": (self.$("#facturacion_id_cliente").length > 0) ? self.$("#facturacion_id_cliente").val() : 0,
        "id_tipo_comprobante": (self.$("#facturacion_tipo").length > 0) ? self.$("#facturacion_tipo").val() : 0,
        "ofertas":self.ofertas,
        "bonificaciones":self.bonificaciones,
      });
      if (this.$("#facturacion_tipo_pago").length > 0) {
        this.model.set({
          "tipo_pago":self.$("#facturacion_tipo_pago").val(),
        });
      }
    },  
        
    aceptar: function() {
      
      var self = this;
      try {
        this.validar(); // Primero validamos
      } catch(e) {
        alert(e);
        return;
      }

      // Desactivamos el doble submiteo
      if (this.guardando == 1) return;
      this.guardando = 1;

      // Abrimos el dialogo para que el usuario espere
      workspace.esperar("Guardando comprobante...");

      this.view_to_model();
      var id_cliente = self.$("#facturacion_id_cliente").val();
      var id_tipo_comprobante = self.$("#facturacion_tipo").val();

      // TODO: Utilizar un array para los impuestos agregados
      // Si hay algun producto marcado para aplicar percepcion de viajes al exterior
      var base_percep_viajes = 0;
      if (id_tipo_comprobante != 999) {
        this.items.each(function(item){
          if (item.get("percep_viajes") == 1) {
            if (self.discrimina_iva()) {
              base_percep_viajes = base_percep_viajes + item.get("total_sin_iva");
            } else {
              base_percep_viajes = base_percep_viajes + item.get("total_con_iva");
            }            
          }
        });
      }

      // IMPUESTO PAIS
      // Solamente tomamos los servicios de transporte de pasajeros
      var base_impuesto_pais = 0;
      // Si estamos editando un comprobante, limpiamos los campos de tarjeta, cta_cte, para que no queden mal
      if (!this.model.isNew()) {
        this.model.set({
          "efectivo":0,
          "tarjeta":0,
          "vuelto":0,
          "cheque":0,
          "cta_cte":0,
        });
      }      

      // Dependiendo de la forma de pago
      var tipo_pago = ($("#facturacion_tipo_pago").length>0) ? $("#facturacion_tipo_pago").val() : "E";
      if (tipo_pago == "C") {
        this.model.set({ "cta_cte":$("#facturacion_total").val(), "tipo_pago":tipo_pago });
      } else if (tipo_pago == "E") {
        this.model.set({ "efectivo":$("#facturacion_total").val(), "tipo_pago":tipo_pago });
      } else if (tipo_pago == "T") {
        this.model.set({ "tarjeta":$("#facturacion_total").val(), "tipo_pago":tipo_pago });
      } else if (tipo_pago == "H") {
        this.model.set({ "cheque":$("#facturacion_total").val(), "tipo_pago":tipo_pago });
      } else if (tipo_pago == "B") {
        this.model.set({ "tarjeta":$("#facturacion_total").val(), "tipo_pago":tipo_pago });
      } else if (tipo_pago == "O") {
        this.model.set({ "efectivo":$("#facturacion_total").val(), "tipo_pago":tipo_pago });
      }

      this.model.save({},{
        success: function(model,response) {
          $('.modal:last').modal('hide');
          self.guardando = 0; // Habilitamos el boton
          if (response.id != undefined) {
            self.model.id = response.id;
          }
          if (response.error == 1) {
            show(response.mensaje);
          } else {
            // Indica que podemos mandar la orden para imprimir
            if (response.imprimir == 1) {

              if (LOCAL == 1 && (ID_EMPRESA == 574 || ID_EMPRESA == 1326)) {
                // TATO manda a imprimir con la EPSON TMU220
                var that = self;
                $.ajaxq("cola_items",{
                  "url":"facturas/function/imprimir_epson/"+self.model.id+"/"+self.model.get("id_punto_venta"),
                  "dataType":"json",
                  "success":function(r) {
                    that.guardando = 0;
                    $('.modal:last').modal('hide');
                    that.do_limpiar();
                  },
                  "error":function() {
                    that.guardando = 0;
                    $('.modal:last').modal('hide');
                    that.do_limpiar();                      
                  }
                });
              } else {
                self.imprimir(self.model.id,self.model.get("id_punto_venta"),response.tipo_impresion,true);
              }
            } else {
              location.href="app/#ventas_listado";
            }
          }
        },
      });           
    },

    imprimir_ticket: function(id) {
      var self = this;
      if (controlador_fiscal != "") {
        if (!self.check_etiqueta_remito()) {
          $.ajaxq("cola_items",{
            "url":"impresor_fiscal/imprimir/"+id,
            "dataType":"json",
            "success":function(r) {
              if (r.result == 0) {
                alert("Hubo un error al imprimir el comprobante.");
              }
              self.guardando = 0;
              $('.modal:last').modal('hide');
            }
          });
        } else {
          $.ajaxq("cola_items",{
            "url":"impresor_fiscal/imprimir_remito/"+self.model.id,
            "dataType":"json",
            "success":function(r) {
              if (r.result == 0) {
                alert("Hubo un error al imprimir el comprobante.");
              }
              self.guardando = 0;
              $('.modal:last').modal('hide');
            }
          });
        }
      }
    },
  
  });

})(app.views, app.models);



(function ( app ) {
  app.views.FacturaItem = app.mixins.View.extend({
  template: _.template($("#factura_item_template").html()),
  tagName: "tr",
  className: function() {
    // Ocultamos la fila que esta bonificada por una oferta (en la base de datos se guarda asi)
    var id_articulo = this.model.get("id_articulo");
    var cantidad = this.model.get("cantidad");
    var tipo_cantidad = this.model.get("tipo_cantidad");
    return ((id_articulo != 0 && cantidad == 0 && (tipo_cantidad == "" || tipo_cantidad == "X")) ? "dn" : "");
  },
  myEvents: {
    "click .reservado":function(e) {
      var self = this;
      e.stopPropagation();
      e.preventDefault();
      if (typeof this.model.id == "undefined") return;
      if (!confirm("Desea pasar estos productos del stock reservado al actual?")) return;
      var cantidad = parseFloat(self.model.get("cantidad"));
      if (isNaN(cantidad)) cantidad = 0;
      $.ajax({
        "url":"facturas_items/function/desreservar/",
        "dataType":"json",
        "type":"get",
        "data":{
          "id":self.model.id,
          "id_articulo":self.model.get("id_articulo"),
          "id_punto_venta":self.model.get("id_punto_venta"),
          "id_variante":self.model.get("id_variante"),
          "cantidad":cantidad,
        },
        "success":function(res){
          if (res.error == 0) location.reload();
        }
      });
    },
    "click .editar":function(e) {
      var self = this;
      e.stopPropagation();
      e.preventDefault();
      this.options.view.editar_articulo(this.model);
    },
    "click .do_eliminar":"do_eliminar",
    "keydown .eliminar":function(e) {
    },
  },
  initialize: function(options) {
    var self = this;
    _.bindAll(this);
    this.options = options;
    this.edicion = (typeof options.edicion != undefined) ? options.edicion : true;
    this.model.on("change",this.render,this);
    this.render();
  },
  do_eliminar: function() {
    this.model.destroy();  // Eliminamos el modelo      
    $(this.el).remove();  // Lo eliminamos de la vista
    this.options.view.calcular_ofertas();
    $("#facturacion_codigo_articulo").focus();
  },
  render: function() {
    var m = this.model.toJSON();
    m.edicion = this.options.edicion; //((typeof FACTURACION_PERMITIR_EDICION_FACTURA != undefined) ? true : this.options.edicion);
    console.log(m);
    $(this.el).html(this.template(m));
    if (this.model.get("anulado") == 1 && control.check("estadisticas_ventas")>=3) {
      // Si somos el administrador general, las filas anuladas debemos mostrarlas
      $(this.el).addClass("fila_roja_2");
    } else if (this.model.get("anulado") == 1) {
      // Si somos un cajero comun, las filas anuladas se deben ocultar
      $(this.el).hide();
    } else if (this.model.get("custom_2") == "1" && ID_PROYECTO == 1) {
      // Si el producto esta en OFERTA, lo marcamos
      $(this.el).addClass("fila_roja");
    }
    return this;
  },
  });
})(app);